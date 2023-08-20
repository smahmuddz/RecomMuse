<?php
    include "head.php";
    include "database.php";
?>
<head>
    <script src="css/style.css"></script>
</head>

<?php 
    
    if(!empty($_GET["singer"]))
        {
        $singer_id = $_GET["singer"];
        $albums = $db->query("SELECT * FROM `albums` WHERE singers_id = $singer_id ORDER BY release_year asc;");
        $num_rows = $albums->num_rows;
        $albums = $albums->fetch_all();
        }
    else
        {       
        $albums = $db->query("SELECT * FROM `albums` ORDER BY release_year DESC;");
        $num_rows = $albums->num_rows;
        $albums = $albums->fetch_all();
        }
?>
        <div class="container-fluid rounded-4 mt-3  p-3 bg-light">
            <h3>
                Released Albums
            </h3>
            <hr>
            <div class="row">
                <?php for($i = 0; $i <$num_rows; $i++): ?>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2">
                        <a href="songs.php?album=<?php echo $albums[$i][0];?>">
                            <div class="card rounded-3" style=" background-color: #fd3c4f">
                                <img style="padding:10px" src="<?php echo $albums[$i][2];?>" class="card-img-top rounded-3 img-filter"  width="200px" alt="<?php echo $albums[$i][1];?>">
                                <div>
                                <a class="card-title" style="margin:10px;color:white; font-weight:bolder; text-decoration:none; ">
                                <?php echo $albums[$i][1];?></a>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endfor; ?>
            </div>
        </div>


<?php   include "footer.php"; ?>