<?php
session_start();
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
function safePOSTNonMySQL($name){ //see lecture videos
    if(isset($_POST[$name])){
        return strip_tags($_POST[$name]);
    }else{
        return "";
    }
}

function userInDB($username, $password){
    $host = "devweb2016.cis.strath.ac.uk";
    $user = "cs312n";
    $pass = "eeGheifohsh8";
    $database = "cs312n";
    $conn = new mysqli($host, $user, $pass, $database);
    if($conn->connect_error){
       die("Connection failed".$conn->connect_error);
    }
    $sql1 = "SELECT COUNT(*) FROM `User` WHERE `Username` = '$username' AND `Password` = '$password'";
    $result = $conn->query($sql1);
    if(!$result){
       die("Failed: ".$conn->error);
    }
    if($result->fetch_assoc()['COUNT(*)'] == 0){
        $conn->close();
        return false;
    }else{
        $conn->close();
        return true;
    }
}
$backTo = (isset($_GET['backTo'])) ? strip_tags($_GET['backTo']) : "";
$logout = safePOSTNonMySQL("action");
if($logout == "set"){
    unset($_SESSION["sessionuser"]);
}

if(isset($_SESSION["sessionuser"])){
    
    $username = $_SESSION["sessionuser"];
    //$sessionuser = $_SESSION["sessionuser"];
}else{
    $sessionuser = "";
    $username = safePOSTNonMySQL("username");
    $password = md5(safePOSTNonMySQL("password"));
    
}
$loginOK = isset($_SESSION["sessionuser"]) || userInDB($username, $password);

if($loginOK && !isset($_SESSION["sessionuser"])){
    session_regenerate_id(); //security thing...
    $_SESSION["sessionuser"] = $username;
}
?>
<html>
    <head>
        <title>Login to your Clyde Guide Account</title>
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
            #body7{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
                                font-family: Tahoma, Geneva, sans-serif;

            }
            form{
                padding: 2rem;
                background-color: whitesmoke;
                margin: 0 auto;
            }
        </style>
    </head>
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
        <div id= "body7">
        <?php
        
        if($loginOK){
        ?>
            
                <p>Welcome back <?php echo $username; ?> </p>
                <?php 
                if($backTo != ""){
                    echo "<a href= $backTo>Go back to where I was, please.</a>"; 
                }?>
                <form name="logout" method="post">
                    <input type="submit" name="logout" value="Logout"/>
                    <input type="hidden" name="action" value="set"/>
                </form>
            </div>
        <?php
        }else{
        ?>
            <div>
                <form name ="login" method="post" id ="formLogin">
                    <p>Please login to continue</p>
                    <table>
                        <tr><td>Username:</td><td><input type="text" name="username"/></td></tr>
                        <tr><td>Password:</td><td><input type="password" name="password"/></td></tr>
                        <tr><td></td><td><input type="submit" name="Login" value="Login"/></td></tr>
                    </table>
                </form>
            </div>
        <?php
        }
        ?>          
    </body>
</html>