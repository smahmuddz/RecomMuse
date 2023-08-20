<?php
include "head.php";
include "database.php";

$album_id = $_GET["album"];
$album = $db->query("SELECT * FROM albums  ")->fetch_assoc();
$tracks = $db->query("SELECT * FROM `music` ");
?>

<div class="container-fluid rounded-4 mt-3 p-3 bg-light">
    <div>
        <h1>Musics</h1>
    </div>
    <hr>
    <div class="row">
        <?php while ($track = $tracks->fetch_assoc()): ?>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 albums my-2">
                <div class="card rounded-3 bg-secondary">
                    <img src="<?php echo $track['image'];?>" class="card-img-top rounded-3 img-filter" width="200px" alt="<?php echo $track['name'];?>">
                    <div class="card-body bg-secondary rounded-3">
                        <p class="card-text albums">
                            <?php echo $track['name'];?>
                        </p>
                        <button class="btn btn-primary" onclick="PlayMusic('<?php echo $track['mp3'];?>', '<?php echo $track['name'];?>')">Play</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<audio id="music-player" controls>
    <source id="music-source" src="" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<p id="music-name"></p>

<script>
    function PlayMusic(path_music, name) {
        const musicName = document.getElementById("music-name");
        const musicBar = document.getElementById('music-player');
        const musicSource = document.getElementById('music-source');

        musicSource.setAttribute('src', path_music);
        musicName.innerHTML = name;
        musicBar.load();
        musicBar.play();
    }
</script>

<?php
include "footer.php";
?>
