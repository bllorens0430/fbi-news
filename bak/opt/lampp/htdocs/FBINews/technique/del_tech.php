<?php
  require("../check.php");
		
//	include("db.php");  

  $id =$_REQUEST['tech_index'];
  
  $sql = "DELETE FROM technique WHERE technique_index  = :tech_index";
  $array_param=array(':tech_index'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);  
    
  // sending query
//  mysql_query($sql)
//  or die(mysql_error());  	
  
  // We redirect them to the login page
  header("Location: index.php");
  die("Redirecting to: index.php"); 
?>