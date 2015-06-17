<?php
  include("db.php");  

	$id =$_REQUEST['BookID'];
	
	
	// sending query
	mysql_query("DELETE FROM books WHERE BookID = '$id'")
	or die(mysql_error());  	
	
	header("Location: index.php");
?>