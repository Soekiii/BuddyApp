<?php 
include_once (__DIR__ . "/Db.php");
class Message{
    private $userID;
    private $message;
    private $recipientID;

//getter setter userID
    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

// getter setter recipientID
    public function getRecipientID()
    {
        return $this->recipientID;
    }

    public function setRecipientID($recipientID)
    {
        $this->recipientID = $recipientID;

        return $this;
    }

//getter setter message
    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

// om je berichtje in de DB te steken
    public function messageSchrijven(){ 
            $conn = Db::getConnection();

            $statement = $conn->prepare("insert into msg(senderID,recipientID,content) values(:senderID,:recipientID,:content)");
            $statement->bindValue(":senderID", $this->getUserID()); // huidige user
            $statement->bindValue(":recipientID", $this->getRecipientID()); // de user naarwaar het verstuurd wordt
            $statement->bindValue(":content", $this->getMessage()); // het bericht
            $result = $statement->execute();
            //$result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
    }

// berichtje afprinten
    public function messagePrint(){ //$senderID,$recipientID
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * from msg where senderID = :senderID AND recipientID = :recipientID"); //where senderID = :senderID AND recipientID = :recipientID
        $statement->bindValue(":senderID", $this->getUserID());
        $statement->bindValue(":recipientID", $this->getRecipientID());
        $result = $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    

}