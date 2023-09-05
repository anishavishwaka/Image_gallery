<!--PHP-->
<?php
include "connection.php";
$sql="SELECT * FROM user_form";
$query=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($query);
?>

<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<style>
    button{
        background-color:blueviolet;
        font-size: 14px;
        font-weight: 550;
        padding: 8px 8px;
        border: 2px solid black;
        border-radius: 5px;
        float: right;
    }  
</style>
<body>
    <div class="container-fluid">
<form method="post">
        <button name="logout">logout</button>
</form>  
<h2 class="mb-2 text-gray-800  text-center">Our Users</h2>
<div class="card shadow">
<div class="card-header py-3 d-flex justify-content-between">
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
<thead>
<tr>
<th>Sr.No</th>
<th>Username</th>
<th>Email</th>
<th>Operation</th>
</tr>
</thead>
<tbody>
    <!--PHP-->
<?php
$count=0;
if($rows){
while($result=mysqli_fetch_assoc($query)){
?>
<tr>
<td><?= ++$count ?></td>
<td><?= $result['name'] ?></td>
<td><?= $result['email'] ?></td>
<td>
<form class="mt-2"  method="POST"
onsubmit="return confirm('you really want to delete this user..')">
<input type="hidden" value="<?= $result['id'] ?>" name="userid" >
<input type="submit" name="deleteUser" value="Delete" class="btn btn-sm btn-danger" >
</form>
</td>
</tr>
<?php
}
}
else{
?>
<tr><td  colspan="4" >   NO result found</td>  </tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<?php
session_start();
if (isset($_POST['deleteUser'])){
$id=$_POST['userid'];
$delete="DELETE FROM user_form  WHERE  id= '$id'";
$run=mysqli_query($conn,$delete);
if($run){
$msg=['Post has been deleted','alert-success'];
$_SESSION['msg']=$msg;
header("location:admin_dashboard.php");
}
else{
$msg=['failed','alert-danger'];
$_SESSION['msg']=$msg;
header("location:admin_dashboard.php");
}
}
?>
<?php
if(isset($_POST['logout'])){
session_destroy();
header("location:home.php");
}
?>
</body>
</html>
