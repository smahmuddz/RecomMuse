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
        /* Add custom CSS for the scrollbar and card size */
        .album-container {
            max-height: 550px; /* Define the maximum height for the container */
            overflow-y: auto; /* Add a vertical scrollbar when content overflows */
        }

        .card {
            /* Customize the card size here */
            width: 100%;
            max-width: 150px; /* Adjust the maximum width as needed */
        }
    </style>
</head>

<body>
    <?php
    $query = "SELECT * FROM `albums` ORDER BY album_name ASC;";
    // Execute the query
    $albums_result = $db->query($query);

    if ($albums_result) {
        $albums = $albums_result->fetch_all(MYSQLI_ASSOC);
        $num_rows = count($albums);
    } else {
        $num_rows = 0;
    }
    ?>

    <div class="container mt-5">
        <h3 class="mb-2" style="color:red;">Released Albums</h3>
        <div class="row justify-content-center"> <!-- Center the columns -->
            <div class="album-container">
                <?php foreach ($albums as $album): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card border-0 shadow">
                            <img src="<?php echo $album['album_cover_link']; ?>" class="card-img-top" alt="<?php echo $album['album_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $album['album_name']; ?></h5>
                                <a href="albumfeed.php?album=<?php echo urlencode($album['album_name']); ?>" class="btn btn-danger">View Songs</a>
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
