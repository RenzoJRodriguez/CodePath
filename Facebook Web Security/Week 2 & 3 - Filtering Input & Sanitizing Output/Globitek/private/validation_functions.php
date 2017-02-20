<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  //Validating that form values contain only whitelisted characters (Registration Page)
  function whitelist_check($value, $type){
       //First Name & Last Name character check. Whitelisted characters [A-Z a-z s - , . ']
       if(($type == 'first_name') || ($type == 'last_name')){
            return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
       }
       //Username character check. Whitelisted characters [A-Z a-z 0-9 _]
       else if($type == 'username'){
            return preg_match('/\A[A-Za-z0-9\_]+\Z/', $value);
       }
       //Phone Number character check. Whitelisted characters [0-9 ( ) - s]
       else if($type == 'phone'){
            return preg_match('/\A[0-9\(\)\-\s]+\Z/', $value);
       }
       //Email character check. Whitelisted characters [A-Z a-z 0-9 @ . _ -]
       else if($type == 'email'){
            return preg_match('/\A[A-Za-z0-9\@\.\_\-]+\Z/', $value);
       }
       ////////////////////////MY CUSTOM VALIDATION///////////////////////////////////
       //State/territory name character check. Whitelisted characters [A-Z a-z & . - s]
       else if($type == 'name'){
            return preg_match('/\A[A-Za-z\&\.\-\s]+\Z/', $value);
       }
       ////////////////////////MY CUSTOM VALIDATION///////////////////////////////////
       //State code character check. Whitelisted characters [A-Z] and that is has length 2
       else if($type == 'code'){
            return preg_match('/\A[A-Z]{2}+\Z/', $value);
       }
       ////////////////////////MY CUSTOM VALIDATION///////////////////////////////////
       else if(($type == 'country_id') || ($type == 'state_id') || ($type == 'position')){
       //Country/Position character check. Whitelisted characters [0-9] and that is a whole number
            return preg_match('/\A[0-9]+\Z/', $value);
       }
  }

    // has_valid_email_format('test@test.com')
    function has_valid_email_format($value) {
      // Function can be improved later to check for special cases
     return preg_match('/\A[A-Za-z0-9\_\.]+@[A-Za-z0-9\.]+\.[A-Za-z0-9]{2,}\Z/', $value);
    }

    ////////////////////////MY CUSTOM VALIDATION///////////////////////////////////
    //Validates the uniqueness of the username
  function has_unique_username($value, $db, $current_value){
       $sql = "SELECT 1 from users where username='$value' LIMIT 1";
       $result = db_query($db, $sql);
       if($result->num_rows == 0){
            return TRUE;
       }
     else{
          return FALSE;
     }
  }

  ////////////////////////MY CUSTOM VALIDATION///////////////////////////////////
  function has_unique_phone($value, $db, $current_value){
       $sql = "SELECT 1 from salespeople where phone ='$value' LIMIT 1";
       $result = db_query($db, $sql);
       if($result->num_rows == 0){
            return TRUE;
       }
     else{
          return FALSE;
     }
  }
?>
