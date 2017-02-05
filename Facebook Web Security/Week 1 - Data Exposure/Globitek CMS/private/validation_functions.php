<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return empty($value);
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    return (strlen($value) >= $options["min"] && strlen($value) <= $options["max"]);
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
       if(strpos($value, '@') !== false){
            return true;
       }
       return false;
  }

  //Validating that form values contain only whitelisted characters
  function charCheck($value, $type){
       //Name & Last Name character check. Whitelisted characters [letters, spaces, symbols: - , . ']
       if($type == 'name'){
            return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
       }
       //Username character check. Whitelisted characters [letters, numbers, symbols: _ ]
       else if($type == 'username'){
            return preg_match('/\A[A-Za-z0-9\_]+\Z/', $value);
       }
       //Email character check. Whitelisted characters [letters, numbers, symbols: _ @ .]
       else{
            return preg_match('/\A[A-Za-z0-9\_\@\.]+\Z/', $value);
       }
  }

  //Validates the uniqueness of the username
  function has_unique_username($value, $db){
       $sql = "SELECT 1 from users where username='$value' LIMIT 1";
       $result = db_query($db, $sql);

       if($result->num_rows == 0){
            return TRUE;
       }
     else{
          return FALSE;
     }
  }


?>
