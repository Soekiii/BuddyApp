<?php
include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Buddy.php");

class Forum extends Buddy{
    private $postID;
    private $postTxt;
    private $commentID;
    private $commentTxt;
    private $mod;

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

        /**
     * Get the value of postTxt
     */ 
    public function getPostTxt()
    {
        return $this->postTxt;
    }

    /**
     * Set the value of postTxt
     *
     * @return  self
     */ 
    public function setPostTxt($postTxt)
    {
        $this->postTxt = $postTxt;

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
    public function sendComment($postID, $userID, $commentTxt){
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

    public function specificPost($postID){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM post INNER JOIN user ON post.userID = user.userID WHERE post.postID = :postID');
        $stmt->bindParam(':postID', $postID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function specificComments($postID){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM comments INNER JOIN user on comments.userID = user.userID WHERE comments.postID = :postID');
        $stmt->bindParam(':postID', $postID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Get the value of mod
     */ 
    public function getMod()
    {
        return $this->mod;
    }

    /**
     * Set the value of mod
     *
     * @return  self
     */ 
    public function setMod($mod)
    {
        $this->mod = $mod;

        return $this;
    }

    // check if user is moderator
    public function checkMod($userID){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM modteam WHERE userID = :userID');
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // create new post
    public function newPost($userID, $postTxt){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO post (userID, postTxt) VALUES (:userID, :postTxt)');
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':postTxt', $postTxt);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // check if post is pinned
    public function checkPinned(){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM pinned INNER JOIN post ON pinned.postID = post.postID');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // pin a post
    public function pinPost($postID){
        $conn = Db::getConnection();
        $stmt = $conn->prepare('INSERT INTO pinned(postID, pinnedStatus) VALUES (:postID, 1)');
        $stmt->bindParam(':postID', $postID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}