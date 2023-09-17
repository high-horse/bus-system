<?php 
include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
if(isset($_GET['id'])){
    $from = $_GET['from_address'];
    $to = $_GET['to_address'];
    $dist = $_GET['dist'];
    $id = $_GET['id'];
    $q = "DELETE FROM `edges` WHERE `edge_id`='$id'";
     if(mysqli_query($con,$q)){
        header('Location:all_routes_list.php?msg=Record successfully deleted.');
     }else{
        header('Location:all_routes_list.php?errmsg=Sorry can not delete right now.');
     }
 }
