<?php
// Start session to check if counselor is logged in
session_start();

// Check if counselor is not logged in, redirect to login page
if (!isset($_SESSION['counselor_logged_in']) || $_SESSION['counselor_logged_in']!== true) {
    header("Location: counselor_login.php");
    exit;
}

// Include database connection file
require_once 'config.php';

// Fetch appointments from the database
try {
    $sql = "SELECT * FROM appointments";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    echo "Error: ". $e->getMessage();
    exit;
}