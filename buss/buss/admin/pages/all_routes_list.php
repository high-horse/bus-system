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
            <th>From</th>
            <th>To</th>
            <th>Distance</th>
            <th>Action</th>
            <?php

            include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');

            $q = "SELECT * FROM `edges` ORDER BY edge_id DESC";
            $all = mysqli_query($con, $q);
            while ($row = mysqli_fetch_assoc($all)) {
            ?>
                <tr>
                    <td><?php
                        $from_id = $row['from'];
                        $fetch_sql = "SELECT address  FROM `nodes` WHERE `node_id` = '$from_id'";
                        $run_query = mysqli_query($con, $fetch_sql);
                        while ($get_from_address = mysqli_fetch_assoc($run_query)) {
                            echo $get_from_address['address'];
                        }
                        ?></td>
                    <td><?php
                        $to_id = $row['to'];
                        $fetch_sql1 = "SELECT address  FROM `nodes` WHERE `node_id` = '$to_id'";
                        $run_query1 = mysqli_query($con, $fetch_sql1);
                        while ($get_to_address = mysqli_fetch_assoc($run_query1)) {
                            echo $get_to_address['address'];
                        }
                        ?></td>
                    <td><?php echo $row['distance']; ?></td>
                    <td><a href="delete_routes.php?id=<?php echo $row['edge_id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="fas fa-trash-alt"></i> </a>|<a href="edit_routes.php?id=<?php echo $row['edge_id']; ?>"> <i class="far fa-edit"></i> </a></td>
                </tr>


            <?php } ?>

        </table>
    </div>

</body>

</html>