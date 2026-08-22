<?php
// Database connection shared by the public site (blog.php, our-team.php) and the
// admin panel (admin/). Fill in the four constants below with the values from
// Hostinger hPanel -> Databases -> MySQL Databases (create a database + user
// there first if you haven't already, then note the host/name/user/password it
// gives you -- the host is almost always "localhost" on Hostinger shared hosting).
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

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
