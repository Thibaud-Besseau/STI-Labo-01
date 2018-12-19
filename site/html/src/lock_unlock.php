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

if(isset($_GET['user'])&& isset($_GET['action']))
{
    $db = new MyDB();
    $db->lock_unlock($_GET['user'],$_GET['action']);
    header('Location: ./users.php');


}


?>