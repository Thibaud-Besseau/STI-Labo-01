<?php
require_once("../config/db.php");
session_start();




if (!isset($_SESSION["email"])) {
   header('Location: ../index.php');

} else {
    $db = new MyDB();

    $email = $_SESSION['email'];
    $isAdmin = $_SESSION['isAdmin'];
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mailbox
            <small>13 new messages</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="mailbox.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Mailbox</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="compose.php" class="btn btn-primary btn-block margin-bottom">Compose</a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a href="mailbox.php"><i class="fa fa-inbox"></i> Inbox</a></li>
                            <li><a href="password.php"><i class="fa fa-lock"></i> Change Password</a></li>
                            <?php if($isAdmin){echo('<li><a href="users.php"><i class="fa fa-lock"></i> Manage</a></li>');}?>
                            <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>


                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Inbox</h3>

                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm"><i
                                                class="fa fa-chevron-left"></i></button>
                                    <button type="button" class="btn btn-default btn-sm"><i
                                                class="fa fa-chevron-right"></i></button>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.pull-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>

                                <?php

                                $emailsUser = $db->emailsUser($email);
                                foreach ($emailsUser as $email) {
                                    print("<tr>");
                                    print('<td class="mailbox-name"><a href="read.php?id=' . $email["Id"] . '">'.$email["Sender_Name"].'</a></td>');
                                    print('<td class="mailbox-subject"><b>' . $email["Subject"] . '</b> ' . substr($email["Message"], 0, 30) . '...</td>');
                                    print('<td class="mailbox-attachment"></td>');
                                    print('<td class="mailbox-date">' . gmdate("Y-m-d\ H:i:s", $email["Date"]) . '</td>');
                                    print('<td>    <a href="compose.php?id='. $email["Id"].'&type=1"<button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> </button></a>
                                                   <a href="compose.php?id='. $email["Id"].'&type=2"<button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i> </button></a>
                                                   <a href="delete.php?id='. $email["Id"] .'" <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></a></td>');
                                    print("</tr>");
                                }
                                ?>
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm"><i
                                                class="fa fa-chevron-left"></i></button>
                                    <button type="button" class="btn btn-default btn-sm"><i
                                                class="fa fa-chevron-right"></i></button>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.pull-right -->
                        </div>
                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</body>
</html>
