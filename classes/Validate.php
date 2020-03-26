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
        if(!preg_match('|@student.thomasmore.be$|', $val)){
          $this->addError('email', 'email must end with @student.thomasmore.be');
        }
    }

  }
  // Checkt of het password leeg is
  private function validatePassword(){

    $val = trim($this->data['password']);

    if(empty($val)){
      $this->addError('password', 'password is not correct');
    }

  }
  // Welke input veld en welke error laat ik zien
  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

}