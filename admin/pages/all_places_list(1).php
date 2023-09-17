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
    <div class="col-sm-12 col-md-8 working" style="overflow:scroll ;">
        <?php
        if (isset($_GET['msg'])) { ?>
            <div class="alert alert-success"> <?php echo $_GET['msg']; ?></div>
        <?php } ?>

        <?php if (isset($_GET['errmsg'])) { ?>
            <div class="alert alert-danger"> <?php echo $_GET['errmsg']; ?></div>
        <?php } ?>
        <table class="table">
            <th>Places</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Action</th>
            <?php

            include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');

            $q = "SELECT * FROM `nodes`";
            $all = mysqli_query($con, $q);
            while ($row = mysqli_fetch_assoc($all)) {
            ?>
                <tr>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['latitude']; ?></td>
                    <td><?php echo $row['longitude']; ?></td>
                    <td><a href="delete_places.php?id=<?php echo $row['node_id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="fas fa-trash-alt"></i> </a>|<a href="edit_places.php?id=<?php echo $row['node_id']; ?>"> <i class="far fa-edit"></i> </a></td>
                </tr>


            <?php } ?>

        </table>
    </div>

</body>

</html>