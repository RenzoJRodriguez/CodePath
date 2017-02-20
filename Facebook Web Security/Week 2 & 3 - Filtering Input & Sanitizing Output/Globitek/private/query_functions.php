<?php
  // COUNTRY QUERIES
  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  // STATE QUERIES
  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }
  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . $country_id . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }
  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . $id . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
     //If name  field is left blank
    if(is_blank($state['name'])){
         $errors[] = "State name cannot be blank.";
    }
    //If name has invalid characters
    elseif(!whitelist_check($state['name'], 'name')){
         $errors[] = "Invalid character(s) in State name.";
    }
    //If name field is not the appropriate length
    elseif(strlen($state['name']) > 255){
         $errors[] = "State name cannot exceed 255 characters.";
    }

    //If state code field is left blank
    if(is_blank($state['code'])){
         $errors[] = "State code cannot be blank.";
    }
    //If state code has invalid characters or is not long enough
    elseif(!whitelist_check($state['code'], 'code')) {
         $errors[] = "Invalid character(s) in State code (must be in CAPS) or is not 2 characters long";
    }

    //If Country ID field is blank
    if(is_blank($state['country_id'])) {
         $errors[] = "Country ID cannot be blank.";
    }
    //If Country ID has invalid characters
    elseif(!whitelist_check($state['country_id'], 'country_id')){
         $errors[] = "Invalid character(s) in Country ID.";
    }
    //If Country ID field is not the appropriate length
    //Issue/Vulnerability: "Out of range value" even if this check fails
    elseif(strlen($state['country_id']) > 10){
              $errors[] = "Country ID cannot exceed 10 characters.";
    }

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO states ";
    $sql .= "(name, code, country_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . $state['name'] . "',";
    $sql .= "'" . $state['code'] . "',";
    $sql .= "'" . $state['country_id'] . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE states SET ";
    $sql .= "name='" . $state['name'] . "', ";
    $sql .= "code='" . $state['code'] . "', ";
    $sql .= "country_id='" . $state['country_id'] . "' ";
    $sql .= "WHERE id='" . $state['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_state statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // TERRITORY QUERIES
  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }
  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . $state_id . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }
  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . $id . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
   //If name field is left blank
   if(is_blank($territory['name'])){
        $errors[] = "Name cannot be blank.";
   }
   //If name has invalid characters
   elseif(!whitelist_check($territory['name'], 'name')){
        $errors[] = "Invalid character(s) in name.";
   }
   //If name is not the appropriate length
   // elseif(strlen($territory['name']) > 255){
   //      $errors[] = "Name cannot exceed 255 characters.";
   // }

   //If position  field is left blank
   if(is_blank($territory['position'])){
        $errors[] = "Position cannot be blank.";
   }
   //If position has invalid characters
   elseif(!whitelist_check($territory['position'], 'position')){
        $errors[] = "Invalid character(s) in position.";
   }
   //If position is not the appropriate length
   elseif (strlen($territory['position']) > 10) {
        $errors[] = "Position cannot exceed 10 characters.";
   }

    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO territories ";
    $sql .= "(name, state_id, position) ";
    $sql .= "VALUES (";
    $sql .= "'" . $territory['name'] . "',";
    $sql .= "'" . $territory['state_id'] . "',";
    $sql .= "'" . $territory['position'] . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE territories SET ";
    $sql .= "name='" . $territory['name'] . "', ";
    $sql .= "state_id='" . $territory['state_id'] . "', ";
    $sql .= "position='" . $territory['position'] . "' ";
    $sql .= "WHERE id='" . $territory['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_territory statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // SALESPERSON QUERIES
  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }
  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . $territory_id . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }
  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "WHERE id='" . $id . "';";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . $id . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
       global $db;
       //If first_name field is left blank
      if (is_blank($salesperson['first_name'])) {
        $errors[] = "First name cannot be blank.";
      }
       //If first_name has invalid characters
      elseif(!whitelist_check($salesperson['first_name'], 'first_name')){
       $errors[] = "Invalid character(s) in first name.";
     }
     //If first_name field is not the appropriate length
      elseif (strlen($salesperson['first_name']) > 255) {
       $errors[] = "First name cannot exceed 255 characters.";
      }

      //If last_name field is left blank
      if (is_blank($salesperson['last_name'])) {
       $errors[] = "Last name cannot be blank.";
      }
      //If last_name had invalid characters
      elseif(!whitelist_check($salesperson['last_name'], 'last_name')){
           $errors[] = "Invalid character(s) in last name.";
     }
     //If last_name field is not the appropriate length
      elseif (strlen($salesperson['last_name']) > 255) {
       $errors[] = "Last name cannot exceed 255 characters.";
      }

      //If email is left blank
      if (is_blank($salesperson['email'])) {
       $errors[] = "Email cannot be blank.";
      }
      //If email is not in a valid format
      elseif (!has_valid_email_format($salesperson['email'])) {
       $errors[] = "Email must be a valid format.";
      }
      //If email has invalid characters
      elseif(!whitelist_check($salesperson['email'], 'email')){
       $errors[] = "Invalid character(s) in email.";
     }
     //If email is not the appropriate length
     elseif(strlen($salesperson['email']) > 255){
         $errors[] = "Email cannot exceed 255 characters";
     }

     //If username is left blank
      if (is_blank($salesperson['phone'])) {
       $errors[] = "Phone number cannot be blank.";
      }
       //If username has invalid characters
      elseif(!whitelist_check($salesperson['phone'], 'phone')){
       $errors[] = "Invalid character(s) in phone number.";
      }
      //If username is not appropriate length
      elseif (strlen($salesperson['phone']) > 255) {
       $errors[] = "Phone number cannot exceed 255 characters.";
      }
      elseif(!has_unique_phone($salesperson['phone'], $db)){
          $errors[] = "Phone number is already taken.";
      }

      return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO salespeople ";
    $sql .= "(first_name, last_name, phone, email) ";
    $sql .= "VALUES (";
    $sql .= "'" . $salesperson['first_name'] . "',";
    $sql .= "'" . $salesperson['last_name'] . "',";
    $sql .= "'" . $salesperson['phone'] . "',";
    $sql .= "'" . $salesperson['email'] . "'";
    $sql .= ");";

    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE salespeople SET ";
    $sql .= "first_name='" . $salesperson['first_name'] . "', ";
    $sql .= "last_name='" . $salesperson['last_name'] . "', ";
    $sql .= "phone='" . $salesperson['phone'] . "', ";
    $sql .= "email='" . $salesperson['email'] . "' ";
    $sql .= "WHERE id='" . $salesperson['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // USER QUERIES
  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }
  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users WHERE id='" . $id . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
       global $db;
    //If first_name field is left blank
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    }
     //If first_name has invalid characters
    elseif(!whitelist_check($user['first_name'], 'first_name')){
     $errors[] = "Invalid character(s) in first name.";
   }
   //If first_name field is not the appropriate length
    elseif (strlen($user['first_name']) > 255) {
     $errors[] = "First name cannot exceed 255 characters.";
    }

    //If last_name field is left blank
    if (is_blank($user['last_name'])) {
     $errors[] = "Last name cannot be blank.";
    }
    //If last_name had invalid characters
    elseif(!whitelist_check($user['last_name'], 'last_name')){
         $errors[] = "Invalid character(s) in last name.";
   }
   //If last_name field is not the appropriate length
    elseif (strlen($user['last_name']) > 255) {
     $errors[] = "Last name cannot exceed 255 characters.";
    }

    //If email is left blank
    if (is_blank($user['email'])) {
     $errors[] = "Email cannot be blank.";
    }
    //If email is not in a valid format
    elseif (!has_valid_email_format($user['email'])) {
     $errors[] = "Email must be a valid format.";
    }
    //If email has invalid characters
    elseif(!whitelist_check($user['email'], 'email')){
     $errors[] = "Invalid character(s) in email.";
   }
   //If email is not the appropriate length
   elseif(strlen($user['email']) > 255){
       $errors[] = "Email cannot exceed 255 characters";
   }

   //If username is left blank
    if (is_blank($user['username'])) {
     $errors[] = "Username cannot be blank.";
    }
     //If username has invalid characters
    elseif(!whitelist_check($user['username'], 'username')){
     $errors[] = "Invalid character(s) in username.";
    }
    //If username is not appropriate length
    elseif (strlen($user['username']) < 8 || strlen($user['username']) > 255) {
     $errors[] = "Username must be at least 8 characters and less than 255 characters.";
    }
    elseif(!has_unique_username($user['username'], $db)){
         $errors[] = "Username is already taken";
    }

    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (";
    $sql .= "'" . $user['first_name'] . "',";
    $sql .= "'" . $user['last_name'] . "',";
    $sql .= "'" . $user['email'] . "',";
    $sql .= "'" . $user['username'] . "',";
    $sql .= "'" . $created_at . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . $user['first_name'] . "', ";
    $sql .= "last_name='" . $user['last_name'] . "', ";
    $sql .= "email='" . $user['email'] . "', ";
    $sql .= "username='" . $user['username'] . "' ";
    $sql .= "WHERE id='" . $user['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    }
    else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

?>
