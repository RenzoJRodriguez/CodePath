<?php
     require_once('../private/initialize.php');
     require_once('../private/validation_functions.php');   //Requiring the provided validation functions library
     // Set default values for all variables the page needs.
     $db = db_connect();
     $first_name = '';
     $last_name = '';
     $email = '';
     $username = '';
     $errors = array();
     $sql = '';
     // if this is a POST request, process the form
     // Hint: private/functions.php can help
     if(is_post_request()){
          // Confirm that POST values are present before accessing them.
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $email = $_POST['email'];
          $username = $_POST['username'];

     // Perform Validations
     // Hint: Write these in private/validation_functions.php
     //Validating First Name. Number of validity checks: 3
     if(is_blank($first_name)){                                                  //If first_name field is left blank
          array_push($errors, 'First name cannot be blank.');
     }
     else if(!whitelist_check($first_name, 'first_name')){                                   //If first_name has invalid characters
          array_push($errors, 'Invalid character(s) in first name.');
     }
     else if(!has_length($first_name, ['min' => 2, 'max' => 255])){               //If first_name field is not the appropriate length
          array_push($errors, 'First name must be between 2 and 255 characters.');
     }

     //Validating Last Name. Number of validity checks: 3
     if(is_blank($last_name)){                                                       //If last_name field is left blank
          array_push($errors, 'Last name cannot be blank.');
     }
     else if(!whitelist_check($last_name, 'last_name')){                                       //If last_name had invalid characters
          array_push($errors, 'Invalid character(s) in last name.');
     }
     else if(!has_length($last_name, ['min' => 2, 'max' => 255])){                   //If last_name field is not the appropriate length
          array_push($errors, 'Last name must be between 2 and 255 characters.');
     }

     //Validating Email. Number of validity checks: 4
     if(is_blank($email)){                                            //If email is left blank
          array_push($errors, 'Email cannot be blank.');
     }
     else if(!whitelist_check($email, 'email')){                           //If email has invalid characters
          array_push($errors, 'Invalid character(s) in email.');
     }
     else if(!has_valid_email_format($email)){                        //If email is not in a valid format
          array_push($errors, 'Email must be a valid format.');
     }
     else if(strlen($email) > 255){                                   //If email is not the appropriate length
          array_push($errors, 'Email cannot exceed 255 characters.');
     }

     //Validating Username. Number of validity checks: 5
     if(is_blank($username)){                                              //If username is left blank
          array_push($errors, 'Username cannot be blank.');
     }
     else if(!whitelist_check($username, 'username')){                          //If username has invalid characters
          array_push($errors, 'Invalid character(s) in username.');
     }
     else if(!has_unique_username($username, $db)){                             //If username is not unique
          array_push($errors, 'Username is taken.');
     }
     else if(strlen($username) < 8){                                       //If username is too short
          array_push($errors, 'Username must be at least 8 characters.');
     }
     else if(strlen($username) > 255){                                     //If username is too long
          array_push($errors, 'Username cannot exceed 255 characters.');
     }

     // if there were no errors, submit data to database
     if(empty($errors)){
          // Write SQL INSERT statement
          $sql = 'INSERT INTO users (first_name, last_name, email, username, created_at) values (\'' . $first_name . '\', \'' . $last_name . '\', \'' . $email . '\', \'' . $username . '\',  CURRENT_TIMESTAMP());';
          // For INSERT statments, $result is just true/false
          $result = db_query($db, $sql);
          if($result) {
            db_close($db);
            redirect_to('registration_success.php');
          }
          else {
             // The SQL INSERT statement failed.
             // Just show the error, not the form
             echo db_error($db);
             db_close($db);
             exit;
           }
     }
}
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">

     <h1>Register</h1>
     <p>Register to become a Globitek Partner.</p>

     <?php
          // Hint: private/functions.php can help
          echo display_errors($errors);
     ?>

     <!--HTML FORM-->
     <form method="post" action="register.php">
         <p>First name:</p>
               <input type="input" name="first_name" value="<?php echo h($first_name); ?>">

         <p>Last name:</p>
               <input type="input" name="last_name" value="<?php echo h($last_name); ?>">

         <p>Email:</p>
               <input type="input" name="email" value="<?php echo h($email); ?>">

         <p>Username:</p>
               <input type="input" name="username" value="<?php echo h($username); ?>">

         <input name="submit" type="submit" value="Submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
