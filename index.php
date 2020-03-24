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
    <!-- search form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="text" name="search" placeholder="search">
    </form>

    <!-- zoekresultaten uitlezen-->
    <div class="result-container">
    </div>
    <a href="logout.php" class="link">logout <?php echo $_SESSION['email'] ?></a>
</body>
</html>