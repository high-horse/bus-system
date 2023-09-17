<!DOCTYPE html>
<html>

<head>
	<title>BusFinder Admin</title>
	<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/buss/admin/includes/admin_header.php");
	?>
</head>

<body>
	<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/admin_navigation.php');

	include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$q  = "SELECT * FROM `edges` WHERE `edge_id` = '$id'";
		$bus = mysqli_query($con, $q);
		$name = mysqli_fetch_assoc($bus);
		$from_id = $name['from'];
		$fetch_sql = "SELECT address  FROM `nodes` WHERE `node_id` = '$from_id'";
		$run_query = mysqli_query($con, $fetch_sql);
		while ($get_from_address = mysqli_fetch_assoc($run_query)) {
			$from_address_val = $get_from_address['address'];
		}

		$to_id = $name['to'];
		$fetch_sql1 = "SELECT address  FROM `nodes` WHERE `node_id` = '$to_id'";
		$run_query1 = mysqli_query($con, $fetch_sql1);
		while ($get_to_address = mysqli_fetch_assoc($run_query1)) {
			$to_address_val = $get_to_address['address'];
		}
	}
	?>
	<div class="col-sm-12 col-md-8 working" style="overflow: hidden;">
		<form action="edit_process_routes.php" method="post">
			<div class="bg-image"></div>
			<div class="bg-grad"></div>
			<div class="header">
				<div>Edit<span>Route</span></div>
			</div>

			<div class="form-box">
				<div class="autocomplete" style="width:250px;">
					<input type="text" name="from_address" id="from_address" value="<?php echo $from_address_val; ?>" />
				</div>
				<div class="autocomplete" style="width:250px;">
					<input type="text" name="to_address" id="to_address" value="<?php echo $to_address_val; ?>" />
				</div>
				<input type="text" name="dist" id="txtboxToFilter" value="<?php echo $name['distance']; ?>" />
				<input type="hidden" name="id" value="<?php echo $name['edge_id']; ?>">
				<input type="submit" name="addEdge" value="Update" />
			</div>
		</form>
	</div>

</body>
<script src="js/autocomplete.js"></script>
<script>
	$("#txtboxToFilter").keydown(function(event) {
		// Allow only backspace and delete
		if (event.keyCode == 46 || event.keyCode == 8) {
			// let it happen, don't do anything
		} else {
			// Ensure that it is a number and stop the keypress
			if (event.keyCode < 48 || event.keyCode > 57) {
				event.preventDefault();
			}
		}
	});
	<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');
	$q = "select * from nodes";
	$run_q = mysqli_query($con, $q);
	$row = mysqli_fetch_all($run_q);
	foreach ($row as $result) {
		// print_r($result);
		$nodes[] = $result[1];
	}
	echo "var jsony =" . json_encode($nodes) . ";\n";
	?>
	autocomplete(document.getElementById("from_address"), jsony);
	autocomplete(document.getElementById("to_address"), jsony);
</script>

</html>