<?php

function getGETsafely($conn, $name){
    if(isset($_GET[$name])){
    return $conn -> real_escape_string($_GET[$name]);
    } else {
        return "";
    }
}
        $host = "devweb2016.cis.strath.ac.uk";
        $user = "cs312n";
        $password = "eeGheifohsh8";
        $database = "cs312n";
        $conn = new mysqli($host, $user, $password, $database);
        if($conn->connect_error) {
                die("Connection failed".$conn->connect_error);
            }
  ?>
<html>
    <head>
        <title>Submit Review</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
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
            .entry{
                align-content: center;
                padding: 2rem;
                background-color: background;
                
            }
            #body2{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
            }
            #mes{
               
                font-family: Tahoma, Geneva, sans-serif;
    
                padding: 2em;
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
        <div id ="body2">
        <div id ="mes">
        <?php
        ob_start();
        require 'review.php';
        ob_end_clean();
     
        $id = getGETsafely($conn, "ID");
        $review = getGETsafely($conn, "review");
        $star = getGETsafely($conn, "star");
        $title = getGETsafely($conn, "title");
    
        $sql = "SELECT * FROM `Place` WHERE `id` = $id";
        $result = $conn->query($sql);
        if(!$result) {
            die("Query failed".$conn->error); 
        }
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $name=$row["Name"];
            }
        }
        
        
$sql = "INSERT INTO `Review` (`ID`, `Stars`, `Place`, `Title`, `Message`, `Place_ID`, `User_Name`, `Rate`) VALUES (NULL, '$star', '$name', '$title', '$review', '$id', '$sessionuser', '0')";       
$result = $conn->query($sql);      
if(!$result) {
            die("Query failed".$conn->error); 
        }
        else {
            echo "The insert was a success!";
        }
      
        
      
        
        
        
        
        
        
        ?>    
        </div>
            </div>
    </body>
</html>
