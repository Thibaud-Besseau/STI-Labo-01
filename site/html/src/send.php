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
    $post_Sender = filter_var($_POST['Sender'], FILTER_SANITIZE_STRING);
    $post_Recipient = filter_var($_POST['Recipient'], FILTER_SANITIZE_STRING);
    $post_Subject = filter_var($_POST['Subject'], FILTER_SANITIZE_STRING);
    $post_Message = filter_var($_POST['Message'], FILTER_SANITIZE_STRING);




}


$db = new MyDB();

$db->sendEmail($post_Sender, $post_Recipient, $post_Subject, $post_Message);
header("location: ./mailbox.php");
