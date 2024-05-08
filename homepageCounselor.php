<?php
// Start user session
session_start();

// Include connection file
require_once("config.php");
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acity Counselling Service</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            position: relative;
            background-image: url('assets/img/mentalHealth.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Watermark effect */
        .logo-watermark {
            position: fixed;
            opacity: 0.05;
            pointer-events: none;
            z-index: -1;
            bottom: 20px;
            right: 20px;
            width: 200px;
            transform: rotate(30deg) scale(1.5);
        }

        /* Glassmorphism effect */
        .glassmorphism {
            background-color: rgba(255, 255, 255, 0.3); /* Background color with transparency */
            -webkit-backdrop-filter: blur(10px); /* Blur effect */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 20px; /* Rounded corners */
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); /* Box shadow */
        }

        /* Red button styles */
        .red-button {
            background-color: #f44336; /* Red color */
        }

        .red-button:hover {
            background-color: #da190b; /* Dark red color */
        }

        .red-button:hover .text-white {
            font-weight: bold; /* Bolden text on hover */
        }
    </style>
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

<!-- Hero Section -->
<section class="glassmorphism bg-gray-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to the Acity Counselling Service</h1>
            <p class="text-lg text-gray-700 mb-8">We are here to support your mental health and well-being.</p>
            <a href="services.html" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300">Learn More</a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-8">Our Services</h2>
            <!-- Group Therapy Service Card -->
            <div class="glassmorphism bg-white shadow-md rounded-lg p-8 mb-8">
                <h3 class="text-2xl font-semibold mb-4">Group Therapy</h3>
                <p class="text-gray-700 mb-4">Join our group therapy sessions with fellow students.</p>
                <a href="https://acity.edu.gh/careers.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300">Learn More</a>
            </div>
            <!-- End of Group Therapy Service Card -->

            <!-- List of Appointments Card -->
            <div class="glassmorphism bg-white shadow-md rounded-lg p-8 mb-8">
                <h3 class="text-2xl font-semibold mb-4">Pending Appointments</h3>
                <p class="text-gray-700 mb-4">Find the current appointments that have to be met or canceled to be rescheduled.</p>
                <a href="booked_appointment.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition duration-300">Bookings</a>
            </div>
            <!-- End of List of Appointments Card -->
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

<script src="assets/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>