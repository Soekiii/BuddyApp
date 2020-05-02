<?php
    // IF USER NOT SIGNED IN (user_id = empty) -> redirect to login page
    session_start();    
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
    }
    
    $userID = $_SESSION['user_id'];
    include_once(__DIR__ . "/classes/User.php");

    

    if(!empty($_POST)){
        $changeBio = new User();

        $newBio = htmlspecialchars($_POST['bio']);

        if(!empty($newBio)){
            $conn = Db::getConnection();
            $changeBio = $conn->prepare("UPDATE user SET bio = '$newBio' WHERE userID = '$userID'");
            $changeBio->execute();
            echo "Bio added!";
        } else {
            echo "Please write a bio.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a bio</title>
</head>
<body>
    <a href="../editProfile.php">Go back</a>

    <h3>Add a bio</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <!-- ==== BIO TEXT FIELD ==== -->
    <div>
        <textarea name="bio" id="" cols="30" rows="10" placeholder="Keep it short ;)"></textarea>
    </div>
    
    <!-- ==== SUBMIT ==== -->
    <div>
        <input type="submit" value="Submit" name="submit">
    </div>
</body>
</html>