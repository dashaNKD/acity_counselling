<?php
// Include the database connection file
require_once 'config.php';

// Initialize session
session_start();

// Sign Up Process
if (isset($_POST['signUp'])) {
    $firstName = filter_input(INPUT_POST, 'fName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Check if the email already exists
    $checkEmailSql = "SELECT * FROM counselors WHERE email =?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        echo "Error: " . $conn->error;
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email Already Exists!";
    } else {
        // Insert the counselor into the database
        $insertQuery = "INSERT INTO counselors (first_name, last_name, email, password) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

        if (!$stmt->execute()) {
            echo "Error: " . $conn->error;
            exit();
        }

        header("Location: counselor_dashboard.html");
        exit(); // Add exit to prevent further execution
    }
}

// Sign In Process
if (isset($_POST['signIn'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Check if the counselor exists in the database
    $sql = "SELECT * FROM counselors WHERE email =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        echo "Error: " . $conn->error;
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['email'] = $email;
            header("Location: counselor_dashboard.html");
            exit(); // Add exit to prevent further execution
        } else {
            echo "Invalid Email or Password";
        }
    } else {
        echo "Invalid Email or Password";
    }
}

// Close the database connection
$conn->close();