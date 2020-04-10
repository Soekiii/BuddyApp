<?php
include_once(__DIR__ . "/Db.php");

class Buddy
{
    private $hobbyUser;
    private $hobbyOthers;

    // FETCH USER'S HOBBY TABLE AND JOIN IT WITH THEIR USER TABLE
    public function setHobbyUser()
    {
        $hobbyUser = $this->hobbyUser;
        $userArray = $_SESSION['user_id'];
        $userID = implode(" ", $userArray);
        $conn = Db::getConnection();
        $statementUser = $conn->prepare('SELECT * FROM hobby INNER JOIN user ON hobby.userID = user.userID and user.userID = :userID');
        $statementUser->bindValue(':userID', $userID);
        $statementUser->execute();
        $hobbyUser = $statementUser->fetch(PDO::FETCH_ASSOC);

        return $hobbyUser;
    }

    // FETCH OTHER USERS' HOBBY TABLE AND JOIN IT WITH THEIR USER TABLE
    public function setHobbyOthers()
    {
        $hobbyOthers = $this->hobbyOthers;
        $userArray = $_SESSION['user_id'];
        $userID = implode(" ", $userArray);
        $conn = Db::getConnection();
        $statementOthers = $conn->prepare('SELECT * FROM hobby INNER JOIN user ON hobby.userID = user.userID and user.userID != :userID');
        $statementOthers->bindValue(':userID', $userID);
        $statementOthers->execute();
        $hobbyOthers = $statementOthers->fetchAll(PDO::FETCH_ASSOC);

        return $hobbyOthers;
    }
}
