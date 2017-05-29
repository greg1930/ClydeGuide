<?php
session_start();
$logout = (isset($_POST["action"])) ? $_POST["action"] : "";
if($logout == "set"){
    unset($_SESSION["sessionuser"]);
}
if(isset($_SESSION["sessionuser"])){ // user is logged in
     $sessionuser = ($_SESSION["sessionuser"]);
     echo "<form name=\"logout\" method=\"post\">
                    <input type=\"submit\" name=\"logout\" value=\"Logout\"/>
                    <input type=\"hidden\" name=\"action\" value=\"set\"/>
           </form>";
}
?>
<?php
        $host = "devweb2016.cis.strath.ac.uk";
        $user = "cs312n";
        $password = "eeGheifohsh8";
        $database = "cs312n";
        $conn = new mysqli($host, $user, $password, $database);
        $rating = 0;
        $count = 0;
        if($conn->connect_error) {
                die("Connection failed".$conn->connect_error);
        }
        $sql = "SELECT * FROM `Place`";
        $result = $conn->query($sql);
        if(!$result) {
            die("Query failed".$conn->error); 
        }
       
  ?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

background-image: url("slideshow.gif");
-->
<html>
    <head>
        <title>Clyde Guide</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
              border:none;
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
            #bbody{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
            }
            .entry{
                align-content: center;
                
                
            }
            #viewLoc{
                font-family: Avant Garde, Century Gothic, sans-serif;
                text-align: center;
                align-items: center;
                align-content: center;
            }
            h3{
                font-family: Avant Garde, Century Gothic, sans-serif;
                padding: 2rem 0rem 1rem 4rem;
            }
            
        </style>
    </head>
    <body>
        <div>
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
            <div id = "bbody">
        <div id = "mainBody2">
            <h2>Welcome to Glasgow</h2>
        </div>
            
        <div class = "entries">
         
            <form action ="map.php" method ="get" id="viewLoc">
                If you want to view the locations on a map, click here:<br>
                <input type ="submit"  value ="Map View" /><hr>
            </form>
            
            <h3>What would you like to view? </h3><br>
           <?php
           while($row = $result->fetch_assoc()) {
                $id = $row["ID"];
                $sql2 = "SELECT * FROM `Review` WHERE `Place_ID` = $id";
                $result2 = $conn->query($sql2);
                if(!$result2) {
                    die("Query failed".$conn->error); 
                }
                while($row2 = $result2->fetch_assoc()) {
                    $stars = $row2["Stars"];
                    $rating = $rating + $stars;
                    $count++;
                }
                if($count!=0) {
                $average = $rating/$count;
                }
                $name = $row["Name"];            
            ?>
             
             <div class ="entry">
            <div class = "buttonAndW">
            <?php 
            
            echo $name;
            echo "<form name=\"form\" method=\"GET\" action=\"viewplace.php\">
            <input type=\"submit\" value=\"see details\"/>
            <input type=\"hidden\" name=\"hidden\" value=\"$id\"/>
            </form>";
            ?> </div>
                <?php
            $image_url = $row["Photo_Url"]; ?>
                 <img src="<?php echo $image_url; ?>" class="picture"><?php echo "<br><br>";
             
            echo "$average";echo "<br><br>";
            $rating = 0;
            $count = 0;
            $average = 0;
            } ?> 
            
            </div>
        </div>
        </div>
    </body>
</html>
