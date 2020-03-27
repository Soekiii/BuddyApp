<?php 
include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/User.php");

class Hobby {
    private $hobby;
    private $locatie;
    private $film;
    private $game;
    private $muziek;
    private $userID;
    
    //getter setter Hobby
    public function getHobby(){
        return $this->hobby;
    }

    public function setHobby($hobby){
        $this->hobby = $hobby;

        return $this;
    }

    //getter setter locatie
    public function getLocatie(){
        return $this->locatie;
    }

    public function setLocatie($locatie){
        $this->locatie = $locatie;

        return $this;
    }

    //getter setter film
    public function getFilm(){
        return $this->film;
    }

    public function setFilm($film){
        $this->film = $film;

        return $this;
    }

    //getter setter game
    public function getGame(){
        return $this->game;
    }

    public function setGame($game){
        $this->game = $game;

        return $this;
    }

    //getter setter muziek
    public function getMuziek(){
        return $this->locatie;
    }

    public function setMuziek($muziek){
        $this->muziek = $muziek;

        return $this;
    }

    //getter setter userID
    public function getUserID(){
        return $this->userID;
    }

    public function setUserID($userID){
        $this->userID = $userID;

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
           // if(count($aantal) = 5){
            //    return true;
            //}
           // else{
            //    return false;
            //}
        }
        catch(throwable $e){
            $error = "Something went wrong";
        }
    }

    //Locatie van eigenschappen weer te geven
    public function hobbyInvullen(){
            $conn = Db::getConnection();

            //$statement = $conn->prepare("insert into hobby(locatie,hobby,game,film,muziek,userID) values(:locatie,:hobby,:game,:film,:muziek,'".$userID."')");
            $statement = $conn->prepare("insert into hobby(locatie,hobby,game,film,muziek,userID) values(:locatie,:hobby,:game,:film,:muziek,:userID)");
            $statement->bindParam(':locatie', $locatie);
            $statement->bindParam(':hobby', $hobby);
            $statement->bindParam(':game', $game);
            $statement->bindParam(':film', $film);
            $statement->bindParam(':muziek', $muziek);
            $statement->bindParam(':userID', $userID);
            $result = $statement->execute();
            
            return $result;

    }

    
}
?>