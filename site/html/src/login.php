<?php
require_once("../config/db.php");
session_start();


    $db = new MyDB();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form
      $post_Email = $_POST['inputEmail'];
      $post_Password = $_POST['inputPassword'];


       //test if the user give the correct informations
       if ($db->loginUser($post_Email, $post_Password)===true)
       {

           $_SESSION = array();
           $_SESSION['email'] = $post_Email;


           if($db->isAdmin($post_Email))
           {
               $_SESSION['isAdmin'] = true;

           }
           else
           {
               $_SESSION['isAdmin'] = false;

           }

           header("location: ./mailbox.php");

       }
       else
       {
           header("location: ../index.php");

       }
   }
?>

