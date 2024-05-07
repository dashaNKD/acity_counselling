<?php
// Configuration file for database connection
require_once 'config.php';

// Function to fetch appointments
function fetchAppointments() {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM appointments");
    $stmt->execute();
    $result = $stmt->get_result();

    $appointments = array();
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }

    $stmt->close();

    return $appointments;
}

// Process the appointment update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);

    // Create a new mysqli object with error reporting
    global $conn;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE appointments SET status =? WHERE id =?");

    if ($stmt) {
        switch ($action) {
            case 'accept':
                $status = 'accepted';
                break;
            case 'cancel':
                $status = 'canceled';
                break;
            case 'reschedule':
                header("Location: reschedule.php?id=$id");
                exit();
            default:
                header("Location: booked_appointment.php?error=Invalid+action.");
                exit();
        }

        // Bind parameters by reference
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            header("Location: booked_appointment.php?success=Appointment+status+updated+successfully.");
        } else {
            header("Location: booked_appointment.php?error=". urlencode($stmt->error));
        }
    } else {
        header("Location: booked_appointment.php?error=". urlencode($conn->error));
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
} else {
    // Connect to the database
    global $conn;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
}

// Display submitted appointments
$result = fetchAppointments();
require_once 'booked_appointment.php';