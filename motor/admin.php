<!-- admin.php -->
<?php
require('./database.php');

if (isset($_POST['adminLogin'])) {
    $username = $_POST['adminUsername'];
    $password = $_POST['adminPassword'];

    // Query to check for admin role
    $queryAdminLogin = "SELECT * FROM register WHERE Username = '$username' AND role = 'admin'";
    $resultAdminLogin = mysqli_query($connection, $queryAdminLogin);
    $admin = mysqli_fetch_assoc($resultAdminLogin);

    if ($admin && $password === $admin['Password']) {
        // Admin login successful
        echo '<script>alert("Admin Login Successful! Welcome, ' . $admin['Username'] . '"); window.location.href="admindb.php";</script>';
    } else {
        // Invalid admin credentials
        echo '<script>alert("Invalid Admin Username or Password!"); window.location.href="admin.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Admin</title>
</head>
<body>
    <!-- Icon Circle above the form -->
    <div class="icon-circle">
        <i class="fas fa-user-shield"></i> <!-- Admin icon inside the circle -->
    </div>

    <div class="wrapper">
        <h2>Admin</h2>
        <form method="POST" action="">
            <div class="input-box">
                <i class="fas fa-user"></i> <!-- Icon for username -->
                <input type="text" name="adminUsername" id="adminUsername" placeholder="Enter Admin Username" required>
            </div>
            <div class="input-box">
                <i class="fas fa-lock"></i> <!-- Icon for password -->
                <input type="password" name="adminPassword" id="adminPassword" placeholder="Enter Admin Password" required>
                <span class="eye-icon" onclick="togglePasswordVisibility('adminPassword')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="input-box button">
                <input type="submit" name="adminLogin" value="Login">
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>