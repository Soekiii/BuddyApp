<?php
include_once(__DIR__ . "/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");

if (!empty($_POST)) {
    $changeBio = new User();

    $newBio = htmlspecialchars($_POST['bio']);

    if (!empty($newBio)) {
        $conn = Db::getConnection();
        $changeBio = $conn->prepare("UPDATE user SET bio = '$newBio' WHERE userID = '$userID'");
        $changeBio->execute();
        echo "Bio toegevoegd!";
    } else {
        echo "Schrijf een korte bio van jezelf!";
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
    <a href="editProfile.php">Go back</a>

    <h3>Add a bio</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- ==== BIO TEXT FIELD ==== -->
        <div>
            <textarea name="bio" id="" cols="30" rows="10" placeholder="Hou het kort ;)"></textarea>
        </div>

        <!-- ==== SUBMIT ==== -->
        <div>
            <input type="submit" value="Submit" name="submit">
        </div>
</body>

</html>