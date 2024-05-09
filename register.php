<?php
// Include the database connection file
require_once 'config.php';

// Initialize session
session_start();

// Sign Up Process
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize input data
    $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
    $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    // Check if the email already exists
    $checkEmailSql = "SELECT * FROM counselors WHERE email =?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email Already Exists!";
    } else {
        // Hash the password using password_hash (instead of MD5)
        //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the counselor into the database
        $insertQuery = "INSERT INTO counselors (first_name, last_name, email, password_hash) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: counselor_dashboard.php");
            exit(); // Add exit to prevent further execution
        } else {
            echo "Error: ". $conn->error;
        }
    }
}

// Sign In Process
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize input data
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    // Check if the counselor exists in the database
    $sql = "SELECT * FROM counselors WHERE email =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['email'] = $email;
            header("Location: counselor_dashboard.php");
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