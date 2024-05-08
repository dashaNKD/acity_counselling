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
  if (!empty($rollNumber) &&!preg_match($rollNumberRegex, $rollNumber)) {
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
    $stmt = $conn->prepare("INSERT INTO appointments (name, roll_number, email, date, time, message, status) VALUES (?,?,?,?,?,?, 'pending')");
    $stmt->bind_param("sssssss", $name, $rollNumber, $email, $date, $time, $message);

    if ($stmt->execute()) {
      // Appointment creation successful, update appointments view
      $appointments = fetchAppointments($conn);  
    } else {
      $errors[] = "Error creating appointment: ". $stmt->error;
    }

    $stmt->close();
  }
}

// Display the appointment submission form
include 'appointments.html'; // Replace with your form template

// Display appointments table
$appointments = fetchAppointments($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Appointments</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
<nav class="bg-gray-800 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div>
            <a href="homepageCounselor.php" class="flex items-center text-white text-xl font-bold">
                <img src="assets/img/currentAcityLogo.png" alt="Acity Counselling Service logo" class="h-8 mr-2">
                Acity Counselling Service
            </a>
        </div>
        <div>
            <ul class="flex justify-between">
                <li><a href="about.html" class="text-gray-300 hover:text-white px-3 py-2">About Us</a></li>
                <li><a href="resources.html" class="text-gray-300 hover:text-white px-3 py-2">Resources</a></li>
                <li><a href="services.html" class="text-gray-300 hover:text-white px-3 py-2">Services</a></li>
                <li><a href="contact.html" class="text-gray-300 hover:text-white px-3 py-2">Contact Us</a></li>
                <li>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300 md:w-auto">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Appointments Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-8">Booked Appointments</h2>
            <?php if (!empty($appointments)) {?>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Roll Number</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Time</th>
                            <th class="px-4 py-2">Message</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment) {?>
                            <tr>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['name'])?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['roll_number'])?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['email'])?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['date'])?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['time'])?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['message'])?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($appointment['status'])?></td>
                                <td class="px-4 py-2">
                                    <form action="submit_appointment.php" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($appointment['id'])?>">
                                        <button type="submit" name="accept" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300 mr-2">Accept</button>
                                        <button type="submit" name="reject" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300 mr-2">Reject</button>
                                        <button type="submit" name="reschedule" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300">Reschedule</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            <?php } else {?>
                <p class="text-center">No appointments found.</p>
            <?php }?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 py-8">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <a href="homepageCounselor.php" class="flex items-center text-white text-xl font-bold">
                <img src="assets/img/currentAcityLogo.png" alt="Acity Counselling Service logo" class="h-8 mr-2">
                Acity Counselling Service
            </a>
            <p class="text-white">&copy; 2024 Academic City University College Counselling Service. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="assets/js/custom.js"></script>
<script src="assets/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>