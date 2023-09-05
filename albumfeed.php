<?php 
session_start();
include "head.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Feed</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="music-player">
    <!-- Music player HTML structure -->
    <div class="player-main">
        <!-- Current music info goes here -->
        <?php
        include "database.php";
        $musicData = array();
        
        if (isset($_GET['album'])) {
            $album_name = urldecode($_GET['album']);
            
            // Fetch music data from the database for the selected album
            $query = "SELECT * FROM songs WHERE album = '$album_name' ORDER BY name ASC";
            $result = $db->query($query);
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $musicData[] = $row;
                }
            } else {
                echo "ডাটাবেজ এরর: " . $db->error;
            }
        } else {
            echo "কোনো অ্যালবাম সিলেক্ট করা নেই।";
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
                </div>
            </div>
        <?php } else { ?>
            <div class="main-current">
                <p>এই অ্যালবাম এর কোনো মিউজিক ডেটা পাওয়া যায়নি</p>
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
            </li>
        <?php } ?>
    </ul>
</div>

<!-- JavaScript code for music player -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            // Play the audio
            audio.play();
            isPlaying = true;
            $('.btn._pause').css('background-image', 'url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/329679/music-player-freebie-pause.svg")');
        }

        // Play the first music when the page loads
        playMusic(currentMusicKey);

        // Play the selected music when a list item is clicked
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

        // Pause when the audio ends
        audio.addEventListener('ended', function() {
            isPlaying = false;
            $('.btn._pause').css('background-image', 'url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/329679/music-player-freebie-play.svg")');
        });
    });
</script>
</body>
</html>
