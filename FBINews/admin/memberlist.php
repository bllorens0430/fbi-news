<?php
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
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
	  die("Failed to run query: " . $ex->getMessage());
  }
	  
  // Finally, we can retrieve all of the found rows into an array using fetchAll
  $rows = $stmt->fetchAll();
?>
<h1>Memberlist</h1>
<table>
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>E-Mail Address</th>
	</tr>
	<?php foreach($rows as $row): ?>
		<tr>
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