<?php 

class Validate {

  private $data;
  private $errors = [];
  private static $fields = ['email', 'password'];
  

  public function __construct($post_data){
    $this->data = $post_data;
  }

    /**
     * Get the value of data
     */ 
     public function getErrors()
     {
         return $this->errors;
     }

  

  public function validateForm(){

    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;

  }
  // Checht of de email leeg is of het een geldig emailadress is
  private function validateEmail(){

    $val = trim($this->data['email']);

    if(empty($val)){
      $this->addError('email', 'email mag niet leeg zijn');
    } else {
        if(!preg_match('|@student.thomasmore.be$|', $val)){
          $this->addError('email', 'email moet eindigen op @student.thomasmore.be');
        }
    }
    
  }
  // Checkt of het password leeg is
  private function validatePassword(){

    $val = trim($this->data['password']);

    if(empty($val)){
      $this->addError('password', 'passwoord mag niet leeg zijn');
    }

  }
  // Welke input veld en welke error laat ik zien
  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

 


 public function Emailvalidator(){  //kijkt na of alle velden goed zijn ingevuld & geeft error weer

  $val = trim($this->data['email']);

  if(empty($val)){
    $this->addError('email', ' leeg invullen met @student.thomasmore.be E-mailadres');
  //email leeg
  }
  if(!empty($val)){ //als hij niet leeg is dan kijken naar fouten
    
    if (!filter_var($val, FILTER_VALIDATE_EMAIL)){ //email niet correct met @ enz...
      $this->addError('email', 'Email niet correct');

    }
    else { //is niet leeg en staan geen fouten in dan kijken of mailadres student.thomasmore.be juist is
      $val = explode ("@", $val); 
      //explode = knipt email in 2 delen, waarvan we enkel het achterste deel van de email willen checken
  
      if ($val[1] != "student.thomasmore.be") {
        $this->addError('email', 'enkel toegankelijk met @student.thomasmore.be');
        }
    }

  }

  $val = trim($this->data['firstName']);
  if(empty($val)){
    $this->addError('firstName', 'Hoe heet jij alweer?');
  // voornaam:            ---> check of voornaam is ingevuld! + melding indien niet ingevuld

  }

  $val = trim($this->data['lastName']);
  if(empty($val)){
    $this->addError('lastName', 'Geef hier je achternaam?');
  // achternaam:          ---> check of achternaam is ingevuld! + melding indien niet ingevuld
  }
  $val = trim($this->data['password']);
  if(empty($val)){
    $this->addError('password', 'Geef hier je paswoord op, ik zal niet meekijken hoor :-)');
  //paswoord:            ---> check of paswoord is ingevuld! + melding indien niet ingevuld
  }
  if(strlen($val)<10){  
    $this->addError('password', 'Je paswoord is niet lang genoeg');

    //paswoord:           ---> check of paswoord min 6 karakters heeft
  }
 
  
if (!preg_match("/[A-Z+&@#\/%?=~_|!:,.;]/",$val)) { 
  $this->addError('password', 'Je paswoord moet minstens 1 hoofdletter of 1 speciaal karakter bevatten');
}
 
    // paswoord:           ---> The preg_match() function searches a string for pattern, returning true if the pattern exists, and false otherwise.
 }



 public function checkValidEmail()
    {
    $conn = Db::getConnection();

    $val = trim($this->data['email']);

    $statement = $conn->prepare('SELECT * from user WHERE email = :email');
    $statement->bindParam(':email', $val);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);


    if($result["email"] === $val){ //als email zelfde is als opgevraagd dan false
        $this->addError('email', 'email reeds bekend, ga naar inloggen');
        return false;
    }

    return true;  //als er geen mail te vinden is true

    }
    
    




}