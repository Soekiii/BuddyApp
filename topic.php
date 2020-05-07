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
                    <?php if ($mod === "1") { ?>
                        <input type="hidden" name="postID" id="" value="<?php echo $post['postID'] ?>">
                        <input type="submit" name="pinPost" class="btn btn-primary mt-4" value="Pin post">
                    <?php } ?>
                </div>
            </form>

            <div class="col-md-12 my-col">
                <div class="form-group">
                    <b><a href="users.php?id=<?php echo $post['userID'] ?>"><?php echo $post['firstname'] . " " . $post['lastname'] ?></a><?php echo ": " .  $post['postTxt']; ?></b>
                </div>
            </div>

            <?php foreach ($comments as $comment) : ?>
                <div class="col-md-12 my-col">
                    <div class="form-group">
                        <form action="" method="post">
                            <a href="users.php?id=<?php echo $comment['userID'] ?>"><?php echo $comment['firstname'] . " " . $comment['lastname'] ?></a><?php echo ": " .  $comment['commentsTxt']; ?>
                            <input type="hidden" name="userID" class="userID" value="<?php echo $userID ?>">
                            <input type="hidden" name="postID" class="commentID" value="<?php echo $comment['commentID'] ?>">
                            <a href="#" style="color:Gainsboro" id="btnUpvote" class="fa fa-thumbs-up"></a>
                            <?php echo $comment['commentID'] ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" name="comment">
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

    <script>
        Array.from(document.querySelectorAll("#btnUpvote")).forEach(bttn => {
            bttn.addEventListener('click', (e) => {
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
                        console.log('Success:', result);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

</body>

</html>