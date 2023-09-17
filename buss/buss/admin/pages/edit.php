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
        $q  = "SELECT * FROM `bus` WHERE bus_id = '$id'";
        $bus = mysqli_query($con, $q);
        $name = mysqli_fetch_assoc($bus);
    }
    ?>
    <div class="col-sm-12 col-md-8 working">
        <form action="edit_process.php" method="post">
            <div class="bg-image"></div>
            <div class="bg-grad"></div>
            <div class="header">
                <div>Edit<span>Bus</span></div>
            </div>
            <div class="form-box">
                <input type="text" name="bus_n" placeholder="bus name" value="<?php echo $name['bus_name']; ?>" />
                <input type="hidden" name="id" value="<?php echo $name['bus_id']; ?>">

                <input type="submit" name="addBus" value="Update" />
            </div>
        </form>
    </div>

</body>

</html>