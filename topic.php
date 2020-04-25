<?php
session_start();
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Forum.php");

$userID = "";
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
} else {
    $userArray = $_SESSION['user_id'];
    $userID = implode(" ", $userArray);
}

if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    $fetchPost = new Forum();
    $post = $fetchPost->specificPost($postID);

    $fetchComments = new Forum();
    $comments = $fetchComments->specificComments($postID);
}

/*if (!empty($_POST['comment'])){
    $sendComment = new Forum();
    $sendComment->setUserID($userID);
    $sendComment->set
    $comment = $sendComment->sendComment();
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div>
        <div>
            <?php echo $post['firstname'] . " " . $post['lastname'] . " says: " . $post['postTxt']; ?>
        </div>
    </div>
    
    <div>
        <?php foreach ($comments as $comment) : ?>
            <div> <?php echo $comment['firstname'] . " " . $comment['lastname'] . " responds: " . $comment['commentsTxt']; ?> </div>
        <?php endforeach; ?>    
    </div>

    <div>
        <form action="" method="post" name="comment">
            <textarea name="comment" id="" cols="140" rows="2"></textarea>
            <input type="submit" name="comment" value="Reageer">
        </form>
    </div>
</body>

</html>