<?php
  require("../session.php"); // start or resume a session
  require("../syscheck.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database


  	$success='';
	$user_error='';
	$email_error='';
	$pw_error='';
	$email='';
	$username='';
	$change=0;
  // This if statement checks to determine whether the edit form has been submitted
  // If it has, then the account updating code is run, otherwise the form is displayed
  if(!empty($_POST))
  {
  		//make sure username valid
  	  	if ($_POST['username']!=$_POST['oldusername']) {


	  	  if(empty($_POST['username'])OR$_POST['username']=='')
			{
				// Note that die() is generally a terrible way of handling user errors
				// like this.  It is much better to display the error with the form
				// and allow the user to correct their mistake.  However, that is an
				// exercise for you to implement yourself.

				$user_error="<span class='error'>Please enter a username.</span>";
			}
			else{
			$username=htmlspecialchars($_POST['username'], ENT_QUOTES, 'utf-8');

		}
		}
		else{
			$username=htmlspecialchars($_POST['oldusername'], ENT_QUOTES, 'utf-8');
		}



	  // Make sure the user entered a valid E-Mail address
	  if(empty($_POST['email'])OR$_POST['email']=='')
		{
			$email_error="<span class='error'>Please enter an email.</span>";
		}
		elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{

			$email_error="<span class='error'>Invalid E-Mail Address</span>";
		}
		else{
			$email=htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8');
		}

	  // If the user is changing their username or E-Mail address, we need to make sure that
	  // the new value does not conflict with a value that is already in the system.
	  // If the user is not changing anything this check is not needed.
	  $sql="SELECT * FROM users WHERE username=:username";
	  $array_param=array(':username'=>$_POST['oldusername']);
	  $sth = $db->prepare($sql);
	  $sth->execute($array_param);
	  $row = $sth->fetch();
	  //check username for duplicates
	  if(strcmp($_POST['username'], $row['username'])!=0)
		  {
		  	$change++;
			  // Define our SQL query
			  $query = "SELECT 1 FROM users WHERE username = :username";

			  // Define our query parameter values
			  $query_params = array(
				  ':username' => $_POST['username']
			  );

			  try
			  {
				  // Execute the query
				  $stmt = $db->prepare($query);
				  $result = $stmt->execute($query_params);
			  }
			  catch(PDOException $ex)
			  {
				  // Note: On a production website, you should not output $ex->getMessage().
				  // It may provide an attacker with helpful information about your code.
				  error_log("Failed to run query: " . $ex->getMessage());
			  }

			  // Retrieve results (if any)
			  $check_name = $stmt->fetch();
			  if($check_name)
			  {
			  	if ($user_error=='') {
				  $user_error="<span class='error'>This username is already in use </span>";
				}
			  }
		  }
		  //check email for duplicates
	  if(strcmp($_POST['email'], $row['email'])!=0)
	  {
	  		$change++;
		  // Define our SQL query
		  $query = "SELECT 1 FROM users WHERE email = :email";

		  // Define our query parameter values
		  $query_params = array(
			  ':email' => $_POST['email']
		  );

		  try
		  {
			  // Execute the query
			  $stmt = $db->prepare($query);
			  $result = $stmt->execute($query_params);
		  }
		  catch(PDOException $ex)
		  {
			  // Note: On a production website, you should not output $ex->getMessage().
			  // It may provide an attacker with helpful information about your code.
			  error_log("Failed to run query: " . $ex->getMessage());
		  }

		  // Retrieve results (if any)
		  $check_mail= $stmt->fetch();
		  if($check_mail)
		  {
		  	if ($email_error=='') {
			  $email_error="<span class='error'>This E-Mail address is already in use </span>";
			}
		  }
	  }


	  // If the user entered a new password, we need to hash it and generate a fresh salt
	  // for good measure.
	  if(!empty($_POST['password']))
	  {
		  $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
		  $password = hash('sha256', $_POST['password'] . $salt);
		  for($round = 0; $round < 65536; $round++)
		  {
			  $password = hash('sha256', $password . $salt);
		  }

		  $change++;
	  }
	  else
	  {
		  // If the user did not enter a new password we will not update their old one.
		  $password = null;
		  $salt = null;
	  }
	  if($row['notes']!=$_POST['notes']){
	  	$change++;
	  }


	  //only ruyn update query if no errors

	  if($user_error==''&&$email_error==''&&$pw_error==''){

		  // Initial query parameter values
		  $query_params = array(
		  		':username' => $_POST['username'],
			  ':email' => $_POST['email'],
			  ':user_id' => $row['id'],
			  ':notes' => $_POST['notes']
		  );

		  // If the user is changing their password, then we need parameter values
		  // for the new password hash and salt too.
		  if($password != null)
		  {
			  $query_params[':password'] = $password;
			  $query_params[':salt'] = $salt;
		  }

		  // Note how this is only first half of the necessary update query.
		  // We will dynamically
		  // construct the rest of it depending on whether or not the user is changing
		  // their password.
		  $query = "
			  UPDATE users
			  SET
			  	  username = :username,
				  email = :email,
				  notes = :notes
		  ";

		  // If the user is changing their password, then we extend the SQL query
		  // to include the password and salt columns and parameter tokens too.
		  if($password !== null)
		  {
			  $query .= "
				  , password = :password
				  , salt = :salt
			  ";
		  }

		  // Finally we finish the update query by specifying that we only wish
		  // to update the one record with for the current user.
		  $query .= "
			  WHERE
				  id = :user_id
		  ";



			  try
			  {
				  // Execute the query
				  $stmt = $db->prepare($query);
				  $result = $stmt->execute($query_params);
				  if ($change==0) {
				  	$success= "<p class='error'>No changes made</p>";
				  }
				  else{
				  $success= "<p>Successfuly updated $username with email: $email</p>";
					}
			  }
			  catch(PDOException $ex)
			  {
				  // Note: On a production website, you should not output $ex->getMessage().
				  // It may provide an attacker with helpful information about your code.
				  echo "final run";
				  echo $query;
				  error_log("Failed to run query: " . $ex->getMessage());
			  }
	}

	  // Now that it is the login user and the user's E-Mail address has changed,
	  // the data stored in the $_SESSION array is stale;
	  // we need to update it so that it is accurate.
/*if (strcmp($_SESSION['user']['username'], $_POST['username'])==0) {
		  $_SESSION['user']['email'] = $_POST['email'];
	  }

	  header("Location: memberlist.php");
	  die("Redirecting to memberlist.php");*/
	}

  /////////////////////////////////////////
  ///// process request
  if (!empty($_REQUEST)){

	$email = addslashes($_REQUEST['email']);

	$sql = "SELECT * FROM users WHERE email  = :email";
	$array_param=array(':email'=>$email);
	$sth = $db->prepare($sql);
	$sth->execute($array_param);
	$row = $sth->fetch();

	if (!$row)
	{
		die("Error: Data not found..");
	}

	$username=addslashes($row['username']);
	$notes= $row['notes'];


	$db=null;
  }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Register</title>
</head>

<body>
<div id='container'>
<?php include '../header2.php' ?>
<div id='content'>
<h1>Edit Account</h1>
	<?php echo $success; ?>
  <form action="update_user.php" method="post">
	  <p>Username:<br />
	  <input type="text" name="oldusername"
      value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" hidden/>
	  <input type="text" name="username"
      value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" />
      <?php echo $user_error; ?>
	  <br /><br />
	  E-Mail Address:<br />
	  <input type="text" name="email"
      value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" /> <?php echo $email_error; ?>
	  <br /><br />
	  Password:<br />
	  <input type="password" name="password" value="" />
	  <?php echo $pw_error; ?>
	  <br />
	  <i>(leave blank if you do not want to change your password)</i>	  </p>
	  <p>Notes:<br />
	    <textarea name="notes" id="notes" cols="120" rows="15"><?php echo htmlspecialchars($notes, ENT_QUOTES, 'UTF-8'); ?></textarea>
	    <br />
	    <br />
	    <input type="submit" value="Update Account" />
    </p>
  </form>
<form action="admin.php">
<input type="submit" value="Go Back">
</form>
<br>
</div>
<?php include '../footer.php'; ?>
</div>
</body>
</html>
