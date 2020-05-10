<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/EditProfile.php");

//echo $userID;

// if submitted form is not empty
if (!empty($_POST)) {
    $email = $_POST['newEmail'];
    $password = $_POST['password'];

    $verifyUser = new EditProfile();
    $verifyUser->setUserID($userID);
    $verifyUser->setPassword($password);
    $verified = $verifyUser->verifyUser($userID, $password);

        if ($verified == 1) {
            $changeEmail = new EditProfile();
            $changeEmail->setUserID($userID);
            $changeEmail->setEmail($email);
            $email = $changeEmail->editEmail($userID, $email);
            echo "Email succesvol aangepast!";
        } else {
            echo "Het is niet gelukt je email aan te passen.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email aanpassen</title>
</head>

<body>
    <a href="editProfile.php">Ga terug</a>
    <h3>Email aanpassen</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- ==== NEW EMAIL ==== -->
        <div>
            <label for="newEmail">Nieuwe email</label>
            <input type="text" id="newEmail" name="newEmail">
        </div>

        <!-- ==== PASSWORD ==== -->
        <div>
            <label for="verifyPassword"> Geef je paswoord in</label>
            <input type="password" name="password" id="password">
        </div>

        <!-- ==== SUBMIT ==== -->
        <div>
            <input type="submit" value="Submit" name="submit">
        </div>
    </form>
</body>

</html>