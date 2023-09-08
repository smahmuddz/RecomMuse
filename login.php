<?php
session_start();
include "database.php";
include "head.php";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Validate email using regex
    if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
        $error_message = "Invalid email format";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $db->query($query);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password']; 

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php");
                exit; 
            } else {
                $error_message = "Invalid login credentials";
            }
        } else {
            $error_message = "Invalid login credentials";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .page-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .image-container {
            display: flex;
            align-items: center;
            padding: 20px;
        }
        .rotating-image {
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</head>
<body>
<div class="page-container">
    <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5 col-xl-4 image-container" style="margin-right: 10px;">
                    <img src="img/disc.png" class="img-fluid rotating-image" alt="Sample image">
                </div>

            <div class="col-md-6 col-lg-4 col-xl-3 form-container ml-5">
                <div class="text-center" style="margin-bottom: 20px;">
                    <h1>আপনাকে স্বাগতম</h1>
                    
                    <img style="margin-bottom:10px;" src="img/favicon.png" alt="" srcset="">
                    <p>আপনার পছন্দের গান রেকমেন্ডেশন পেতে এখনি লগিন করুন।</p>
                </div>
              

                <div class="text-danger text-center"><?php echo $error_message; ?></div>
                <form action="" method="post">
                    
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="ই-মেইল" required />
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="পাসওয়ার্ড" required />
                    </div>
                        <div class="d-flex justify-content-between align-items-center text-left">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    রিমেম্বার মি
                                </label>
                            </div>
                            <a href="#!" class="text-body">ফরগট পাসওয়ার্ড?</a>
                        </div>

                        <div class="text-center mt-4 text-left"> <!-- Added the text-left class -->
                            <button type="submit" class="btn btn-danger">লগিন</button>
                            <p class="mt-4">আপনার কী একাউন্ট নেই? <a href="register.php" class="text-danger">রেজিস্টার
                            </a></p>
                        </div>
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
