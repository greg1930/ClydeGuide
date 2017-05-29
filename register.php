 
 <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();
$logout2 = (isset($_POST["actionLogout2"])) ? $_POST["actionLogout2"] : "";
if($logout2 == "set"){
    unset($_SESSION["sessionuser"]);
}
$logout = (isset($_POST["actionLogout"])) ? $_POST["actionLogout"] : "";
if($logout == "set"){
    unset($_SESSION["sessionuser"]);
}
if(isset($_SESSION["sessionuser"])){
    echo "Do you want to register as a new user?<br/>"
    . "Then please logout first!";
    $sessionuser = ($_SESSION["sessionuser"]);
    echo "<form name=\"logout\" method=\"post\">
                    <input type=\"submit\" name=\"logout\" value=\"Logout\"/>
                    <input type=\"hidden\" name=\"actionLogout\" value=\"set\"/>
           </form>";
}else{
?>
<?php

function safePOSTNonMySQL($name){ // copied from lecture videos
    if(isset($_POST[$name])){
        return strip_tags($_POST[$name]);
    }else{
        return "";
    }
}

$firstName = safePOSTNonMySQL('firstName');
$surname = safePOSTNonMySQL('surname');
$email = safePOSTNonMySQL('email');
$username = safePOSTNonMySQL('username');
$password = md5(safePOSTNonMySQL('password'));
$action = safePOSTNonMySQL('action');

?>
<html>
    <head>
        <title>Register for the Clyde Guide</title>
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
            form{
                align-content: center;
                padding: 2rem;
                background-color: whitesmoke;
                
            }
            #body2{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
            }
            form{
               font-family: Tahoma, Geneva, sans-serif; 
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
         
        <?php
        if($action == "insert"){ // user once typed in something
            if(empty($username)||empty($email)||$password == md5("")|| empty($firstName)||empty($surname)){ // check if a field is empty
                // show form again and add hints to the empty fields
                // password has to be filled in every time (whether already filled in or not) because I can't regenerate it (security)
                echo "<h2>Create an account</h2>
                <form action=\"register.php\" method=\"post\" id =\"register\">
                    <table>
                        <tr><td>Your first Name:</td><td><input name=\"firstName\" type=\"text\" value=\"$firstName\"/></td>";
                        if(empty($firstName)){ echo "<td>Please fill in your first name!</td>";}
                        echo "</tr><tr><td>Your surname:</td><td><input name =\"surname\" type=\"text\" value=\"$surname\"/></td>";
                        if(empty($surname)){ echo "<td>Please fill in your surname!</td>";}   
                        echo"</tr><tr><td>Your email address:</td><td><input name =\"email\" type=\"text\" value=\"$email\"/></td>";
                        if(empty($email)){ echo "<td>Please fill in your email!</td>";}
                        echo"</tr><tr><td>Choose a username:</td><td><input name =\"username\" type =\"text\" value=\"$username\"/></td>";
                        if(empty($username)){ echo "<td>Please choose a username!</td>";}
                        echo"</tr><tr><td>Choose your password:</td><td><input name =\"password\" type =\"password\"/></td>";
                        if($password == md5("")){ echo "<td>Please choose a password!</td>";}else{echo "<td>Please tell us your password again!</td>";}
                        echo"</tr><tr><td></td><td><input type =\"submit\" value=\"create acount\"/></td></tr>
                    </table>
                    <input type =\"hidden\" name =\"action\" value =\"insert\"/>
                </form>";
            }else{
                $host = "devweb2016.cis.strath.ac.uk";
                $user = "cs312n";
                $pass = "eeGheifohsh8";
                $database = "cs312n";
                $conn = new mysqli($host, $user, $pass, $database);
                if($conn->connect_error){
                    die("Connection failed".$conn->connect_error);
                }
                $sqlx = "SELECT COUNT(*) FROM `User` WHERE `username` = '$username'";
                $resultx = $conn->query($sqlx);
                if(!$resultx){
                    die("Failed: ".$conn->error);
                }
                if($resultx->fetch_assoc()['COUNT(*)'] != 0){
                    echo "The username already exists, we are sorry!<br/>"
                    . "<a href= register.php > Try again! </a>";
                    $conn->close();
                }else{
                    $sql = "INSERT INTO `User` (`Username`, `Password`, `Email`, `Firstname`, `Surname`)"
                            . "VALUES ('$username', '$password', '$email', '$firstName', '$surname')";
                    $result = $conn->query($sql);
                    if(!$result){
                        die("Failed: ".$conn->error);
                    }
                //Insertion successful!
                echo "Welcome $firstName to the Clyde Guide community!";
                $conn->close();
            }
            }
        }else{
            // show form for registration
        
            ?><h2>Create an account</h2>
               <hr>
            <form action="register.php" method="post">
                <table>
                    <tr><td>Your first Name:</td><td><input name ="firstName" type="text"/></td></tr>
                    <tr><td>Your surname:</td><td><input name ="surname" type="text"/></td></tr>
                    <tr><td>Your email address:</td><td><input name ="email" type="text"/></td></tr>
                    <tr><td>Choose a username:</td><td><input name ="username" type ="text"/></td></tr>
                    <tr><td>Choose your password:</td><td><input name ="password" type ="password"/></td></tr>
                    <tr><td></td><td><input type ="submit" value="create acount"/></td></tr>
                </table>
                <input type ="hidden" name ="action" value ="insert"/>
            </form>
          
            <?php
        }
        
        ?>
                  </div>
    </body>
</html>
<?php } ?>


