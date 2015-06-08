<?php
require("../session.php"); // start or resume a session
require("../check.php"); // check if there is a session ongoing
require("../common.php"); // connect to the database

		
//	include("db.php");  

  $email =$_REQUEST['email'];
  
  $sql = "DELETE FROM users WHERE email  = :email";
  $array_param=array(':email'=>$email);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);  
    
  header("Location: memberlist.php");
  die("Redirecting to: memberlist.php"); 
?>