<?php
   include("../config/config.php");
   session_start();
   echo("hello");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      
      $sql = "SELECT id FROM user WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
	  mysql_close();
	   
      $count = mysqli_num_rows($result);
      		
      if($count == 1) {
         session_register("myusername");
         $_SESSION['login'] = $myusername;
         
         header("location: index.php");
      }else {
         $error = "Your Email or Password is invalid!";
      }
   }
?>

