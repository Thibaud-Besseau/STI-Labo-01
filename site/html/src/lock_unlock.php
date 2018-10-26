<?php
require_once("../config/db.php");

if (!isset($_COOKIE["login"])) {
    header('Location: ../index.php');
} else {
    $db = new MyDB();
    $isAdmin = $db->isAdmin($_COOKIE["login"]);

    if($isAdmin ==true)
    {
        $email = $_COOKIE["login"];
    }
    else
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