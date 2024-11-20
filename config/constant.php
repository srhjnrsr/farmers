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
    define('DB_HOST', 'localhost');
}
//prod: 'srv1716.hstgr.io'
//local: localhost

if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
//prod: 'u186919644_farmers'
//local: root

if (!defined('DB_PASS')) {
    define('DB_PASS', '');
}
//prod: '5S#K;N$uJ'
//local: ''

if (!defined('DB_NAME')) {
    define('DB_NAME', 'lagonoy_farmers');
}
//prod: 'u186919644_lagonoy_farmer'
//local: 'lagonoy_farmers'
