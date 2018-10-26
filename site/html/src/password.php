<?php
	/*
		UserCake Version: 1.0
		http://usercake.com

	*/
    require_once("../config/db.php");

    if (!isset($_COOKIE["login"])) {
        header('Location: ../index.php');
    } else {
        $email = $_COOKIE["login"];
    }
?>

<?php
/*
    Below is a very simple example of how to process a login request.
    Some simple validation (ideally more is needed).
*/
//Forms posted
if(!empty($_POST))
{
    $errors = array();
    $password = $_POST["password"];
    $password_new = $_POST["passwordc"];
    $password_confirm = $_POST["passwordcheck"];

    //Perform some validation
    //Feel free to edit / change as required

    $db = new MyDB();
    $errors= array();
    $i=0;


    $actualPassword=$db->getUsersPassword($email);

    if($actualPassword==$password)
    {
        if($password_new==$password_confirm)
        {
            $db->changePassword($email,$password_new);
        }
        else
        {
            
        }

    }
    else
    {
        $errors[$i++]="Actual Password not correct";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>


<div id="content">
    <div class="modal-ish">
        <div class="modal-body">

            <?php
            if(!empty($_POST))
            {
                if(count($errors) > 0)
                {
                    ?>
                    <div id="errors">
                        <?php errorBlock($errors); ?>
                    </div>
                <?php } else { ?>
                    <div id="success">
                        <p><?php echo lang("ACCOUNT_DETAILS_UPDATED"); ?></p>
                    </div>
                <?php } }?>



            <form name="changePass" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                <p>
                    <label>Password:</label>
                    <input type="password" name="password" />
                </p>

                <p>
                    <label>New Pass:</label>
                    <input type="password" name="passwordc" />
                </p>

                <p>
                    <label>Confirm Pass:</label>
                    <input type="password" name="passwordcheck" />
                </p>
        </div>


        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Update" />
        </div>


    </div>

    </form>


    <div class="clear"></div>

    <p style="margin-top:30px; text-align:center;"><a href="/">Home</a></p>
</div>
</body>
</html>