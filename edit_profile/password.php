<?php
    session_start();
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
    }

    include_once (__DIR__ . "\..\classes\User.php");
    
    $userArray = $_SESSION['user_id'];
    $userID = implode(" ",$userArray);
            //echo $userID;
    
    function verifyUser($userID, $currentPassword){
        // SET UP CONNECTION AND VERIFY PASSWORD USING userID
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM user WHERE userID = :userID');
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if(password_verify($currentPassword, $result['password'])){
            return true;
        } else {
            return false;
        }
    }    

    if(!empty($_POST)){
        $changePassword = new User();
        $newPassword = htmlspecialchars($_POST['newPassword']);
        $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
        $currentPassword = htmlspecialchars($_POST['currentPassword']);

        if(!empty($newPassword) && !empty($confirmPassword) && !empty($currentPassword)){
            if($newPassword === $confirmPassword){
                if(verifyUser($userID, $currentPassword)){
                    $conn = Db::getConnection();
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ["cost" => 12]);
                    $changePassword = $conn->prepare("UPDATE user SET password = '$hashedPassword' WHERE userID = '$userID'");
                    $changePassword->execute();
                    echo "Password changed successfully!";
                } else {
                    echo "Current password is incorrect.";
                }
            } else {
                echo "Failed to change password. New password and its confirmation don't match.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
</head>
<body>
    <a href="../edit_profile.php">Go back</a>
    <h3>Change password</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- ==== NEW PASSWORD ==== -->
    <div>
        <label for="newPassword">New password</label>
        <input type="password" name="newPassword" id="newPassword">
    </div>

    <!-- ==== CONFIRM NEW PASSWORD ==== -->
    <div>
        <label for="confirmPassword">Confirm new password</label>
        <input type="password" name="confirmPassword" id="confirmPassword">
    </div>

    <!-- ==== CURRENT PASSWORD ==== -->
    <div>
        <label for="currentPassword">Current password</label>
        <input type="password" name="currentPassword" id="currentPassword">
    </div>

    <!-- ==== SUBMIT ==== -->
    <div>
        <input type="submit" value="Submit" name="submit">
    </div>
    </form>
</body>
</html>