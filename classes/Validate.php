<?php 

class Validate {

  private $data;
  private $errors = [];
  private static $fields = ['email', 'password'];

  public function __construct($post_data){
    $this->data = $post_data;
  }
  // kijkt na of al de $fields in het formulier zitten
  public function validateForm(){
     foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }
    $this->validateEmail();
    return $this->errors;
  }
  // Is email leeg of geen emailadress
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
  // Welke input veld en welke error laat ik zien
  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

}