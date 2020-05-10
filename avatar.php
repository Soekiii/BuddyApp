<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/EditProfile.php");


if (!empty($_POST['submit'])) {
    $uploadAvatar = new User();
    // store name of avatar (files with the same name will cause conflict -> solve by adding timestamp)
    $avatar = time() . ' ' . $_FILES['avatar']['name'];
    $target = 'avatars/' . $avatar;

    $imgSize = $_FILES['avatar']['size'];
    $imgType =  array(
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif'
    );

    if ($imgSize < 3000000) {
        if (in_array($_FILES['avatar']['type'], $imgType)) {
            // move avatar from temporary storage to target folder = "avatars"
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
                $changeAvatar = new EditProfile();
                $changeAvatar->setUserID($userID);
                $changeAvatar->setAvatar($avatar);
                $avatar = $changeAvatar->editAvatar($userID, $avatar);
                echo "Je avatar werd succesvol opgeladen!";
            } else {
            }
        } else {
            echo "Alleen .jpg, .jpeg, .png and .gif afbeeldingen zijn toegestaan.";
        }
    } else {
        echo "Je afbeelding is te groot";
    }
}
?>

<! DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change avatar</title>
    </head>

    <body>
        <a href="editProfile.php">Go back</a>

        <h3>Change avatar</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div>
                <label for="avatar">Select a file: </label>
                <input type="file" name="avatar" id="avatar">
            </div>

            <div>
                <input type="submit" value="Submit" name="submit" id="submit">
            </div>
        </form>
    </body>

    </html>