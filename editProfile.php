<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");


//update user met ben ik buddy of zoek ik buddy
if (!empty($_POST)) {
    $user = new User();
    $user->setBuddy($_POST['buddy']);
    $user->setUserBuddy($userID);
    $user->updateUserBuddy();
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
                    <div class="profile-userpic m-4">

                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle-name m-4">
                            Marcus Doe
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR MENU -->
                    
                    <div class="mb-4"><a href="index.php">Cancel</a></div>
                    <div class="mb-4"><a href="avatar.php">Upload avatar</a></div>
                    <div class="mb-4"><a href="bio.php">Edit bio</a></div>
                    <div class="mb-4"><a href="email.php">Change email</a></div>
                    <div class="mb-4"><a href="password.php">Change password</a></div>
                    

                    <form action="edit_profile.php" method="post">
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
                    Some user related content goes here...
                </div>
            </div>
        </div>
    </div>

</body>

</html>