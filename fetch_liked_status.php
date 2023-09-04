<?php
session_start();
include "database.php"; // Include your database connection file

// Check if the user is logged in and if the song_id is provided
if (isset($_SESSION['user_id']) && isset($_POST['song_id'])) {
    $user_id = $_SESSION['user_id'];
    $song_id = $_POST['song_id'];

    // Query to fetch liked and unliked status from the database
    $query = "SELECT liked, unliked FROM liked_songs WHERE user_id = $user_id AND song_id = $song_id";

    // Execute the query
    $result = $db->query($query);

    if ($result) {
        // Fetch the liked and unliked status
        $row = $result->fetch_assoc();
        if ($row) {
            $likedStatus = (bool)$row['liked'];
            $unlikedStatus = (bool)$row['unliked'];
            // Create an array to hold the status
            $status = [
                'liked' => $likedStatus,
                'unliked' => $unlikedStatus
            ];
            // Return the status as JSON
            echo json_encode($status);
        } else {
            // If no row is found, return default values
            $status = [
                'liked' => false,
                'unliked' => false
            ];
            echo json_encode($status);
        }
    } else {
        // Handle the case where the query failed
        echo json_encode(['error' => 'Error fetching liked/unliked status']);
    }
} else {
    // Handle the case where user is not logged in or song_id is not provided
    echo json_encode(['error' => 'User not logged in or song_id missing']);
}
?>
