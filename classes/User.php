<?php
include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Hobby.php");
class User
{
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $buddy;
    private $userBuddy;


    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;


        //return $this;
    }

    /**
     * Get the value of password
     */
    public function getFirstname()
    {
        return $this->firstName;
    }


    /**
     *Set the value of firstname
     *  @return  self
     */
    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     *Set the value of lastName
     *  @return  self
     */
    public function setLastname($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    //get en set buddyCheckbox
    public function getBuddy()
    {
        return $this->buddy;
    }

    public function setBuddy($buddy)
    {
        $this->buddy = $buddy;
    }

    public function getUserBuddy()
    {
        return $this->userBuddy;
    }

    public function setUserBuddy($userBuddy)
    {
        $this->userBuddy = $userBuddy;
    }




    public function canILogin()
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare('select * from user where email = :email');
        $email = $this->getEmail();
        $password = $this->getPassword();
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $result['password'])) {
            return true;
        } else {
            return false;
        }
    }
    // vraag userId op via de persoon zijn email
    public function getUserId()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare('select userID from user where email = :email');
        $email = $this->getEmail();
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function userSearch($search, $email)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("select * from user where firstname or lastname like :search and email != :email");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':search', '%' . $search . '%');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function registerNewUser()
    {
        $conn = Db::getConnection();

        //Hash the password  

        $this->password = password_hash($this->password, PASSWORD_BCRYPT, ["cost" => 12]);

        //Registratie in database
        $statement = $conn->prepare("INSERT INTO user (firstname, lastname, email, password, buddy, avatar) values (:firstname, :lastname, :email, :password, :buddy, :avatar)");
        $statement->bindValue(":firstname", $this->firstName);
        $statement->bindValue(":lastname", $this->lastName);
        $statement->bindValue(":email", $this->email);
        $statement->bindValue(":password", $this->password);
        $statement->bindValue(":buddy", $this->buddy);
        $statement->bindValue(":avatar", "default.png");

        $result = $statement->execute();

        return $result;
    }

    //database statement om aan te passen of je buddy bent of een buddy zoekt
    public function updateUserBuddy()
    {

        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE user SET buddy='$this->buddy' WHERE userID = '$this->userBuddy'");
        $result = $statement->execute();
        return $result;
    }

    public function calcMatch()
    {
        $userArray = $_SESSION['user_id'];
        $userID = implode(" ", $userArray);

        $conn = Db::getConnection();
        $statementUser = $conn->prepare('SELECT * FROM hobby WHERE userID = :userID');
        $statementUser->bindValue(':userID', $userID);
        $statementUser->execute();
        $hobbyUser = $statementUser->fetch(PDO::FETCH_ASSOC);

        $statementOthers = $conn->prepare('SELECT * FROM hobby WHERE userID != :userID');
        $statementOthers->bindValue(':userID', $userID);
        $statementOthers->execute();
        $hobbyOthers = $statementOthers->fetchAll(PDO::FETCH_ASSOC);

        $statementName = $conn->prepare('SELECT * FROM user WHERE userID != :userID');
        $statementName->bindValue(':userID', $userID);
        $statementName->execute();
        $hobbyName = $statementName->fetchAll(PDO::FETCH_ASSOC);

        foreach ($hobbyOthers as $hobbyOther) {
            $scores = [];
            $score = 0;

            if ($hobbyUser['game'] == $hobbyOther['game']) {
                $score += 10;
            }

            if ($hobbyUser['hobby'] == $hobbyOther['hobby']) {
                $score += 10;
            }

            if ($hobbyUser['film'] == $hobbyOther['film']) {
                $score += 10;
            }

            if ($hobbyUser['muziek'] == $hobbyOther['muziek']) {
                $score += 10;
            }

            if ($hobbyUser['locatie'] == $hobbyOther['locatie']) {
                $score += 10;
            }

            $hobbyOtherString = implode(" ", $hobbyOther);

            $scores[$hobbyOtherString] = $score;

            echo "USERID " . $hobbyOther['userID'] . " HAS A MATCH SCORE OF ". $score . "    ||||    ";
        }

        return $scores;
        return $hobbyOthers;
        return $hobbyUser;
    }
}
