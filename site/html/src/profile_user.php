<?php
require_once("../config/db.php");
require_once("../config/session.php");

session_start();

//check if session has expired
$mySession = new MySession();
$mySession->isLoginSessionExpired();

if (!isset($_SESSION["email"])) {
    header('Location: ../index.php');
} else {

    $db = new MyDB();
    $isAdmin = $_SESSION['isAdmin'];

    if ($isAdmin === true) {
        $email = $_SESSION['email'];
    } else {
        header('Location: ./mailbox.php');

    }
}
if (!empty($_GET)) {

    $isAnUpdate = filter_var($_GET['isAnUpdate'], FILTER_SANITIZE_STRING);
    if ($isAnUpdate) {
        $idUser = filter_var($_GET['user'], FILTER_SANITIZE_STRING);

    }

}

if (!empty($_POST)) {

    $db = new MyDB();

    $errors = array();
    $isAnUpdate = filter_var($_POST['isAnUpdate'], FILTER_SANITIZE_STRING);

    $firstName = filter_var($_POST['First_Name'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['Last_Name'], FILTER_SANITIZE_STRING);
    if(!$isAnUpdate) {
        $email = filter_var($_POST['Email'], FILTER_SANITIZE_STRING);
    }
    $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
    $idUser = filter_var($_POST['idUser'], FILTER_SANITIZE_STRING);


    if(strlen($firstName)<= $db->getFirstNameLenght())
    {
        $firstName= substr($firstName,0,$db->getFirstNameLenght());
    }
    if(strlen($lastName)<= $db->getLastNameLenght())
    {
        $lastName= substr($lastName,0,$db->getLastNameLenght());
    }
    if(strlen($password)<= $db->getPasswordLenght())
    {
        $password= substr($password,0,$db->getPasswordLenght());
    }





    if (isset($_POST["isAdmin"])) {

        $adminAccount = 1;
    } else {
        $adminAccount = 0;
    }


    $errors = null;
    $i = 0;

    if (trim($firstName) !== "" && trim($lastName) !== "" && trim($password) !=="") {

        if ($isAnUpdate) {

            $newPasswordHash= password_hash($password, PASSWORD_BCRYPT);
            if( $_SESSION ['token'] === $_POST ['token']) {

                $db->updateUser($idUser, $firstName, $lastName, $newPasswordHash, $adminAccount);
            }

        }
        else
        {
            $newPasswordHash= password_hash($password, PASSWORD_BCRYPT);
            if( $_SESSION ['token'] === $_POST ['token']) {

                $db->createUser($email, $firstName, $lastName, $newPasswordHash, $adminAccount);
            }

        }

        header('Location: ./users.php');


    } else {
        $errors = "Enter information in all the filed";
    }


}

if ($isAnUpdate) {
    $user = $db->getUser($idUser);

}

?>

<!DOCTYPE html>
<html class=''>
<head>
    <meta charset='UTF-8'>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon"
          href="https://production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          id="bootstrap-css">

    <link href='../public/css/admin-lte.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group has-feedback">
                <input id="Email" name="Email" type="email"  class="form-control"
                       placeholder="Email" <?php if ($isAnUpdate) {
                    echo('disabled value="' . $user["Email"] . '"');
                } ?>>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="First_Name" name="First_Name" type="text" class="form-control"
                       placeholder="First name" <?php if ($isAnUpdate) {
                    echo('value="' . $user["First_Name"] . '"');
                } ?>>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="Last_Name" name="Last_Name" type="text" class="form-control"
                       placeholder="Last name" <?php if ($isAnUpdate) {
                    echo('value="' . $user["Last_Name"] . '"');
                } ?>>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="Password" name="Password" type="password" class="form-control"
                       placeholder="Password" <?php if ($isAnUpdate) {
                    echo('value="' . $user["Password"] . '"');
                } ?>>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input id="isAdmin" name="isAdmin" type="checkbox" <?php if ($isAnUpdate and $user["Role"]) {
                    echo('checked');
                } ?>> Admin Account
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <a href="./users.php" class="btn btn-primary btn-block btn-flat">Reset</a>
                </div>
                <div class="col-xs-4">
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                </div>
                <!-- /.col -->
            </div>

            <input type="hidden" name="isAnUpdate" id="isAnUpdate" value="<?php echo $isAnUpdate; ?>"/>
            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION["token"]; ?>" />

            <?php

            if ($isAnUpdate) {
                echo('<input type="hidden" name="idUser" id="idUser" value="' . $idUser . '"/>');
            }

            ?>

        </form>

        <a href="./users.php" class="text-center">
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
</body>
</html>
