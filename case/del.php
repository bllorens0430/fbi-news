<?php
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  $id =$_REQUEST['case_index'];
  $id= substr($id, 0, 10) . ' ' . substr($id, 10);
  $sql="DELETE FROM cases_has_technique WHERE cases_case_index=:case_index";
  $array_param=array(':case_index'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);
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
