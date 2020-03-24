<?php
include_once (__DIR__ . "/Db.php");
    class User 
    {

    public function canILogin($email, $password)
    {
    $conn = Db::getConnection();

    $statement = $conn->prepare('select * from user where email = :email');
    $statement->bindParam(':email', $email);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $result['password'])) {
        return true;
    } else {
        return false;
    }
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