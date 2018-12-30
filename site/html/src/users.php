<?php
require_once("../config/db.php");
require_once("../config/session.php");

session_start();

//check if session has expired
$mySession = new MySession();
$mySession->isLoginSessionExpired();


if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
} else {




    $db = new MyDB();
    $isAdmin =$_SESSION['isAdmin'];

    if($isAdmin ===true)
    {
        $email = $_SESSION['email'];
    }
    else
    {
        header('Location: ./mailbox.php');

    }


    $users = $db->allUsers();;

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
<body>
<div class="content-wrapper">

<!-- Main content -->
<section class="content">
  <div class="row">
      <div class="col-md-3">
          <a href="mailbox.php" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

          <div class="box box-solid">
              <div class="box-header with-border">
                  <h3 class="box-title">Folders</h3>

                  <div class="box-tools">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                  </div>
              </div>
              <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                      <li><a href="mailbox.php"><i class="fa fa-inbox"></i> Inbox</a></li>
                      <li><a href="password.php"><i class="fa fa-lock"></i> Change Password</a></li>

                      <?php if($isAdmin){echo('<li><a href="users.php"><i class="fa fa-lock"></i> Manage</a></li>');}else {echo($isAdmin);}?>
                      <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>


                  </ul>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
    <div class="col-xs-9">
      <div class="box">
        <div class="box-header">
            <div class="col-xs-8">
          <h3 class="box-title">Hover Data Table</h3>
            </div>
            <div class="col-xs-4">
                <a href="./profile_user.php?isAnUpdate=0" class="btn btn-primary btn-block btn-flat">Add User</a>

            </div>

            </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($users as $user) {

                    echo("<tr>");
                    echo('<td>'.$user["First_Name"]." ".$user["Last_Name"].'</td>');
                    echo('<td>'.$user["Email"].'</td>');
                    echo('<td>');
                    if ($user["Role"]===0)
                    {
                        echo("User");
                    }
                    else {
                        echo("Admin");

                    }
                    echo('</td>');

                    echo('<td>');
                    if ($user["Enable"]!==0)
                    {
                        echo("Enable");
                    }
                    else {
                        echo("Disable");

                    }
                    echo('</td>');

                    echo('<td>');


                    echo('<a href="./profile_user.php?user='.$user["Id"].'&isAnUpdate=1&token='.$_SESSION["token"].'"> <button class="btn-flat circle greenButton "><span style="margin:auto" style="display:table" class="glyphicon glyphicon-edit"></span></button></a>');

                    if($user["Enable"]!=0)
                    {
                        echo('<a href="lock_unlock.php?action=0&user='.$user["Id"].'&token='.$_SESSION["token"].'"><button class="btn-flat circle greyButton"> <span style="margin:auto" style="display:table" class="fa fa-lock"></span></button></a>');
                    }
                    else
                    {
                        echo('<a href="lock_unlock.php?action=1&user='.$user["Id"].'&token='.$_SESSION["token"].'"><button class="btn-flat circle greyButton"> <span style="margin:auto" style="display:table" class="fa fa-unlock"></span></button></a>');

                    }

                    echo('<a href="./delete_user.php?user='.$user["Id"].'&token='.$_SESSION["token"].'"> <button class="btn-flat circle greenButton "><span style="margin:auto" style="display:table" class="glyphicon glyphicon-trash"></span></button></a>');

                    echo('</td>');

                    echo("</tr>");
                }
            ?>
                <tr>

                </tr>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>