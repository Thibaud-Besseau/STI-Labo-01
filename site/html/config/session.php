<?php
/**
 * Created by PhpStorm.
 * User: thibaud
 * Date: 12/30/18
 * Time: 7:01 PM
 */


class mySession
{


    /**
     * mySession constructor.
     */
    public function __construct()
    {
    }

    function isLoginSessionExpired()
    {
        //test if the last activity was more 30 minutes ago
        if(isset($_SESSION['LAST_Activity']) && (time() - $_SESSION['LAST_Activity'] > 1800))
        {
            session_unset();
            session_destroy();
            session_write_close();
            setcookie(session_name(),'',0,'/');
            session_regenerate_id(true);
        }
        else
        {
            //update the session last activity
            $_SESSION['LAST_Activity']=time();
        }

        //regenerate the session id all the 30 minutes
        if(time() - $_SESSION['CREATED']>1800)
        {
            // session started more than 30 minutes ago
            session_regenerate_id(true); // change session ID for the current session and invalidate old session ID
            $_SESSION['CREATED'] = time();
        }

        $this->generateToken();
    }

    function generateToken()
    {



        //check if the token exist and if it was created less than 10 minutes before
        if(!isset($_SESSION["creationDate"]) || ( time()- $_SESSION["creationDate"]) > 600) {

            $_SESSION["token"] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

            $_SESSION["creationDate"] = time();
        }
    }
}