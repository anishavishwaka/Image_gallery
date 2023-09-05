<?php
include "Connection.php";
session_start();
if(isset($_SESSION['user_data'])){   
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image gallery</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
<form action="" method="post" enctype="multipart/form-data">
   <h3>login now</h3>
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '<div class="message">'.$message.'</div>';
      }
   }
   ?>
   <input type="email" name="email" placeholder="enter email" class="box" required>
   <input type="password" name="password" placeholder="enter password" class="box" required>
   <input type="submit" name="submit" value="login now" class="btn">
   <p>don't have an account? <a href="Sign_up.php">regiser now</a></p>
</form>
</div>
<?php
if(isset($_POST['submit'])){
$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, md5($_POST['password']));

$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');
$data=mysqli_num_rows($select);
if($data){
   $result = mysqli_fetch_assoc($select);
   $user_data=array($result['id'],$result['name'],$result['email']);
   $_SESSION['id'] = $result['id'];
   $_SESSION['user_data']=$user_data;
   header('location:Front_page.php');
}else{
   $message[] = 'incorrect email or password!';
}
}
?>
</body>
</html>