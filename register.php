<?php
session_start();
include "database.php";
include "head.php";

// Initialize error message variables
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $profileImage = $_FILES['profile_image'];
    $uid = $_POST['uid']; // Add the UID input

    // Perform registration validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($uid)) {
        $error_message = "Please fill in all fields.";
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $name)) {
        $error_message = "Invalid name format. Only letters and spaces are allowed.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' OR uid = '$uid'"; // Modify the query to include UID
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['email'] === $email) {
                $error_message = "Email already exists. Please choose a different one.";
            } elseif ($row['uid'] === $uid) {
                $error_message = "UID already exists. Please choose a different one.";
            }
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Handle profile image upload
            $profileImageName = '';
            if ($profileImage['error'] == UPLOAD_ERR_OK) {
                $profileImageName = time() . '_' . $profileImage['name'];
                move_uploaded_file($profileImage['tmp_name'], 'img/user/' . $profileImageName);
            }

            // Insert data into the database
            $insertQuery = "INSERT INTO users (name, email, password, profile_image, uid) VALUES ('$name', '$email', '$hashedPassword', '$profileImageName', '$uid')";
            if ($db->query($insertQuery) === TRUE) {
                $success_message = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error_message = "Error during registration: " . $db->error;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
            overflow: auto; 
        }
        .page-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="page-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4 form-container">
                <div class="text-center">
                <img src="img/favicon.png" alt="" srcset="">
                <h1 class="text-center">Register</h1>
                </div><!-- Display success or error messages -->
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Name input -->
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required pattern="^[A-Za-z\s]+$" />
                    </div>

                    <!-- Email input -->
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter a valid email address" required />
                    </div>

                    <!-- UID input -->
                    <div class="form-group">
                        <input type="text" id="uid" name="uid" class="form-control" placeholder="Enter UID" required />
                    </div>

                    <!-- Password input -->
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required />
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-group">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required />
                    </div>

                    <!-- Profile Image input -->
                    <div class="form-group">
                        <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*" />
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger">Register</button>
                        <p class="mt-2">Already have an account? <a href="login.php" class="text-danger">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
