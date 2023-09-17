<?php 
include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
if(isset($_GET['id'])){
    $name = $_GET['node_address'];
    $lat = $_GET['node_latitude'];
    $long = $_GET['node_longitude'];
    $id = $_GET['id'];
    $q = "DELETE FROM `nodes` WHERE `node_id`='$id'";
     if(mysqli_query($con,$q)){
        header('Location:all_places_list.php?msg=Record successfully deleted.');
     }else{
        header('Location:all_places_list.php?errmsg=Sorry can not delete right now.');
     }
 }
