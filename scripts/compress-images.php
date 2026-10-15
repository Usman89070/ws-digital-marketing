<?php
// Compresses every image under a given directory to <= 100KB, re-encoding
// in place IN ITS OWN FORMAT (a .jpg stays a real JPEG, a .png stays a real
// PNG, a .webp stays a real WebP) -- admin-panel uploads can be any of the
// three (see admin/includes/auth.php::handle_image_upload), and writing a
// different format's bytes into that extension would break rendering,
// since the server's Content-Type header is derived from the extension.
//
// Strategy per file: for JPEG/WebP, sweep quality down; for PNG, first try
// max compression, then fall back to a 256-colour palette (still lossless
// PNG, much smaller for photo-like images). If still over budget at the
// lowest quality/palette setting, scale dimensions down in 10% steps and
// retry. Keeps aspect ratio throughout.

$targetBytes = 100 * 1024;
$root = $argv[1] ?? '.';

$files = [];
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
foreach ($rii as $file) {
    if ($file->isFile() && preg_match('/\.(webp|png|jpe?g)$/i', $file->getFilename())) {
        $files[] = $file->getPathname();
    }
}

function encode_attempt(\GdImage $im, string $ext, int $step): string
{
    // $step counts down from high quality/fidelity (0) to low (increasing).
    if ($ext === 'webp' || $ext === 'jpg' || $ext === 'jpeg') {
        $quality = max(30, 85 - ($step * 5));
        ob_start();
        $ext === 'webp' ? imagewebp($im, null, $quality) : imagejpeg($im, null, $quality);
        return ob_get_clean();
    }
    // PNG: step 0 = max compression, true colour. step 1+ = quantised to a
    // shrinking palette (still a valid, lossless-from-here-on PNG).
    $work = $im;
    if ($step >= 1) {
        $colours = max(16, 256 >> min($step - 1, 4));
        $work = imagecreatetruecolor(imagesx($im), imagesy($im));
        imagealphablending($work, false);
        imagesavealpha($work, true);
        imagecopy($work, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
        imagetruecolortopalette($work, true, $colours);
    }
    ob_start();
    imagepng($work, null, 9);
    $data = ob_get_clean();
    if ($work !== $im) {
        imagedestroy($work);
    }
    return $data;
}

foreach ($files as $path) {
    $origSize = filesize($path);
    if ($origSize <= $targetBytes) {
        echo "SKIP  {$path} already " . round($origSize / 1024, 1) . "KB\n";
        continue;
    }

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $img = match ($ext) {
        'webp' => imagecreatefromwebp($path),
        'png' => imagecreatefrompng($path),
        'jpg', 'jpeg' => imagecreatefromjpeg($path),
        default => null,
    };
    if (!$img) {
        echo "FAIL  {$path} could not decode\n";
        continue;
    }

    $origW = imagesx($img);
    $origH = imagesy($img);
    $scale = 1.0;
    $bestData = null;
    $bestSize = PHP_INT_MAX;

    for ($attempt = 0; $attempt < 60; $attempt++) {
        $w = max(1, (int) round($origW * $scale));
        $h = max(1, (int) round($origH * $scale));

        if ($scale < 1.0) {
            $resized = imagecreatetruecolor($w, $h);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $img, 0, 0, 0, 0, $w, $h, $origW, $origH);
        } else {
            $resized = $img;
        }

        $maxStep = $ext === 'png' ? 5 : 11;
        for ($step = 0; $step <= $maxStep; $step++) {
            $data = encode_attempt($resized, $ext, $step);
            $size = strlen($data);
            if ($size < $bestSize) {
                $bestSize = $size;
                $bestData = $data;
            }
            if ($size <= $targetBytes) {
                break 2; // good enough, stop both loops
            }
        }

        if ($resized !== $img) {
            imagedestroy($resized);
        }
        $scale -= 0.1;
        if ($scale <= 0.1) {
            break;
        }
    }

    imagedestroy($img);

    if ($bestData === null) {
        echo "FAIL  {$path} no encode produced\n";
        continue;
    }

    file_put_contents($path, $bestData);
    $newSize = strlen($bestData);
    printf(
        "DONE  %-55s %6.1fKB -> %6.1fKB%s\n",
        $path,
        $origSize / 1024,
        $newSize / 1024,
        $newSize > $targetBytes ? '  [STILL OVER 100KB]' : ''
    );
}
