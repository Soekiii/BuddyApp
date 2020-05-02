<?php
include_once(__DIR__ . "/Db.php");


class Like{
    private $id;
    private $userId;
    private $commentId;




    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of commentId
     */ 
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Set the value of commentId
     *
     * @return  self
     */ 
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;

        return $this;
    }

    public function save(){
        $conn = Db::getConnection();
        $statement = $conn->prepare('INSERT into comment_like (userID, commentID) values (:userID, :commentID)');

        $userID = $this->userId;
        $commentID = $this->commentId;

        $statement->bindValue(":userID", $userID);
        $statement->bindValue(":commentID", $commentID);

        $result = $statement->execute();
        return $result;
    }
}