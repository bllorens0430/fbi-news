  <?php
  
  // when we come to this php, it is root changing accounts.
	  // First we execute our common code to connection to the database and start the session
	  require("common.php");

	if (isset($_SESSION)) {
		if (strcmp($_SESSION['user']['username'], 'root')!=0) {
		  header("Location: index.php");
		  die("Redirecting to: index.php");
		}
	}	  
	  // At the top of the page we check to see whether the user is logged in or not
	  if(empty($_SESSION['user']))
	  {
		  // If they are not, we redirect them to the login page.
		  header("Location: view.php");
		  
		  // Remember that this die statement is absolutely critical.  Without it,
		  // people can view your members-only content without logging in.
		  die("Redirecting to view.php");
	  }
	  
	  // This if statement checks to determine whether the edit form has been submitted
	  // If it has, then the account updating code is run, otherwise the form is displayed
	  if(!empty($_POST))
	  {
		  // Make sure the user entered a valid E-Mail address
		  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		  {
			  die("Invalid E-Mail Address");
		  }
		  
		  // If the user is changing their E-Mail address, we need to make sure that
		  // the new value does not conflict with a value that is already in the system.
		  // If the user is not changing their E-Mail address this check is not needed.
		  $sql="SELECT * FROM users WHERE username=:username";
		  $array_param=array(':username'=>$_POST['username']);
		  $sth = $db->prepare($sql);
		  $sth->execute($array_param);
		  $row = $sth->fetch();		
		  
		  if(strcmp($_POST['email'], $row['email'])!=0)
		  {
			  echo "email different";
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
				  die("Failed to run query: " . $ex->getMessage());
			  }
			  
			  // Retrieve results (if any)
			  $row = $stmt->fetch();
			  if($row)
			  {
				  die("This E-Mail address is already in use");
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
		  }
		  else
		  {
			  // If the user did not enter a new password we will not update their old one.
			  $password = null;
			  $salt = null;
		  }
		  
		  // Initial query parameter values
		  $query_params = array(
			  ':email' => $_POST['email'],
			  ':user_id' => $row['id'],
			  ':notes' => $_POST['notes']
		  );
		  
		  // If the user is changing their password, then we need parameter values
		  // for the new password hash and salt too.
		  if($password !== null)
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
		  }
		  catch(PDOException $ex)
		  {
			  // Note: On a production website, you should not output $ex->getMessage().
			  // It may provide an attacker with helpful information about your code. 
			  echo "final run";
			  echo $query;
			  die("Failed to run query: " . $ex->getMessage());
		  }
		  
		  // Now that the user's E-Mail address has changed, the data stored in the $_SESSION
		  // array is stale; we need to update it so that it is accurate.
		  if (strcmp($_SESSION['user']['username'], $_POST['username'])==0) {
			  $_SESSION['user']['email'] = $_POST['email'];
		  }
		  
		  // This redirects the user back to the members-only page after they register
		  if (strcmp($_SESSION['user']['username'], 'root')==0){
			  header("Location: memberlist.php");
			  die("Redirecting to memberlist.php");
		  }
		  
		  header("Location: view.php");
		  
		  // Calling die or exit after performing a redirect using the header function
		  // is critical. 
		  // If you do not die or exitThe rest of your PHP script will continue to execute and
		  // will be sent to the user .
		  die("Redirecting to view.php");
	  }
	  
	  /////////////////////////////////////////
	  ///// process request
	if (!empty($_REQUEST)){
	  
	  $email =$_REQUEST['email'];
	  
	  $sql = "SELECT * FROM users WHERE email  = :email";
	  $array_param=array(':email'=>$email);
	  $sth = $db->prepare($sql);
	  $sth->execute($array_param);
	  $row = $sth->fetch();
	  
	  if (!$row) 
	  {
		  die("Error: Data not found..");
	  }
	
	  $username=$row['username'] ;
	  $notes= $row['notes'] ;					
	  
	  //mysql_close($db);
	  $db=null;
	}
	    
  ?>
  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit News</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>   
<h1>Edit Account</h1>
  <form action="update_user.php" method="post">
	  <p>Username:<br />
	  <input type="text" name="username" 
      value="<?php echo $username; ?>" readonly/>
	  <br /><br />
	  E-Mail Address:<br />
	  <input type="text" name="email" 
      value="<?php echo $email; ?>" />
	  <br /><br />
	  Password:<br />
	  <input type="password" name="password" value="" /><br />
	  <i>(leave blank if you do not want to change your password)</i>	  </p>
	  <p>Notes:<br />
	    <textarea name="notes" id="notes" cols="120" rows="15"><?php echo $notes; ?></textarea>
	    <br />
	    <br />
	    <input type="submit" value="Update Account" />
    </p>
  </form>
<form action="admin.php">
<input type="submit" value="Go Back">
</form> 
</body>
</html>
