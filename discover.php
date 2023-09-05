<?php 
session_start();
include "head.php";
?>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="music-player">
    <!-- Music player HTML structure -->
    <div class="player-main">
        <!-- Current music info goes here -->
        <?php
        include "database.php";
        // Initialize the $musicData variable as an empty array
        $musicData = array();
        // Fetch music data from the database
        $query = "
SELECT
    songs.id,
    songs.name,
    songs.artist,
    songs.album,
    songs.music,
    songs.coverImage,
    songs.genre,
    songs.language,
    MAX(
        IFNULL(similarity.combined_similarity, 0) -
        IFNULL(unliked_similarity.unliked_similarity, 0)
    ) AS combined_similarity
FROM songs
LEFT JOIN (
    SELECT
        s1.id AS song1_id,
        s2.id AS song2_id,
        (
            (0.2 * IFNULL(GREATEST(0, (COUNT(DISTINCT s1.genre, s2.genre) / COUNT(DISTINCT s1.genre, s2.genre, s1.language, s2.language))), 0))
            + (0.4 * IFNULL(GREATEST(0, (COUNT(DISTINCT s1.language, s2.language) / COUNT(DISTINCT s1.genre, s2.genre, s1.language, s2.language))), 0))
            + (0.4 * IFNULL(GREATEST(0, (COUNT(DISTINCT ls1.song_id, ls2.song_id) / COUNT(DISTINCT ls1.song_id, ls2.song_id, ls1.user_id, ls2.user_id))), 0))
        ) AS combined_similarity
    FROM songs s1
    JOIN songs s2 ON s1.id < s2.id
    LEFT JOIN liked_songs ls1 ON s1.id = ls1.song_id AND ls1.liked = 1
    LEFT JOIN liked_songs ls2 ON s2.id = ls2.song_id AND ls2.liked = 1
    WHERE s1.id <> s2.id -- Ensure that we don't consider the same song pair twice
    GROUP BY s1.id, s2.id
) AS similarity ON songs.id = similarity.song1_id
LEFT JOIN (
    SELECT
        s1.id AS song1_id,
        s2.id AS song2_id,
        (
            (0.2 * IFNULL(GREATEST(0, (COUNT(DISTINCT s1.genre, s2.genre) / COUNT(DISTINCT s1.genre, s2.genre, s1.language, s2.language))), 0))
            + (0.4 * IFNULL(GREATEST(0, (COUNT(DISTINCT s1.language, s2.language) / COUNT(DISTINCT s1.genre, s2.genre, s1.language, s2.language))), 0))
            + (0.4 * IFNULL(GREATEST(0, (COUNT(DISTINCT ls1.song_id, ls2.song_id) / COUNT(DISTINCT ls1.song_id, ls2.song_id, ls1.user_id, ls2.user_id))), 0))
        ) AS unliked_similarity
    FROM songs s1
    JOIN songs s2 ON s1.id < s2.id
    LEFT JOIN liked_songs ls1 ON s1.id = ls1.song_id AND ls1.unliked = 1
    LEFT JOIN liked_songs ls2 ON s2.id = ls2.song_id AND ls2.unliked = 1
    WHERE s1.id <> s2.id -- Ensure that we don't consider the same song pair twice
    GROUP BY s1.id, s2.id
) AS unliked_similarity ON songs.id = unliked_similarity.song1_id
GROUP BY songs.id, songs.name, songs.artist, songs.album, songs.music, songs.coverImage, songs.genre, songs.language
ORDER BY combined_similarity DESC;

        ";
        $result = $db->query($query);
        // Check if the query was successful
        if ($result) {
            // Fetch and store music data in the $musicData array
            while ($row = $result->fetch_assoc()) {
                $musicData[] = $row;
            }
        } else {
            // Handle the case where the query failed
            echo "Error fetching music data: " . $db->error;
        }

        // Initialize liked and unliked status
        $likedStatus = false;
        $unlikedStatus = false;

        // Check if the user is logged in and if $musicData is not empty
        if (!empty($musicData) && isset($_SESSION['user_id'])) {
            // Fetch liked and unliked status for the currently playing song
            $query = "SELECT liked, unliked FROM liked_songs WHERE user_id = {$_SESSION['user_id']} AND song_id = {$musicData[0]['id']}";
            $result = $db->query($query);

            // Check if the query was successful
            if ($result) {
                $row = $result->fetch_assoc();
                if ($row) {
                    $likedStatus = $row['liked'];
                    $unlikedStatus = $row['unliked'];
                }
            } else {
                // Handle the case where the query failed
                echo "Error fetching liked/unliked status: " . $db->error;
            }
        }
        ?>
        <?php if (!empty($musicData)) { ?>
            <div class="main-current">
                <div class="current-keyvisual">
                    <img id="music-cover" src="<?php echo $musicData[0]['coverImage']; ?>"/>
                </div>
                <div class="current-info">
                    <h1><?php echo $musicData[0]['name']; ?></h1>
                    <p><?php echo $musicData[0]['artist']; ?></p>
                    <div class="current-buttons m-4" >
                        <button class="btn _thumbs-up <?php echo $likedStatus ? 'clicked' : ''; ?>"><i class="fas fa-thumbs-up"></i></button>
                        <button class="btn _thumbs-down <?php echo $unlikedStatus ? 'clicked' : ''; ?>"><i class="fas fa-thumbs-down"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Music control buttons and progress bar -->
        <div class="main-control">
            <div class="btn _previous"></div>
            <div class="btn _pause"></div>
            <div class="btn _next"></div>
            <div class="btn _timeline">
                <span class="current-time">0:00</span>
                <span class="timescope">
                    <span class="timescope-dot"></span>
                </span>
                <span class="end-time">0:00</span>
            </div>
        </div>
    </div>
    <!-- Music playlist goes here -->
    <ul class="player-list">
        <?php foreach ($musicData as $key => $music) { ?>
                        <li class="play-music" data-key="<?php echo $key; ?>">
                <img class="list-cover" src="img/disc.png" />
                <div class="list-info">
                    <div class="info-title"><?php echo $music['name']; ?></div>
                    <div class="info-artist"><?php echo $music['artist']; ?></div>
                </div>
                <div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>

<!-- JavaScript code for music player -->
<script>
    $(document).ready(function() {
        var audio = new Audio();
        var currentMusicKey = 0;
        var musicData = <?php echo json_encode($musicData); ?>;
        var isPlaying = false;

        // Function to play music by its key
        function playMusic(key) {
            var music = musicData[key];
            currentMusicKey = key;

            // Set the audio source to the music file
            audio.src = music['music'];

            // Update the current music info
            $('.current-info h1').text(music['name']);
            $('.current-info p').text(music['artist']);

            // Update the cover image
            $('#music-cover').attr('src', music['coverImage']);

            // Reset the like and unlike button colors
            $('.btn._thumbs-up').css('background-color', '');
            $('.btn._thumbs-down').css('background-color', '');

            // Fetch liked and unliked status for the currently playing song
            fetchLikedStatus();
            
            // Play the audio
            audio.play();
            isPlaying = true;
            $('.btn._pause').css('background-image', 'url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/329679/music-player-freebie-pause.svg")');
        }

        // Fetch liked and unliked status for the currently playing song
        function fetchLikedStatus() {
            if (isPlaying && musicData[currentMusicKey]) {
                var songId = musicData[currentMusicKey].id;

                $.ajax({
                    type: 'POST',
                    url: 'fetch_liked_status.php', // Create a PHP script to fetch liked/unliked status
                    data: {
                        song_id: songId
                    },
                    success: function(response) {
                        var status = JSON.parse(response);
                        var likedStatus = status.liked;
                        var unlikedStatus = status.unliked;

                        // Update like and unlike button colors based on the status
                        updateButtonColors(likedStatus, unlikedStatus);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }

        // Play the first music when the page loads
        playMusic(currentMusicKey);

        // Click event handler for the list items
        $('.play-music').click(function() {
            var key = $(this).data('key');
            playMusic(key);
        });

        // Pause and play button click event handler
        $('.main-control .btn._pause').click(function() {
            if (isPlaying) {
                audio.pause();
                isPlaying = false;
                $('.btn._pause').css('background-image', 'url("https://www.svgrepo.com/show/95124/play-button.svg")');
            } else {
                audio.play();
                isPlaying = true;
                $('.btn._pause').css('background-image', 'url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/329679/music-player-freebie-pause.svg")');
            }
        });

        // Previous button click event handler
        $('.main-control .btn._previous').click(function() {
            if (currentMusicKey > 0) {
                playMusic(currentMusicKey - 1);
            }
        });

        // Next button click event handler
        $('.main-control .btn._next').click(function() {
            if (currentMusicKey < musicData.length - 1) {
                playMusic(currentMusicKey + 1);
            }
        });

        // Update the timeline as the audio plays
        audio.addEventListener('timeupdate', function() {
            var currentTime = audio.currentTime;
            var duration = audio.duration;
            var percentage = (currentTime / duration) * 100;
            $('.timescope-dot').css('left', percentage + '%');

            // Update current and end time
            var currentMinutes = Math.floor(currentTime / 60);
            var currentSeconds = Math.floor(currentTime % 60);
            var endMinutes = Math.floor(duration / 60);
            var endSeconds = Math.floor(duration % 60);
            $('.current-time').text(currentMinutes + ':' + (currentSeconds < 10 ? '0' : '') + currentSeconds);
            $('.end-time').text(endMinutes + ':' + (endSeconds < 10 ? '0' : '') + endSeconds);
        });

        // Click event handler for the timeline
        $('.timescope').click(function(e) {
            var offset = $(this).offset();
            var width = $(this).width();
            var clickX = e.clientX - offset.left;
            var percentage = (clickX / width) * 100;
            var seekTime = (percentage / 100) * audio.duration;
            audio.currentTime = seekTime;
        });

        // Function to update button colors based on liked and unliked status
        function updateButtonColors(likedStatus, unlikedStatus) {
            // Update thumbs-up button color
            if (likedStatus) {
                $('.btn._thumbs-up').css('background-color', 'white');
            } else {
                $('.btn._thumbs-up').css('background-color', '');
            }

            // Update thumbs-down button color
            if (unlikedStatus) {
                $('.btn._thumbs-down').css('background-color', 'black');
            } else {
                $('.btn._thumbs-down').css('background-color', '');
            }
        }

        // Function to handle thumbs-up click
        $('.btn._thumbs-up').click(function() {
            // Toggle the clicked class for thumbs-up
            $(this).toggleClass('clicked');
            // Clear the clicked class and reset the color for thumbs-up
            $('.btn._thumbs-down').removeClass('clicked').css('background-color', '');

            // Change the button color to white when clicked
            if ($(this).hasClass('clicked')) {
                $(this).css('background-color', 'white');
            } else {
                // Change the button color back to its default color when unclicked
                $(this).css('background-color', ''); // Empty string resets to default
            }

            // Update the liked status in the database when the button is clicked
            var isLiked = $(this).hasClass('clicked');
            updateLikedStatus(isLiked, false); // Call a function to update the liked status
        });

        // Function to handle thumbs-down click
        $('.btn._thumbs-down').click(function() {
            // Toggle the clicked class for thumbs-down
            $(this).toggleClass('clicked');
            // Clear the clicked class and reset the color for thumbs-up
              $('.btn._thumbs-up').removeClass('clicked').css('background-color', '');

            // Change the button color to black when clicked
            if ($(this).hasClass('clicked')) {
                $(this).css('background-color', 'black');
            } else {
                // Change the button color back to its default color when unclicked
                $(this).css('background-color', ''); // Empty string resets to default
            }

            // Update the unliked status in the database when the button is clicked
            var isUnliked = $(this).hasClass('clicked');
            updateLikedStatus(false, isUnliked); // Call a function to update the unliked status
        });

        // Function to update liked and unliked status in the database
        function updateLikedStatus(liked, unliked) {
            if (musicData[currentMusicKey]) {
                var songId = musicData[currentMusicKey].id;

                $.ajax({
                    type: 'POST',
                    url: 'update_liked_status.php', // Create a separate PHP script to handle the update
                    data: {
                        song_id: songId,
                        liked: liked,
                        unliked: unliked
                    },
                    success: function(response) {
                        // Handle the response from the server (e.g., display a message)
                        console.log(response);
                    },
                    error: function(error) {
                        // Handle errors, if any
                        console.error(error);
                    }
                });
            }
        }
    });
</script>
</body>
</html>
