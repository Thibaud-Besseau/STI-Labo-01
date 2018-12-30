<?php

class MyDB extends SQLite3
{
    private $file_db;
    private static $passwordLenght=25;
    private static $emailLenght=25;
    private static $firstNameLenght=25;
    private static $lastNameLenght=25;
    private static $subjectLenght=2147483647;
    private static $bodyLenght=2147483647;

    /**
     * @return int
     */
    public static function getPasswordLenght()
    {
        return self::$passwordLenght;
    }

    /**
     * @return int
     */
    public static function getEmailLenght()
    {
        return self::$emailLenght;
    }

    /**
     * @return int
     */
    public static function getFirstNameLenght()
    {
        return self::$firstNameLenght;
    }

    /**
     * @return int
     */
    public static function getLastNameLenght()
    {
        return self::$lastNameLenght;
    }

    /**
     * @return int
     */
    public static function getSubjectLenght()
    {
        return self::$subjectLenght;
    }

    /**
     * @return int
     */
    public static function getBodyLenght()
    {
        return self::$bodyLenght;
    }




    function __construct()
    {
        $this->open('/usr/share/nginx/databases/sti-db.db',SQLITE3_OPEN_READWRITE);


    }

    public function lock_unlock($id, $action)
    {
        $sql = 'Update user SET Enable= :action  WHERE  Id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':action', $action);
        $statement->execute();
        $statement->close();
    }


    public function updateUser($id,$firstName,$lastName,$password,$adminAccount)
    {
        $sql = 'Update user SET First_Name= :first_name, Last_Name= :last_name, Password= :password, Role = :adminAccount  WHERE  Id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':first_name', $firstName);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':adminAccount', $adminAccount);
        $statement->execute();
        $statement->close();

    }


