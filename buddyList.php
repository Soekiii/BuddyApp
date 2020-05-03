<?php
include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__."/classes/Message.php");
include_once(__DIR__."/classes/User.php");
include_once(__DIR__ . "/classes/Buddy.php");

//Hier worden de buddies getoond.


//Checken welke userid nu aangelogd is.

//voor de namen van de gebruiker
$user = new User();

//alle buddys uit de lijst halen
$buddyList = User::getAllBuddies($userID);
//var_dump($buddyList);

// aanmaken van nieuw object in klasse user
$buddyMatch = new User();
$result = $buddyMatch->whoAreBuddies();

$getUserById = new User();
$userData = $getUserById->getUserData($userID);

$checkRequest = new Buddy();
$buddyRequests = $checkRequest->checkRequest($userID);

$buddyAvailable = new Buddy();
$available = $buddyAvailable->buddyAvailable($userID);

// USER ACCEPTED BUDDY REQUEST
if (isset($_POST['accept'])) {
    $accept = new Buddy();
    $accept->setUserID($userID);
    $buddyID = $_POST['buddyID'];
    $accept->setBuddyID($buddyID);
    $acceptRequest = $accept->acceptRequest($userID, $buddyID);
    //refresh the page to empty the friend request list (user already has a buddy and cannot accept more)
    header('Location: buddyList.php');
}

if (isset($_POST['reject'])) {
    $reject = new Buddy();
    $reject->setUserID($userID);
    $buddyID = $_POST['buddyID'];
    $reject->setBuddyID($buddyID);
    $rejectMsg = $_POST['rejectMsg'];
    $reject->setRejectMsg($rejectMsg);
    $rejectRequest = $reject->rejectRequest($userID, $buddyID, $rejectMsg);
    header('Location:buddyList.php');
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">

<!-- BUDDY REQUESTS-->
<h3 class="my-4"><?php echo $userData['firstname'] . " " . $userData['lastname']; ?></h3>
<div class="row my-row">

<?php
// if user has no buddy yet --> user can still accept requests
    // if user has no buddy yet --> user is still available
    if($available == "0"){
        foreach ($buddyRequests as $buddyRequest) : ?>
       
            <?php
            if ($buddyRequest['status'] == 0) { ?>
                <div class="col-md-3 my-col">
                    <div class="form-group">
                    <div class="bold"><?php echo $buddyRequest['firstname'] . " " . $buddyRequest['lastname']; ?></div><p>Heeft je een buddy request gestuurd.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="buddyID" id="" value="<?php echo $buddyRequest['userID'] ?>">
                        <input type="submit" name="accept" id="" value="Accepteer">
                        <input type="submit" name="reject" id="" value="Weiger">
                    </form>
                </div>
                </div>
            <?php
            }
            ?>
        <?php endforeach;
        } else {
        foreach($buddyRequests as $buddyRequest) : ?>
            <?php
            if($buddyRequest['status'] == 1){ ?>
                <div class="col-md-3 my-col">
                    <div class="form-group">
                    <a href="users.php?id=<?php echo $buddyRequest['userID']?>"><?php echo $buddyRequest['firstname'] . " " . $buddyRequest['lastname'] ?></a> <?php echo "'s buddy"; ?>
                    </div>
                </div>
            <?php } ?>
            
        

        <?php endforeach; } ?>
       
</div>
<!-- AL DE BUDDY's -->
<div class="row my-row">
    <div class="col-md-8 my-col">
    <div class="form-group">
<h3 class="mb-4">Wij zijn buddies!</h3>

<?php foreach($result as $afdruk): ?>
    <div class="row my-row">
    <div class="col my-col">
    <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
        <div><img width="50px"src="avatars/<?php echo $afdruk["avatar1"]?>">
        <?php echo $afdruk["firstnameBuddy1"]." ".$afdruk["lastnameBuddy1"]?></div>
        <div class="d-flex align-items-center"><p class="bold">Buddy met</p></div>
        <div><?php echo $afdruk["firstnameBuddy2"]." ".$afdruk["lastnameBuddy2"]?><img width="50px" src="avatars/<?php echo $afdruk["avatar2"]?>"></div>
        </div>
    </div>
    </div>
    </div>
    </div>
  <?php endforeach ?>
        </div>
    </div>

    

<!-- JOUW BUDDY -->
<div class="col-md-4 my-col">
            <div class="form-group">
<h3 class="mb-4">Chat met je buddy: </h3>
<?php foreach($buddyList as $buddy): ?>
    <div class="row my-row">
        <div class="col my-col">
    <div><!-- IF userID is in buddy1 tabel, moet die buddy uit buddy2 tabel echo'en-->
        <?php if ($userID == $buddy['buddy1ID']): ?>
            <div class="bold">Chat met <?php echo $buddy["buddy2ID"]; ?></div>
            <form action="buddyChat.php" method="POST">
                <input type="hidden" name="recipientID" id="" value="<?php echo $buddy["buddy2ID"];?>">
                <div class="">
                    <button type="submit" class="btn btn-primary mt-4">Chat nu</button>
                </div>
            </form>
        <!-- IF userID is in buddy2 tabel, moet die buddy uit buddy1 tabel echo'en-->
        <?php elseif ($userID == $buddy['buddy2ID']): ?>
            <div class="bold">Chat met <?php echo $buddy["buddy1ID"]; ?></div>
            <form action="buddyChat.php" method="POST">
                <input type="hidden" name="recipientID" id="" value="<?php echo $buddy["buddy1ID"];?>">
                <div class="">
                    <button type="submit" class="btn" class="btn btn-primary mt-4">Chat nu</button>
                </div>
            </form>
        <?php endif;?>
    </div>
                            </div>
    </div>
<?php endforeach;?>

</div>
</div>
</div>
    </div> <!-- row -->
    
</div> <!-- container -->

</body>
</html>