<?php
include_once(__DIR__ . "/classes/Buddy.php");
include_once(__DIR__ . "/inc/header.inc.php");

session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
} else {
    $userArray = $_SESSION['user_id'];
    $userID = implode(' ', $userArray);
}

if(isset($_GET['id'])){
    $buddy = new Buddy();
    $buddyID = $_GET['id'];
    $buddy->setBuddyID($buddyID);
    $buddyOthers = $buddy->showBuddyOthers($buddyID);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach($buddyOthers as $buddy) : ?>
    <?php if($buddy['status'] == 1){ ?>
        <div class="buddy">
            <a href="users.php?id=<?php echo $buddy['userID'] ?>"><?php echo $buddy['firstname'] . " " . $buddy['lastname'] ?></a> <?php echo "'s buddy"; ?>
        </div>
    <?php } ?>
    <?php endforeach; ?>
</body>
</html>