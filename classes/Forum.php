<?php
include_once(__DIR__ . "/Db.php");

class Forum {
    private $opID;
    private $commenterID;
    private $postID;
    private $commentID;

    /**
     * Get the value of userID
     */ 
    public function getOpID()
    {
        return $this->opID;
    }

    /**
     * Set the value of userID
     *
     * @return  self
     */ 
    public function setOpID($opID)
    {
        $this->opID = $opID;

        return $this;
    }

    /**
     * Get the value of buddyID
     */ 
    public function getCommenterID()
    {
        return $this->commenterID;
    }

    /**
     * Set the value of buddyID
     *
     * @return  self
     */ 
    public function setCommenterID($commenterID)
    {
        $this->commenterID = $commenterID;

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

    // fetch alle forum posts en de bijhorende user
    public function retrievePosts(){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM post INNER JOIN user ON post.userID = user.userID ORDER BY post.postID DESC');
        $stmt->execute();
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $content;
    }
}