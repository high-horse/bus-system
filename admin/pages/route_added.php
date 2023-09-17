<?php
if(isset($_POST['addEdge'])) {

    include($_SERVER['DOCUMENT_ROOT'].'/buss/admin/includes/connection1.php');
	
	$from = $_POST['from_node'];
	$to = $_POST['to_node'];
	$dist = $_POST['distance'];    

	$q2 = "select * from nodes where address like '$from'";
	$run_q2 = mysqli_query($con, $q2);
	$row_q2 = mysqli_fetch_assoc($run_q2);
    $f1 = $row_q2['node_id'];
    $bus = $_POST['bus'];


	$q3 = "select * from nodes where address like '$to'";
	$run_q3 = mysqli_query($con, $q3);
	$row_q3 = mysqli_fetch_assoc($run_q3);
	$t1 = $row_q3['node_id'];

	$my_query = "select * from edges where 'from' = $f1 and 'to' = $t1";
	$run_q4 = mysqli_query($con, $my_query);
	$i=0;
	if(mysqli_num_rows($run_q4)==0 && $i==0) {
        $qq = "SELECT max(edge_id)+1 FROM edges";
		$run_q5 = mysqli_query($con, $qq);
		$row_q5 = mysqli_fetch_assoc($run_q5);
		$tt = $row_q5['max(edge_id)+1'];
		$q0 = "INSERT INTO `edges` (`edge_id`, `from`, `to`, `distance`) VALUES ('$tt', '$f1', '$t1', '$dist')";
        $run_qq = mysqli_query($con, $q0);
		++$i;
        foreach($bus as $b_id){
            // print_r($b_id);
            $b0 = "INSERT INTO `bus_edge` (`bus_id`, `edge_id`) VALUES ('$b_id', '$tt')";
            $run_qb = mysqli_query($con, $b0);
        }
		header('Location:all_routes_list.php?msg=Record successfully inserted.');
	}else{
		print("NOT REACHED");
	}
}
