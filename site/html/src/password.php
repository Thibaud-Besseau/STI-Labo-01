<?php
	/*
		UserCake Version: 1.0
		http://usercake.com

	*/
    require_once("../config/db.php");
session_start();


if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
    } else {
        $email = $_SESSION['email'];
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
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password_new = filter_var($_POST['passwordc'], FILTER_SANITIZE_STRING);
    $password_confirm = filter_var($_POST['passwordcheck'], FILTER_SANITIZE_STRING);

    if(strlen($password)<= $db->getPasswordLenght())
    {
        $password= substr($password,0,$db->getPasswordLenght());
    }

    if(strlen($password_new)<= $db->getPasswordLenght())
    {
        $password_new= substr($password_new,0,$db->getPasswordLenght());
    }

    if(strlen($password_confirm)<= $db->getPasswordLenght())
    {
        $password_confirm= substr($password_confirm,0,$db->getPasswordLenght());
    }

    //Perform some validation
    //Feel free to edit / change as required

    $db = new MyDB();
    $errors= null;
    $i=0;


    $actualHashPassword=$db->getUsersPassword($email);

    if(password_verify($password,$actualHashPassword))
    {
        if(strcmp($password_new,$password_confirm) && trim($password_new)!=="")
        {
            $db->changePassword($email,$password_new);
        }
        elseif (trim($password_new) === "")
        {
            $errors="Enter a real password";

        }
        else
        {
            $errors="Enter the same password twice";

        }

    }
    else
    {
        $errors="Actual Password not correct";
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
                        <?php  echo($errors); ?>
                    </div>
                <?php } else { ?>
                    <div id="success">
                        <p><?php echo("ACCOUNT_DETAILS_UPDATED"); ?></p>
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