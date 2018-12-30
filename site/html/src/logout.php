<?php
/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 10/26/18
 * Time: 7:37 AM
 */  //create a cookie to authorize the user to access other pages


session_start();

if (isset($_SESSION["email"])) {
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);

}

header("location: ../index.php");
