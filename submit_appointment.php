<?php
require_once 'config.php'; // Include the database connection

// Function to fetch appointments from database
function fetchAppointments($conn) {
    $sql = "SELECT * FROM appointments ORDER BY date, time ASC"; // Replace with your specific query
    $result = $conn->query($sql);
  
    if ($result->num_rows > 0) {
      $appointments = [];
      while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
      }
      return $appointments;
    } else {
      return []; // Return empty array if no appointments found
    }
  }

// Define regular expressions for basic validation (replace with more robust validation if needed)
$nameRegex = "/^[a-zA-Z ]+$/"; // Allow letters and spaces for name
$emailRegex = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/"; // Basic email format
$rollNumberRegex = "/^[0-9]+$/"; // Allow only digits for roll number

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $rollNumber = filter_var($_POST['rollNumber'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
  $time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
  $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  // Validate data (replace with your specific validation logic)
  $errors = [];
  if (!preg_match($nameRegex, $name)) {
    $errors[] = "Invalid name format. Only letters and spaces allowed.";
  }
  if (!empty($rollNumber) && !preg_match($rollNumberRegex, $rollNumber)) {
    $errors[] = "Invalid roll number format. Only digits allowed.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }
  if (empty($date) || empty($time)) {
    $errors[] = "Please enter both date and time.";
  }

  if (empty($errors)) {
    // Create a prepared statement to insert new appointment
    $stmt = $conn->prepare("INSERT INTO appointments (name, roll_number, email, date, time, message, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sssssss", $name, $rollNumber, $email, $date, $time, $message);

    if ($stmt->execute()) {
      // Appointment creation successful, consider using fetchAppointments to update view (optional)
      // header("Location: booked_appointments.php?success=Appointment+submitted+successfully.");  // Uncomment for redirection

      // (Optional) Call fetchAppointments function to update appointments view (replace with your actual function call)
      $appointments = fetchAppointments($conn);  
  
    } else {
      // Appointment creation failed, redirect with error message
      header("Location: booked_appointments.php?error=" . urlencode($stmt->error));
    }

    $stmt->close();
  } else {
    // Display form with errors
    echo "<h1>Submit Appointment</h1>";
    echo "<ul>";
    foreach ($errors as $error) {
      echo "<li style='color: red;'>$error</li>";
    }
    echo "</ul>";
    // Include the form again with pre-filled data (optional, improve user experience)
    include 'appointments.html'; // Replace with your form template
  }
} else {
  // Display the appointment submission form
  include 'appointments.html'; // Replace with your form template
}

$conn->close(); // Close the database connection (optional, can be closed in a central location)
