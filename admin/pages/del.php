<?php 
include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
 if(isset($_GET['id'])){
     $id = $_GET['id'];
     $q = "DELETE FROM `bus` WHERE `bus_id`='$id'";
     if(mysqli_query($con,$q)){
        header('Location:all_bus_list.php?msg=Record successfully deleted.');
     }else{
        header('Location:all_bus_list.php?errmsg=Sorry cannot delete right now.');
     }
 }
