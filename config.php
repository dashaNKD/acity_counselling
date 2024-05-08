<?php
// Connect to the database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "appointments";

// Create a new mysqli object with error reporting
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the appointment ID and the action from the form
$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
$action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");

// Check if the SQL statement was prepared successfully
if ($stmt) {
    // Set the status based on the action
    if ($action == 'accept') {
        $status = 'accepted';
    } elseif ($action == 'cancel') {
        $status = 'canceled';
    } else {
        // Redirect back to the booked_appointment.php file with an error message
        header("Location: appointments.php?error=Invalid+action.");
        exit();
    }

    // Bind parameters by reference
    $stmt->bind_param("si", $status, $id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect back to the booked_appointment.php file with a success message
        header("Location: appointments.php?success=Appointment+status+updated+successfully.");
    } else {
        // Redirect back to the booked_appointment.php file with an error message
        header("Location: appointments.php?error=" . urlencode($stmt->error));
    }

    // Close the statement and the connection
    $stmt->close();
} else {
    // Redirect back to the booked_appointment.php file with an error message
    header("Location: appointments.php?error=" . urlencode($conn->error));
}

// Close the connection
$conn->close();

// If the action is 'reschedule'
if ($action == 'reschedule') {
    // Redirect to the reschedule page with the appointment data
    header("Location: reschedule.php?id=$id");
    exit();
}
