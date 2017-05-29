<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION["sessionuser"])){
    $sessionuser = "";
    echo "Please login to add a new place!";?> <br/>
<a class="btn" href="login.php" >Go to the login page</a><?php
}else{
$sessionuser = ($_SESSION["sessionuser"]);}
?>
    <?php

function safePOSTNonMySQL($name) { // copied from lecture videos
    if (isset($_POST[$name])) {
        return strip_tags($_POST[$name]);
    } else {
        return "";
    }
}

$action = safePOSTNonMySQL('action');
$place = safePOSTNonMySQL('place');
$user = safePOSTNonMySQL('user');
$review = safePOSTNonMySQL('review');
?>

<html>
    <head>
        <title>ClydeGuide - Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            form{
                padding: 2 rem;
                background-color: whitesmoke;
                opacity: 0.9 ;
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
        <div>

            <?php
            $host = 'devweb2016.cis.strath.ac.uk';
            $username = 'cs312n';
            $pass = 'eeGheifohsh8';
            $database = 'cs312n';
            $conn = new mysqli($host, $username, $pass, $database);

            $placeInfo;

            $purl = "";
            $pname = "";
            $paddress = "";
            $plong = "";
            $plat = "";

            $userInfo;

            $uuser = "";
            $uemail = "";
            $ufirst = "";
            $ulast = "";


            $reviewInfo;

            $rstars = "";
            $rtitle = "";
            $rmessage = "";
            $rplace = "";
            $ruser = "";

            if (isset($_POST['pedit'])) {
                $pid = safePOSTNonMySQL('pid');
                $purl = safePOSTNonMySQL('URL');
                $pname = safePOSTNonMySQL('Name');
                $paddress = safePOSTNonMySQL('Address');
                $plong = safePOSTNonMySQL('Long');
                $plat = safePOSTNonMySQL('Lat');

                $insert = "UPDATE `Place` SET `Photo_URL` = '$purl', `Name` = '$pname', `Address`= '$paddress', "
                        . "`Longitude` = '$long', `Latitude`= '$lat'"
                        . "WHERE `ID` = '$pid'";
                //execute sql
                $conn->query($insert);
                echo "$pname edited. </br>";
            } else if (isset($_POST['pdelete'])) {
                $pid = safePOSTNonMySQL('pid');
                $purl = safePOSTNonMySQL('URL');
                $pname = safePOSTNonMySQL('Name');
                $paddress = safePOSTNonMySQL('Address');
                $plong = safePOSTNonMySQL('Long');
                $plat = safePOSTNonMySQL('Lat');

                $delete = "DELETE FROM `Place` WHERE `ID` = '$pid'";
                //x
                $conn->query($delete);
                echo "$pname Deleted. </br>";
            } else if (isset($_POST['uedit'])) {
                $uuser = safePOSTNonMySQL('Username');
                $uemail = safePOSTNonMySQL('Email');
                $ufirst = safePOSTNonMySQL('First');
                $ulast = safePOSTNonMySQL('Last');

                $insert = "UPDATE `User` SET `Username` = '$uuser', `Email` = '$uemail', "
                        . "`Firstname` = '$ufirst', `Surname` = '$ulast'"
                        . "WHERE `Username` = '$uuser'";
                
                $conn->query($insert);
                echo "$uuser edited. </br>";
            } else if (isset($_POST['udelete'])) {
                $uuser = safePOSTNonMySQL('Username');
                $uemail = safePOSTNonMySQL('Email');
                $ufirst = safePOSTNonMySQL('First');
                $ulast = safePOSTNonMySQL('Last');

                $delete = "DELETE FROM `User` WHERE `Username` = '$uuser'";
                //x
                $conn->query($delete);


                echo "$uuser Deleted. </br>";
            } else if (isset($_POST['redit'])) {
                $rid = safePOSTNonMySQL('rid');
                $rstars = safePOSTNonMySQL('Stars');
                $rtitle = safePOSTNonMySQL('Title');
                $rmessage = safePOSTNonMySQL('Message');
                $rplace = safePOSTNonMySQL('Place_ID');
                $ruser = safePOSTNonMySQL('User_Name');

                $insert = "UPDATE `Review` SET `Stars` = '$rstars', `Title` = '$rtitle',"
                        . "`Message` = '$rmessage', `Place_ID` = '$rplace', `User_Name` = '$ruser'"
                        . "WHERE `ID` = '$rid'";
                //x
                $conn->query($insert);


                echo "$rtitle edited. </br>";
            } else if (isset($_POST['rdelete'])) {
                $rid = safePOSTNonMySQL('rid');
                $rstars = safePOSTNonMySQL('Stars');
                $rtitle = safePOSTNonMySQL('Title');
                $rmessage = safePOSTNonMySQL('Message');
                $rplace = safePOSTNonMySQL('Place_ID');
                $ruser = safePOSTNonMySQL('User_Name');

                $delete = "DELETE FROM `Review` WHERE `ID` = '$rid'";
                //x
                $conn->query($delete);


                echo "$rtitle Deleted. </br>";
            }


            if ($action == "editPlace") {
                $sql = "SELECT * FROM `Place` WHERE `ID` = '$place'";
                $placeInfo = $conn->query($sql);

                if ($placeInfo->num_rows > 0) {

                    while ($row = $placeInfo->fetch_assoc()) {

                        $purl = $row["Photo_Url"];
                        $pname = $row["Name"];
                        $paddress = $row["Address"];
                        $plong = $row["Longitude"];
                        $plat = $row["Latitude"];
                    }
                }


                echo"<form action=\"admin.php\" method = \"post\" id = \"formg\"><table>";
                echo "<input type =\"hidden\" name =\"pid\" value =\"$place\"/>";

                echo "<tr><td><b>Photo URL:<b></td><td>";
                echo "<input name = \"URL\" type = \"text\" value = \"$purl\"> </td></tr>";

                echo "<tr><td><b>Name</b></td>";
                echo "<td><input name = \"Name\" type = \"text\" value = \"$pname\"> </td></tr>";

                echo "<tr><td><b>Address</b></td>";
                echo "<td><input name = \"Address\" type = \"text\" value = \"$paddress\"> </td></tr>";

                echo "<tr><td><b>Longitude</b></td>";
                echo "<td><input name = \"Long\" type = \"text\" value = \"$plong\"> </td></tr>";

                echo "<tr><td><b>Latitude</b></td>";
                echo "<td><input name = \"Lat\" type = \"text\" value = \"$plat\"> </td></tr>";

                echo "<tr><td> <input type=\"submit\" name = \"pedit\" value=\"Edit\"> </td><td> <input type=\"submit\" name = \"pdelete\" value=\"Delete\"> </td></tr>";


                echo "</form>";
            } else if ($action == "editUser") {

                $sql = "SELECT * FROM `User` WHERE `Username` = '$user'";
                $userInfo = $conn->query($sql);

                if ($userInfo->num_rows > 0) {

                    while ($row = $userInfo->fetch_assoc()) {

                        $uuser = $row["Username"];
                        $uemail = $row["Email"];
                        $ufirst = $row["Firstname"];
                        $ulast = $row["Surname"];
                    }
                }


                echo"<form action=\"admin.php\" method = \"post\"><table>";

                echo "<tr><td><b>Username:<b></td><td>";
                echo "<input name = \"Username\" type = \"text\" value = \"$uuser\"> </td></tr>";

                echo "<tr><td><b>Email:</b></td>";
                echo "<td><input name = \"Email\" type = \"text\" value = \"$uemail\"> </td></tr>";

                echo "<tr><td><b>First Name:</b></td>";
                echo "<td><input name = \"First\" type = \"text\" value = \"$ufirst\"> </td></tr>";

                echo "<tr><td><b>Last Name:</b></td>";
                echo "<td><input name = \"Last\" type = \"text\" value = \"$ulast\"> </td></tr>";

                echo "<tr><td> <input type=\"submit\" name = \"uedit\" value=\"Edit\"> </td><td> <input type=\"submit\" name = \"udelete\" value=\"Delete\"> </td></tr>";

                echo "</form>";
            } else if ($action == "editReview") {

                $sql = "SELECT * FROM `Review` WHERE `ID` = '$review'";
                $reviewInfo = $conn->query($sql);

                if ($reviewInfo->num_rows > 0) {

                    while ($row = $reviewInfo->fetch_assoc()) {

                        $rstars = $row["Stars"];
                        $rtitle = $row["Title"];
                        $rmessage = $row["Message"];
                        $rplace = $row["Place_ID"];
                        $ruser = $row["User_Name"];
                    }
                }


                echo"<form action=\"admin.php\" method = \"post\"><table>";

                echo "<input type =\"hidden\" name =\"rid\" value =\"$review\"/>";

                echo "<tr><td><b>Stars:<b></td><td>";
                echo "<input name = \"Stars\" type = \"text\" value = \"$rstars\"> </td></tr>";

                echo "<tr><td><b>Title:</b></td>";
                echo "<td><input name = \"Title\" type = \"text\" value = \"$rtitle\"> </td></tr>";

                echo "<tr><td><b>Message:</b></td>";
                echo "<td><input name = \"Message\" type = \"text\" value = \"$rmessage\"> </td></tr>";

                echo "<tr><td><b>Place_ID:</b></td>";
                echo "<td><input name = \"Place_ID\" type = \"text\" value = \"$rplace\"> </td></tr>";

                echo "<tr><td><b>Username:</b></td>";
                echo "<td><input name = \"User_Name\" type = \"text\" value = \"$ruser\"> </td></tr>";

                echo "<tr><td> <input type=\"submit\" name = \"redit\" value=\"Edit\"> </td><td> <input type=\"submit\" name = \"rdelete\" value=\"Delete\"> </td></tr>";

                echo "</form>";
            } else {

                echo "<form action=\"admin.php\" method = \"post\">";


                $sql = "SELECT * FROM `Place`";
                $names = $conn->query($sql);

                echo"<b>Edit Place:</b>";

                echo"<select name = \"place\">";
                if ($names->num_rows > 0) {
                    while ($row = $names->fetch_assoc()) {
                        echo "<option value =\"" . $row["ID"] . "\">" . $row["Name"] . "</option>\n";
                    }
                }
                echo "</select>";

                echo "<input type=\"submit\" value=\"Edit Place\">";
                echo "<input type =\"hidden\" name =\"action\" value =\"editPlace\"/>";

                echo "</br></br>";
                echo "</form><form action=\"admin.php\" method = \"post\">";


                $sql = "SELECT * FROM `User`";
                $names = $conn->query($sql);
                echo"<b>Edit User:</b>";
                echo"<select name = \"user\">";
                if ($names->num_rows > 0) {
                    while ($row = $names->fetch_assoc()) {
                        echo "<option value =\"" . $row["Username"] . "\">" . $row["Username"] . "</option>\n";
                    }
                }
                echo "</select>";

                echo "<input type=\"submit\" value=\"Edit User\">";
                echo "<input type =\"hidden\" name =\"action\" value =\"editUser\"/>";

                echo "</br></br>";
                echo "</form><form action=\"admin.php\" method = \"post\">";
                echo"<b>Edit Review:</b>";

                $sql = "SELECT * FROM `Review`";
                $names = $conn->query($sql);

                echo"<select name = \"review\">";
                if ($names->num_rows > 0) {
                    while ($row = $names->fetch_assoc()) {
                        echo "<option value =\"" . $row["ID"] . "\">" . $row["Title"] . "</option>\n";
                    }
                }
                echo "</select>";

                echo "<input type=\"submit\" value=\"Edit Review\">";
                echo "<input type =\"hidden\" name =\"action\" value =\"editReview\"/>";
                echo"</form>";
            }
            ?>

        </div>
    </body>
</html>
