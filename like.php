<?php
include_once(__DIR__ . "/classes/Db.php");

if(isset($_POST['postID'])){
    $statement = $conn->prepare('INSERT into user_content_like (postID,user_id) VALUES(:postID, :user_id)');
    $statement->bindValue(':postID', $_POST['postID']);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result)){
        echo 'done';
    }

}