    public function createUser($email,$firstName,$lastName,$password,$adminAccount)
    {
        $sql = 'INSERT INTO user (Email, First_Name , Last_Name , Password, Role, Enable) VALUES   (:email,:first_name,:last_name,:password,:adminAccount,1)';
        $statement = $this->prepare($sql);
        $statement->bindValue(':first_name', $firstName);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':adminAccount', $adminAccount);
        $statement->execute();
        $statement->close();

    }

    public function changePassword($email, $password)
    {

        $newPasswordHash= password_hash($password, PASSWORD_BCRYPT);

        $sql = 'Update user SET Password= :password  WHERE  Email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $newPasswordHash);
        $statement->execute();
        $statement->close();
        return $password;

    }

    public function isAdmin($email)
    {
        $sql = 'SELECT Role  FROM   user  WHERE  Email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $role = $row['Role'];
        $statement->close();
        return $role;

    }

    public function getUser($id)
    {
        $sql = 'SELECT *  FROM   user  WHERE  Id = :id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $statement->close();
        return $row;

    }


    public function getUsersPassword($email)
    {
        $sql = 'SELECT Password  FROM   user  WHERE  Email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $password = $row['Password'];
        $statement->close();
        return $password;
    }

    protected function userExists($email)
    {
        $sql = 'SELECT COUNT(*) AS count FROM user WHERE  Email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);

        $result = $statement->execute();
        $row = $result->fetchArray();


        $isRegistred = false;
        if ($row['count'] === 1) {
            $isRegistred = true;
        } else {
            $isRegistred = false;
        }

        $statement->close();

        return $isRegistred;
    }

    public function loginUser($email, $password)
    {
        $connected = false;
        if ($this->userExists($email)) {


            $passwordHashDb = $this->getUsersPassword($email);



            if (password_verify($password,$passwordHashDb)) {
                $connected = true;
            }


        }

        return $connected;
    }


    public function emailsUser($email)
    {
        $sql = 'SELECT message.*  FROM message LEFT JOIN user ON message.Recipient = user.Id  WHERE  user.Email = :email ORDER BY message.Id DESC';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $result = $statement->execute();
        $row = array();
        $i = 0;
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            $row[$i]['Id'] = $res['Id'];
            $row[$i]['Sender'] = $res['Sender'];
            $row[$i]['Recipient'] = $res['Recipient'];
            $row[$i]['Subject'] = $res['Subject'];
            $row[$i]['Message'] = $res['Message'];
            $row[$i]['Date'] = $res['Date'];
            $sql = 'SELECT First_Name, Last_Name  FROM user WHERE  user.Id = :Id';
            $statement = $this->prepare($sql);
            $statement->bindValue(':Id', $res['Sender']);
            $result2 = $statement->execute();
            $sender = $result2->fetchArray();
            $row[$i]['Sender_Name'] = $sender['First_Name'] . " " . $sender['Last_Name'];
            $i++;

        }
        $statement->close();
        return $row;
    }



    public function users()
    {

        $sql = 'SELECT *  FROM user WHERE Enable > 0 ORDER BY user.First_Name ASC';

        $statement = $this->prepare($sql);
        $result = $statement->execute();
        $row = array();

        $i = 0;
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            $row[$i]['Id'] = $res['Id'];
            $row[$i]['First_Name'] = $res['First_Name'];
            $row[$i]['Last_Name'] = $res['Last_Name'];
            $row[$i]['Email'] = $res['Email'];
            $row[$i]['Role'] = $res['Role'];
            $row[$i]['Enable'] = $res['Enable'];


            $i++;

        }
        $statement->close();
        return $row;
    }


    public function allUsers()
    {

        $sql = 'SELECT *  FROM user ORDER BY user.First_Name ASC';

        $statement = $this->prepare($sql);
        $result = $statement->execute();
        $row = array();

        $i = 0;
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            $row[$i]['Id'] = $res['Id'];
            $row[$i]['First_Name'] = $res['First_Name'];
            $row[$i]['Last_Name'] = $res['Last_Name'];
            $row[$i]['Email'] = $res['Email'];
            $row[$i]['Role'] = $res['Role'];
            $row[$i]['Enable'] = $res['Enable'];


            $i++;

        }
        $statement->close();
        return $row;
    }


    public function sendEmail($idSender, $idRecipient, $subject, $message)
    {
        try {
            $date = date(time());
            $sql = "INSERT INTO message('Sender', 'Recipient', 'Subject', 'Message', 'Date') VALUES (:idSender, :idRecipient, :subject, :message, :now)";
            $statement = $this->prepare($sql);
            $statement->bindValue(':idSender', $idSender);
            $statement->bindValue(':idRecipient', $idRecipient);
            echo($idRecipient);
            $statement->bindValue(':subject', $subject);
            $statement->bindValue(':message', $message);
            $statement->bindValue(':now', $date);
            $statement->execute();
            $statement->close();
        } catch (Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }


    public function deleteMessage($id_Message)
    {
        try {
            $sql = "DELETE FROM message WHERE Id= :Id_Message";
            $statement = $this->prepare($sql);
            $statement->bindValue(':Id_Message', $id_Message);
            $statement->execute();
            $statement->close();
        } catch (Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }


    public function deleteUser($idUser)
    {
        try {
            $sql = "DELETE FROM user WHERE Id= :Id_User";
            $statement = $this->prepare($sql);
            $statement->bindValue(':Id_User', $idUser);
            $statement->execute();
            $statement->close();
        } catch (Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }


    public function email($id_Message)
    {
        $sql = "SELECT message.*  FROM message WHERE Id= :Id_Message";
        $statement = $this->prepare($sql);
        $statement->bindValue(':Id_Message', $id_Message);
        $result = $statement->execute();

        $res = $result->fetchArray(SQLITE3_ASSOC);

        $sql = 'SELECT First_Name, Last_Name  FROM user WHERE  user.Id = :Id';
        $statement = $this->prepare($sql);
        $statement->bindValue(':Id', $res['Sender']);
        $result2 = $statement->execute();
        $sender = $result2->fetchArray();


        $row = array();

        $row['Id'] = $res['Id'];
        $row['Sender'] = $res['Sender'];
        $row['Recipient'] = $res['Recipient'];
        $row['Subject'] = $res['Subject'];
        $row['Message'] = $res['Message'];
        $row['Date'] = $res['Date'];
        $row['Sender_Name'] = $sender['First_Name'] . " " . $sender['Last_Name'];


        $statement->close();

        return ($row);
    }


}

?>
