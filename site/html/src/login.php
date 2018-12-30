<?php
require_once("../config/db.php");
session_start();


    $db = new MyDB();

   if($_SERVER["REQUEST_METHOD"] === "POST") {
        // username and password sent from form

      $post_Email = filter_var($_POST['inputEmail'], FILTER_SANITIZE_STRING);
      $post_Password = filter_var($_POST['inputPassword'], FILTER_SANITIZE_STRING);


      //verify entries lenght
       if(strlen($post_Email)<= $db->getEmailLenght())
       {
           $post_Email= substr($post_Email,0,$db->getEmailLenght());
       }

      if(strlen($post_Password)<= $db->getPasswordLenght())
      {
          $post_Password= substr($post_Password,0,$db->getEmailLenght());
      }


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

