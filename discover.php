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
    <div class="player-main">
        <?php
        include "database.php";
         $result =0;
        $musicData = array();
        if(isset($_SESSION['user_id'])){
        $uid= $_SESSION['user_id'];}

        if(isset($_SESSION['user_id']))
        {        $query = "
        SELECT
            songs.id,
            songs.name,
            songs.artist,
            songs.album,
            songs.music,
            songs.coverImage,
            songs.genre,
            songs.language,
            IFNULL(combined_similarity, 0) AS combined_similarity
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
            LEFT JOIN liked_songs ls1 ON s1.id = ls1.song_id AND ls1.liked = 1 AND ls1.user_id = $uid
            LEFT JOIN liked_songs ls2 ON s2.id = ls2.song_id AND ls2.liked = 1 AND ls2.user_id = $uid
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
            LEFT JOIN liked_songs ls1 ON s1.id = ls1.song_id AND ls1.unliked = 1 AND ls1.user_id = $uid
            LEFT JOIN liked_songs ls2 ON s2.id = ls2.song_id AND ls2.unliked = 1 AND ls2.user_id = $uid
            WHERE s1.id <> s2.id -- Ensure that we don't consider the same song pair twice
            GROUP BY s1.id, s2.id
        ) AS unliked_similarity ON songs.id = unliked_similarity.song1_id
        WHERE (
            $uid IN (SELECT user_id FROM liked_songs WHERE song_id = songs.id AND liked = 1)
            OR
            NOT EXISTS (SELECT 1 FROM liked_songs WHERE user_id = $uid)
        )
        GROUP BY songs.id, songs.name, songs.artist, songs.album, songs.music, songs.coverImage, songs.genre, songs.language
        ORDER BY combined_similarity DESC;
    ";
            $result = $db->query($query);}
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $musicData[] = $row;
            }
        } else {
            echo "User not logged in ." ;
        }

        $likedStatus = false;
        $unlikedStatus = false;

        if (!empty($musicData) && isset($_SESSION['user_id'])) {
            $query = "SELECT liked, unliked FROM liked_songs WHERE user_id = {$_SESSION['user_id']} AND song_id = {$musicData[0]['id']}";
            $result = $db->query($query);
         if ($result) {
                $row = $result->fetch_assoc();
                if ($row) {
                    $likedStatus = $row['liked'];
                    $unlikedStatus = $row['unliked'];
                }
            } else {
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
                   <?php
                    if (isset($_SESSION['login'])) {
                        echo '<div class="current-buttons m-4">';
                        echo '<button class="btn _thumbs-up ' . ($likedStatus ? 'clicked' : '') . '"><i class="fas fa-thumbs-up"></i></button>';
                        echo '<button class="btn _thumbs-down ' . ($unlikedStatus ? 'clicked' : '') . '"><i class="fas fa-thumbs-down"></i></button>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        <?php } ?>
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

<script>
    $(document).ready(function() {
        var audio = new Audio();
        var currentMusicKey = 0;
        var musicData = <?php echo json_encode($musicData); ?>;
        var isPlaying = false;

        function playMusic(key) {
            var music = musicData[key];
            currentMusicKey = key;

            audio.src = music['music'];

            $('.current-info h1').text(music['name']);
            $('.current-info p').text(music['artist']);

            $('#music-cover').attr('src', music['coverImage']);
            $('.btn._thumbs-up').css('background-color', '');
            $('.btn._thumbs-down').css('background-color', '');

            fetchLikedStatus();
            
            audio.play();
            isPlaying = true;
            $('.btn._pause').css('background-image', 'url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/329679/music-player-freebie-pause.svg")');
        }

        function fetchLikedStatus() {
            if (isPlaying && musicData[currentMusicKey]) {
                var songId = musicData[currentMusicKey].id;

                $.ajax({
                    type: 'POST',
                    url: 'fetch_liked_status.php', 
                    data: {
                        song_id: songId
                    },
                    success: function(response) {
                        var status = JSON.parse(response);
                        var likedStatus = status.liked;
                        var unlikedStatus = status.unliked;
                        updateButtonColors(likedStatus, unlikedStatus);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }

        playMusic(currentMusicKey);

        $('.play-music').click(function() {
            var key = $(this).data('key');
            playMusic(key);
        });

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

        $('.main-control .btn._previous').click(function() {
            if (currentMusicKey > 0) {
                playMusic(currentMusicKey - 1);
            }
        });

        $('.main-control .btn._next').click(function() {
            if (currentMusicKey < musicData.length - 1) {
                playMusic(currentMusicKey + 1);
            }
        });

        audio.addEventListener('timeupdate', function() {
            var currentTime = audio.currentTime;
            var duration = audio.duration;
            var percentage = (currentTime / duration) * 100;
            $('.timescope-dot').css('left', percentage + '%');

            var currentMinutes = Math.floor(currentTime / 60);
            var currentSeconds = Math.floor(currentTime % 60);
            var endMinutes = Math.floor(duration / 60);
            var endSeconds = Math.floor(duration % 60);
            $('.current-time').text(currentMinutes + ':' + (currentSeconds < 10 ? '0' : '') + currentSeconds);
            $('.end-time').text(endMinutes + ':' + (endSeconds < 10 ? '0' : '') + endSeconds);
        });

        $('.timescope').click(function(e) {
            var offset = $(this).offset();
            var width = $(this).width();
            var clickX = e.clientX - offset.left;
            var percentage = (clickX / width) * 100;
            var seekTime = (percentage / 100) * audio.duration;
            audio.currentTime = seekTime;
        });

        function updateButtonColors(likedStatus, unlikedStatus) {
            if (likedStatus) {
                $('.btn._thumbs-up').css('background-color', 'white');
            } else {
                $('.btn._thumbs-up').css('background-color', '');
            }

            if (unlikedStatus) {
                $('.btn._thumbs-down').css('background-color', 'black');
            } else {
                $('.btn._thumbs-down').css('background-color', '');
            }
        }

        $('.btn._thumbs-up').click(function() {
            $(this).toggleClass('clicked');
            $('.btn._thumbs-down').removeClass('clicked').css('background-color', '');

            if ($(this).hasClass('clicked')) {
                $(this).css('background-color', 'white');
            } else {
                $(this).css('background-color', ''); 
            }

            var isLiked = $(this).hasClass('clicked');
            updateLikedStatus(isLiked, false); 
        });

        $('.btn._thumbs-down').click(function() {
            $(this).toggleClass('clicked');
              $('.btn._thumbs-up').removeClass('clicked').css('background-color', '');

            if ($(this).hasClass('clicked')) {
                $(this).css('background-color', 'black');
            } else {
                $(this).css('background-color', ''); 
            }

            var isUnliked = $(this).hasClass('clicked');
            updateLikedStatus(false, isUnliked); 
        });

        function updateLikedStatus(liked, unliked) {
            if (musicData[currentMusicKey]) {
                var songId = musicData[currentMusicKey].id;

                $.ajax({
                    type: 'POST',
                    url: 'update_liked_status.php', 
                    data: {
                        song_id: songId,
                        liked: liked,
                        unliked: unliked
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }
    });
</script>
</body>
</html>
