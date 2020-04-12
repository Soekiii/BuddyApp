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

$status = new Buddy();
$statusRequests = $status->checkRequest($userID);
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

    <?php foreach ($statusRequests as $statusRequest) : ?>
        <?php
        if ($statusRequest['status'] == 0) { ?>
            <div class="notifs">
                <?php echo $statusRequest['firstname'] . " " . $statusRequest['lastname']; ?> heeft je een buddy request gestuurd.
                <form action="" method="post">
                    <input type="submit" name="accept" id="" value="Accepteer">
                    <input type="submit" name="reject" id="" value="Weiger">
                </form>
            </div>
        <?php } ?>
    <?php endforeach; ?>
</body>

</html>