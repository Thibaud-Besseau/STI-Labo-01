<?php
/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 10/25/18
 * Time: 7:53 PM
 */
session_start();


require_once("../config/db.php");
require_once("../config/session.php");


//check if session has expired
$mySession = new MySession();
$mySession->isLoginSessionExpired();




if(isset($_GET['id']) && isset($_SESSION['email']))
    {

        //todo check if user's email
        $id_Message = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        $token = filter_var($_GET['token'], FILTER_SANITIZE_STRING);


        $db = new MyDB();
        if( $_SESSION ['token'] === $token) {

            echo($db->deleteMessage($id_Message));
        }



    }




header("location: ./mailbox.php");

?>