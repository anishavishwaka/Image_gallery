<?php
$username = "root";
$password = "";
$server = "localhost";
$db = "images";
$conn = mysqli_connect($server,$username,$password,$db);
if($conn){
    ?>
<script>
    alert('connenction successful');
</script>
<?php
}
else{
    die("no connection".mysqli_connect_error());
}
?>