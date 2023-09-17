<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<head>

    <title>Bus Finder</title>
    <?php

    if (isset($_GET['error'])) {
        if ($_GET['error'] == "no_route") {
            echo '<script>
                alert("Didn\'t find any route of yours.");
                window.location.replace("index.php");
            </script>';
        }
    }

    include('includes/header.php');
    ?>
</head>

<body>
    <?php
    include('includes/navigation.php');
    ?>
    <div class="image-ban">
        <div class="overlay">
            <div class="container-fluid middlepart">
                <div class="row">
                    <div class="col-md-6 left">
                        <h2>Connecting People & <span class="color">Places</span></h2>
                    </div>
                    <div class="col-md-6 right">
                        <form autocomplete="off" action="route_map.php" method="post" class="col-md-8 offset-md-3 formpart">
                            <h4>Search:</h4>
                            <div class="autocomplete">
                                <input type="text" class="form-control" id="from" name="from" placeholder="Enter source" required>
                            </div>
                            <div class="autocomplete">
                                <input type="text" class="form-control" id="to" name="to" placeholder="Enter destination" required>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="return valid();">Get Started!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function valid() {
            var from = document.getElementById('from').value;
            var to = document.getElementById('to').value;

            if (from == "" || to == "") {
                alert("Enter places in both fields.")
                return false;
            } else if (from == to) {
                alert("Your starting point and destination are same.")
                return false;
            } else {
                return true;
            }
        }
        $("input[type='text']").keydown(function(e) {
            // Ensure that it is a number and stop the keypress
            if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) {
                event.preventDefault();
            } else {
                return true;
            }

        });
    </script>
    <script>
        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/buss/admin/includes/connection1.php');
        $q = "select * from nodes";
        $run_q = mysqli_query($con, $q);
        $row = mysqli_fetch_all($run_q);
        foreach ($row as $result) {
            $nodes[] = $result[1];
        }
        echo "var jsony =" . json_encode($nodes) . ";\n";
        ?>
        autocomplete(document.getElementById("from"), jsony);
        autocomplete(document.getElementById("to"), jsony);
    </script>
    <?php
    include('includes/footer.php');
    ?>
</body>

</html>