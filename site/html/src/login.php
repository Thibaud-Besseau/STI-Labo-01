<?php
require_once("../config/db.php");

    $db = new MyDB();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form
      $post_Email = $_POST['inputEmail'];
      $post_Password = $_POST['inputPassword'];


       //test if the user give the correct informations
       if ($db->loginUser($post_Email, $post_Password)===true)
       {
           //create a cookie to authorize the user to access other pages
           $cookie_name = "login";
           $cookie_value = $post_Email;
           setcookie($cookie_name, $cookie_value, time() + (3600 * 30), "/"); // 1 day expiration
           header("location: ../mailbox.php");

       }
       else
       {
           header("location: ../index.php");

       }
   }
?>

