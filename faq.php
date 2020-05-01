<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
} 

$userID = $_SESSION['user_id'];
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Forum.php");

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
    <div class="container">
    <div class="col my-col">
    <div class="form-group">
    <h3 class="mb-4">Veelgestelde vragen</h3>
    <?php foreach ($faqs as $faq) : ?>
        <div class="row my-row">
        <div class="col my-col">
            <div class="card">
                <div class="card-body ">
                
                <a href="topic.php?id=<?php echo $faq['postID'] ?>"><?php echo $faq['postTxt']; ?></a>
            </div>
        </div>
        </div>
        </div>
    <?php endforeach ?>
    </div>
    </div>
    </div>
</body>

</html>