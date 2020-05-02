<?php 
    session_start();
    include_once(__DIR__ . "/../classes/Db.php");
    if(isset($_POST["email"])){
        $conn = Db::getConnection();
        $statement = $conn->prepare("select * from user where email = '".$_POST["email"] ."'");
        $statement->execute();
        $count = $statement->rowCount();
        $result = "";
        if($count){
            $result = 'email al in gebruik';
        } else {
            $result =  'email nog niet gebruikt';
        }
        return $result;
    }