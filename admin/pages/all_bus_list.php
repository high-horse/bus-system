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
            <th>Bus Name</th>
            <th>Action</th>
            <?php

            include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');

            $q = "SELECT * FROM `bus`";
            $all = mysqli_query($con, $q);
            while ($row = mysqli_fetch_assoc($all)) {
            ?>
                <tr>
                    <td><?php echo $row['bus_name']; ?></td>
                    <td><a href="del.php?id=<?php echo $row['bus_id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"> <i class="fas fa-trash-alt"></i> </a>|<a href="edit.php?id=<?php echo $row['bus_id']; ?>"> <i class="far fa-edit"></i> </a></td>
                </tr>


            <?php } ?>

        </table>
    </div>

</body>

</html>