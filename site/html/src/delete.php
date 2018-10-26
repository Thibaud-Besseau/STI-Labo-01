<?php
/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 10/25/18
 * Time: 7:53 PM
 */

    require_once("../config/db.php");

    if(isset($_GET['id']))
    {
        $id_Message = $_GET['id'];

        $db = new MyDB();
        $db->deleteMessage($id_Message);

    }




header("location: ../index.php");

?>