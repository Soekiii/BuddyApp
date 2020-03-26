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
        if(empty($email)){
        throw new Exception('email mag niet leeg zijn');
        } else {
        if(!preg_match('|@student.thomasmore.be$|', $email)){
          throw new Exception ('email moet eindigen op @student.thomasmore.be');
        }
    }
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        if(empty($password)){
        throw new Exception ('password is niet juist');
        }
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

    

    
}