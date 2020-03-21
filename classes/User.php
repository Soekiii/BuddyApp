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
    
    }
}