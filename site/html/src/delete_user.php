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

$user=filter_var($_GET['user'], FILTER_SANITIZE_STRING);

if(isset($user))
{
    $db = new MyDB();
    $db->deleteUser($user);
    header('Location: ./users.php');


}


?>