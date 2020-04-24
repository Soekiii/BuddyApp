<?php
include_once(__DIR__ . "/Db.php");

class Forum extends User {
    private $postID;
    private $commentID;
    private $commentTxt;

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

        /**
     * Get the value of commentTxt
     */ 
    public function getCommentTxt()
    {
        return $this->commentTxt;
    }

    /**
     * Set the value of commentTxt
     *
     * @return  self
     */ 
    public function setCommentTxt($commentTxt)
    {
        $this->commentTxt = $commentTxt;

        return $this;
    }

    // fetch alle forum posts en de bijhorende user
    public function fetchPosts(){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM post INNER JOIN user ON post.userID = user.userID ORDER BY post.postID DESC');
        $stmt->execute();
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $content;
    }

    // verstuur comment
    public function sendComment(){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO comments (userID, postID, commentsTxt) VALUES (:userID, :postID, :commentsTxt)');
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':postID', $postID);
        $stmt->bindParam(':commentsTxt', $commentTxt);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function fetchComments(){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM comments');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}