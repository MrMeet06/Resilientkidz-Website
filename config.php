<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$dbHost = 'localhost'; // Host name (default: 'localhost')
$dbUsername = 'root'; // MySQL database username
$dbPassword = 'root'; // MySQL database password
$dbName = 'resilentkidz'; // MySQL database name

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>