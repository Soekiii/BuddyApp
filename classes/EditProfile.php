<?php
include_once(__DIR__ . "/Db.php");
include_once(__DIR__ . "/Mail.php");
include_once(__DIR__ . "/Hobby.php");
include_once(__DIR__ . "/User.php");

class EditProfile
{
    private $avatar;
    private $bio;
    private $userID;
    private $email;
    private $password;
    private $newPassword;


    public function editBio($userID, $bio)
    {
        $conn = Db::getConnection();
        $changeBio = $conn->prepare("UPDATE user SET bio = :bio WHERE userID = :userID");
        $changeBio->bindParam(':bio', $bio);
        $changeBio->bindParam(':userID', $userID);
        $changeBio->execute();
        $result = $changeBio->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function editAvatar($userID, $avatar)
    {
        $conn = Db::getConnection();
        $uploadAvatar = $conn->prepare("UPDATE user SET avatar = :avatar WHERE userID = :userID");
        $uploadAvatar->bindParam(':avatar', $avatar);
        $uploadAvatar->bindParam(':userID', $userID);
        $uploadAvatar->execute();
        $result = $uploadAvatar->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function verifyUser($userID, $password)
    {
        // SET UP CONNECTION AND VERIFY PASSWORD USING userID
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM user WHERE userID = :userID');
        $statement->bindParam(':userID', $userID);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $result['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function editEmail($userID, $email)
    {
        $conn = Db::getConnection();
        $changeEmail = $conn->prepare("UPDATE user SET email = :email WHERE userID = :userID");
        $changeEmail->bindParam(':email', $email);
        $changeEmail->bindParam(':userID', $userID);
        $changeEmail->execute();
        $result = $changeEmail->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function editPassword($userID, $newPassword){
        $conn = Db::getConnection();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ["cost" => 12]);
        $changePassword = $conn->prepare("UPDATE user SET password = :hashedPassword WHERE userID = :userID");
        $changePassword->bindParam(':hashedPassword', $hashedPassword);
        $changePassword->bindParam(':userID', $userID);
        $changePassword->execute();
    }

    /**
     * Get the value of avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of bio
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @return  self
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get the value of userID
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Set the value of userID
     *
     * @return  self
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

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

        return $this;
    }

    /**
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Set the value of newPassword
     *
     * @return  self
     */ 
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
