<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";

$currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = explode('/', $currentUrl);
$root = $url[0] . '//' . $url[2] . '/' . $url[3] . '/';


if (!defined('ROOT_URL')) {
    define('ROOT_URL', $root);
}
if (!defined('DB_HOST')) {
    define('DB_HOST', 'https://goldenrod-tarsier-926635.hostingersite.com/');
    // define('DB_HOST', 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'u186919644_roots');
    // define('DB_USER', 'root');

}
if (!defined('DB_PASS')) {

    define('DB_PASS', 'Root_root011200');
    // define('DB_PASS', '');

}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'u186919644_lagonoy');
    // define('DB_NAME', 'lagonoy_farmers');
}
