<?php
require("../session.php"); // start or resume a session
require("../check.php"); // check if there is a session ongoing
require("../common.php"); // connect to the database

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