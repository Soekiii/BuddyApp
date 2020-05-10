<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Forum.php");

if (isset($_GET['id'])) {
    $postID = $_GET['id'];
    $fetchPost = new Forum();
    $post = $fetchPost->specificPost($postID);
    $fetchComments = new Forum();
    $comments = $fetchComments->fetchComments($postID);

    $checkForLikes = new Forum();
    $check = $checkForLikes->checkForLikes($postID);
}

if (!empty($_POST['comment'])) {
    $sendComment = new Forum();
    $postID = $_POST['postID'];
    $commentTxt = $_POST['commentTxt'];
    $sendComment->setUserID($userID);
    $sendComment->setPostID($postID);
    $comment = $sendComment->sendComment($postID, $userID, $commentTxt);
    header("Refresh: 0");
} else {
}

$checkMod = new Forum();
$mod = $checkMod->checkMod($userID);
if (empty($mod)) {
} else {
    $mod = implode(" ", $mod);
}

$isPinned = new Forum();
$pinned = $isPinned->isPinned($postID);


if (isset($_POST['pinPost'])) {
    $pinPost = new Forum();
    $postID = $_POST['postID'];
    $pinPost->setPostID($postID);
    $pin = $pinPost->pinPost($postID);
    header('Refresh:0');
}

if (isset($_POST['unpinPost'])) {
    $unpinPost = new Forum();
    $postID = $_POST['postID'];
    $unpinPost->setPostID($postID);
    $unpin = $unpinPost->unpinPost($postID);
    header('Refresh:0');
}

$checkLike = new Forum();
$checkLike->setUserID($userID);
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
            <div class="col justify-content-end">
                <?php if ($mod === "1") { ?>
                    <?php if ($pinned == 1) { ?>
                        <form action="" method="post" name="unpinPost">
                            <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
                            <input type="submit" style="background-color:salmon; border:1px solid salmon;" name="unpinPost" class="btn btn-primary mt-4" value="unpin post">
                        </form>
                    <?php } else { ?>
                        <form action="" method="post" name="pinPost">
                            <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
                            <input type="submit" name="pinPost" class="btn btn-primary mt-4" value="pin post">
                        </form>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="col-md-12 my-col">
                <div class="form-group">
                    <b><a href="users.php?id=<?php echo $post['userID'] ?>"><?php echo htmlspecialchars($post['firstname'] . " " . $post['lastname']) ?></a><?php echo htmlspecialchars(": " .  $post['postTxt']); ?></b>
                </div>
            </div>

            <?php if ($check == 1) {
                $mostLiked = new Forum();
                $likes = $mostLiked->mostLikes($postID); ?>
                <div class="col-md-12 my-col">
                    <div class="form-group">
                        <b><span class="fa fa-star" style="color:#FFDB58"></span> <a href="users.php?id=<?php echo $likes['userID'] ?>"><?php echo htmlspecialchars($likes['firstname'] . " " . $likes['lastname']) ?></a><?php echo htmlspecialchars(": " .  $likes['commentsTxt']); ?></b>
                    </div>
                </div> <?php } else {
                    } ?>

            <?php foreach ($comments as $comment) : ?>
                <div class="col-md-12 my-col">
                    <div class="form-group">
                        <form action="" method="post">
                            <a href="users.php?id=<?php echo $comment['userID'] ?>"><?php echo htmlspecialchars($comment['firstname'] . " " . $comment['lastname']) ?></a><?php echo htmlspecialchars(": " .  $comment['commentsTxt']); ?>
                            <input type="hidden" name="userID" class="userID" value="<?php echo $userID ?>">
                            <input type="hidden" name="postID" class="commentID" value="<?php echo $comment['commentID'] ?>">
                            <?php
                            $commentID = $comment['commentID'];
                            $checkLike->setCommentID($commentID);
                            $liked = $checkLike->checkLike();
                            ?>
                            <?php if ($liked == 0) { ?>
                                <a style="color:Gainsboro" id="btnUpvote" class="fa fa-thumbs-up"></a> <?php } else { ?>
                                <span class="fa fa-thumbs-up" style="color:blue"></span> <?php } ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" name="comment">
                <div class="col-md-12 my-col justify-content-center">
                    <div class="form-group">
                        <textarea name="commentTxt" id="commentTxt" cols="col-120" rows="2"></textarea>
                        <input type="hidden" name="postID" id="reactPostID" value="<?php echo $post['postID'] ?>">
                        <input type="submit" name="comment" id="react" class="btn btn-primary mt-4" value="Reageer">
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        Array.from(document.querySelectorAll("#btnUpvote")).forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                let commentID = e.target.parentNode.querySelector('.commentID').value;
                let userID = e.target.parentNode.querySelector('.userID').value;

                console.info(commentID, userID);


                const formData = new FormData();

                formData.append('userID', userID);
                formData.append('commentID', commentID);

                fetch('savelike.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        let liked = btn.style.color = "blue";
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

</body>

</html>