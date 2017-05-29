<?php

session_start();
$logout = (isset($_POST["actionLogout"])) ? $_POST["actionLogout"] : "";
if($logout == "set"){
    unset($_SESSION["sessionuser"]);
}
if(!isset($_SESSION["sessionuser"])){
    $sessionuser = "";
    echo "Please login to add a new place!";?> <br/>
    <form name='externalForm' action='login.php' method='get'>
        <input type='hidden' name='backTo' value='place.php'/>
        <input type='submit' value='Go to the login page'/>
    </form>
<?php
}else{
    $sessionuser = ($_SESSION["sessionuser"]);
    echo "<form name=\"logout\" method=\"post\">
                    <input type=\"submit\" name=\"logout\" value=\"Logout\"/>
                    <input type=\"hidden\" name=\"actionLogout\" value=\"set\"/>
           </form>";
?>

<!DOCTYPE html> 
<html>
    <style>
            body{
                margin: 10px 5% 10px 5%;
                background-image: url("F.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
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
                color: #000099;
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
            #entryy{
                align-content: center;
                padding: 2rem;
                background-color: whitesmoke;
                                font-family: Avant Garde, Century Gothic, sans-serif;

                
            }
            #body3{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
            }
            
        </style>
    <body> 
        
        <div id = "mainBody">
            <h1>Clyde Guide</h1>
        </div>
       <div id = "menu">
            <a href ="Welcome.php">Home</a>
            <a href="place.php"> Add a Place </a>
            <a href="review.php"> Add a Review</a>
            <a href ="register.php">Register</a>
            <a href ="login.php">Log In</a>
            <a href ="AboutUs.html">Developers</a>
        </div>
        <div id ="body3">
        <h2>Place Details</h2> 
        <hr>
        <div> 
            <?php
            $action = isset($_POST["action"]) ? $_POST["action"] : "";
            $place = isset($_POST["place"]) ? $_POST["place"] : "";
            if(!$action == "set"){?>
               <form method="post" id ="entryy">         
                Enter place: <input type="text" name="place"> <br> 
                <input type="hidden" name="action" value="set"/>
                <input type="submit" value="Submit"/>        
            </form> 
            <?php    
            }else{
                $host = "devweb2016.cis.strath.ac.uk";
                $user = "cs312n";
                $password = "eeGheifohsh8";
                $database = "cs312n";
                $conn = new mysqli($host, $user, $password, $database);
                $url = "https://maps.googleapis.com/maps/api/place/textsearch/xml?location=55.861152,-4.250196&radius=20000&query=$place&key=AIzaSyCZ5hIyTYkYvgeNluTFbVYDflLL81hjz3w";
                $xml = simplexml_load_file($url);
                $name = $xml->result->name;
                $address = $xml->result->formatted_address;
                $photo = $xml->result->photo->photo_reference;
                $photoreference = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photo&key=AIzaSyCZ5hIyTYkYvgeNluTFbVYDflLL81hjz3w";
                $latitude = $xml->result->geometry->location->lat;
                $longitude = $xml->result->geometry->location->lng;
                $found = false;
                if ($conn->connect_error) {
                    die("Connection failed" . $conn->connect_error);
                }                                           
                $sql = "SELECT * FROM `Place`"; 
                $result = $conn->query($sql);    
                if(!$result) {                
                    die("Query failed".$conn->error);   
                }      
                if($result->num_rows > 0) {    
                    while($row = $result->fetch_assoc()) {     
                        $existing=$row["Name"];    
                        if($existing==$name) {      
                            $found = true;         
                            echo "Place already exists";   
                        }       
                    }      
                }          
                if($found==false) {     
                    // create sql query and run it             
                    $sql2 = "INSERT INTO `Place` (`ID`, `Photo_Url`, `Name`, `Address`, `Longitude`, `Latitude`) "
                            . "VALUES (NULL, '$photoreference', '$name', '$address', '$longitude', '$latitude')"; 
                    if($conn->query($sql2)===TRUE) {   
                        echo"<p>Insert  successful</p>";   
                    } else {                   
                        die("Error on insert".$conn->error); 
                    }   
                }      
                $conn->close(); 
            }
     
            ?>
        </div> 
 
<?php } ?>
        </div>
   </body>
</html>


