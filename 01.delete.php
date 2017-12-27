<?php 
$db=mysqli_connect('localhost','root','','demo');
$id=$_GET['id'];
$sql="delete from student where id='$id'";
if(mysqli_query($db,$sql)){
    echo "<script> location.replace('01.php') </script>";
}else{
    echo 'ERROR : '.mysqli_error($db);
}
mysqli_close($db);
?>