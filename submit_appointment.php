<?php
// Include the database connection file
require_once 'config.php';

// Retrieve form data
$name = $_POST['name'];
$rollNumber = $_POST['roll_number'];
$email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];
$message = $_POST['message'];

// Insert data into the appointments table
$sql = "INSERT INTO appointments (name, roll_number, email, date, time, message) 
        VALUES ('$name', '$rollNumber', '$email', '$date', '$time', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
