<?php

	// First we execute our common code to connection to the database and start the session
	// "require" is identical to include except upon failure 
	// it will also produce a fatal E_COMPILE_ERROR level error. 
	// In other words, it will halt the script whereas 
	// include only emits a warning (E_WARNING) which allows the script to continue. 
	require("session.php");
	require("common.php");

	// This variable will be used to re-display the user's username to them in the
	// login form if they fail to enter the correct password.  It is initialized here
	// to an empty value, which will be shown if the user has not submitted the form.
	$submitted_username = '';
	
	// This if statement checks to determine whether the login form has been submitted
	// If it has, then the login code is run, otherwise the form is displayed
	if(!empty($_POST))
	{
		echo "Check login now! <br>";
		// This query retreives the user's information from the database using
		// their username.
		$query = "SELECT id, username, password, salt, email
			FROM users
			WHERE username = :username";
		
		// The parameter values
		$query_params = array(':username' => $_POST['username']);
		
		try {
			// Execute the query against the database
			$stmt = $db->prepare($query);
			$result = $stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			// Note: On a production website, you should not output $ex->getMessage().
			// It may provide an attacker with helpful information about your code. 
			die("Failed to run query: " . $ex->getMessage());
		}
		
		// This variable tells us whether the user has successfully logged in or not.
		// We initialize it to false, assuming they have not.
		// If we determine that they have entered the right details, 
		// then we switch it to true.
		$login_ok = false;
		
		// Retrieve the user data from the database.  If $row is false, then the username
		// they entered is not registered.
		$row = $stmt->fetch();
		if($row)
		{
			// Using the password submitted by the user and the salt stored in the database,
			// we now check to see whether the passwords match 
			// by hashing the submitted password
			// and comparing it to the hashed version already stored in the database.
			$check_password = hash('sha256', $_POST['password'] . $row['salt']);
			for($round = 0; $round < 65536; $round++)
			{
				$check_password = hash('sha256', $check_password . $row['salt']);
			}
			
			if($check_password === $row['password'])
			{
				// If they do, then we flip this to true
				$login_ok = true;
			}
		}
		
		// If the user logged in successfully, 
		// then we send them to the private members-only page
		// Otherwise, we display a login failed message and show the login form again
		if($login_ok)
		{
			// Here I am preparing to store the $row array into the $_SESSION by
			// removing the salt and password values from it.  Although $_SESSION is
			// stored on the server-side, there is no reason to store sensitive values
			// in it unless you have to.  Thus, it is best practice to remove these
			// sensitive values first.
			unset($row['salt']);
			unset($row['password']);
			
			// This stores the user's data into the session at the index 'user'.
			// We will check this index on the private members-only page 
			// to determine whether
			// or not the user is logged in.  We can also use it to retrieve
			// the user's details.				
			$_SESSION['user'] = $row;
//			$_SESSION['username']=$_POST['username'];

/*			
			// Redirect the user to the private members-only page.
			if (strcmp($_POST['username'], "root") == 0) {
			  header("Location: admin.php");
			  die("Redirecting to: admin.php");
			}
			
			header("Location: view.php");
			die("Redirecting to: view.php");
			*/
//			echo "going to content.php";

			header("Location: content.php");
			die("Redirecting to: content.php");

		}
		else
		{
			// Tell the user they failed
			print("Login Failed.");
			
			// Show them their username again so all they have to do is enter a new
			// password.  The use of htmlentities prevents XSS attacks.  You should
			// always use htmlentities on user submitted values before displaying them
			// to any users (including the user that submitted them).  
			// For more information: http://en.wikipedia.org/wiki/XSS_attack
			$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
		}
	}
  	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
  <div id="banner">
    <h1>Xinwen Fu</h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li><a target="_blank" href="http://www.cs.uml.edu/~xinwenfu/">HOMEPAGE</a></li>
      <li id="active"><a id="current" href="index.php">LOGIN</a></li>
      <li><a href="content.php">SYSTEM</a></li>
      <li><a href="resources.html">RESOURCES</a></li>
      <li><a href="service.html">SERVICE</a></li>
      <li><a href="contact.html">CONTACT</a></li>
    </ul>
  </div>
  <div id="sidebar" class="login-card">
  <form action="index.php" method="post">
    <input type="text" name="username" placeholder="Username" value="<?php echo $submitted_username; ?>" >
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="login" class="login login-submit" value="Login">
  </form>    
    
  </div>
  <div id="content">
       <h2> Cyber Crime Case System</h2>
    <h3 style="color:red">Warning</h3>
<p>
This is a private system.  Unauthorized access to or use of this system  is strictly prohibited. Unauthorized users may be subject to criminal prosecution under the law.
</p>

  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.cs.uml.edu/~xinwenfu/">homepage</a> | <a href="mailto:xinwenfu@gmail.com">contact</a> | &copy; 2015 Xinwen Fu<a rel="license" href="http://creativecommons.org/licenses/by/3.0/"></a></p>
    </div>
  </div>
</div>
</body>
</html>
