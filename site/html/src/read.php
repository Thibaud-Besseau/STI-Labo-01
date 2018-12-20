<?php
require_once("../config/db.php");
$db = new MyDB();
session_start();


if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
} else {
    $email = $_SESSION['email'];
    $isAdmin = $_SESSION['isAdmin'];
}


if(isset($_GET["id"]))
{
    $emailsUser = $db->email(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

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
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <a href="compose.php" class="btn btn-primary btn-block margin-bottom">Compose</a>

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
                        <li><a href="mailbox.php"><i class="fa fa-inbox"></i> Inbox
                        <li><a href="delete.php?id=<?php print($emailsUser[Id]);?>"><i class="fa fa-trash-o"></i> Trash</a></li>
                        <?php if($isAdmin){echo('<li><a href="users.php"><i class="fa fa-lock"></i> Manage</a></li>');}?>
                        <li><a href="password.php"><i class="fa fa-lock"></i> Change Password</a></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Read Mail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                        <h3><?php print($emailsUser["Subject"]); ?></h3>
                        <h5>From: <?php print($emailsUser["Sender_Name"]); ?>
                            <span class="mailbox-read-time pull-right"><?php print( gmdate("Y-m-d\ H:i:s", $emailsUser["Date"]) ); ?></span></h5>
                    </div>
                    <!-- /.mailbox-read-info -->
                    <div class="mailbox-read-message">
                        <?php
                        print($emailsUser["Message"]);

                        ?>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


</body>
</html>