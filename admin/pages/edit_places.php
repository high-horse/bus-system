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
		$q  = "SELECT * FROM `nodes` WHERE `node_id` = '$id'";
		$bus = mysqli_query($con, $q);
		$name = mysqli_fetch_assoc($bus);
	}
	?>
	<div class="col-sm-12 col-md-8 working" style="overflow: hidden;">
		<form action="edit_process_places.php" method="post">
			<div class="bg-image"></div>
			<div class="bg-grad"></div>
			<div class="header">
				<div>Edit<span>Place</span></div>
			</div>

			<div class="form-box">
				<input type="text" name="node_address" value="<?php echo $name['address']; ?>" />
				<input type="text" name="node_latitude" value="<?php echo $name['latitude']; ?>" />
				<input type="text" name="node_longitude" value="<?php echo $name['longitude']; ?>" />
				<input type="hidden" name="id" value="<?php echo $name['node_id']; ?>">
				<input type="submit" name="addNode" value="Update" />
			</div>
		</form>
	</div>

</body>

</html>