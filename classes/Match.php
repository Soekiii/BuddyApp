<?php
include_once(__DIR__ . "/Db.php");

class Match
{   
    private $hobbyUser;         // current user's hobby's
    private $hobbyOthers;        // other users' hobby's and names

    
    public function getUserHobby()
    {
        return $this->userHobby;
    }
    public function setUserHobby($userHobby)
    {
        $this->userHobby = $userHobby;

        return $this;
    }

    public function getOtherHobby()
    {
        return $this->otherHobby;
    }
    public function setOtherHobby($otherHobby)
    {
        $this->otherHobby = $otherHobby;

        return $this;
    }

    // CALCULATE HOW MUCH USERS MATCH BY GIVING POINTS FOR EACH COMMON INTEREST
    public function calcMatch($hobbyUser, $hobbyOthers)
    {
        $userArray = $_SESSION['user_id'];
        $userID = implode(" ", $userArray);

        // fetch current user's interests
        $conn = Db::getConnection();
        $statementUser = $conn->prepare('SELECT * FROM hobby WHERE userID = :userID');
        $statementUser->bindValue(':userID', $userID);
        $statementUser->execute();
        $hobbyUser = $statementUser->fetch(PDO::FETCH_ASSOC);

        // fetch all other users' interests
            // join hobby and user tables so you can retrieve users' names
        $statementOthers = $conn->prepare('SELECT * FROM hobby INNER JOIN user ON hobby.userID = user.userID and user.userID != :userID');
        $statementOthers->bindValue(':userID', $userID);
        $statementOthers->execute();
        $hobbyOthers = $statementOthers->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->hobbyUser = $hobbyUser;
        return $this->hobbyOthers = $hobbyOthers;
    }
}