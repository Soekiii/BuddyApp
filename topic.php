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
    $comments = $fetchComments->specificComments($postID);
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

if(isset($_POST['pinPost'])){
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
</head>

<body>
    <div class="container">
    <div>
        <form action="" method="post" name="pinPost">
        <?php if($mod['modStatus'] == 1){ ?>
            <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
            <input type="submit" name="pinPost" value="Pin post">
        <?php } ?>
        </form>
    </d>
    <div>
        <div>
            <?php echo $post['firstname'] . " " . $post['lastname'] . " zegt: " . $post['postTxt']; ?>
        </div>
    </div>

    <div>
        <?php foreach ($comments as $comment) : ?>
            <input type="text" name="commentID" id="" value="<?php echo $comment['commentID']?>">
            <div> <?php echo $comment['firstname'] . " " . $comment['lastname'] . " reageert: " . $comment['commentsTxt']; ?> </div>
            <i class="far fa-thumbs-up"></i>
        <?php endforeach; ?>
    </div>

    <div>
        <form action="" method="post" name="comment">
            <textarea name="commentTxt" id="" cols="140" rows="2"></textarea>
            <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
            <input type="submit" name="comment" value="Reageer">
        </form>
    </div>
    </div>
</body>
</html>
<script>
    $(document).on('click', '.like_button', function(){
        var commentID = $(this).data('commentID');
        $(this).attr('disabled', 'disabled');
        $.ajax({
            url: 'like.php',
            methode: 'POST',
            data: {commentID:commentID},
            succes:function(data)
            {
                if(data == 'done')
                {
                    load_stuff();
                }
            }
        });
    });
</script>