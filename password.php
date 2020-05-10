<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/EditProfile.php");


if (!empty($_POST)) {
    $password = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $verifyUser = new EditProfile();
    $verifyUser->setUserID($userID);
    $verifyUser->setPassword($password);
    $verified = $verifyUser->verifyUser($userID, $password);

    if ($newPassword === $confirmPassword) {
        if ($verified == 1) {
            $changePassword = new EditProfile();
            $changePassword->setUserID($userID);
            $changePassword->setNewPassword($newPassword);
            $password = $changePassword->editPassword($userID, $newPassword);
            echo "Paswoord is succesvol aangepast!";
        } else {
            echo "Huidig paswoord is niet correct.";
        }
    } else {
        echo "Het is niet gelukt je paswoord aan te passen. Beide paswoorden komen niet overeen!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paswoord aanpassen</title>
</head>

<body>
    <a href="editProfile.php">Go back</a>
    <h3>Paswoord aanpassen</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- ==== NEW PASSWORD ==== -->
        <div>
            <label for="newPassword">Nieuw paswoord</label>
            <input type="password" name="newPassword" id="newPassword">
        </div>

        <!-- ==== CONFIRM NEW PASSWORD ==== -->
        <div>
            <label for="confirmPassword">Bevestig nieuw paswoord</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
        </div>

        <!-- ==== CURRENT PASSWORD ==== -->
        <div>
            <label for="currentPassword">Huidig paswoord</label>
            <input type="password" name="currentPassword" id="currentPassword">
        </div>

        <!-- ==== SUBMIT ==== -->
        <div>
            <input type="submit" value="Submit" name="submit">
        </div>
    </form>
</body>

</html>