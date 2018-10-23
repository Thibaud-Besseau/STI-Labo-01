<?php
   class MyDB extends SQLite3 {
       function __construct() {
           $this->open('../../databases/sti-db.db');
       }

       protected function getUsersPassword($email) {
        $sql = 'SELECT password  FROM   user  WHERE  email = :email';
        $statement = $this->prepare($sql);
        $statement->bindValue(':email', $email);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $password = $row['password'];
        $statement->close();
        return $password;
    }

       protected function userExists($email) {
           $sql = 'SELECT COUNT(*) AS count FROM   user WHERE  email = :email';
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
           if ($this->userExists($email)) {
               $password_db = $this->getUsersPassword($email);

               if ($password === $password_db) {
                   $connected = true;
               } else {
                   $connected = false;
               }
           } else {
               $connected = false;
           }


           return $connected;
       }




   }
?>
