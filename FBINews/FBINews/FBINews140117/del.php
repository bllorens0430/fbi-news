<?php
require("check.php");
		
  include("db.php");  

	$id =$_REQUEST['case_index'];

	$sql = "DELETE FROM cases WHERE case_index="."'" . $id . "'";
	
	// sending query
	mysql_query($sql)
	or die(mysql_error());  	
	
  include("index.php");  
?>