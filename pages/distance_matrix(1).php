<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'bus';

$con = new mysqli($dbhost,$dbuser,$dbpass,$db);

//check connection
if($con->connect_error){
	die("connection failed: " . $con->connect_error);
}

$q = "select * from edges";
$run_q = mysqli_query($con, $q);
$row=mysqli_fetch_all($run_q);
$no = $_GET['page'];
foreach ($row as $result)
{
    if($result[0]>=$no){
    $query = "select * from nodes where node_id=$result[1]";
    $run_query = mysqli_query($con,$query);
    $from_node = mysqli_fetch_assoc($run_query);
    $from_address = $from_node["address"];
    $from_lat = $from_node["latitude"];
    $from_lng = $from_node["longitude"];
    
    $query = "select * from nodes where node_id=$result[2]";
    $run_query = mysqli_query($con,$query);
    $to_node = mysqli_fetch_assoc($run_query);
    $to_address = $to_node["address"];
    $to_lat = $to_node["latitude"];
    $to_lng = $to_node["longitude"];
    
    $origin_latlng = $from_lat.','.$from_lng;
    $destination_latlng = $to_lat.','.$to_lng;
    
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origin_latlng."&destinations=".$destination_latlng."&unit=metric&key=AIzaSyDJ5YrHe6GorQ8BVPtT_gsmTM6ElhZwEHY";
    $contents = file_get_contents($url);
    $contents = json_decode($contents,true);
    $distance = $contents["rows"][0]["elements"][0]["distance"]["text"];
    $distance = str_replace(' km', '', $distance) ;
    
    $query = "update edges set distance=".$distance."where edge_id=$result[0]";
    $run_query = mysqli_query($con,$query);
    
    echo  $result[0].' : '.$from_address.' - '.$to_address.' .ie ';
    echo $origin_latlng.'-'.$destination_latlng.' : '.$distance.'<br>'; 
    }   
}
?>
<script>
/*
var xmlhttp = new XMLHttpRequest();
var url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=Vancouver+BC|Seattle&destinations=San+Francisco|Victoria+BC&mode=bicycling&unit=metric&key=AIzaSyDJ5YrHe6GorQ8BVPtT_gsmTM6ElhZwEHY";
xmlhttp.overrideMimeType("json");
xmlhttp.open("GET", url, true);
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
    document.write(myObj["rows"][0]["elements"][0]["distance"].text);
  }
};
xmlhttp.send(null);
*/
</script>
