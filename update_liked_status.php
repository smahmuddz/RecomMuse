<?php
session_start();
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $songId = $_POST["song_id"];
    $liked = $_POST["liked"];
    $unliked = $_POST["unliked"];
    $userId = $_SESSION["user_id"];

    // Check if a record for the user and song already exists in the liked_songs table
    $query = "SELECT * FROM liked_songs WHERE user_id = $userId AND song_id = $songId";
    $result = $db->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            // A record already exists, update it
            $updateQuery = "UPDATE liked_songs SET liked = $liked, unliked = $unliked WHERE user_id = $userId AND song_id = $songId";
            if ($db->query($updateQuery)) {
                echo "Liked status updated successfully.";
            } else {
                echo "Error updating liked status: " . $db->error;
            }
        } else {
            // No record exists, insert a new one
            $insertQuery = "INSERT INTO liked_songs (user_id, song_id, liked, unliked) VALUES ($userId, $songId, $liked, $unliked)";
            if ($db->query($insertQuery)) {
                echo "Liked status inserted successfully.";
            } else {
                echo "Error inserting liked status: " . $db->error;
            }
        }
    } else {
        echo "Error checking liked status: " . $db->error;
    }
} else {
    // Handle invalid requests or other errors
    echo "Invalid request.";
}
?>
