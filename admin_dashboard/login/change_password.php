<?php
session_start();
include "../database/config.php";

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login/login.html");
    exit();
}

$uname = $_SESSION['admin'];
$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the admin record
    $sql = "SELECT password FROM `admin` WHERE `user_name`='$uname'";
    $result = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if (!$result) {
        $error = "Error fetching admin data: " . mysqli_error($conn);
    } else {
        $admin = mysqli_fetch_assoc($result);

        // Check if the old password matches
        if ($admin && $admin['password'] === $old_password) {
            if ($new_password === $confirm_password) {
                // Update the password
                $update_sql = "UPDATE `admin` SET `password`='$new_password' WHERE `user_name`='$uname'";
                if (mysqli_query($conn, $update_sql)) {
                    $success = "Password successfully updated!";
                } else {
                    $error = "Error updating password: " . mysqli_error($conn);
                }
            } else {
                $error = "New password and confirmation do not match.";
            }
        } else {
            $error = "Old password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 10px rgba(0,0,0,0.1);
        }
        .back-btn {
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="../dashboard/dashboard.php" class="btn btn-secondary back-btn">Back to Dashboard</a>

    <div class="card">
        <h3 class="text-center">Change Password</h3>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" id="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>

</body>
</html>
