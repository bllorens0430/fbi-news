<?php
  require("check.php");
		
//	include("db.php");  

  $id =$_REQUEST['case_index'];
  
  $sql = "DELETE FROM cases WHERE case_index  = :case_index";
  $array_param=array(':case_index'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);  
    
  // sending query
//  mysql_query($sql)
//  or die(mysql_error());  	
  
  // We redirect them to the login page
  header("Location: view.php");
  die("Redirecting to: view.php"); 
?>