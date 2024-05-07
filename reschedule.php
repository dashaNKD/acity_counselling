<?php
// Include the database connection file
require_once("connect.php");

// Get the appointment ID from the query string
$appointment_id = $_GET['id'];

// Retrieve the appointment details from the database
$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

// Close the statement and the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
<nav class="bg-gray-800 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div>
            <a href="index.html" class="flex items-center text-white text-xl font-bold">
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

<!-- Reschedule Form -->
<section class="container mx-auto my-10 px-4">
    <h1 class="text-2xl mb-4">Reschedule Appointment</h1>
    <form action="submit_appointment.php" method="post">
        <input type="hidden" name="id" value="<?php echo $appointment_id; ?>">
        <div class="mb-4">
            <label for="date" class="block text-gray-700">Date</label>
            <input type="date" name="date" id="date" value="<?php echo $appointment['date']; ?>" required class="mt-2 w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">
        </div>
        <div class="mb-4">
            <label for="time" class="block text-gray-700">Time</label>
            <input type="time" name="time" id="time" value="<?php echo $appointment['time']; ?>" required class="mt-2 w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300">
            Reschedule Appointment
        </button>
    </form>
</section>

<!-- Footer -->
<footer class="bg-gray-800 py-8">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <a href="index.html" class="flex items-center text-white text-xl font-bold">
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