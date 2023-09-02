
<?php 
session_start();
include "head.php"; 
include "database.php";
if(isset($_SESSION['login'])){
    $query = "SELECT * FROM users WHERE id=" . $_SESSION['user_id'];
    include 'database.php';
     $result = $db->query($query);
     if ($result->num_rows == 1) {
         $user = $result->fetch_assoc();
        $username= $user['name'];
        $image= $user["profile_image"];
        $uid =$user["uid"];
      }}
?>
<head>
    <style>
        body{
    background-color:#B3E5FC;
    border-radius: 10px;
            }

.card{
  width: 400px;
  border: none;
  border-radius: 10px;
   
  background-color: #fff;
}

.number2{
  font-weight:500;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">    
</head>
<div class="container mt-5 d-flex justify-content-center">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <div class="image">
                <img src="<?php echo 'img/user/' . $image; ?>" class="rounded" width="155" >
                </div>
                <div class="ml-3 w-100">
                   <h4 class="mb-0 mt-0"><?php echo $username; ?></h4>
                   <span><?php echo "@".$uid;?> </span>

                   <div class="p-2 mt-2 bg-danger d-flex justify-content-between rounded text-white stats">
                    <div class="d-flex flex-column">
                        <span class="number2">Total Time Listened</span>
                        <span class="number2">/Placeholder</span>
                    </div>
                   </div>
                </div>                    
                </div>                
            </div>             
         </div>