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

$checkPinned = new Forum();
$faqs = $checkPinned->checkPinned();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h4>Veelgestelde vragen</h4>
    <?php foreach ($faqs as $faq) : ?>
        <div class="posts">
            <div>
                <a href="topic.php?id=<?php echo $faq['postID'] ?>"><?php echo $faq['postTxt']; ?></a>
            </div>
        </div>
    <?php endforeach ?>
</body>

</html>