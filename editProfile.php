<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");

$getUserById = new User();
$userData = $getUserById->getUserData($userID);
// BIO
if (!empty($_POST)) {
    if(isset($_POST['bio'])){ 
    $changeBio = new User();

    $newBio = htmlspecialchars($_POST['bio']);

    if (!empty($newBio)) {
        $conn = Db::getConnection();
        $changeBio = $conn->prepare("UPDATE user SET bio = '$newBio' WHERE userID = '$userID'");
        $changeBio->execute();
        $result = "Bio added!";
    } else {
        $result = "Please write a bio.";
    }
}
}
// EMAIL
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
if (!empty($_POST['email-form'])) {
if(isset($_POST['email'])){ 
    
    
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
}
// PASSWORD

if (!empty($_POST['paswoord-form'])) {
    if(isset($_POST['paswoord'])){ 
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
                echo "Password changed successfully!";
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "Failed to change password. New password and its confirmation don't match.";
        }
    }
    }
}

//update user met ben ik buddy of zoek ik buddy
if (!empty($_POST)) {
    if(isset($_POST['aanpassen'])){ 
    $user = new User();
    $user->setBuddy($_POST['buddy']);
    $user->setUserBuddy($userID);
    $user->updateUserBuddy();
}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Edit Profile | Amigo</title>
</head>

<body>
    <div class="container">
        <div class="row profile mt-4">
            <div class="col-md-3 ">
                <div class="card text-center">
                    <div class="card-body">
                        <!-- SIDEBAR USERPIC -->
                        
                        <img class="img-fluid" src="avatars/<?php echo $userData["avatar"]?>">
                       
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="bold m-4">
                        <?php echo $userData['firstname'] . " " . $userData['lastname']; ?>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR MENU -->

                        <!--<div class="mb-4"><a href="index.php">Cancel</a></div>-->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-4"><button type="submit" class="" name="profiel">Profielfoto aanpassen</button></div>
                        <div class="mb-4"><button type="submit" class="" name="bio">Edit bio</button></div>
                        <div class="mb-4"><button type="submit" class="" name="email">Verander email</button></div>
                        <div class="mb-4"><button type="submit" class="" name="paswoord">Verander password</button></div>
                        

                        
                            <div class="radio">
                                <input type="radio" id="seekBuddy" name="buddy" checked value="0">
                                <label> Ik zoek een buddy </label>
                            </div>

                            <div class="radio">
                                <input type="radio" id="iAmBuddy" name="buddy" value="1">
                                <label> Ik ben een buddy </label>
                            </div>

                            <button type="submit" class="btn" style="width: 150px" id="aanpassen" name="aanpassen">aanpassen</button>
                        </form>

                        <!-- END MENU -->
                        <!-- END MENU -->
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body ">
                    
                    <?php if(empty($_POST)){
                        echo $userData['bio'];
                        } ?>
                        <!-- ==== PROFIELFOTO OUTPUT ==== -->
                        <?php if(isset($_POST['profiel'])){ ?>
                        <h3>Profielfoto aanpassen</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="avatar">Select a file: </label>
                                <input type="file" name="avatar" id="avatar">
                            </div>

                            <div>
                                <input type="submit" value="Submit" name="submit" id="submit">
                            </div>
                        </form>
                        <?php } ?>
                        <!-- ==== BIO OUTPUT ==== -->
                        <?php if(isset($_POST['bio'])){ ?>
                        <h3>Pas u bio aan</h3>
                        <?php if (isset($result)) : ?>
                            <div class="result"><?php echo $result; ?></div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <!-- ==== BIO TEXT FIELD ==== -->
                            <div>
                                <textarea name="bio" id="" cols="30" rows="10" placeholder="Keep it short ;)"></textarea>
                            </div>

                            <!-- ==== SUBMIT ==== -->
                            <div>
                                <input type="submit" value="Submit" name="submit">
                            </div>
                        </form>
                        <?php } ?>
                        <!-- ==== EMAIL OUTPUT ==== -->
                        <?php if(isset($_POST['email'])){ ?>
                        <h3>Verander email</h3>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="email-form">
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
                        <?php } ?>
                        <!-- ==== PASSWORD OUTPUT ==== -->
                        <?php if(isset($_POST['paswoord'])){ ?>
                        <h3>Verander password</h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="paswoord-form">
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
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>