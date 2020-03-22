<?php 
session_start();
if (empty($_SESSION['email'])) {
    header('Location: login.php');
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Amigos</title>
</head>
<body>
<a href="logout.php" class="link">logout <?php echo $_SESSION['email'] ?></a>
</body>
</html>