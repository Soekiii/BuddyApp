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

$checkRequest = new Buddy();
$buddyRequests = $checkRequest->checkRequest($userID);

$buddyAvailable = new Buddy();
$available = $buddyAvailable->buddyAvailable($userID);

// USER ACCEPTED BUDDY REQUEST
if(!empty($_POST['accept'])){
    $accept = new Buddy();
    $accept->setUserID($userID);
    $buddyID = $_POST['buddyID'];
    $accept->setBuddyID($buddyID);
    $acceptRequest = $accept->acceptRequest($userID, $buddyID);
    //refresh the page to empty the friend request list (user already has a buddy and cannot accept more)
    header('Location: profile.php');
}

// USER REJECTED BUDDY REQUEST
if(!empty($_POST['reject'])){
    $reject = new Buddy();
    $reject->setUserID($userID);
    $buddyID = $_POST['buddyID'];
    $reject->setBuddyID($buddyID);
    $rejectRequest = $reject->rejectRequest($userID, $buddyID, $rejectMsg);
    //refresh the page to remove request from list (request does not exist in db)
    header('Location:profile.php');
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
    <div class="link">
        <a href="/editProfile.php">Instellingen</a>
    </div>

    <?php
    // if user has no buddy yet --> user is still available
    if($available == "0"){
    foreach ($buddyRequests as $buddyRequest) : ?>
        <?php
        if ($buddyRequest['status'] == 0) { ?>
            <div class="notifs">
                <?php echo $buddyRequest['firstname'] . " " . $buddyRequest['lastname']; ?> heeft je een buddy request gestuurd.
                <form action="" method="post">
                    <input type="hidden" name="buddyID" id="" value="<?php echo $buddyRequest['userID'] ?>">
                    <input type="submit" name="accept" id="" value="Accepteer">
                    <input type="submit" name="reject" id="" value="Weiger">
                </form>
            </div>
        <?php
        }
        ?>
    <?php endforeach;
    } else {
    foreach($buddyRequests as $buddyRequest) : ?>
        <?php
        if($buddyRequest['status'] == 1){ ?>
            <div class="buddy">
                <?php echo $buddyRequest['firstname'] . " " . $buddyRequest['lastname'] . "'s buddy"; ?>
            </div>
        <?php } ?>
    <?php endforeach; } ?>
</body>

</html>