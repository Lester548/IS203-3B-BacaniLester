<?php
require('./database.php');

// Registration Process
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = $_POST['email'];

    if ($password !== $confirmPassword) {
        echo '<script>alert("Passwords do not match!"); window.location.href="register.php";</script>';
        exit();
    } elseif (strlen($password) < 8) {
        echo '<script>alert("Password must be at least 8 characters long!"); window.location.href="register.php";</script>';
        exit();
    } elseif ($username === $password) {
        echo '<script>alert("Username cannot be the same as password!"); window.location.href="register.php";</script>';
        exit();
    } else {
        $queryCheckUsername = "SELECT * FROM register WHERE Username = '$username'";
        $sqlCheckUsername = mysqli_query($connection, $queryCheckUsername);

        if (mysqli_num_rows($sqlCheckUsername) > 0) {
            echo '<script>alert("Username already exists! Please choose a different username."); window.location.href="register.php";</script>';
            exit();
        }

        $queryCheckEmail = "SELECT * FROM register WHERE Email = '$email'";
        $sqlCheckEmail = mysqli_query($connection, $queryCheckEmail);

        if (mysqli_num_rows($sqlCheckEmail) > 0) {
            echo '<script>alert("Email already used! Please choose a different email."); window.location.href="register.php";</script>';
            exit();
        }

        $queryRegister = "INSERT INTO register (Email, Username, Password, Confirm) VALUES ('$email', '$username', '$password', '$confirmPassword')";
        $sqlRegister = mysqli_query($connection, $queryRegister);

        if ($sqlRegister) {
            echo '<script>alert("Registration Successful!"); window.location.href="register.php";</script>';
            exit();
        } else {
            echo '<script>alert("Failed to Register! Error: ' . mysqli_error($connection) . '"); window.location.href="register.php";</script>';
            exit();
        }
    }
}

// Login Process
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists
    $query = "SELECT * FROM register WHERE Username = '$username'";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Check if the password matches
        if ($user['Password'] === $password) {
            // Successful login, you can set session variables here if needed
            echo '<script>alert("Login Successful!"); window.location.href="index.php";</script>';
            exit();
        } else {
            echo '<script>alert("Incorrect Password!"); window.location.href="register.php";</script>';
            exit();
        }
    } else {
        echo '<script>alert("Username does not exist!"); window.location.href="register.php";</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
        <div class="login-form">
            <div class="sign-in-htm">
                <form method="POST" action="register.php">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input id="user" name="username" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" name="password" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <input id="check" type="checkbox" class="check" checked>
                        <label for="check"><span class="icon"></span> Keep me Signed in</label>
                    </div>
                    <div class="group">
                        <input type="submit" name="login" class="button" value="Sign In">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="#forgot">Forgot Password?</a>
                    </div>
                </form>
            </div>
            <div class="sign-up-htm">
                <form method="POST" action="register.php">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input id="user" name="username" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" name="password" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <label for="confirmPass" class="label">Repeat Password</label>
                        <input id="confirmPass" name="confirmPassword" type="password" class="input" data-type="password" required>
                    </div>
                    <div class="group">
                        <label for="email" class="label">Email Address</label>
                        <input id="email" name="email" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <input type="submit" name="register" class="button" value="Sign Up">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Already Member?</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
