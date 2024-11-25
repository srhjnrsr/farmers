<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";

$currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = explode('/', $currentUrl);
$root = $url[0] . '//' . $url[2] . '/' . $url[3] . '/';
//get the root url
//so that we can use it in other files
if (!defined('ROOT_URL')) {
    define('ROOT_URL', $root);
}

if (!defined('DB_HOST')) {
    // define('DB_HOST', 'https://palegoldenrod-elk-953378.hostingersite.com/');
    define('DB_HOST', 'localhost');
}
//local: localhost

if (!defined('DB_USER')) {
    // define('DB_USER', 'u412427249_farmers');
    define('DB_USER', 'root');
}
//local: root

if (!defined('DB_PASS')) {
    // define('DB_PASS', 'u412427249_Root_root011200');
    define('DB_PASS', '');
}
//local: ''
if (!defined('DB_NAME')) {
    // define('DB_NAME', 'u412427249_lagonoy_farmers');
    define('DB_NAME', 'lagonoy_farmers');
}

//local: 'lagonoy_farmers'
