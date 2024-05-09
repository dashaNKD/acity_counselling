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

    <!-- Header with logout button -->
    <header>
        <h1>Counselor Dashboard</h1>
        <form action="logout.php" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </header>

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
