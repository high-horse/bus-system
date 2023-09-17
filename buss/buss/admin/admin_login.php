<?php
session_start();
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con,'bus');
$name=$_POST['user'];
$pass=$_POST['Password'];
$s="select * from admin where username='$name' && password='$pass'";
$result = mysqli_query($con,$s);
$num = mysqli_num_rows($result);
if($num == 1){
    $_SESSION['username']=$name;
    header('location:pages/add_bus.php');
}else{
    header('location:../admin.php?login_failed=1');
}
?>