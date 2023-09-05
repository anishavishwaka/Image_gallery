<?php
    include "connection.php";
    session_start();
    if(isset($_SESSION['user_data'])) {
    $P_id= $_SESSION['user_data'][0];
}
//GET ID
    $img_id= $_GET['id'];
    $sql = "SELECT*FROM image LEFT JOIN user_form ON image.P_id=user_form.id WHERE img_id='$img_id' ";
    $query=mysqli_query($conn, $sql);
    $result=mysqli_fetch_assoc($query);
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Gallery</title>
  <link rel="stylesheet" href="css/upload.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

</head>
<body>
  <div class="container">
    <div class="wrapper">
      <div class="image">
      <img src="upload/<?=$result['image']?>" alt="image">
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
<input type="submit" value="UPDATE"  name = "edit" class = "btn">
<a href="Front_page.php" class = "btn">BACK</a>
</form>
</div>
<!--PHP-->
<?php
if(isset($_POST['edit'])) {
    $filename= $_FILES['image']['name'];
    $tmp_name= $_FILES['image']['tmp_name'];
    $size = $_FILES['image']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type= ['jpg','png','jpeg'];
    $destination = "upload/".$filename;
    if(!empty($filename)){
      if(in_array($image_ext,$allow_type)) {
        if($size <= 2000000){
          $unlink= "upload/".$result['image'];
          unlink($unlink);
          move_uploaded_file($tmp_name,$destination); 
          $update="UPDATE image SET image='$filename',P_id='$P_id'
           WHERE img_id='$img_id'";
           $query = mysqli_query($conn,$update);
           if($query){
            $msg =['posted','alert-success'];
            $_SESSION['msg'] = $msg;
            header("location:Front_page.php");
           }
           else{
            $msg =  ['failed','alert-danger'];
            $_SESSION['msg'] = $msg;
            header("location:upload.php");
           }
  
            }
            else{
            $msg=['file not allowed','alert-danger'];
             $_SESSION['msg']=$msg;
            //  header("location:index.php");
            }
        } 
      } 
    }   
?>

</div>
</div>
  <!--JAVASCRIPT-->
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