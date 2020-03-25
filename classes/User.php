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

    public function checkValidEmail($email)
    {
    $conn = Db::getConnection();

    $statement = $conn->prepare('SELECT * from user WHERE email = :email');
    $statement->bindParam(':email', $email);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
   
    return $result;
    }

}