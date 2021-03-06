<?php
	// First we execute our common code to connection to the database
	// and start the session
	require("../session.php");
	require("../syscheck.php");
	require("../common.php");
	if (strcmp($_SESSION['user']['username'], 'root')!=0) {
	header("Location: ../content.php");
	die("Redirecting to: ../content.php");
  }

	$success='';
	$user_error='';
	$email_error='';
	$pw_error='';
	$username='';
	$email='';

	// This if statement checks to determine whether the registration
	// form has been submitted
	// If it has, then the registration code is run, otherwise the form is displayed
	if(!empty($_POST))
	{
		// Ensure that the user has entered a non-empty username
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

		// Ensure that the user has entered a non-empty password
		if(empty($_POST['password']))
		{
			$pw_error="<span class='error'> Please enter a password. </span>";
		}

		// Make sure the user entered a valid E-Mail address
		// filter_var is a useful PHP function for validating form input, see:
		// http://us.php.net/manual/en/function.filter-var.php
		// http://us.php.net/manual/en/filter.filters.php
		if(empty($_POST['email'])OR$_POST['email']=='')
		{
			$email_error="<span class='error'>Please enter an email.</span>";
		}
		elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{

			$email_error="<span class='error'>Invalid E-Mail Address</span>";
		}
		else{
			$email=htmlspecialchars($_POST['email']);
		}

		// We will use this SQL query to see whether the username entered by the
		// user is already in use.
		// A SELECT query is used to retrieve data from the database.
		// :username is a special token,
		// we will substitute a real value in its place when we execute the query.
		$query = "SELECT 1 FROM users WHERE username = :username";

		// This contains the definitions for any special tokens that we place in
		// our SQL query.  In this case, we are defining a value for the token
		// :username.  It is possible to insert $_POST['username'] directly into
		// your $query string; however doing so is very insecure and opens your
		// code up to SQL injection exploits.  Using tokens prevents this.
		// For more information on SQL injections, see Wikipedia:
		// http://en.wikipedia.org/wiki/SQL_Injection
		$query_params = array(
			':username' => $_POST['username']
		);

		try
		{
			// These two statements run the query against your database table.
			$stmt = $db->prepare($query);
			$result = $stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			// Note: On a production website, you should not output $ex->getMessage().
			// It may provide an attacker with helpful information about your code.
			error_log("Failed to run query: " . $ex->getMessage());
		}

		// The fetch() method returns an array representing the "next" row from
		// the selected results, or false if there are no more rows to fetch.
		$row = $stmt->fetch();

		// If a row was returned, then we know a matching username was found in
		// the database already and we should not allow the user to continue.
		if($row)
		{
			if($user_error==""){
			$user_error="<span class='error'> This username is already in use </span>";
		}
		}

		// Now we perform the same type of check for the email address, in order
		// to ensure that it is unique.
		$query = "
			SELECT
				1
			FROM users
			WHERE
				email = :email
		";

		$query_params = array(
			':email' => $_POST['email']
		);

		try
		{
			$stmt = $db->prepare($query);
			$result = $stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			error_log("Failed to run query: " . $ex->getMessage());
		}

		$row = $stmt->fetch();

		if($row)
		{
			if ($email_error=="") {
				$email_error="<span class='error'> This email address is already registered </span>";
			}
		}



		//Only insert the values if they made no errors
		if($user_error==''&&$email_error==''&&$pw_error==''){
			// An INSERT query is used to add new rows to a database table.
			// Again, we are using special tokens (technically called parameters) to
			// protect against SQL injection attacks.
			$query = "
				INSERT INTO users (
					username,
					password,
					salt,
					email
				) VALUES (
					:username,
					:password,
					:salt,
					:email
				)
			";

			// A salt is randomly generated here to protect again brute force attacks
			// and rainbow table attacks.  The following statement generates a hex
			// representation of an 8 byte salt.  Representing this in hex provides
			// no additional security, but makes it easier for humans to read.
			// For more information:
			// http://en.wikipedia.org/wiki/Salt_%28cryptography%29
			// http://en.wikipedia.org/wiki/Brute-force_attack
			// http://en.wikipedia.org/wiki/Rainbow_table
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

			// This hashes the password with the salt so that it can be stored securely
			// in your database.  The output of this next statement is a 64 byte hex
			// string representing the 32 byte sha256 hash of the password.  The original
			// password cannot be recovered from the hash.  For more information:
			// http://en.wikipedia.org/wiki/Cryptographic_hash_function
			$password = hash('sha256', $_POST['password'] . $salt);

			// Next we hash the hash value 65536 more times.  The purpose of this is to
			// protect against brute force attacks.
			// Now an attacker must compute the hash 65537
			// times for each guess they make against a password, whereas if the password
			// were hashed only once the attacker would have been able
			// to make 65537 different guesses in the same amount of time instead of only one.
			for($round = 0; $round < 65536; $round++)
			{
				$password = hash('sha256', $password . $salt);
			}

			// Here we prepare our tokens for insertion into the SQL query.  We do not
			// store the original password; only the hashed version of it.  We do store
			// the salt (in its plaintext form; this is not a security risk).
			$query_params = array(
				':username' => $_POST['username'],
				':password' => $password,
				':salt' => $salt,
				':email' => $_POST['email']
			);

			try
			{
				// Execute the query to create the user
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
				$success="<p>Successfly registered $username with email: $email.</p>";
			}
			catch(PDOException $ex)
			{
				// Note: On a production website, you should not output $ex->getMessage().
				// It may provide an attacker with helpful information about your code.
				error_log("Failed to run query: " . $ex->getMessage());
			}
		}
		// This redirects the user back to the login page after they register
		//header("Location: admin.php");

		// Calling die or exit after performing a redirect using the header function
		// is critical.  The rest of your PHP script will continue to execute and
		// will be sent to the user if you do not die or exit.
		//die("Redirecting to admin.php");
	}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../bootstrap-3.3.5-dist/css/hcisec.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>Register</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>
</head>

<body>
<div class='container'>
<?php include '../header2.php' ?>
<div id='sidebar'>
	<h2>Register</h2>
</div>
<div id= 'content'>
  <script type="text/javascript">
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

    <?php echo $success; ?>
    <form action="register.php" method="post" onsubmit="return checkPassword(this)">
        Username:<br />
        <input type="text" name="username" value=<?php echo "'$username'"?> />
        <?php echo $user_error; ?>
        <br /><br />
        E-Mail:<br />
        <input type="text" name="email" value=<?php echo "'$email'"?> />
        <?php echo $email_error; ?>
        <br /><br />
        Password:<br />
        <input class='password' type="password" name="password" value="" />
        <?php echo $pw_error; ?>

        <br /><br />

         <p>Repeat password:<br />
          <input class='password' type="password" name="password2" value="" />
          <br />
          <br />
          <input type="submit" value="Register" />
        </p>
    </form>
    <p> <a href="admin.php">Go Back</a></p>
</div>
</div>
<?php include '../footer.php' ?>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.3.5-dist/../bootstrap-3.3.5-dist/../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
