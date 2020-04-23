<?php
include_once(__DIR__ . "/Db.php");

class Forum {
    private $userID;
    private $buddyID;
    private $postID;
    private $commentID;

    /**
     * Get the value of userID
     */ 
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Set the value of userID
     *
     * @return  self
     */ 
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

    /**
     * Get the value of buddyID
     */ 
    public function getBuddyID()
    {
        return $this->buddyID;
    }

    /**
     * Set the value of buddyID
     *
     * @return  self
     */ 
    public function setBuddyID($buddyID)
    {
        $this->buddyID = $buddyID;

        return $this;
    }

    /**
     * Get the value of postID
     */ 
    public function getPostID()
    {
        return $this->postID;
    }

    /**
     * Set the value of postID
     *
     * @return  self
     */ 
    public function setPostID($postID)
    {
        $this->postID = $postID;

        return $this;
    }

    /**
     * Get the value of commentID
     */ 
    public function getCommentID()
    {
        return $this->commentID;
    }

    /**
     * Set the value of commentID
     *
     * @return  self
     */ 
    public function setCommentID($commentID)
    {
        $this->commentID = $commentID;

        return $this;
    }

    public function retrievePosts(){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM post INNER JOIN comments ON post.postID = comments.postID ORDER BY post.postID DESC');
        $stmt->execute();
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $content;
    }
}