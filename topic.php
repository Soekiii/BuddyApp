<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

$userID = $_SESSION['user_id'];
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Forum.php");



if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    $fetchPost = new Forum();
    $post = $fetchPost->specificPost($postID);

    $fetchComments = new Forum();
    $comments = $fetchComments->fetchComments($postID);
}

if (!empty($_POST['comment'])) {
    $sendComment = new Forum();
    $postID = $_POST['postID'];
    $commentTxt = $_POST['commentTxt'];
    $sendComment->setUserID($userID);
    $sendComment->setPostID($postID);
    $comment = $sendComment->sendComment($postID, $userID, $commentTxt);
    var_dump($comment['commentID']);
    header("Refresh: 0");
}

$checkMod = new Forum();
$mod = $checkMod->checkMod($userID);

if (isset($_POST['pinPost'])) {
    $pinPost = new Forum();
    $postID = $_POST['postID'];
    $pinPost->setPostID($postID);
    $pin = $pinPost->pinPost($postID);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!--<style>
        .my-container {
            border: 1px solid green;
        }

        .my-row {
            border: 3px solid red;
        
        }

        .my-col {
            border: 3px dotted blue;
        }
    </style> -->
</head>

<body>
    <div class="container">
        <div class="row my-row">
            <form action="" method="post" name="pinPost">
                <div class="col justify-content-end">
                    <?php if ($mod['modStatus'] == 1) { ?>

                        <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
                        <input type="submit" name="pinPost" class="btn btn-primary mt-4" value="Pin post">

                    <?php } ?>
                </div>
            </form>

            <div class="col-md-12 my-col">
                <div class="form-group">
                    <?php echo $post['firstname'] . " " . $post['lastname'] . " zegt: " . $post['postTxt']; ?>
                </div>
            </div>


            <?php foreach ($comments as $comment) : ?>
                <div class="col-md-12 my-col">
                    <div class="form-group">
                        <?php echo $comment['firstname'] . " " . $comment['lastname'] . " reageert: " . $comment['commentsTxt']; ?>
                        <input type="hidden" name="userID" id="userID" value="<?php echo $post['userID']?>">
                        <input type="hidden" name="postID" id="postID" value="<?php echo $post['postID']?>">
                        <input type="submit" id="btnUpvote" data-commentid="<?php echo $comment['commentID'] ?>" class="btn btn-primary" value="Upvote">
                        

                    </div>
                </div>
            <?php endforeach; ?>



            <form action="" method="post" name="comment">
                <div class="col-md-12 my-col justify-content-center">
                    <div class="form-group">
                        <textarea name="commentTxt" id="" cols="col-120" rows="2"></textarea>
                        <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
                        <input type="submit" name="comment" class="btn btn-primary mt-4" value="Reageer">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script src="like.js"></script>
</body>

</html>