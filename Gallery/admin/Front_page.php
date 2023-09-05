<!--PHP-->
<?php
include "connection.php";
session_start();
$user_id = $_SESSION['id'];
if(!isset($user_id)){
header('location:login.php');
};
if(isset($_GET['logout'])){
unset($user_id);
session_destroy();
header('location:login.php');
}
$sql = "SELECT*FROM image LEFT JOIN user_form ON image.P_id=user_form.id";
$run = mysqli_query($conn,$sql);
$row=mysqli_num_rows($run);
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/front_page.css">
</head>
<body>
<div class="hero">
<nav>
<header>
        <h2>Image Gallery</h2> 
</header>
<?php
$select = mysqli_query($conn, "SELECT * FROM user_form WHERE id = '$user_id'") or die('query failed');
if(mysqli_num_rows($select) > 0){
$fetch = mysqli_fetch_assoc($select);
}
?>
<div class="img">
<?php
if($fetch['img'] == ''){
echo '<img  class="user" src="images/profile.png" onclick="toggleMenu()">';
}else{
echo '<img class="user"  src="uploaded_img/'.$fetch['img'].'" onclick="toggleMenu()">';
}
?>  
<div class="sub-menu-wrap" id="subMenu">
<div class="sub-menu">
<div class="user-info">
<?php
if($fetch['img'] == ''){
echo '<img class="user" src="images/profile.png">';
}else{
echo '<img  class="user" src="uploaded_img/'.$fetch['img'].'">';
}
?>  
<h3><?php echo $fetch['name']; ?></h3>
</div>
<hr>
<a href="update_profile.php" class="sub-menu-link">
<img src="images/profile.png" alt="">
<p>edit profile</p>
<span>></span>
</a>
<a href="user_dashboard.php" class="sub-menu-link">
<img src="images/your-images.png" alt="">
<p>your images</p>
<span>></span>
</a>
<a href="upload.php" class="sub-menu-link">
<img src="images/upload.png" alt="">        
<p>upload image</p>
<span>></span>
</a>
<a href="home.php?logout=<?php echo $user_id; ?>" class="sub-menu-link">
<img src="images/logout.png" alt="">
<p>Logout</p>
<span>></span>
</a>
</div>
</div>
</div>
</nav> 
<section class="search">
<div class="search-box">
<input type="search" name="" id="" placeholder="Seacrch Images....">
<i class="fa fa-search"></i>
</div>
</section>
<div class="container">
<?php
    if($row){
    while($result=mysqli_fetch_assoc($run)) {
    $img= $result['image'];
?>
<section class="gallery">           
<ul class="images">
<li class="card">
<a href=""><?php  ?><img src="upload/<?=$img ?>"></a>
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
</section>
<?php
}}
?>
<script src="script.js"></script>
</div>
</div>
</body>
</html>
