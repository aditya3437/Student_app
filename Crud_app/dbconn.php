<?php

// Check if constants are not defined
if (!defined("HOSTNAME")) {
    define("HOSTNAME", "localhost:3307");
}

if (!defined("USERNAME")) {
    define("USERNAME", "root");
}

if (!defined("PASSWORD")) {
    define("PASSWORD", "");
}

if (!defined("DATABASE")) {
    define("DATABASE", "crud_app");
}

// Establishing a connection to the database
$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// Checking if the connection was successful
if (!$connection) {
    die("Couldn't connect to database: " . mysqli_connect_error());
} 
?>
