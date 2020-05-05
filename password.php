<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");




function verifyUser($userID, $currentPassword)
{
    // SET UP CONNECTION AND VERIFY PASSWORD USING userID
    $conn = Db::getConnection();
    $statement = $conn->prepare('SELECT * FROM user WHERE userID = :userID');
    $statement->bindParam(':userID', $userID);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($currentPassword, $result['password'])) {
        return true;
    } else {
        return false;
    }
}

if (!empty($_POST)) {
    $changePassword = new User();
    $newPassword = htmlspecialchars($_POST['newPassword']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
    $currentPassword = htmlspecialchars($_POST['currentPassword']);

    if (!empty($newPassword) && !empty($confirmPassword) && !empty($currentPassword)) {
        if ($newPassword === $confirmPassword) {
            if (verifyUser($userID, $currentPassword)) {
                $conn = Db::getConnection();
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ["cost" => 12]);
                $changePassword = $conn->prepare("UPDATE user SET password = '$hashedPassword' WHERE userID = '$userID'");
                $changePassword->execute();
                echo "Paswoord is succesvol aangepast!";
            } else {
                echo "Huidig paswoord is niet correct.";
            }
        } else {
            echo "Het is niet gelukt je paswoord aan te passen. Beide paswoorden komen niet overeen!";
        }
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