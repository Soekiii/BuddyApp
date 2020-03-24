<?php 
session_start();
if (empty($_SESSION['email'])) {
    header('Location: login.php');
}
include_once (__DIR__ . "/classes/User.php");

        if(isset($_POST['submit-search'])){
            $search = htmlspecialchars('search');
            $searchResult = User::userSearch($search);
            //echo var_dump($search);
            // als de array gelijk is aan NULL of O dan geeft die error weer
            if($searchResult == NULL || $searchResult == 0){
                $error = "geen zoekresultaten gevonden.";
            } else {
                $result = "Zoekresultaat";
        }

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
    <button type="submit" name="submit-search">Search</button>
    <!-- search error -->
    <?php if(isset($error)): ?>
        <div class="error" style="color: red"><?php echo $error; ?></div>
    <?php endif; ?>
    </form>

    <!-- zoekresultaten uitlezen-->
    <div class="result-container">
    </div>
    <a href="logout.php" class="link">logout <?php echo $_SESSION['email'] ?></a>
</body>
</html>