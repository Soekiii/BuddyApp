<?php
include_once (__DIR__ . "/Db.php");
    class User 
    {
    private $email;
    private $password;
    
    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
<<<<<<< HEAD

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
=======

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
>>>>>>> refs/remotes/origin/master
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    public function canILogin()
    {
    $conn = Db::getConnection();

    $statement = $conn->prepare('select * from user where email = :email');
    $email = $this->getEmail();
    $password = $this->getPassword();
    $statement->bindParam(':email', $email);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $result['password'])) {
        return true;
    } else {
        return false;
    }
    }
    // vraag userId op via de persoon zijn email
    public function getUserId()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare('select userID from user where email = :email');
        $email = $this->getEmail();
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function userSearch($search)
    {
    $conn = Db::getConnection();

    $statement = $conn->prepare("select * from user where firstname like :search or lastname like :search");
    $statement->bindValue(':search', '%' . $search . '%');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }

<<<<<<< HEAD
=======

    public function registerNewUser($firstName, $lastName, $email, $password){
        $conn = Db::getConnection();    
            
            //Hash the password   
        $passwordBcrypt = password_hash($password, PASSWORD_BCRYPT);
            //Registratie in database
        $statment= $conn->prepare("INSERT INTO user (firstname, lastname, email, password) values (:firstname, :lastname, :email, :password)");
        $statment->bindValue(":firstname",$firstName);
        $statment->bindValue(":lastname",$lastName);
        $statment->bindValue(":email",$email);
        $statment->bindValue(":password",$password);

        $result=$statment->execute();

        return $result;
  
    }
   
>>>>>>> refs/remotes/origin/master
    

    
}