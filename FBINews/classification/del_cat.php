<?php
require("../session.php"); // start or resume a session
require("../check.php"); // check if there is a session ongoing
require("../common.php"); // connect to the database

		
//	include("db.php");  

  $id =$_REQUEST['cat_number'];
  
  $sql = "DELETE FROM crime_category WHERE cat_number  = :cat_number";
  $array_param=array(':cat_number'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);  
    

  header("Location: index.php");
  die("Redirecting to: index.php"); 
?>