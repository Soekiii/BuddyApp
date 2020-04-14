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
if(isset($_POST['accept'])){
    $accept = new Buddy();
    $accept->setUserID($userID);
    $buddyID = $_POST['buddyID'];
    $accept->setBuddyID($buddyID);
    $acceptRequest = $accept->acceptRequest($userID, $buddyID);
    //refresh the page to empty the friend request list (user already has a buddy and cannot accept more)
    header('Location: profile.php');
}

if(isset($_POST['reject'])){
    $reject = new Buddy();
    $reject->setUserID($userID);
    $buddyID = $_POST['buddyID'];
    $reject->setBuddyID($buddyID);
    $rejectMsg = $_POST['rejectMsg'];
    $reject->setRejectMsg($rejectMsg);
    $rejectRequest = $reject->rejectRequest($userID, $buddyID, $rejectMsg);
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
    <?php
    // if user has no buddy yet --> user can still accept requests
    if($available == "0" || $available == "3"){
    foreach ($buddyRequests as $buddyRequest) : ?>
        <?php
        // status=0 --> buddy needs to be accepted/rejected
        if ($buddyRequest['status'] == 0) { ?>
            <div class="notifs">
                <?php echo $buddyRequest['firstname'] . " " . $buddyRequest['lastname']; ?> heeft je een buddy request gestuurd.
                <form action="" method="post">
                    <div class="request">
                        <input type="hidden" name="buddyID" id="" value="<?php echo $buddyRequest['userID'] ?>">
                        <input type="submit" name="accept" id="accept" value="Accepteer">
                        <input type="text" name="rejectMsg" id="msg" placeholder="Reden weigering?">
                        <input type="submit" name="reject" value="Weiger">
                    </div>
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
                <a href="users.php?id=<?php echo $buddyRequest['userID'] ?>"><?php echo $buddyRequest['firstname'] . " " . $buddyRequest['lastname'] ?></a> <?php echo "'s buddy"; ?>
            </div>
        <?php } ?>
    <?php endforeach;} ?>

    
    <script>
        // if user rejects request, display the text area
        function showTextarea(){
            document.getElementById("rejectMsg").style.display = "block";
            console.log("click");
        }
    </script>
</body>

</html>