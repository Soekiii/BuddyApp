<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");

//echo $userID;

function verifyUser($userID, $password)
{
    // SET UP CONNECTION AND VERIFY PASSWORD USING userID
    $conn = Db::getConnection();
    $statement = $conn->prepare('SELECT * FROM user WHERE userID = :userID');
    $statement->bindParam(':userID', $userID);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $result['password'])) {
        return true;
    } else {
        return false;
    }
}

// if submitted form is not empty
if (!empty($_POST)) {
    // create new instance of class User = changeEmail
    $changeEmail = new User();
    // retrieve submitted data and place in variables
    $newEmail = htmlspecialchars($_POST['newEmail']);
    $password = htmlspecialchars($_POST['password']);

    if (!empty($newEmail) && !empty($password)) {
        if (verifyUser($userID, $password)) {
            $conn = Db::getConnection();
            $changeEmail = $conn->prepare("UPDATE user SET email = '$newEmail' WHERE userID = '$userID'");
            $changeEmail->execute();
            echo "Email successfully changed!";
        } else {
            echo "Failed to change email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change email</title>
</head>

<body>
    <a href="editProfile.php">Go back</a>
    <h3>Change email</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- ==== NEW EMAIL ==== -->
        <div>
            <label for="newEmail">New email</label>
            <input type="text" id="newEmail" name="newEmail">
        </div>

        <!-- ==== PASSWORD ==== -->
        <div>
            <label for="verifyPassword">Enter password</label>
            <input type="password" name="password" id="password">
        </div>

        <!-- ==== SUBMIT ==== -->
        <div>
            <input type="submit" value="Submit" name="submit">
        </div>
    </form>
</body>

</html>