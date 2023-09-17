<?php
include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
if(isset($_POST['bus_n'])){
    $name = $_POST['bus_n'];
    $id = $_POST['id'];
    $sql = "UPDATE `bus` SET `bus_name`='$name' WHERE `bus_id`='$id'";
    if(mysqli_query($con,$sql)){
        header('Location:all_bus_list.php?msg=Record successfully updated.');
    }else{
        header('Location:all_bus_list.php?errmsg=Sorry cannot update right now.');
    }

}
