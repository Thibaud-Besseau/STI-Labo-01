<?php
require_once("../config/db.php");
require_once("../config/session.php");

session_start();

//check if session has expired
$mySession = new MySession();
$mySession->isLoginSessionExpired();


if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
} else {
    $db = new MyDB();
    $isAdmin = $_SESSION['isAdmin'];

    if($isAdmin =!true)
    {
        header('Location: ./mailbox.php');

    }
}

$type=0;

$user=filter_var($_GET['user'], FILTER_SANITIZE_STRING);
$action=filter_var($_GET['action'], FILTER_SANITIZE_STRING);
$token = filter_var($_GET['token'], FILTER_SANITIZE_STRING);


if(isset($_GET['user'])&& isset($_GET['action']))
{
    $db = new MyDB();
    if( $_SESSION ['token'] === $token) {

        $db->lock_unlock($user, $action);
    }

    header('Location: ./users.php');


}


?>