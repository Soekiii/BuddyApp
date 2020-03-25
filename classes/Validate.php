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



    return $this->errors;
  }

  
  




}