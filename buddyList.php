<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
//Hier worden de buddies getoond.

include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__."/classes/Message.php");
include_once(__DIR__."/classes/User.php");

//Checken welke userid nu aangelogd is.
$userArray = $_SESSION['user_id'];
$userID = implode(" ", $userArray);
$currentUser = $userID;

//alle buddys uit de lijst halen
$buddyList = User::getAllBuddies($userID);
//var_dump($buddyList);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php foreach($buddyList as $buddy): ?>
    <div><!-- IF currentuser is in buddy1 tabel, moet die buddy uit buddy2 tabel echo'en-->
        <?php if ($currentUser == $buddy['buddy1ID']): ?>
            <h1>Chat met <?php echo $buddy["buddy2ID"]; ?></h1>
            <form action="message.php" method="POST">
                <input type="hidden" name="recipientID" id="" value="<?php echo $buddy["buddy2ID"];?>">
                <div class="">
                    <button type="submit" class="btn" style="width: 75px">Chat nu</button>
                </div>
            </form>
        <!-- IF currentuser is in buddy2 tabel, moet die buddy uit buddy1 tabel echo'en-->
        <?php elseif ($currentUser == $buddy['buddy2ID']): ?>
            <h1>Je chat nu met <?php echo $buddy["buddy1ID"]; ?></h1>
            <form action="message.php" method="POST">
                <input type="hidden" name="recipientID" id="" value="<?php echo $buddy["buddy1ID"];?>">
                <div class="">
                    <button type="submit" class="btn" style="width: 75px">Chat nu</button>
                </div>
            </form>
        <?php endif;?>
    </div>
<?php endforeach;?>

</body>
</html>