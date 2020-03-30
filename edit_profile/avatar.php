<?php
    session_start();    
    if(empty($_SESSION['user_id'])){
        header('Location: login.php');
    }

    include_once (__DIR__ . "/../classes/User.php");

    $userArray = $_SESSION['user_id'];
    $userID = implode(" ", $userArray);

    if(!empty($_POST['submit'])){
        $uploadAvatar = new User();
        // store name of avatar (files with the same name will cause conflict -> solve by adding timestamp)
        $avatar = time() . ' ' . $_FILES['avatar']['name'];
        $target = '../avatars/' . $avatar;

        $imgSize = $_FILES['avatar']['size'];
        $imgType =  array (
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/gif'
                    );
        
        if($imgSize < 3000000){
            if(in_array($_FILES['avatar']['type'], $imgType)){
        // move avatar from temporary storage to target folder = "avatars"
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)){
                    $conn = Db::getConnection();
                    $uploadAvatar = $conn->prepare("UPDATE user SET avatar = '$avatar' WHERE userID = '$userID'");
                    $uploadAvatar->execute();
                    echo "Avatar successfully uploaded!";
                } else {}
            } else { echo "Only .jpg, .jpeg, .png and .gif images allowed.";}
        } else {
            echo "File size is too large";
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
    <a href="../edit_profile.php">Go back</a>

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