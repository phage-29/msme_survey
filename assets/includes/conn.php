<?php

define('servername', 'localhost');
define('username', 'root');
define('password', 'Password@123!');
define('dbname', 'midb');

define('website', 'Market Intelligence');

$conn = new mysqli(servername, username, password, dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

require_once "common_functions.php";
