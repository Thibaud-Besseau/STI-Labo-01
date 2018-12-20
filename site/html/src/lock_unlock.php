<?php
require_once("../config/db.php");
session_start();


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

if(isset($_GET['user'])&& isset($_GET['action']))
{
    $db = new MyDB();
    $db->lock_unlock($user,$action);
    header('Location: ./users.php');


}


?>