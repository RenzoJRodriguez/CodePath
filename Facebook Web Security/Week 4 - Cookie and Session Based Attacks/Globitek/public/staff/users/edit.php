<?php
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$users_result = find_user_by_id($_GET['id']);
// No loop, only one result
$user = db_fetch_assoc($users_result);

// Set default values for all variables the page needs.
$errors = array();

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
       if(isset($_POST['first_name'])) { $user['first_name'] = $_POST['first_name']; }
       if(isset($_POST['last_name'])) { $user['last_name'] = $_POST['last_name']; }
       if(isset($_POST['username'])) { $user['username'] = $_POST['username']; }
       if(isset($_POST['email'])) { $user['email'] = $_POST['email']; }

       $result = update_user($user);
       if($result === true) {
         redirect_to('show.php?id=' . $user['id']);
       } else {
         $errors = $result;
       }

}
?>
<?php $page_title = 'Staff: Edit User ' . $user['first_name'] . " " . $user['last_name']; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Users List</a><br />

  <h1>Edit User: <?php echo h($user['first_name']) . " " . h($user['last_name']); ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="edit.php?id=<?php echo h(u($user['id'])); ?>" method="post">
    First name:<br />
    <input type="text" name="first_name" value="<?php echo h($user['first_name']); ?>" /><br />
    Last name:<br />
    <input type="text" name="last_name" value="<?php echo h($user['last_name']); ?>" /><br />
    Username:<br />
    <input type="text" name="username" value="<?php echo h($user['username']); ?>" /><br />
    Email:<br />
    <input type="text" name="email" value="<?php echo h($user['email']); ?>" /><br />
    <br />
    <?php echo csrf_token_tag(); ?>
    <input type="submit" name="submit" value="Update"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
