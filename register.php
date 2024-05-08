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
    $checkEmailSql = "SELECT * FROM users WHERE email =?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        echo "Email Already Exists!";
    } else {
        // Insert the user into the database
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

        if ($stmt->execute()) {
            header("Location: indexCounselor.php");
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

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare the provided password with the stored password
        if ($password === $row['password']) {
            session_start();
            $_SESSION['email'] = $row['email'];
            header("Location: homepageCounselor.php");
            exit(); // Add exit to prevent further execution
        } else {
            echo "Invalid Email or Password";
        }
    } else {
        echo "Not Found, Invalid Email or Password";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
