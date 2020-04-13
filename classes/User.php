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
    private $token;
    private $active;


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
        $this->token = md5(time() . $this->email);
        //Registratie in database
        $statement = $conn->prepare("INSERT INTO user (firstname, lastname, email, password, buddy, avatar, token, active) values (:firstname, :lastname, :email, :password, :buddy, :avatar, :token, :active)");
        $statement->bindValue(":firstname", $this->firstName);
        $statement->bindValue(":lastname", $this->lastName);
        $statement->bindValue(":email", $this->email);
        $statement->bindValue(":password", $this->password);
        $statement->bindValue(":buddy", $this->buddy);
        $statement->bindValue(":token", $this->token);
        $statement->bindValue(":active", "0");
        $statement->bindValue(":avatar", "default.png");

        $result = $statement->execute();
        if($result){
            $user = $this->getUser();
            $_SESSION['userID'] = $user['userID'];
            $this->sendMail($user['email'],$user['userID'], $user['token'] );
            $_SESSION['succes'] = "Bevestig je registratie via email";
        }

        return $result;
    }
    
    public function getUser(){
        $conn = Db::getConnection();
        $statement = $conn->prepare('select * from user where email = :email');
        $statement->bindParam(':email', $this->email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function sendMail($email,$id,$token){
        $subject = "Account Activatie";
        $email = "frederichermans@hotmail.com";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <info@amigos.be>' . "\r\n";
        $message = "<html><body>";
        $message .= '<h3>' . $_SERVER['SERVER_NAME'] .'/activatie.php?active='. $token . '&id=' . $id . '</h3>';
        $message .= "</body></html>";

        mail($email,$subject,$message,$headers);
    }
    public function activate($id, $token){
        $conn = Db::getConnection();
        $statement = $conn->prepare('update user set active=1 where userID = :userID and token = :token');
        $statement->bindParam(':userID', $id);
        $statement->bindParam(':token', $token);
        $result = $statement->execute();
        if($result){
            $user = $this->getUserId();
            $_SESSION['user'] = $user;
            header("Location: index.php");
        }

        return $result;
    }

    //om al de buddies uit de database te halen
    static function getAllBuddies($currentUser)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM buddies where buddy1ID = :currentUser OR buddy2ID = :currentUser");
        //$statement = $conn->prepare("SELECT u.firstname, u.lastname* FROM buddies as b, user u 
        //WHERE (u.userID = b.buddy1ID OR u.userID = b.buddy2ID) AND (buddy1ID = :currentUser OR buddy2ID = :currentUser)");
        $statement->bindValue(":currentUser", $currentUser);
        if ($statement->execute()) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    //database statement om aan te passen of je buddy bent of een buddy zoekt
    public function updateUserBuddy()
    {

        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE user SET buddy='$this->buddy' WHERE userID = '$this->userBuddy'");
        $result = $statement->execute();
        return $result;
    }

    

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}
