<?php
// Include the database connection file
require_once 'config.php';

// Retrieve form data
$name = $_POST['name'];
$rollNumber = $_POST['rollNumber'];
$email = $_POST['email'];
$message = $_POST['message'];

// Insert data into the messages table
$sql = "INSERT INTO messages (name, roll_number, email, message) 
        VALUES ('$name', '$rollNumber', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    // Set success message
    $successMessage = "In-person session successfully booked!";
    // Redirect user to contact.html after successful message
    header('Location: contact.html?message=' . urlencode($successMessage));
    exit(); // Ensure no further output is sent
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
