<!-- counselor_dashboard.php -->

<?php
    // Start session to check if counselor is logged in
    session_start();

    // Check if counselor is not logged in, redirect to login page
    if (!isset($_SESSION['counselor_logged_in']) || $_SESSION['counselor_logged_in'] !== true) {
        header("Location: counselor_login.php");
        exit;
    }

    // Include database connection file
    require_once 'config.php';

    // Fetch appointments from the database
    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Navigation -->
    <nav class="bg-gray-800 py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div>
                <a href="index.html" class="flex items-center text-white text-xl font-bold">
                    <img src="img/currentAcityLogo.png" alt="Acity Counselling Service logo" class="h-8 mr-2">
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
                        <a href="counselor_login.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300 md:w-auto">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <!-- Display Appointments -->
        <section class="appointments">
            <h2>Appointments</h2>
            <table>
                <tr>
                    <th>Client Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>";
                            echo "<button>Accept</button>";
                            echo "<button>Cancel</button>";
                            echo "<button>Reschedule</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No appointments found</td></tr>";
                    }
                ?>
            </table>
        </section>
    </main>

</body>
</html>
