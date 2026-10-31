<?php
// Database connection shared by the public site (blog.php, our-team.php) and the
// admin panel (admin/). Fill in the four constants below with the values from
// Hostinger hPanel -> Databases -> MySQL Databases (create a database + user
// there first if you haven't already, then note the host/name/user/password it
// gives you -- the host is almost always "localhost" on Hostinger shared hosting).
//
// SETUP (do this once): copy this file to "config.php" in the same folder and
// fill in your real values there. config.php is in .gitignore and is NEVER
// tracked by git, so future code updates can never silently overwrite your
// real database credentials with these placeholders again. Do not edit this
// file (config.sample.php) with real credentials -- it is the template that
// ships with every update.
//
// Never show raw PHP/database errors to site visitors -- if a query ever
// fails unexpectedly, this stops the response from leaking file paths, table
// names, or connection details on the page. Errors are still fully recorded
// in the server's own PHP error log for debugging, just never rendered.
ini_set('display_errors', '0');
error_reporting(E_ALL);

define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

// Lets the deploy workflow clear this server's PHP opcode cache (opcache)
// right after every deploy, by calling cache-reset.php?token=... with this
// same value. Without this, a changed PHP file can keep running its OLD
// compiled version for a while after upload, even though the new file
// content is genuinely sitting on disk -- opcache only revalidates a file
// on its own schedule, not the instant it changes.
//
// SETUP: replace this with your own long random string (anything works,
// e.g. generate one at random.org or run `openssl rand -hex 32`), then add
// the exact same value as a "CACHE_RESET_TOKEN" secret in this repo's
// GitHub Settings -> Secrets and variables -> Actions.
define('CACHE_RESET_TOKEN', 'change-this-to-a-long-random-string');

// OPTIONAL -- live Google reviews on the homepage. Without these two lines the
// homepage shows the reviews managed in Admin -> Reviews instead.
//   1. Google Cloud Console -> create a project -> enable "Places API (New)"
//      (billing must be switched on; a few lookups a day cost almost nothing).
//   2. Credentials -> create an API key, and restrict it to "Places API (New)"
//      and to this server's IP address.
//   3. GOOGLE_PLACE_ID is your Business Profile's Place ID: find it with the
//      "Place ID Finder" (developers.google.com/maps/documentation/places/web-service/place-id)
//      by searching your business name.
// Google returns up to the 5 most relevant reviews; new ones appear within an hour.
// define('GOOGLE_PLACES_API_KEY', 'your-api-key');
// define('GOOGLE_PLACE_ID', 'your-place-id');

function get_db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
    return $pdo;
}
