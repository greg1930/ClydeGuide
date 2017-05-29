<?php
        $host = "devweb2016.cis.strath.ac.uk";
        $user = "cs312n";
        $password = "eeGheifohsh8";
        $database = "cs312n";
        $conn = new mysqli($host, $user, $password, $database);
        if($conn->connect_error) {
                die("Connection failed".$conn->connect_error);
        }
        $sql = "SELECT * FROM `Place`";
        $result = $conn->query($sql);
        if(!$result) {
            die("Query failed".$conn->error); 
        }
       
  ?>
<html>
  <head>
      <style>
            body{
                margin: 10px 5% 10px 5%;
                background-image: url("F.jpg");
                background-size: cover;
                background-repeat: no-repeat;
            }
            h1{
              text-align: center;
              font-family: Geneva, sans-serif;
              font-style:italic;
              font-size: 60px;
              background-color:#47c3d5;
              padding: 30px;
              border-radius: 10px;
              opacity: 0.6;
              border:none
            }
            #menu{
              text-align: center;
              font-family: Geneva, sans-serif;
              padding: 20px;
              background-color: #47c3d5;
              opacity: 0.7;
            }
            #menu a{
                color:activeborder;
                text-decoration: none;
                font-family: Geneva, sans-serif;
                display: inline;
                padding: 3em;
            }
            #menu a:hover{
                color:white;
                text-decoration: underline;
            }
            h2{
                text-align: center;
                font-family: Tahoma, Geneva, sans-serif;
                letter-spacing: 1em;
                padding: 2em;
            }
      #map {
        height: 400px;
        width: 100%;
       }
    </style>
  </head>
  <body>
      
       <div id = "mainBody">
            <h1>Clyde Guide</h1>
        </div>
     
        <div id = "menu">
            <a href ="Welcome.php">Home</a>
            <a href ="register.php">Register</a>
            <a href="place.php"> Add a Place </a>
            <a href="review.php"> Add a Review</a>
            <a href ="AboutUs.html">Developers</a>
            <a href="map.php">Map</a>
        </div>
      
    
    <div id="map" ></div>
    <script>
      function initMap() {
        var uluru = {lat: 55.861152, lng: -4.250196};
       
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: uluru
        });
        <?php while($row = $result->fetch_assoc()) { ?>
        var marker = new google.maps.Marker({
          position: {lat: <?php echo $row["Latitude"]; ?>, lng: <?php echo $row["Longitude"]; ?>},
          map: map
       
        });
         google.maps.event.addListener(marker, 'click', function() {
            window.location.href = "https://devweb2016.cis.strath.ac.uk/cs312n/viewplace.php?hidden="+<?php echo $row["ID"];?>+">";
          });
       
        <?php } ?>
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ5hIyTYkYvgeNluTFbVYDflLL81hjz3w&callback=initMap">
    </script>
     <form action ="Welcome.php" method ="get">
                <input type ="submit"  value ="List View" />
            </form>
  </body>
</html>
