<?php
    include "head.php";
    include "database.php";
    $artists = $db->query("SELECT * FROM `singers` ORDER BY LEFT(name, 1) ASC; ");
?>
<div class="container-fluid rounded-4 mt-3 p-3 bg-light">
    <h3>
        Artists
    </h3>
    <hr>
    <div class="row justify-content-LEFT">
        <?php foreach($artists as $artist): ?>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 albums my-2 text-center"">
                <a class="albums" href="album.php?singer=<?php echo $artist['id']; ?>">
                    <div>
                        <img src="<?php echo $artist['image'];?>" class="rounded-circle" width="200px" alt="<?php echo $artist['name'];?>">
                    </div>
                </a>
                <div>
                    <p style="font-weight: bold; color: #1e1e1e; margin-top:10px;"><?php echo $artist['name'];?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
    include "footer.php";
?>
