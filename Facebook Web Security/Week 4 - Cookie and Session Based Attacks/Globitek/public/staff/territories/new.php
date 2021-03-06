<?php
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to('../index.php');
}

// Set default values for all variables the page needs.
$errors = array();
$territory = array(
  'name' => '',
  'position' => '',
  'state_id' => $_GET['id']
);

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
               if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
               if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

               $result = insert_territory($territory);
               if($result === true) {
               $new_id = db_insert_id($db);
               redirect_to('show.php?id=' . $new_id);
          } else {
               $errors = $result;
          }
}
?>
<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo h(u($territory['state_id'])); ?>">Back to State</a><br />

  <h1>New Territory</h1>

  <?php echo display_errors($errors); ?>

  <form action="new.php?id=<?php echo h(u($territory['state_id'])); ?>" method="post">
    Name:<br />
    <input type="text" name="name" value="<?php echo h($territory['name']); ?>" /><br />
    Position:<br />
    <input type="text" name="position" value="<?php echo h($territory['position']); ?>" /><br />
    <br />
    <?php echo csrf_token_tag(); ?>
    <input type="submit" name="submit" value="Create"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
