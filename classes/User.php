<?php
include_once (__DIR__ . "/Db.php");
    class User 
    {

    public function canILogin($email, $password)
    {
    $conn = Db::getConnection();

    $statement = $conn->prepare('select * from users where email = :email');
    $statement->bindParam(':email', $email);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $result['password'])) {
        return true;
    } else {
        return false;
    }
    }

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
   
    

    
}