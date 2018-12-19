<?php
require_once("../config/db.php");
session_start();


if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
} else {
    $db = new MyDB();

    if($_SESSION['isAdmin'] =!true)
    {
        header('Location: ./mailbox.php');

    }
}

$type=0;

if(isset($_GET['user']))
{
    $db = new MyDB();
    $db->deleteUser($_GET['user']);
    header('Location: ./users.php');


}


?>