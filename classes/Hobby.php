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
        return $this->muziek;
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
            $userID = $this->getUserID();
            $conn = Db::getConnection();
            //$statement = $conn->prepare("select * from hobby where userID = '".$userID."'");
            $statement = $conn->prepare("select hobby,film,muziek,locatie,game from hobby where userID = :ID ");
            $statement->bindParam(':ID', $userID);
            $statement->execute();
            $aantal = $statement->fetchAll(PDO::FETCH_ASSOC); //
            //$aantal = $statement->fetchColumn();
            //$aantal = $statement->num_rows;
            //return $aantal;
            //return $userID;
            //return $aantal;
            
            
            
           if(count($aantal) == 5){
                header('Location: hobby.php');
           }
        }catch(throwable $e){
           $error = "Something went wrong";
       }
    }

    //Locatie van eigenschappen weer te geven
    public function hobbyInvullen(){
            $conn = Db::getConnection();

            //$statement = $conn->prepare("insert into hobby(locatie,hobby,game,film,muziek,userID) values(:locatie,:hobby,:game,:film,:muziek,'".$userID."')");
            $statement = $conn->prepare("insert into hobby(locatie,hobby,game,film,muziek,userID) values(:locatie,:hobby,:game,:film,:muziek,:userID)");
            $statement->bindParam(':locatie', $this->locatie);
            $statement->bindParam(':hobby', $this->hobby);
            $statement->bindParam(':game', $this->game);
            $statement->bindParam(':film', $this->film);
            $statement->bindParam(':muziek', $this->muziek);
            $statement->bindParam(':userID', $this->userID);
            $result = $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;

    }

    // geeft eigenschappen van gebruiker
    public static function getEigenschappen($userID){
        $conn = Db::getConnection();

        $statement = $conn->prepare("select * from hobby 
        INNER JOIN user ON hobby.userID = user.userID and user.userID = :userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public static function filterHobby($hobby, $email){
        $conn = Db::getConnection();
        $statement =$conn->prepare("select firstname,lastname,hobby,avatar from hobby, user where hobby.userID = user.userID 
        and user.email != :email and hobby like :hobby");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':hobby', '%' . $hobby . '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function filterFilm($film, $email){
        $conn = Db::getConnection();
        $statement =$conn->prepare("select firstname,lastname, film,avatar from hobby, user where hobby.userID = user.userID 
        and user.email != :email and film like :film");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':film', '%' . $film . '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function filterGame($game, $email){
        $conn = Db::getConnection();
        $statement =$conn->prepare("select firstname,lastname, game,avatar from hobby, user where hobby.userID = user.userID 
        and user.email != :email and game like :game");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':game', '%' . $game . '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function filterMuziek($muziek, $email){
        $conn = Db::getConnection();
        $statement =$conn->prepare("select firstname,lastname, muziek,avatar from hobby, user where hobby.userID = user.userID 
        and user.email != :email and muziek like :muziek");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':muziek', '%' . $muziek . '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function filterLocatie($locatie, $email){
        $conn = Db::getConnection();
        $statement =$conn->prepare("select firstname,lastname, locatie,avatar from hobby, user where hobby.userID = user.userID 
        and user.email != :email and locatie like :locatie");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':locatie', '%' . $locatie . '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    


}
?>