<?php
$db=mysqli_connect('localhost','root','','demo');
$name=mysqli_real_escape_string($db,$_GET['name']);
$age=mysqli_real_escape_string($db,$_GET['age']);

if($db == false){
    echo 'ERROR DB';
}
$sql="insert into student (name,age) values ('$name','$age')";
if(mysqli_query($db,$sql)){
    echo "<script> location.replace('01.php') </script>";
}else{
    echo 'ERROR : '. mysqli_error($db);
}
mysqli_close($db);
?>