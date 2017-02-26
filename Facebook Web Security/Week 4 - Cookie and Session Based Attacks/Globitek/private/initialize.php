<?php

// Make sure output buffering is turned on in php.ini before
// attempting page redirects. Or else uncomment the line below.
ob_start();

// Enable sessions
session_start([
    'use_only_cookies' => true,       //Using cookies to store the Session ID on the client side. Added to prevent attacks involving passing session IDs in URLs
    'cookie_lifetime' => (24*60*60),        //Sets the lifetime of a cookie. In this case, 86400 means that the cookies will be saved for one day
    'cookie_httponly' => true         //Prevents XSS by making the cookies only accessible through the HTTP protocol. Meaning the cookies will not be accessible to scripting languages such as Javascript
  ]);

// Turns off any browser built-in XSS protections
// LEAVE THIS LINE IN WHILE YOU ARE LEARNING
// We want to get punished for any XSS mistakes...
header('X-XSS-Protection: 0');

// Assign path shortcuts to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the parent directory
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("SHARED_PATH", PRIVATE_PATH . '/shared');
define("PUBLIC_PATH", PROJECT_PATH . '/public');

// DOC_ROOT is everything in URL up to and including "/public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("DOC_ROOT", $doc_root);

require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');
require_once('validation_functions.php');
require_once('auth_functions.php');
require_once('csrf_functions.php');

$db = db_connect();

?>
