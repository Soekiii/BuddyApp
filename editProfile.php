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
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">

                </div>
    
                <div><a href="index.php">Cancel</a></div>
    <div class="avatar"><a href="avatar.php">Upload avatar</a></div>
    <div class="bio"><a href="bio.php">Edit bio</a></div>
    <div class="email"><a href="email.php">Change email</a></div>
    <div class="password"><a href="spassword.php">Change password</a></div>


    <form action="edit_profile.php" method="post" style="width: 366px">
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

</body>

</html>