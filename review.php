<?php
session_start();
$logout = (isset($_POST["action"])) ? $_POST["action"] : "";
if($logout == "set"){
    unset($_SESSION["sessionuser"]);
}
if(!isset($_SESSION["sessionuser"])){
    $sessionuser = "";
    echo "Please login to add a review!<br/>";
?>
    <form name='externalForm' action='login.php' method='get'>
        <input type='hidden' name='backTo' value='review.php'/>
        <input type='submit' value='Go to the login page'/>
    </form>
<?php
}else{
    $sessionuser = ($_SESSION["sessionuser"]);
    echo "<form name=\"logout\" method=\"post\">
                    <input type=\"submit\" name=\"logout\" value=\"Logout\"/>
                    <input type=\"hidden\" name=\"action\" value=\"set\"/>
           </form>";
?>
<html>
    <head>
        <title>Leave a review</title>
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
            #formrev{
                align-content: center;
                padding: 2rem;
                background-color: whitesmoke;
                font-family: Avant Garde, Century Gothic, sans-serif;
                
            }
            
             #body4{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
            }
            
        </style>
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
            <div id ="body4">
            <h2>Place</h2><br>
            <hr>
            <form action="reviewadd.php"method="get" id ="formrev">
            <?php 
        $host = "devweb2016.cis.strath.ac.uk";
        $user = "cs312n";
        $password = "eeGheifohsh8";
        $database = "cs312n";
        $conn = new mysqli($host, $user, $password, $database);
        $star = 1;

        
        
        if($conn->connect_error) {
                die("Connection failed".$conn->connect_error);
            }
            // issue query
            $sql = "SELECT * FROM `Place`";
            $result = $conn->query($sql);
            // handle results
            if(!$result) {
                die("Query failed".$conn->error); 
            }
            echo "<select name=\"ID\">";
            
            while($row = $result->fetch_assoc()) {
                echo "<option value =\"".$row["ID"]."\">".$row["Name"]."</option>\n";
                $name = $row["Name"];
            }
          
        ?>
            <input type="hidden" name="title"> <br><br>Star Rating<br>
            
            <?php
            echo "<select name=\"star\">";
            while($star<6) {
                echo "<option value =\"".$star."\">".$star."</option>\n";
                $star++;
            }
            
            ?>
            <input type="hidden" name="title"> <br><br>Title<br>
            <textarea name="title" cols="40" rows="1"></textarea>
            <input type="hidden" name="blank">
            <input type="hidden" name="review"> <br><br>Review<br>
            <textarea name="review" cols="40" rows="5"></textarea>
            <br>
            <input type="submit"/>
            </form>
        

<?php } ?>
            </div>
            </div>
    </body>
</html>
