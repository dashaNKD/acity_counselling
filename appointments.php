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
      header('Location: appointments.php'); // Redirect to same page to avoid resubmission
      exit;
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
                    <a href="logout.php" class="text-gray-300 hover:text-white px-3 py-2">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main content -->
<main class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-4">Booked Appointments</h1>
    <form action="appointments.php" method="post" class="bg-white p-4 rounded">
        <div class="mb-4">
            <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="rollNumber" class="block mb-2 text-sm font-bold text-gray-700">Roll Number</label>
            <input type="text" name="rollNumber" id="rollNumber" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-bold text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="date" class="block mb-2 text-sm font-bold text-gray-700">Date</label>
            <input type="date" name="date" id="date" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="time" class="block mb-2 text-sm font-bold text-gray-700">Time</label>
            <input type="time" name="time" id="time" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="message" class="block mb-2 text-sm font-bold text-gray-700">Message</label>
            <textarea name="message" id="message" rows="4" class="w-full p-2 border rounded" required></textarea>
        </div>
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Book Appointment
            </button>
        </div>
    </form>

    <!-- Display existing appointments -->
<h2 class="text-2xl font-bold mb-4">Current Appointments</h2>
<table class="w-full bg-white rounded-lg overflow-hidden">
    <thead class="bg-gray-200">
        <tr>
            <th class="text-left py-2 px-4">Name</th>
            <th class="text-left py-2 px-4">Roll Number</th>
            <th class="text-left py-2 px-4">Email</th>
            <th class="text-left py-2 px-4">Date</th>
            <th class="text-left py-2 px-4">Time</th>
            <th class="text-left py-2 px-4">Message</th>
            <th class="text-left py-2 px-4">Status</th>
            <th class="text-left py-2 px-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment):?>
            <tr>
                <td class="border py-2 px-4"><?php echo htmlspecialchars($appointment['name']);?></td>
                <td class="border py-2 px-4"><?php echo htmlspecialchars($appointment['roll_number']);?></td>
                <td class="border py-2 px-4"><?php echo htmlspecialchars($appointment['email']);?></td>
                <td class="border py-2 px-4"><?php echo htmlspecialchars($appointment['date']);?></td>
                <td class="border py-2 px-4"><?php echo htmlspecialchars($appointment['time']);?></td>
                <td class="border py-2 px-4"><?php echo htmlspecialchars($appointment['message']);?></td>
                <td class="border py-2 px-4">
                    <?php if ($appointment['status'] === 'pending'):?>
                        <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full">Pending</span>
                    <?php elseif ($appointment['status'] === 'confirmed'):?>
                        <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full">Confirmed</span>
                    <?php else:?>
                        <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full">Canceled</span>
                    <?php endif;?>
                </td>
                <td class="border py-2 px-4">
                    <form action="reschedule.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $appointment['id'];?>">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Reschedule
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
</main>

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