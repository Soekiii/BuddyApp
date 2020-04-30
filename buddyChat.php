<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
} 

$userID = $_SESSION['user_id'];
$currentUser = $userID;
//Hier mag enkel het gesprek te zien zijn tussen 2 users die met elkaar bevriend zijn
//tabel buddies >buddyID1 & buddyID2

include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__."/classes/Message.php");
include_once(__DIR__."/classes/User.php");


//var_dump($_POST);

//$recipientID = implode(" ",$_POST);//om het getal terug te krijgen van de recipientID
$recipientID = $_POST['recipientID'];

//msg wordt in databank gestopt
if(!empty($_POST['message'])){
    $msg = new Message();
    $msg->setUserID($currentUser);
    $msg->setRecipientID($recipientID);
    $msg->setMessage(htmlspecialchars($_POST['message']));
    $msg->writeMessage();
}

//msg wordt afgedrukt/gereturned
$messages = Message::messagePrint($currentUser,$recipientID);


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Je chat nu met <?php echo $recipientID ?></h1>
    <?php foreach($messages as $message): ?>
        <div>          
            <p><?php echo $message["senderID"].": " . $message["content"]; ?></p>
        </div>
    <?php endforeach;?>
    <div>
        <form action="" method="post">
            <input type="text" name="message">
            <input type="hidden" name="senderID" id="" value="<?php echo $currentUser?>">
            <input type="hidden" name="recipientID" id="" value="<?php echo $recipientID?>">
            <div class="">
                <button type="submit" class="btn" style="width: 90px">Send</button>
            </div>
        </form>
    </div>

    
</body>
</html>