<?php 
    session_start();
    include_once(__DIR__ . "/../classes/Db.php");
    if(!empty($_POST["email"])){
        $conn = Db::getConnection();
        $statement = $conn->prepare("select * from user where email = :email");
        $statement->bindValue(":email", $_POST["email"]);
        $statement->execute();
        $count = $statement->rowCount();
        if($count > 0){
            echo "<span class='status-not-available' style='color:red;'> email al in gebruik </span>";
        } else {
            echo  "<span class='status-not-available' style='color:green;'> email nog niet gebruikt </span>";
        }
       
    }