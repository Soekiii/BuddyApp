<?php 

class Validate {

  private $data;
  private $errors = [];
  private static $fields = ['email', 'password'];

  public function __construct($post_data){
    $this->data = $post_data;
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
      $this->addError('email', 'email cannot be empty');
    
    } else {
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email', 'email must be a valid email address');
     
      }
    }
    
  }
  // Checkt of het password leeg is
  private function validatePassword(){

    $val = trim($this->data['password']);

    if(empty($val)){
      $this->addError('password', 'password cannot be empty');
    }

  }
  // Welke input veld en welke error laat ik zien
  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

 


 public function Emailvalidator(){

  $val = trim($this->data['email']);

  if(empty($val)){
    $this->addError('email', ' leeg invullen met @student.thomasmore.be E-mailadres');
  //email leeg
  }
  if(!empty($val)){ //als hij niet leeg is dan kijken naar fouten
    
    if (!filter_var($val, FILTER_VALIDATE_EMAIL)){ //email niet correct met @ enz...
      $this->addError('email', 'email niet correct');

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
    $this->addError('firstName', 'hoe heet jij alweer?');
  // voornaam:            ---> check of voornaam is ingevuld! + melding indien niet ingevuld

  }

  $val = trim($this->data['lastName']);
  if(empty($val)){
    $this->addError('lastName', 'geef hier je achternaam?');
  // achternaam:          ---> check of achternaam is ingevuld! + melding indien niet ingevuld
  }
  $val = trim($this->data['password']);
  if(empty($val)){
    $this->addError('password', 'geef hier je paswoord op, ik zal niet meekijken hoor :-)');
  //paswoord:            ---> check of paswoord is ingevuld! + melding indien niet ingevuld
  }
  if(strlen($val< 6)){
    $this->addError('password', 'je paswoord te gemakkelijk, kies een beter met min 6 karakters');
    //paswoord:            ---> check of paswoord min 6 karakters heeft
  }
    return $this->errors; //alle gegevens terugsturen naar aanvrager
  }



 public function checkValidEmail($email)
    {
    $conn = Db::getConnection();

    $statement = $conn->prepare('SELECT * from user WHERE email = :email');
    $statement->bindParam(':email', $email);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if($result["email"] === $email){ //als email zelfde is als opgevraagd dan false

        return false;
    }

    return true;  //als er geen mail te vinden is true

    }
    
    




}