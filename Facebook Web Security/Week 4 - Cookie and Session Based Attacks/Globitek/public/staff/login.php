<?php
require_once('../../private/initialize.php');

// Until we learn about encryption, we will use an unencrypted
// master password as a stand-in. It should go without saying
// that this should *never* be done in real production code.
$master_password = 'secret';

// Set default values for all variables the page needs.
$errors = array();
$username = '';
$password = '';

if(is_post_request()) {

     // Checking if the request being made was made from the same domain
     if(!request_is_same_domain()){
          echo "Error: request is not the same domain";
          exit;
     }

     //Checking if the CSRF token is valid
     if(!csrf_token_is_valid()){
          echo "Error: invalid request";
          exit;
     }

     //Checking if the  CSRF token is recent
     if(!csrf_token_is_recent()){
          echo "Error: session timeout.";
          exit;
     }

  // Confirm that values are present before accessing them.
  if(isset($_POST['username'])) { $username = $_POST['username']; }
  if(isset($_POST['password'])) { $password = $_POST['password']; }

  // Validations
  if (is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if (is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // If there were no errors, submit data to database
  if (empty($errors)) {

    $users_result = find_users_by_username($username);
    // No loop, only one result
    $user = db_fetch_assoc($users_result);
    if($user) {
      if($password === $master_password) {
        // Username found, password matches
        log_in_user($user);
        // Redirect to the staff menu after login
        redirect_to('index.php');
      } else {
        // Username found, but password does not match.
        //Message does not explicitly state which one is incorrect in order to prevent enumeration
        $errors[] = "Username and password do not match.";
      }
    } else {
      // No username found
      //Message does not state whether password was correct in order to prevent enumeration
      $errors[] = "Username and password do not match.";
    }
  }
}

?>
<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<div id="menu">
  <ul>
    <li><a href="../index.php">Public Site</a></li>
  </ul>
</div>

<div id="main-content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <?php echo csrf_token_tag() ?>
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
