<?php

  require("session.php"); // start or resume a session
  require("check.php"); // check if there is a session ongoing
  require("common.php"); // connect to the database
	
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
	  if($_POST['email'] != $_SESSION['user']['email'])
	  {
		  // Define our SQL query
		  $query = "SELECT 1 FROM users WHERE email = :email";
			
		  // Define our query parameter values
		  $query_params = array(':email' => $_POST['email']);
			
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
		
	  // If the user entered a new password, 
	  // we need to hash it and generate a fresh salt for good measure.
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
			':user_id' => $_SESSION['user']['id'],
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
				email = :email
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
		  die("Failed to run query: " . $ex->getMessage());
	  }
		
	  // Now that the user's E-Mail address has changed, 
	  // the data stored in the $_SESSION
	  // array is stale; we need to update it so that it is accurate.
	  $_SESSION['user']['email'] = $_POST['email'];
		
	  header("Location: content.php");
	  // Calling die or exit after performing a redirect using the header function
	  // is critical. If you do not die or exit
	  // The rest of your PHP script will continue to execute and
	  // will be sent to the user .
		die("Redirecting to content.php");
	}  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Account</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>  
  <script type="text/javascript" language="JavaScript">
<!--
//--------------------------------
// This code compares two fields in a form and submit it
// if they're the same, or not if they're different.
//--------------------------------
function checkPassword(theForm) {
	 if (theForm.password.value != theForm.password2.value)
	 {
		alert('Those passwords don\'t match!');
			     return false;
			     } else {
			       return true;
			       }
}
//-->
</script> 
  
  <h1>Edit Account</h1>
  <form action="edit_account.php" method="post" onsubmit="return checkPassword(this)">
	  Username:<br />
	  <b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b>
	  <br /><br />
	  E-Mail Address:<br />
	  <input type="text" name="email" 
      value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" />
	  <br /><br />
	  Password:<br />
	  <input type="password" name="password" value="" /><br />
	    <p>Repeat password:<br />
        <input type="password" name="password2" value="" />
        <br />
	  <i>(leave blank if you do not want to change your password)</i>
	  <br /><br />
	  <input type="submit" value="Update Account" />
  </form>
 
<FORM><INPUT Type="button" VALUE="Cancel" onClick="history.go(-1);return true;"></FORM>

  </body>
</html>