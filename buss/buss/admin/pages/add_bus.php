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
        <form action="" method="post">
            <div class="bg-image"></div>
            <div class="bg-grad"></div>
            <div class="header">
                <div>Add<span>Bus</span></div>
            </div>
            <div class="form-box">
                <input type="text" name="bus_n" placeholder="bus name" />
                <input type="submit" name="addBus" value="Submit Form" />
            </div>
        </form>
    </div>
    <script>
        window.onload = function() {
            document.querySelector(".active").classList.remove("active");
            var x = document.getElementsByClassName("sidebar");
            x[0].getElementsByTagName("li")[0].classList.add("active");
        }
    </script>
    <?php
    if (isset($_POST['addBus'])) {

        include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');

        $bus_name = $_POST['bus_n'];

        $q = "select * from bus where bus_n = '$bus_name'";
        $run_q = mysqli_query($con, $q);
        if (!mysqli_num_rows($run_q)) {
            $q = "insert into bus (bus_name) values ('$bus_name')";
            $run_q = mysqli_query($con, $q);
            header('Location:all_bus_list.php?msg=Record successfully inserted.');
        }
    }
    ?>

</body>

</html>