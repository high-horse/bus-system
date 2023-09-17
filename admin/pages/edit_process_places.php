<?php
include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
if(isset($_POST['node_address'])){
    $name = $_POST['node_address'];
    $lat = $_POST['node_latitude'];
    $long = $_POST['node_longitude'];
    $id = $_POST['id'];
    $sql = "UPDATE `nodes` SET `address`='$name',`latitude`='$lat',`longitude`='$long' WHERE `node_id`='$id'";
    if(mysqli_query($con,$sql)){
        header('Location:all_places_list.php?msg=Record successfully updated.');
    }else{
        header('Location:all_places_list.php?errmsg=Sorry cannot update right now.');
    }

}
