<?php
include "connection.php";
  session_start();
  if(isset($_SESSION['user_data'])){
    $P_id=  $_SESSION['user_data']['0'];
}  
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title>Image Gallery</title>
<link rel="stylesheet" href="css/upload.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class="container">
<div class="wrapper">
<div class="image">
<img src="" alt="">
</div>
<div class="content">
<div class="icon">
<i class="fas fa-cloud-upload-alt"></i>
</div>
<div class="text">
 No file chosen, yet!
</div>
</div>
<div id="cancel-btn">
<i class="fas fa-times"></i>
</div>
<div class="file-name">
 File name here
</div>
</div>
<button onclick="defaultBtnActive()" id="custom-btn">Choose a file</button>
<form action="" method="POST" enctype="multipart/form-data">
<input id="default-btn" type="file" name="image" hidden>
<input type="submit" value="UPLOAD"  name = "upload" class = "btn">
<a href="Front_page.php" class = "btn">BACK</a>
</form>
</div>
<!--PHP-->
<?php
if(isset($_POST['upload']))
{
$filename= $_FILES['image']['name'];
$tmp_name= $_FILES['image']['tmp_name'];
$size = $_FILES['image']['size'];
$image_ext = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
$allow_type= ['jpg','png','jpeg'];
$destination = "upload/".$filename;
if(in_array($image_ext,$allow_type)){
if($size <= 2000000){
move_uploaded_file($tmp_name,$destination);
$sql = "INSERT INTO  image(image,P_id)
       VALUES('$filename','$P_id')";
$query = mysqli_query($conn,$sql);
if($query){
$msg =['posted','alert-success'];
$_SESSION['msg'] = $msg;
header("location:Front_page.php");
}
else {
$msg =  ['failed','alert-danger'];
$_SESSION['msg'] = $msg;
 //header("location:index.php");
}
}
else{
$msg=['large file','alert-danger'];
$_SESSION['msg']=$msg;
// header("location:index.php");
}
}
else{
$msg=['file not allowed','alert-danger'];
 $_SESSION['msg']=$msg;
//  header("location:index.php");
}
}
?>
<!--SCRIPT-->
<script>
         const wrapper = document.querySelector(".wrapper");
         const fileName = document.querySelector(".file-name");
         const defaultBtn = document.querySelector("#default-btn");
         const customBtn = document.querySelector("#custom-btn");
         const cancelBtn = document.querySelector("#cancel-btn i");
         const img = document.querySelector("img");
         let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
         function defaultBtnActive(){
           defaultBtn.click();
         }
         defaultBtn.addEventListener("change", function(){
           const file = this.files[0];
           if(file){
             const reader = new FileReader();
             reader.onload = function(){
               const result = reader.result;
               img.src = result;
               wrapper.classList.add("active");
             }
             cancelBtn.addEventListener("click", function(){
               img.src = "";
               wrapper.classList.remove("active");
             })
             reader.readAsDataURL(file);
           }
           if(this.value){
             let valueStore = this.value.match(regExp);
             fileName.textContent = valueStore;
           }
         });
</script>
</body>
</html>