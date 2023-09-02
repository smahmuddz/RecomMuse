<?php
session_start();
include "database.php";
include "head.php";

// Function to handle file uploads
function uploadFile($file, $targetDir)
{
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        return null; // File already exists
    }

    // Check file size (adjust as needed)
    if ($file["size"] > 5000000) {
        return null; // File is too large
    }

    // Allow only certain file formats (you can modify this)
    if (
        $fileType != "mp3" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "png"
    ) {
        return null; // Invalid file format
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    } else {
        return null; // File upload failed
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $artist = $_POST["artist"];
    $album = $_POST["album"];

// Specify the target directories for music and cover image uploads
$musicTargetDir = "music/";
$coverImageTargetDir = "C:/xampp/htdocs/img/artistimages/"; // Corrected path

// Upload music file
$musicFile = $_FILES["music"];
$musicPath = uploadFile($musicFile, $musicTargetDir);

// Upload cover image file
$coverImageFile = $_FILES["cover_image"];
$coverImagePath = uploadFile($coverImageFile, $coverImageTargetDir);


    // Check if both files were uploaded successfully
    if ($musicPath !== null && $coverImagePath !== null) {
        // Insert song data into the database
        $query = "INSERT INTO songs (name, artist, album, music, coverImage) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssss", $name, $artist, $album, $musicPath, $coverImagePath);

        if ($stmt->execute()) {
            // Song added successfully
            header("Location: add_songs.php?success=true");
            exit();
        } else {
            // Database operation failed
            $errorMessage = "Error: Database operation failed.";
        }
    } else {
        // File upload failed
        $errorMessage = "Error: File upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Songs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Songs</h2>
    <?php
    if (isset($_GET['success']) && $_GET['success'] === 'true') {
        echo '<div class="alert alert-success">Song added successfully!</div>';
    } elseif (isset($errorMessage)) {
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    }
    ?>
    <form action="add_songs.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Song Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="artist">Artist:</label>
            <input type="text" class="form-control" id="artist" name="artist" required>
        </div>
        <div class="form-group">
            <label for="album">Album:</label>
            <input type="text" class="form-control" id="album" name="album" required>
        </div>
        <div class="form-group">
            <label for="music">Upload Song (MP3):</label>
            <input type="file" class="form-control-file" id="music" name="music" accept=".mp3" required>
        </div>
        <div class="form-group">
            <label for="cover_image">Upload Cover Image (JPEG or PNG):</label>
            <input type="file" class="form-control-file" id="cover_image" name="cover_image" accept=".jpg, .jpeg, .png" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Song</button>
    </form>
</div>
</body>
</html>
