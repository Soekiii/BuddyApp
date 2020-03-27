<?php 
include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/User.php");

class Hobby {
    private $hobby;
    
    //getter setter Hobby
    public function getHobby(){
        return $this->hobby;
    }

    public function setHobby($hobby){
        $this->hobby = $hobby;

        return $this;
    }


    // tellen of er 5 eigenschappen in zitten
    public function countHobbies($userID){
        try{
            $conn = Db::getConnection();

            $statement = $conn->prepare("select * from hobby where userID = '".$userID."'");
            $statement->execute();
            $aantal = $statement->fetchAll(PDO::FETCH_ASSOC);
            //$aantal = $statement->fetchColumn();
            //$aantal = $statement->num_rows;
            //$aantal->execute();
            if(count($aantal) >= 5){
                return true;
            }
            else{
                return false;
            }
        }
        catch(throwable $e){
            $error = "Something went wrong";
        }
    }

    //Locatie van eigenschappen weer te geven
    public function hobbyInvullen($userID){
        try{
            $conn = Db::getConnection();

            $statement = $conn->prepare("insert into hobby(hobby,userID) values(:hobby,'".$userID."')");
            $statement->bindParam(':hobbie', $this->hobby);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;

        }
        catch(throwable $t){
            echo "Something went wrong";
        }
    }

    
}
?>