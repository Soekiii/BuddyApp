<?php 
//queryprobeersels
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
}
include_once(__DIR__."/inc/header.inc.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Validate.php");
include_once(__DIR__ . "/classes/Db.php");

$conn = Db::getConnection();

$statement = $conn->prepare("
SELECT 
u1.firstname as firstnameBuddy1, 
u1.lastname as lastnameBuddy1,
u1.avatar as avatar1,
u2.firstname as firstnameBuddy2, 
u2.lastname as lastnameBuddy2, 
u2.avatar as avatar2
FROM 
buddies as b, user u1, user u2
WHERE
u1.userID = b.buddy1ID AND
u2.userID = b.buddy2ID
");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Wij zijn buddies!</title>
</head>
<body>
<h2>Wij zijn buddies!</h2>

<ul id="buddies" class="list-group">
<?php foreach($result as $afdruk): ?>
  <li class="list-group-item"><img src="<?php echo $afdruk["avatar1"]?>"><?php echo $afdruk["firstnameBuddy1"]." ".$afdruk["lastnameBuddy1"]." buddy met ".$afdruk["firstnameBuddy2"]." ".$afdruk["lastnameBuddy2"]?><img src="<?php echo $afdruk["avatar2"]?>"></li>
  <?php endforeach ?>
</ul>
    
</body>
</html>