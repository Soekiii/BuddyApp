<?php
include_once (__DIR__ . "/Db.php");
    class User 
    {
    private $email;
    private $password;
    private $firstName;
    private $lastName;

    
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
        $this->password = $password;
        

        //return $this;
    }

     /**
     * Get the value of password
     */ 
     public function getFirstname()
     {
         return $this->firstName;
     }
 

    /**
    *Set the value of firstname
    *  @return  self
     */ 
    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
     public function getLastName()
     {
         return $this->$LastName;
     }
 

    /**
    *Set the value of lastName
    *  @return  self
     */ 
    public function setLastname($lastName)
    {
        $this->lastName = $lastName;

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


    public function registerNewUser(){
        $conn = Db::getConnection();    
            
            //Hash the password  
        
        $this->password = password_hash($this->password, PASSWORD_BCRYPT, ["cost" => 12]);
        
            //Registratie in database
        $statment= $conn->prepare("INSERT INTO user (firstname, lastname, email, password) values (:firstname, :lastname, :email, :password)");
        $statment->bindValue(":firstname",$this->firstName);
        $statment->bindValue(":lastname",$this->lastName);
        $statment->bindValue(":email",$this->email);
        $statment->bindValue(":password",$this->password);

        $result=$statment->execute();

        return $result;
  
    }
   
    

    
}