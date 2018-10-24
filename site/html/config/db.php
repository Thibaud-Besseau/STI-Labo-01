<?php
   class MyDB extends SQLite3 {
       function __construct() {
           $this->open('../../databases/sti-db.db');
       }

       protected function getUsersPassword($email) {
        $sql = 'SELECT Password  FROM   user  WHERE  Email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $password = $row['Password'];
        $statement->close();
        return $password;
    }

       protected function userExists($email) {
           $sql = 'SELECT COUNT(*) AS count FROM user WHERE  Email = :email';
           $statement = $this->prepare($sql);
           $statement->bindValue(':email', $email);

           $result = $statement->execute();
           $row = $result->fetchArray();


           $isRegistred=false;
           if($row['count'] === 1)
           {
               $isRegistred=true;
           }
           else
           {
               $isRegistred=false;
           }

           $statement->close();

           return $isRegistred;
       }

       public function loginUser($email, $password) {
           $connected=false;
           if ($this->userExists($email)) {

               $password_db = $this->getUsersPassword($email);


               if ($password === $password_db) {
                   $connected = true;
               }


           }

           return $connected;
       }


       public function emailUser($email) {
           $sql = 'SELECT *  FROM message LEFT JOIN user ON message.Recipient = user.Id   WHERE  user.Email = :email';
           $statement = $this->prepare($sql);
           $statement->bindValue(':email', $email);
           $result = $statement->execute();
           $row = $result->fetchArray();
           $statement->close();
           return $row;
       }



   }
?>
