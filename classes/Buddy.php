<?php
include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/User.php");
include_once(__DIR__ . "/Mail.php");


class Buddy extends User
{
    private $hobbyUser;
    private $hobbyOthers;
    private $buddyID;
    protected $userID;
    private $status;
    private $rejectMsg;

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

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    
    public function getRejectMsg()
    {
        return $this->rejectMsg;
    }
    public function setRejectMsg($rejectMsg)
    {
        $this->rejectMsg = $rejectMsg;

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
        if($request){
            $user = $this->getUserById($buddyID);
            //var_dump($user['email']);
            
            $content = "Iemand wilt je buddy worden.";
            Mail::sendMail("Buddy request", $user['email'],$content);
        }

        return $request;
    }

    // RETRIEVE ALL BUDDY ROWS WHERE BUDDY2ID = userID (this means current user has received a buddy request)
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

    // check if user already has a buddy
    public function buddyAvailable($userID){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT MAX(status) FROM buddies WHERE buddy2ID = :userID');
        $stmt->bindPAram(':userID', $userID);
        $stmt->execute();
        $buddyAvailable = $stmt->fetch(PDO::FETCH_ASSOC);
        $available = implode(" ", $buddyAvailable);
        return $available;
    }

    public function rejectRequest($userID, $buddyID, $rejectMsg){
        $conn = Db::getConnection();
        $stmtReject = $conn->prepare('UPDATE buddies SET status="3", rejectMsg= :rejectMsg WHERE buddy1ID = :buddyID AND buddy2ID = :userID');
        $stmtReject->bindParam(':userID', $userID);
        $stmtReject->bindValue(':buddyID', $buddyID);
        $stmtReject->bindValue(':rejectMsg', $rejectMsg);
        $stmtReject->execute();
        $reject = $stmtReject->fetch(PDO::FETCH_ASSOC);
        return $reject;
    }

        // GET OTHER USERS' BUDDY INFORMATION
        public function showBuddyOthers($buddyID){
        $conn = Db::getConnection();
        // switch case: als buddy1ID = buddyID, dan wil je de informatie (naam) van buddy2ID en omgekeerd
        $stmt = $conn->prepare('SELECT * FROM buddies INNER JOIN user ON (CASE WHEN buddy1ID = :buddyID THEN buddy2ID = user.userID WHEN buddy2ID = :buddyID THEN buddy1ID = user.userID END)');
        $stmt->bindParam(':buddyID', $buddyID);
        $stmt->execute();
        $otherBuddy = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $otherBuddy;
        }

        public function buddyData($buddyID){
            $conn = Db::getConnection();
            $stmt = $conn->prepare('SELECT * from buddies INNER JOIN user ON (CASE WHEN buddy1ID = :buddyID THEN buddy1ID = user.userID WHEN buddy2ID = :buddyID THEN buddy2ID = user.userID END)');
            $stmt->bindParam(':buddyID', $buddyID);
            $stmt->execute();
            $buddy = $stmt->fetch(PDO::FETCH_ASSOC);
            return $buddy;
        }

        public function countRequest($userID){
            $conn = Db::getConnection();
            $stmt = $conn->prepare('SELECT COUNT(buddyID) FROM buddies WHERE status = "0" AND buddy2ID = :userID');
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
}
