<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Access</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styleUser.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<main>
    <div class="container" id="signup">
        <h1 class="form-title">Register</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id="fName" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                <label for="lName">Last Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <p class="or">
            ----------or----------
        </p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook-f"></i>
        </div>
        <div class="links">
            <p>Already Have An Account ?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <div class="container" id="signIn" style="display:none;">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <p class="recover">
                <a href="#">Forgot Password ?</a>
            </p>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">
            ----------or----------
        </p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook-f"></i>
        </div>
        <div class="links">
            <p>Don't have an account ?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-800 py-8">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <a href="index.html" class="flex items-center text-black text-xl font-bold">
                <img src="assets/img/currentAcityLogo.png" alt="Acity Counselling Service logo" class="h-8 mr-2">
                Acity Counselling Service
            </a>
            <p class="text-black">&copy; 2024 Academic City University College Counselling Service. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="assets/js/scriptUser.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>