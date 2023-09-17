<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "bus";

// Create connection
$con = new mysqli($servername, $username, $password, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




$objective = '';
$length_description = '';
$path_description = '';
//set the distance array
$_distArr = array();
$graph = "select * from edges";
$run_g = mysqli_query($con, $graph);
while ($row_g = mysqli_fetch_array($run_g)) {
    $from = $row_g['from'];
    $to = $row_g['to'];
    $dist = $row_g['distance'];

    $_distArr[$from][$to] = $dist;
}

$a = $_POST['from'];
$b = $_POST['to'];
$from_address = $a;
$to_address = $b;
$q = "select * from nodes where address = '$a'";
$run_q = mysqli_query($con, $q);
$row_q = mysqli_fetch_array($run_q);
$a = $row_q['node_id'];
$q = "select * from nodes where address = '$b'";
$run_q = mysqli_query($con, $q);
$row_q = mysqli_fetch_array($run_q);
$b = $row_q['node_id'];

if (!isset($a) or !isset($b)) {
    header('location:./index.php?error=no_route');
}
//initialize the array for storing
$S = array(); //the nearest path with its parent and weight
$Q = array(); //the left nodes without the nearest path
foreach (array_keys($_distArr) as $val) $Q[$val] = 99999;
$Q[$a] = 0;

//start calculating
while (!empty($Q)) {
    $min = array_search(min($Q), $Q); //the most min weight
    if ($min == $b) break;
    foreach ($_distArr[$min] as $key => $val) if (!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
        $Q[$key] = $Q[$min] + $val;
        $S[$key] = array($min, $Q[$key]);
    }
    unset($Q[$min]);
}

if (count($Q) == 0 or count($S) == 0) {
    header('location:./index.php?error=no_route');
}

$q = "select * from nodes where node_id = '$a'";
$run_q = mysqli_query($con, $q);
$row_q = mysqli_fetch_array($run_q);
$from = $row_q['address'];
$from_lat = $row_q['latitude'];
$from_long = $row_q['longitude'];

$q = "select * from nodes where node_id = '$b'";
$run_q = mysqli_query($con, $q);
$row_q = mysqli_fetch_array($run_q);
$to = $row_q['address'];
$to_lat = $row_q['latitude'];
$to_long = $row_q['longitude'];

//list the path
$path = array();
$pos = $b;
$pos_name = $to;
$lat_long = array("name" => $pos_name, "lat" => $to_lat, "lng" => $to_long);
while ($pos != $a) {
    $path[] = $pos;
    $path_name[] = $pos_name;
    $path_lat_long[] = $lat_long;
    $pos = $S[$pos][0];
    $q = "select * from nodes where node_id = '$pos'";
    $run_q = mysqli_query($con, $q);
    $row_q = mysqli_fetch_array($run_q);
    $pos_name = $row_q['address'];
    $lat = $row_q['latitude'];
    $long = $row_q['longitude'];
    $lat_long = array("name" => $pos_name, "lat" => $lat, "lng" => $long);
}

$path[] = $a;
$path_name[] = $from;
$path_lat_long[] = array("name" => $from, "lat" => $from_lat, "lng" => $from_long);
$path = array_reverse($path);
$path_name = array_reverse($path_name);
$path_lat_long = array_reverse($path_lat_long);

$from_name = $from;
$to_name = $to;
$objective .= "From $from to $to";
$length_description .= "The length is " . $S[$b][1] . ' km';
$path_description .= "Path is: " . implode('->', $path_name);

for ($i = 0; $i < count($path) - 1; ++$i) {
    $from = current($path);
    $to = next($path);

    if ($i == 0) {
        $starting_from = $from;
        $starting_to = $to;
    }

    if ($i == count($path) - 2) {
        $ending_from = $from;
        $ending_to = $to;
    }

    $q = "select edge_id from edges where `from`='$from' and `to`='$to'";
    $run_q = mysqli_query($con, $q);
    $row_q = mysqli_fetch_array($run_q);
    $edge_list[$from][$to] = $row_q['edge_id'];
}

foreach (array_keys($edge_list) as $key) {
    foreach (array_keys($edge_list[$key]) as $val) {
        $e = $edge_list[$key][$val];
        // echo 'bus list from: '.$key.'-'.$val.'=> '.$e." are : <br/>";
        $q = "select bus_id from bus_edge where edge_id='$e'";
        $run_q = mysqli_query($con, $q);
        while ($row_q =  mysqli_fetch_array($run_q)) {
            $bus_list[$key][$val][] = $row_q['bus_id'];
        }
    }
}

$path_option = array();
$first = 0;
function bus_route($bus_list, $starting_from, $starting_to, $ending_from, $ending_to, $second)
{
    for ($i = 0; $i < count($bus_list[$starting_from][$starting_to]); ++$i) {
        $start_bus = $bus_list[$starting_from][$starting_to][$i];
        $common = false;
        $temp_bus_list = $bus_list;

        foreach (array_keys($temp_bus_list) as $key) {
            $common = false;
            foreach (array_keys($temp_bus_list[$key]) as $val) {
                foreach (array_keys($temp_bus_list[$key][$val]) as $b) {
                    if ($start_bus == $temp_bus_list[$key][$val][$b]) {
                        $common = true;
                        unset($temp_bus_list[$key]);
                        break;
                    }
                }
                if ($common == false) {
                    $temp_starting_from = $key;
                    $temp_starting_to = $val;
                    $temp_ending_from = $ending_from;
                    $temp_ending_to = $ending_to;
                    $ending_to = $key;
                    break;
                }
            }
            if ($common == false) {
                break;
            }
        }
        $con = $GLOBALS['con'];
        $q = "select address from nodes where `node_id`='$starting_from'";
        $run_q = mysqli_query($con, $q);
        $row_q = mysqli_fetch_array($run_q);
        $starting_from_name = $row_q['address'];
        $q = "select address from nodes where `node_id`='$ending_to'";
        $run_q = mysqli_query($con, $q);
        $row_q = mysqli_fetch_array($run_q);
        $ending_to_name = $row_q['address'];
        $q = "select bus_name from bus where `bus_id`='$start_bus'";
        $run_q = mysqli_query($con, $q);
        $row_q = mysqli_fetch_array($run_q);
        $start_bus_name = $row_q['bus_name'];

        if ($common == true) {
            $GLOBALS['path_option'][$GLOBALS['first']][$second] = 'From ' . $starting_from_name . ' to ' . $ending_to_name . ' you can take ' . $start_bus_name . "<br/>";
            if (count($temp_bus_list) == 0) {
                $GLOBALS['first']++;
            }
        } else {
            $GLOBALS['path_option'][$GLOBALS['first']][$second] = 'From ' . $starting_from_name . ' to ' . $ending_to_name . ' you can take ' . $start_bus_name . "<br/>";
            if (count($temp_bus_list) > 0) {
                bus_route($temp_bus_list, $temp_starting_from, $temp_starting_to, $temp_ending_from, $temp_ending_to, $second + 1);
                $ending_to = $temp_ending_to;
            } else {
                $GLOBALS['first']++;
            }
        }

        if (!isset($GLOBALS['path_option'][$GLOBALS['first']][0])) {
            for ($y = 0; $y < ($second); $y++) {
                $GLOBALS['path_option'][$GLOBALS['first']][] = $GLOBALS['path_option'][$GLOBALS['first'] - 1][$y];
                $GLOBALS['last_key'] = $GLOBALS['first'];
            }
        }
    }
}

if (count($bus_list) != 0) {
    bus_route($bus_list, $starting_from, $starting_to, $ending_from, $ending_to, 0);

    if (isset($last_key))
        unset($path_option[$last_key]);
    $min_count = count($path_option[0]);
    $min = 0;
    $best_path_option = $path_option[0];
    $change = 0;

    foreach (array_keys($path_option) as $key) {
        if (count($path_option[$key]) < $min_count) {
            $best_path_option = $path_option[$key];
            $min_count = count($path_option[$key]);
            $min = $key;
            $change++;
        }
    }
    if ($change > 0)
        unset($path_option[$key]);
    else
        unset($best_path_option);

    for ($x = 0; $x < count($path_option); $x++) {
        for ($z = 0; $z < count($path_option) - $x - 1; $z++) {
            if (count($path_option[$z]) > count($path_option[$z + 1])) {
                $temp = $path_option[$z];
                $path_option[$z] = $path_option[$z + 1];
                $path_option[$z + 1] = $temp;
            }
        }
    }
}

$q = "select * from bus";
$run_q = mysqli_query($con, $q);

while ($row_q = mysqli_fetch_array($run_q)) {
    $bus_start = $row_q['bus_id'];
    $bus_start_name = $row_q['bus_name'];

    $r = "select bus_id from bus_edge where edge_id IN (select edge_id from edges where `from`='$a')";
    $run_r = mysqli_query($con, $r);

    while ($row_r = mysqli_fetch_array($run_r)) {
        if ($row_r['bus_id'] == $bus_start)
            $bus_from = $a;
    }

    $r = "select bus_id from bus_edge where edge_id IN (select edge_id from edges where `to`='$b')";
    $run_r = mysqli_query($con, $r);

    while ($row_r = mysqli_fetch_array($run_r)) {
        if ($row_r['bus_id'] == $bus_start)
            $bus_to = $b;
    }

    if (isset($bus_from) && isset($bus_to)) {
        $acc_bus_route[] = $bus_start_name . " goes from " . $from_name . " to " . $to_name . "<br>";
    }
    unset($bus_from);
    unset($bus_to);
}
