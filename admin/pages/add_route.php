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
	?>
	<div class="col-sm-12 col-md-8 working" style="overflow: hidden;">
		<form action="route_added.php" method="post">
			<div class="bg-image"></div>
			<div class="bg-grad"></div>
			<div class="header">
				<div>Add<span>Route</span></div>
			</div>

			<div class="form-box">
				<div class="autocomplete" style="width:250px;">
					<input type="text" name="from_node" placeholder="from" id="from">
				</div>
				<div class="autocomplete" style="width:250px;">
					<input type="text" name="to_node" placeholder="to" id="to">
				</div>
				<select name="bus[]" class="form-control" style="width:250px;margin:10px 0 10px 0;" multiple>
					<?php
					include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');
					$q2 = "select * from bus";
					$run_q2 = mysqli_query($con, $q2);
					$row_q2 = mysqli_fetch_array($run_q2);
					while ($r = mysqli_fetch_array($run_q2)) {
					?><option value='<?php echo $r['bus_id'] ?>'><?php echo $r['bus_name'] ?></option>
					<?php
					}
					?>
				</select>
				<input type="text" name="distance" id="txtboxToFilter" placeholder="distance">
				<input type="submit" name="addEdge" value="Submit Form" />
			</div>
		</form>
	</div>
	<script>
		window.onload = function() {
			document.querySelector(".active").classList.remove("active");
			var x = document.getElementsByClassName("sidebar");
			x[0].getElementsByTagName("li")[1].classList.add("active");
		}
	</script>
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
		$q1 = "select * from nodes";
		$run_q1 = mysqli_query($con, $q1);
		$row1 = mysqli_fetch_all($run_q1);
		foreach ($row1 as $result1) {
			$nodes[] = $result1[1];
		}
		echo "var jsony =" . json_encode($nodes) . ";\n";
		?>
		autocomplete(document.getElementById("from"), jsony);
		autocomplete(document.getElementById("to"), jsony);
	</script>

</body>

</html>