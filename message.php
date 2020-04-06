<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
//Hier mag enkel het gesprek te zien zijn tussen 2 users die met elkaar bevriend zijn
//tabel buddies >buddyID1 & buddyID2

include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__."/classes/Message.php");
include_once(__DIR__."/classes/User.php");

$userArray = $_SESSION['user_id'];
$userID = implode(" ", $userArray);
$currentUser = $userID;

//var_dump($_POST);

$recipientID = implode(" ",$_POST);
echo "currentUser: ";
var_dump($currentUser);
echo ".  recipientID: ";
var_dump($recipientID);



//msg wordt in databank gestopt
if(!empty($_POST)){
    $msg = new Message();
    $msg->getMessage($_POST['message']);
    $msg->messageSchrijven();
}

//msg wordt afgedrukt/gereturned
//$messages = $msg->messagePrint();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="" methd="post">
        <h1>Je chat nu met <?php echo $recipientID ?></h1>
            <input type="text" name="message">
            <input type="hidden" name="recipientID" id="" value="<?php echo $recipientID?>">
            <input type="hidden" name="senderID" id="" value="<?php echo $currentUser?>">
            <div class="">
                <button type="submit" class="btn" style="width: 90px" name="message">Verstuur</button>
            </div>
        </form>
    </div>

    <?php foreach($messages as $message): ?>
        <div>                
        <p><?php echo $message["senderID"].": " . $message["content"]; ?></p>
        </div>
    <?php endforeach;?>

    
</body>
</html>