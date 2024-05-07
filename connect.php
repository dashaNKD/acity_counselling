<?php
// Define database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "login";

// Check if mysqli extension is available
if (!function_exists('mysqli_init') &&!class_exists('mysqli')) {
    echo "mysqli extension is not available";
    exit(); // Exit the script to prevent further execution
}

// Use the mysqli extension to connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    echo "Connection to DB failed: ". $conn->connect_error;
    exit(); // Exit the script to prevent further execution
}
