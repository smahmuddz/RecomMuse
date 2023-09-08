<?php
session_start();
include "database.php"; 

if (isset($_SESSION['user_id']) && isset($_POST['song_id'])) {
    $user_id = $_SESSION['user_id'];
    $song_id = $_POST['song_id'];
    $query = "SELECT liked, unliked FROM liked_songs WHERE user_id = $user_id AND song_id = $song_id";
    $result = $db->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $likedStatus = (bool)$row['liked'];
            $unlikedStatus = (bool)$row['unliked'];
            $status = [
                'liked' => $likedStatus,
                'unliked' => $unlikedStatus
            ];
            echo json_encode($status);
        } else {
            $status = [
                'liked' => false,
                'unliked' => false
            ];
            echo json_encode($status);
        }
    } else {
        echo json_encode(['error' => 'Error fetching liked/unliked status']);
    }
} else {
    echo json_encode(['error' => 'User not logged in or song_id missing']);
}
?>
