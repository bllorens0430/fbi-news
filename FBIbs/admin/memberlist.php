<?php
  require("../session.php"); // start or resume a session
  require("../syscheck.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  if (strcmp($_SESSION['user']['username'], 'root')!=0) {
	header("Location: ../content.php");
	die("Redirecting to: ../content.php");
  }

  // Everything below this point in the file is secured by the login system

  // We can retrieve a list of members from the database using a SELECT query.
  // In this case we do not have a WHERE clause because we want to select all
  // of the rows from the database table.
  $query = "SELECT id, username, email FROM users";

  try
  {
	  // These two statements run the query against your database table.
	  $stmt = $db->prepare($query);
	  $stmt->execute();
  }
  catch(PDOException $ex)
  {
	  // Note: On a production website, you should not output $ex->getMessage().
	  // It may provide an attacker with helpful information about your code.
	  error_log("Failed to run query: " . $ex->getMessage());
  }

  // Finally, we can retrieve all of the found rows into an array using fetchAll
  $rows = $stmt->fetchAll();
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
	<h2>Memberlist</h2>
</div>
<div id='content'>
<table class='table-striped'>
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>E-Mail Address</th>
    <th></th>
    <th></th>
	</tr>
	<?php
	$count = "evenrow";
	foreach($rows as $row):
		?>
	<?php
		if ($count=="oddrow") {
			$count="evenrow";
		}
		else{
			$count="oddrow";
		}
		echo "<tr class='$count'>";
		?>
			<td><?php echo $row['id']; ?></td> <!-- htmlentities is not needed here because $row['id'] is always an integer -->
			<!-- You should
			  // always use htmlentities on user submitted values before displaying them
			  // to any users (including the user that submitted them).  -->
			<td><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td><?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td> <a href ='update_user.php?email=<?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?>'>Edit</a></td>
            <td> <a href ='del_user.php?email=<?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?>'>Delete</a></td>


		</tr>
	<?php endforeach; ?>
</table>
<a href="admin.php">Go Back</a><br />
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
