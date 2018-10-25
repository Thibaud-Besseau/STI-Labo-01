<?php

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('../../databases/sti-db.db');
    }

    protected function getUsersPassword($email)
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
        $sql = 'SELECT message.*  FROM message LEFT JOIN user ON message.Recipient = user.Id   WHERE  user.Email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $result = $statement->execute();
        $row = array();
        $i = 0;
        while($res = $result->fetchArray(SQLITE3_ASSOC)){
            $row[$i]['Id']= $res['Id'];
            $row[$i]['Sender'] = $res['Sender'];
            $row[$i]['Recipient'] = $res['Recipient'];
            $row[$i]['Subject'] = $res['Subject'];
            $row[$i]['Message'] = $res['Message'];
            $row[$i]['Date'] = $res['Date'];
            $i++;

        }
        $statement->close();
        return $row;
    }


    public function sendEmail($idSender, $idRecipient, $subject, $message)
    {
        try {
            $date = time();
            $sql = "INSERT INTO message (Sender, Recipient, Subject, Message, Date) VALUES (:idSender, :idRecipient, :subject, :message, :now)";
            $statement = $this->prepare($sql);
            $statement->bindValue(':idSender', $idSender);
            $statement->bindValue(':idRecipient', $idRecipient);
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


}

?>
