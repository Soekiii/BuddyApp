<?php
include_once(__DIR__ . "/Db.php");

class Buddy
{
    private $hobbyUser;
    private $hobbyOthers;
    private $buddyID;
    private $userID;

    public function getUserID()
    {
        return $this->userID;
    }
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

    public function getBuddyID()
    {
        return $this->buddyID;
    }
    public function setBuddyID($buddyID)
    {
        $this->buddyID = $buddyID;

        return $this;
    }

    public function fetchbuddyID(){
        $buddyID = $this->buddyID;
        $userArray = $_SESSION['user_id'];
        $userID = implode(" ", $userArray);
        $conn = Db::getConnection();
        $stmtbuddyID = $conn->prepare('SELECT userID FROM user WHERE userID != :userID');
        $stmtbuddyID->bindParam(':userID', $userID);
        $stmtbuddyID->execute();
        $buddyID = $stmtbuddyID->fetchAll(PDO::FETCH_ASSOC);

        return $buddyID;
    }
    
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

    public function buddyRequest($userID, $buddyID){
        $userArray = $_SESSION['user_id'];
        $userID = implode(" ", $userArray);
        $conn = Db::getConnection();
        $stmtRequest = $conn->prepare('INSERT INTO buddies(buddy1ID, buddy2ID, status) VALUES (:userID, :buddyID, 0)');
        $stmtRequest->bindParam(':userID', $userID);
        $stmtRequest->bindValue(':buddyID', $buddyID);
        $request = $stmtRequest->execute();

        return $request;
    }
}
