<?php
include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
if(isset($_POST['from_address'])){
    // $from = $_POST['from_address'];
    // $to = $_POST['to_address'];
    // $dist = $_POST['dist'];
    // $id = $_POST['id'];
    // $sql = "UPDATE `edges` SET `from`='$from',`to`='$to',`distance`='$dist' WHERE `edge_id`='$id'";
    // if(mysqli_query($con,$sql)){
    //     header('Location:all_routes_list.php?msg=Record successfully updated.');
    // }else{
    //     header('Location:all_routes_list.php?errmsg=Sorry cannot update right now.');
    // }
    $from = $_POST['from_address'];
	$to = $_POST['to_address'];
	$dist = $_POST['dist'];    

    $q1 = "select * from nodes where address like '$from'";
	$run_q1 = mysqli_query($con, $q1);
	$row_q1 = mysqli_fetch_assoc($run_q1);
	$f = $row_q1['node_id'];
	$q = "select * from nodes where address like '$to'";
	$run_q = mysqli_query($con, $q);
	$row_q = mysqli_fetch_assoc($run_q);
	$t = $row_q['node_id'];

    $id = $_POST['id'];

    $sql = "UPDATE `edges` SET `from` = '$f', `to` = '$t', `distance` = '$dist' WHERE `edges`.`edge_id` = $id";
    // print($sql);die;
    if(mysqli_query($con,$sql)){
        header('Location:all_routes_list.php?msg=Record successfully updated.');
    }else{
        header('Location:all_routes_list.php?errmsg=Sorry cannot update right now.');
    }
	
}
