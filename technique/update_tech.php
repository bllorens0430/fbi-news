<?php
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  $id =$_REQUEST['tech_index'];
  $id= substr($id, 0, 10) . ' ' . substr($id, 10);
  $sql = "SELECT * FROM technique WHERE technique_index  = :tech_index";
  $array_param=array(':tech_index'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);
  $row = $sth->fetch();

  if (!$row)
  {
	  die("Error: Data not found..");
  }

  $tech_index=$row['technique_index'] ;
  $tech_name= $row['technique_name'] ;
  $tech_cat=$row['technique_category'] ;
  $tech_details=$row['technique_details'] ;
  $tech_refs=$row['technique_url'] ;
  $tech_notes=$row['notes'] ;

  //mysql_close($db);
  $db=null;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Edit News</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id='container'>
  <?php include '../header2.php' ?>
  <div id='content'>
<form id="technique" name="technique" method="post" action="index.php">
<table>
<tr>
<td>Technique Index </td>
<td>Technique Name</td>
<td>Technique Category</td>
</tr>
<tr>
<td>
  <input name="tech_index" type="text" id="tech_index" size="42"
  value="<?php echo htmlspecialchars($tech_index, ENT_QUOTES, 'UTF-8') ?>" readonly/> </td>
  <td>
  <input name="tech_name" type="text" id="tech_name" size="42"
  value="<?php echo htmlspecialchars($tech_name, ENT_QUOTES, 'UTF-8') ?>"/></td>
  <td>
  <input name="tech_cat" type="text" id="tech_cat" size="42"
  value="<?php echo htmlspecialchars($tech_cat, ENT_QUOTES, 'UTF-8') ?>"/></td>
	  </tr>
</table>

<p>Technique Details<br />
  <textarea name="tech_details" id="tech_details" cols="128" rows="5" form="technique"><?php echo htmlspecialchars($tech_details, ENT_QUOTES, 'UTF-8') ?></textarea>
</p>
<p>Technique References<br />
  <textarea name="tech_refs" id="tech_refs" cols="128" rows="5" form="technique"><?php echo htmlspecialchars($tech_refs, ENT_QUOTES, 'UTF-8') ?></textarea>
</p>

<p>Notes<br />
  <textarea name="tech_notes" id="tech_notes" cols="128" rows="5" form="technique"><?php echo htmlspecialchars($tech_notes, ENT_QUOTES, 'UTF-8') ?></textarea>
</p>

  <table>
  <tr>
  <td>
	<input type="submit" name="Update" value="Update" />
	</td>
  </tr>
  </table>
</form>

<form action="index.php">
<input type="submit" value="Cancel">
</form>
</div>
<?php include '../footer.php' ?>
</div>

</body>
</html>
