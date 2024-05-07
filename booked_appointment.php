<?php
require_once 'config.php'; // Included the database connection file

// Check if the fetchAppointments function returns a valid result
if ($result = $appointments = fetchAppointments($conn)) {
    // Check if fetchAppointments returned a value (not false)
    if (is_bool($result) && !$result) {
      echo 'Error: Unable to fetch appointments';
      exit;
    } else if (!($result instanceof mysqli_result)) {
      // Check if the result is a valid MySQLi result object
      echo 'Error: Invalid result object';
      exit;
    }
    // ... rest of your code where you process $result ...
  } else {
    // Handle the scenario where fetchAppointments failed to even execute (e.g., database connection issue)
    echo 'Error: An unexpected error occurred.';
    exit;
}  
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