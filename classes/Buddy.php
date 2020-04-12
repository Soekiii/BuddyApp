<?php
include_once(__DIR__ . "/Db.php");

class Buddy
{
    private $hobbyUser;
    private $hobbyOthers;
    private $buddyID;
    private $userID;
    private $status;

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

    public function fetchbuddyID($userID){
        $buddyID = $this->buddyID;
        $conn = Db::getConnection();
        $stmtbuddyID = $conn->prepare('SELECT userID FROM user WHERE userID != :userID');
        $stmtbuddyID->bindParam(':userID', $userID);
        $stmtbuddyID->execute();
        $buddyID = $stmtbuddyID->fetchAll(PDO::FETCH_ASSOC);

        return $buddyID;
    }
    
    // FETCH USER'S HOBBY TABLE AND JOIN IT WITH THEIR USER TABLE
    public function setHobbyUser($userID)
    {
        $hobbyUser = $this->hobbyUser;
        $conn = Db::getConnection();
        $statementUser = $conn->prepare('SELECT * FROM hobby INNER JOIN user ON hobby.userID = user.userID and user.userID = :userID');
        $statementUser->bindValue(':userID', $userID);
        $statementUser->execute();
        $hobbyUser = $statementUser->fetch(PDO::FETCH_ASSOC);

        return $hobbyUser;
    }

    // FETCH OTHER USERS' HOBBY TABLE AND JOIN IT WITH THEIR USER TABLE
    public function setHobbyOthers($userID)
    {
        $hobbyOthers = $this->hobbyOthers;
        $conn = Db::getConnection();
        $statementOthers = $conn->prepare('SELECT * FROM hobby INNER JOIN user ON hobby.userID = user.userID and user.userID != :userID');
        $statementOthers->bindValue(':userID', $userID);
        $statementOthers->execute();
        $hobbyOthers = $statementOthers->fetchAll(PDO::FETCH_ASSOC);

        return $hobbyOthers;
    }

    public function buddyRequest($userID, $buddyID){
        $conn = Db::getConnection();
        $stmtRequest = $conn->prepare('INSERT INTO buddies(buddy1ID, buddy2ID, status) VALUES (:userID, :buddyID, 0)');
        $stmtRequest->bindParam(':userID', $userID);
        $stmtRequest->bindValue(':buddyID', $buddyID);
        $request = $stmtRequest->execute();

        return $request;
    }

    // RETRIEVE BUDDY TABLE WHERE BUDDY2ID = userID (this means current user has received a buddy request)
    public function checkRequest($userID)
    {
        $conn = Db::getConnection();
        // AND JOIN BUDDY2ID WITH USER TABLE TO RETRIEVE NAME OF REQUEST SENDERS
        $stmtRequest = $conn->prepare('SELECT * FROM buddies INNER JOIN user ON buddies.buddy1ID = user.userID WHERE buddies.buddy2ID = :userID');
        $stmtRequest->bindParam(':userID', $userID);
        $stmtRequest->execute();
        $request = $stmtRequest->fetchAll(PDO::FETCH_ASSOC);
        return $request;
    }

    // WHEN REQUEST IS ACCEPTED --> change status to 1
    public function acceptRequest($userID, $buddyID){
        $conn = Db::getConnection();
        $stmtAccept = $conn->prepare('UPDATE buddies SET status="1" WHERE buddy2ID = :userID AND buddy1ID = :buddyID');
        $stmtAccept->bindParam(':userID', $userID);
        $stmtAccept->bindValue(':buddyID', $buddyID);
        $stmtAccept->execute();
        $accept = $stmtAccept->fetch(PDO::FETCH_ASSOC);
        return $accept;
    }
}
