<?php
    session_start();
    $logout = (isset($_POST["actionLogout"])) ? $_POST["actionLogout"] : "";
    if($logout == "set"){
        unset($_SESSION["sessionuser"]);
        header('Location: Welcome.php');
    }else{
        if(isset($_SESSION["sessionuser"])){
            $sessionuser = ($_SESSION["sessionuser"]);
            echo "<form name=\"logout\" method=\"post\">
                            <input type=\"submit\" name=\"logout\" value=\"Logout\"/>
                            <input type=\"hidden\" name=\"actionLogout\" value=\"set\"/>
                   </form>";
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
            h3{
               
                font-family: Tahoma, Geneva, sans-serif;
            }
            #formm{
                padding: 2rem;
                background-color: #99ffcc;
                font-family: Tahoma, Geneva, sans-serif;
                

                
            }
            #body8{
                padding: 2rem;
                background-color: whitesmoke;
                opacity: 0.9;
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
            <div id ="body8">
        <?php ob_start();
        require 'Welcome.php';
        ob_end_clean();
        function get_string_between($string, $start, $end){ //REFERENCE: http://www.justin-cook.com/wp/2006/03/31/php-parse-a-string-between-two-strings/
             $string = ' ' . $string;
             $ini = strpos($string, $start);
             if ($ini == 0) return '';
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                 return substr($string, $ini, $len);
            }
        $id = $_GET["hidden"];
        $filename = "https://devweb2016.cis.strath.ac.uk/~kpb14177/test/viewplace.php";
        $query = $_SERVER['QUERY_STRING'];
        $query = get_string_between($query, 'hidden=', '%');
      
   
        $sql = "SELECT * FROM `Place` WHERE `id` = $id";
        $result = $conn->query($sql);
        if (!$result) {
            $sql = "SELECT * FROM `Place` WHERE `id` = $query";
            $result = $conn->query($sql);
            if(!$result){
                die("Query failed" . $conn->error);
            }
            
        }
        while($row = $result->fetch_assoc()) {
                $name=$row["Name"];
                $address=$row["Address"];
                $image_url=$row["Photo_Url"];
                
            }
    
            ?><h3>Name</h3>  <?php   
        echo $name;
        echo "<br><br>";
        ?><h3>Address</h3> <?php
        echo $address;
        ?><input type="hidden" name="hidden">
        <br><br>
        <img src="<?php echo $image_url; ?>"><?php echo "<br><br>";
                $sql2 = "SELECT * FROM `Review` WHERE `Place_ID` = $id";
                $result2 = $conn->query($sql2);
                if(!$result2) {
                    $sql2 = "SELECT * FROM `Review` WHERE `Place_ID` = $query";
                    $result2 = $conn->query($sql2);
                    if(!$result2){
                       die("Query failed" . $conn->error);
                    }
                }
                while($row2 = $result2->fetch_assoc()) {
                    $stars = $row2["Stars"];
                    $rating = $rating + $stars;
                    $count++;
                }
                if($count!=0) {
                $average = $rating/$count;
                }
                ?><h3>Average Rating</h3> <?php
                echo $average;
                echo "<br><br>";
                ?><h3>Reviews</h3> <?php
                // TODO sort reviews by highest rate!!
                
                $sql3 = "SELECT * FROM `Review` WHERE `Place_ID` = '$id' ORDER BY `Rate` DESC";
                $result3 = $conn->query($sql3);
                if(!$result3) {
                    $sql3 = "SELECT * FROM `Review` WHERE `Place_ID` = $query";
                    $result3 = $conn->query($sql3);
                    if(!$result3){
                        die("Query failed" . $conn->error);
                    } 
                }
                while($row3 = $result3->fetch_assoc()) {
                    $title = $row3["Title"];
                    $message = $row3["Message"];
                     $rate = $row3["Rate"];
                    $user = $row3["User_Name"];
                    if(!($message == "" && $title == "")){
                        echo "$user wrote: (Rating: $rate)
                        <h3>$title</h3>
                        $message <br/>";
                        if(isset($_SESSION["sessionuser"])){
                        ?>
                        <form name='button1' method="post" action='addRating.php' id="formm">
                            <input type='submit' value='True!'/>
                            <?php 
                            $sessionuser = $_SESSION["sessionuser"];
                            $ID = $row3["ID"];
                            echo "<input type='hidden' name='reviewId' value=$ID >";
                            echo "<input type='hidden' name='user' value=$sessionuser >";?>
                            <input type='hidden' name='value' value='1'/>
                        </form>
                        <form name='button1' method="post" action='addRating.php'>
                            <input type='submit' value="Not right!"/>
                            <?php echo "<input type='hidden' name='reviewId' value=$ID >";
                            echo "<input type='hidden' name='user' value=$sessionuser >";?>
                            <input type='hidden' name='value' value='-1'/>
                        </form>
                            <?php
                        }
                        echo "<br><br>";
                    } 
                }
              
        //name
        //picture
        //average star value
        //reviews with rating (with button to rate one review) */
                
        ?> 
                
        </div>
    </body>
</html>
    <?php }?>
