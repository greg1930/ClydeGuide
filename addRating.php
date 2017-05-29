<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$host = "devweb2016.cis.strath.ac.uk";
$user = "cs312n";
$password = "eeGheifohsh8";
$database = "cs312n";
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error);
}


if(isset($_POST['value']) && isset( $_POST['reviewId']) && isset( $_POST['user'])){
addLike($_POST['value'], $_POST['reviewId'], $_POST['user'], $conn);
}

function addLike($value, $reviewId, $name, $conn){
    $sql42 = "SELECT COUNT(*) FROM `Rating` WHERE `User_Name` = '$name' AND `Review_ID`= '$reviewId' ";
    $result42 = $conn->query($sql42);
    if (!$result42) {
        die("Query failed" . $conn->error);
    }
    if($result42->fetch_assoc()['COUNT(*)'] == 0){
        $sql43 = "INSERT INTO `Rating` (`Review_ID`, `User_Name`, `Rate`) VALUES ('$reviewId', '$name', '$value')";
        $result43 = $conn->query($sql43);
        
        $sql44 = "UPDATE `Review` SET `Rate` = `Rate` + $value WHERE `Review`.`ID` = '$reviewId'";
        $result44 = $conn->query($sql44);
        if (!$result43 || !$result44) {
            die("Query failed" . $conn->error);
        }

        echo "Thank you for your rating!";
        echo "<br/><a href=\"Welcome.php\">Go back</a>";
    }else{
        echo "You've alredy rated this entry";
        echo "<br/><a href=\"Welcome.php\">Go back</a>";
    }
}
?>

<html>
    <head>
        <title>Rating added</title>
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
                color: gray;
            }
            #menu a:hover{
                color:white;
                text-decoration: underline;
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
    </body>
</html>
