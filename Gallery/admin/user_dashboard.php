<!--PHP-->
<?php
include "connection.php";
session_start();
if(isset($_SESSION['user_data'])){
$userID = $_SESSION['user_data']['0'];
$username =$_SESSION['user_data']['1'];
}  
?>  
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="css/user_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="main-container">
<?php
if(isset($_SESSION['user_data'])) {?>
 <h2>Welcome <?php echo  $_SESSION['user_data']['1'];?></h2>
<?php
}
?>
<h2>Your Images</h2>
<div class="sub-container">
 <?php
if(isset($_SESSION['user_data'])) {
    $userID = $_SESSION['user_data']['0'];
    $sql = "SELECT*FROM image LEFT JOIN user_form ON image.P_id=user_form.id WHERE name='$username' ";  
    $query=mysqli_query($conn, $sql);
    $row=mysqli_num_rows($query);
    if($row) {
while($result=mysqli_fetch_assoc($query)) {
    $img= $result['image'];
?>    
<!--HTML-->
<section class="gallery">
<ul class="images">
<li class="card">
<a href="">
<?php  ?><img src="upload/<?=$img ?>">  
</a>
<div class="details">
<div class="photographer">
<i class="fa  fa-camera"></i>
<span><?= $result['name'] ?></span>
</div>
<button><i class="fa  fa-download"></i></button>
<button><i class="fa fa-share"></i></button>
</div>             
</li>
</ul> 
<!--OPERATION-->
<a href="edit_img.php?id=<?= $result['img_id']?>"
class="btn btn-sm btn-success">Edit</a>

<!--DELETE-->
<a href="">
<form class="mt-2"  method="POST"onsubmit="return confirm('are u sure')">
<input type="hidden" name="img_id" value="<?= $result['img_id'] ?>" class="btn btn-sm btn-danger">
<input type="hidden" name="image" value="<?= $result['image'] ?>">
<input type="submit" name="deleteImg" value="Delete" class="btn btn-sm btn-danger" >
</form>
</a>
</section>
<?php
}}}
?>
<?php
if (isset($_POST['deleteImg'])){
    $img_id=$_POST['img_id'];
    $image= "upload".$_POST['image'];
    $delete="DELETE FROM image WHERE img_id = '$img_id'";
    $run=mysqli_query($conn,$delete);
    if($run){
        unlink($img);
        $msg=['Post has been deleted','alert-success'];
        $_SESSION['msg']=$msg;
        header("location:user_dashboard.php");
        echo "success";
    }
else{
    $msg=['failed','alert-danger'];
    $_SESSION['msg']=$msg;
    header("location:Front_page.php");
    echo "failed";
}
}
?>
</div>
</div>
</body>
</html> 