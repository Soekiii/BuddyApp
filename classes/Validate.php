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
    return $this->errors;
  }
}