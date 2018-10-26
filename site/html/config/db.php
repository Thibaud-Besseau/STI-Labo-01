<?php

class MyDB extends SQLite3
{
    private $file_db;
    function __construct()
    {
        $this->open('/usr/share/nginx/databases/sti-db.db',SQLITE3_OPEN_READWRITE);


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

            $password_db = $this->getUsersPassword($email);


            if ($password === $password_db) {
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
        echo($id_Message);
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
