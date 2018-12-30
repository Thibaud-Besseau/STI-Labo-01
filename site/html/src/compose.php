<?php
require_once("../config/db.php");
session_start();

$db = new MyDB();

if (!isset($_COOKIE["login"])) {
    header('Location: ../index.php');
} else {
    $email = $_SESSION['email'];
    $isAdmin = $_SESSION['isAdmin'];
}

$type=0;

if(isset($_GET['id']))
{
    $emailsUser = $db->email(filter_var($_GET['id'], FILTER_SANITIZE_STRING));

    $type=filter_var($_GET['type'], FILTER_SANITIZE_STRING);
}

$idSender=null;

?>



<!DOCTYPE html>
<html class=''>
<head>
    <meta charset='UTF-8'>
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="https://production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link href='../public/css/admin-lte.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
    <link rel="stylesheet" href="../public/css/wysihtml.css">
    <link href="../public/css/select2.css" rel="stylesheet"/>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="../public/js/wysihtml5.js"></script>
    <script src="../public/js/advanced.js"></script>


</head>
<body>

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
                        <?php if($isAdmin){echo('<li><a href="users.php"><i class="fa fa-lock"></i> Manage</a></li>');}?>

                        <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>


                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <form action="send.php" method="POST">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Compose New Message</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <select class="select2" style="width: 100%;" id="Recipient" name="Recipient">

                            <?php
                                $db = new MyDB();
                                $users = $db->users();
                                foreach ($users as $user) {

                                    if($user["Email"]===$email)
                                    {
                                        $idSender=$user["Id"];

                                    }


                                    if($type===1 && $user["Id"] === $emailsUser["Sender"])
                                    {
                                        echo('<option selected="true" value="'.$user["Id"].'">'.$user["First_Name"]." ". $user["Last_Name"]. " ( ".$user["Email"]." )".'</option>');

                                    }
                                    else
                                    {
                                        echo('<option value="'.$user["Id"].'">'.$user["First_Name"]." ". $user["Last_Name"]. " ( ".$user["Email"]." )".'</option>');

                                    }

                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Subject:" id="Subject" name="Subject" <?php if($type>0) {echo('value='.$emailsUser["Subject"]); }?>>
                        </div>
                        <div class="form-group">
                        <textarea id="compose-textarea" class="form-control" style="height: 300px" id="Message" name="Message" <?php if($type>0) {echo('value='.$emailsUser["Message"]); }?>>
                        </textarea>
                        </div>
                        <input type="hidden" name="Sender" id="Sender" value="<?php echo $idSender;?>"/>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                        </div>
                        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /. box -->
            </div>
        </form>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

</body>
<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
</script>


<script src="../public/js/select2.js"></script>
<script>
    $(document).ready(function() { $("#Recipient").select2(); });
</script>

</html>

