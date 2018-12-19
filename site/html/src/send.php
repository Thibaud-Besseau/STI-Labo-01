<?php

require_once("../config/db.php");
session_start();


/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 10/25/18
 * Time: 11:00 PM
 */

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $post_Sender = $_POST['Sender'];
    $post_Recipient = $_POST['Recipient'];
    $post_Subject = $_POST['Subject'];
    $post_Message = $_POST['Message'];




}


$db = new MyDB();

$db->sendEmail($post_Sender, $post_Recipient, $post_Subject, $post_Message);
header("location: ./mailbox.php");
