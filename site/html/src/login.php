<?php
require_once("../config/config.php");

    $db = new MyDB();
    if(!$db) {
        echo $db->lastErrorMsg();
    } else {
        echo "Opened database successfully\n";
    }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
       if(isset($_POST['inputEmail']))
       {
           echo("set");
       }
       else
       {
           echo("game");
       }

       // username and password sent from form
      $post_Email = $_POST['inputEmail'];
      $post_Password = $_POST['inputPassword'];


        echo($post_Email);
       //test if the user give the correct informations
       if ($db->loginUser($post_Email, $post_Password)===true)
       {
           //create a cookie to authorize the user to access other pages
           $cookie_name = "login";
           $cookie_value = $post_Email;
           setcookie($cookie_name, $cookie_value, time() + (3600 * 30), "/"); // 1 day expiration
           header("location: index.php");

       }
       else
       {
           echo($db->loginUser($post_Email, $post_Password));
           //header("location: ../login.html");

       }
   }
?>

