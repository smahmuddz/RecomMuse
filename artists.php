<?php
session_start();
include "head.php";
include "database.php";
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .artist-container {
            max-height: 550px;
            overflow-y: auto; 
        }

        .card {
            width: 100%;
            max-width: 150px; 
        }
    </style>
</head>

<body>
    <?php
    $query = "SELECT * FROM `artists` ORDER BY name ASC;";
    $artists_result = $db->query($query);

    if ($artists_result) {
        $artists = $artists_result->fetch_all(MYSQLI_ASSOC);
        $num_rows = count($artists);
    } else {
        $num_rows = 0;
    }
    ?>

    <div class="container mt-5">
        <h3 class="mb-2" style="color:red;">Artists</h3>
        <div class="row justify-content-center"> 
            <div class="artist-container">
                <?php foreach ($artists as $artist): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card border-0 shadow">
                            <img src="<?php echo $artist['image']; ?>" class="card-img-top" alt="<?php echo $artist['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $artist['name']; ?></h5>
                                <a href="artistpage.php?artist=<?php echo urlencode($artist['name']); ?>" class="btn btn-danger">View Artist</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
