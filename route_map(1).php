<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<head>
  <title>Bus Finder</title>
  <?php
  include('includes/header.php');
  ?>
  <style>
    #map {
      height: 500px;
      width: auto;
    }
  </style>
</head>

<body>
  <?php
  include('includes/navigation.php');
  include('pages/service_action.php');
  ?>
  <div class="container searchform col-md-6 offset-md-3">
    <form autocomplete="off" action="route_map.php" method="post">
      <div class="form-row align-items-center">
        <div class="col-auto autocomplete">
          <input type="text" class="form-control mb-2" id="inlineFormInput from" name="from" placeholder="Enter source" value="<?php echo $from_address; ?>">
        </div>
        <div class="col-auto autocomplete">
          <input type="text" class="form-control mb-2" id="inlineFormInput to" name="to" placeholder="Enter destination" value="<?php echo $to_address ?>">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary mb-2 searchbtn" onclick="return valid();">Get Started!</button>
        </div>
      </div>
    </form>
  </div>

  <script>
    function valid() {
      var from = document.getElementById('inlineFormInput from').value;
      var to = document.getElementById('inlineFormInput to').value;

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

  <div class="container-fluid">
    <div class="row" style="margin-top: 100px;padding:0 5px 0 20px;">
      <div class="col-sm-7" id="map"></div>
      <div class="col-sm-5">
        <h5><?php echo $objective; ?></h5>
        <?php
        if (isset($acc_bus_route)) {
        ?>
          <h4>According to bus route</h4>
          <p><?php
              foreach (array_keys($acc_bus_route) as $key) {
                echo $acc_bus_route[$key];
              }
              ?></p>
        <?php
        }
        ?>
        <h4>According to nearest distance</h4>
        <p><?php echo $length_description; ?></p>
		
        <p><?php echo $path_description; ?></p>
		<p > Bus Fare: <b>Rs. <span id="bus-fare"></span></b></p>
		<script>
			const pathDescription = "<?php echo $length_description;?>";
			const match = pathDescription.match(/\d+(\.\d+)?/);

			if (match) {
			  const number = parseFloat(match[0]);
			  if (number <= 5.1) {
				  fare = 20;
				} else if (number > 5.1 && number <= 10) {
				  fare = 25;
				} else if (number > 10 && number <= 15.5) {
				  fare = 30;
				} else if (number > 15.5 && number <= 20) {
				  fare = 35;
				} else if (number > 20 && number <= 25) {
				  fare = 40;
				} else if (number > 25 && number <= 30) {
				  fare = 45;
				} else if (number > 30 && number <= 35) {
				  fare = 50;
				} else if (number > 35 && number <= 40) {
				  fare = 55;
				} else if (number > 40 && number <= 45) {
				  fare = 60;
				} else if (number > 45 && number <= 50) {
				  fare = 65;
				} else {
				  // For distances above 50 km, you can set a default fare or handle it accordingly
				  //fare = "Distance exceeds 50 km, please inquire.";
				  fare = 60;
				}
			  document.getElementById('bus-fare').textContent = fare;
			  
			} else {
			  console.log("No number found in the string.");
			}
		</script>
		
        <?php
        /*
         echo "edges: <br/>";
             foreach(array_keys($edge_list) as $key){
                foreach(array_keys($edge_list[$key]) as $val){
                     echo $key.'-'.$val.'=> '.$edge_list[$key][$val]."<br/>";
                 }
             }
    
         foreach(array_keys($edge_list) as $key){
            foreach(array_keys($edge_list[$key]) as $val){
                echo 'bus list from: '.$key.'-'.$val.'=> '.$e." are : <br/>";
  
                foreach(array_keys($bus_list[$key][$val]) as $b){
                     echo $bus_list[$key][$val][$b]."<br/>"; 
                }
            }
        }
         echo 'bus list from: '.$key.'-'.$val.'=> '.$e." are : <br/>";
         foreach(array_keys($bus_list[$key][$val]) as $b){
             echo $bus_list[$key][$val][$b]."<br/>"; // for now
        }
        */
        ?>
        <?php
        if (isset($best_path_option)) {
        ?>
          <h6>Best choice:</h6>
          <p>
            <?php
            foreach (array_keys($best_path_option) as $key) {
              echo $best_path_option[$key];
            }
            ?>
          </p>
          <h6>Alternative Choice :</h6>
        <?php
        } else {
        ?>
          <h6>Choices :</h6>
        <?php
        }
        ?>
        <p>
          <?php
          foreach (array_keys($path_option) as $key) {
            if ($key < 2) {
              echo "Option " . ($key + 1) . ":<br>";
              foreach (array_keys($path_option[$key]) as $val) {
                echo $path_option[$key][$val];
              }
              echo "<br>";
            }
          }
          ?>
        </p>
      </div>
    </div>
  </div>


  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ5YrHe6GorQ8BVPtT_gsmTM6ElhZwEHY"></script>
  <script>
    var geocoder;
    var map;
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var locations = [
      <?php
      foreach (array_keys($path_lat_long) as $key) {
      ?>[<?php echo "'" . $path_lat_long[$key]['name'] . "'," . $path_lat_long[$key]['lat'] . "," . $path_lat_long[$key]['lng'] . "," . $key; ?>],
      <?php
      }
      ?>
    ];

    function initialize() {
      directionsDisplay = new google.maps.DirectionsRenderer();


      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(27.706746, 85.315172),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      directionsDisplay.setMap(map);
      var infowindow = new google.maps.InfoWindow();

      var marker, i;
      var request = {
        travelMode: google.maps.TravelMode.DRIVING
      };
      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));

        if (i == 0) request.origin = marker.getPosition();
        else if (i == locations.length - 1) request.destination = marker.getPosition();
        else {
          if (!request.waypoints) request.waypoints = [];
          request.waypoints.push({
            location: marker.getPosition(),
            stopover: true
          });
        }

      }
      directionsService.route(request, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(result);
        }
      });
    }
    google.maps.event.addDomListener(window, "load", initialize);
  </script>
  <?php
  include('includes/footer.php');
  ?>
</body>

</html>
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
  autocomplete(document.getElementById("inlineFormInput from"), jsony);
  autocomplete(document.getElementById("inlineFormInput to"), jsony);
</script>