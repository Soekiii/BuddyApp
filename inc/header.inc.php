<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
} else {
  $userID = $_SESSION['user_id'];
}

include_once(__DIR__ . "/../classes/Buddy.php");

$countRequest = new Buddy();
$total = $countRequest->countRequest($userID);

$buddyAvailable = new Buddy();
$available = $buddyAvailable->buddyAvailable($userID);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/c361bab050.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-expand-sm" style="background-color: #1a27c9;">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand" style="color: #fff;"><img src="avatars/Logophp_final_wit.svg" width="30%"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <i class="fas fa-bars" style="color:#fff; font-size:24px;"></i>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" style="color: #fff;" href="index.php">Home</a>
          </li>
          <li class="nav-item">
<a class="nav-link" style="color: #fff;" href="buddyList.php">Buddies <?php if($available == 1){ $notifs = implode(" ", $total); if ($notifs > 0) { ?> <span class="badge badge-danger"><?php echo implode(" ", $total) ?></span> <?php } else {} } else {}; ?> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color: #fff;" href="faq.php">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color: #fff" ; href="editProfile.php">Instellingen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color: #fff;" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>