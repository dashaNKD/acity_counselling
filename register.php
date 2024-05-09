<?php
// Include the database connection file
include 'config.php';

// Sign Up Process
if(isset($_POST['signUp'])){
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

    if($result->num_rows > 0){
        echo "Email Already Exists!";
    } else {
        // Hash the password using MD5
        $hashedPassword = md5($password);

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

    // Close the prepared statement
    $stmt->close();
}

// Sign In Process
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize input data
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    // Hash the provided password using MD5
    $hashedPassword = md5($password);

    // Check if the counselor exists in the database
    $sql = "SELECT * FROM counselors WHERE email =? AND password_hash =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashedPassword);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['email'] = $email;
        header("Location: counselor_dashboard.php");
        exit(); // Add exit to prevent further execution
    } else {
        echo "Invalid Email or Password";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
