<?php 
if(isset($_SESSION['login'])){
$query = "SELECT * FROM users WHERE id=" . $_SESSION['user_id'];
include 'database.php';
 $result = $db->query($query);
 if ($result->num_rows == 1) {
     $user = $result->fetch_assoc();
    $username= $user['name'];
    $image= $user["profile_image"];
  }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/feed.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>RecomMuse</title>
    <link rel="icon" href="img/favicon-3.png">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fd3c4f;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="img/wave.png" alt="logo" width="50px" srcset=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" style="color:#ffffff; " aria-current="page" href="index.php">হোম</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" style="color:#ffffff;" aria-current="page" href="albums.php">অ্যালবাম</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" style="color:#ffffff;" aria-current="page" href="artists.php">সঙ্গীতশিল্পী</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" style="color:#ffffff;" aria-current="page" href="discover.php">মিউজিক ফিড</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" style="color:#ffffff;" aria-current="page" href="playlist.php">প্লেলিস্ট</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <?php if(empty($_SESSION['login'])):?>
                    <a href="login.php" class="btn btn-light mx-2 bp-4" type="button">লগিন</a>
                <?php elseif(!empty($_SESSION['login'])): ?>
                    <!--profile button -->
                    <a href="my_profile.php" class="btn btn-outline-light mx-2" type="button">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo 'img/user/' . $image; ?>" alt="Profile Image" width="30" height="30" style="border-radius: 50%; margin-right: 5px;">
                            
                            <!-- I just wanted to show the first name in the dashboard button -->
                            <?php
                            $nameParts = explode(' ', $username); 
                            if (count($nameParts) > 0) {
                                $firstName = $nameParts[0]; 
                                echo $firstName;
                            }
                            ?>
                        </div>
                    </a>
                <a href="logout.php" class="btn btn-light mx-4" style="height:70%; margin-top:8px;" type="button">লগ আউট</a>
                <?php endif; ?>           
          </form>
          <form class="d-flex" method="POST" action="feed2.php">
                <input class="form-control me-2" type="search" name="searchQuery" placeholder="পছন্দের গান সার্চ করুন" aria-label="Search">
                <button class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i>সার্চ</button>
            </form> 
        </div>
    </div>
</nav>
</body>
</html>