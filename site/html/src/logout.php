<?php
/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 10/26/18
 * Time: 7:37 AM
 */  //create a cookie to authorize the user to access other pages

if (isset($_COOKIE['login'])) {
    unset($_COOKIE['login']);
    setcookie('login', null, -1, '/');

}

header("location: ../index.php");
