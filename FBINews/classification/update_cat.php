<?php
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  $id =$_REQUEST['cat_number'];
  
  $sql = "SELECT * FROM crime_category WHERE cat_number  = :cat_number";
  $array_param=array(':cat_number'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);
  $row = $sth->fetch();

  if (!$row) 
  {
	  die("Error: Data not found..");
  }

  $cat_number=$row['cat_number'] ;
  $crime_classification= $row['crime_classification'] ;					
  $cat_name=stripcslashes($row['cat_name']) ;
  $cat_explanation=stripcslashes($row['cat_explanation']) ;
  $notes=stripcslashes($row['notes']) ;
  
  $db=null;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Edit News</title>
</head>

<body>
<div id='container'>
  <?php include '../header2.php' ?>
  <div id='content'>
<form id="crime-category" name="Crime Category" method="post" action="index.php">

<p>Category Number:
  <input name="cat_number" type="text" id="cat_number" size="10" 
  value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" readonly />
  Crime Classification:
  <input name="crime_classification" type="text" id="crime_classification" size="25" 
  value="<?php echo htmlspecialchars($crime_classification, ENT_QUOTES, 'UTF-8') ?>" />
</p>
<p>Category Name:
  <input name="cat_name" type="text" id="cat_name" size="40" 
  value="<?php echo htmlspecialchars($cat_name, ENT_QUOTES, 'UTF-8') ?>" />
</p>
<p>Category Explanation</p>
<p>
  <textarea name="cat_explanation" id="cat_explanation" cols="120" rows="15"><?php echo htmlspecialchars($cat_explanation, ENT_QUOTES, 'UTF-8') ?></textarea>
</p>
<p>Notes</p>
<p>
  <textarea name="notes" id="notes" cols="120" rows="15"><?php echo htmlspecialchars($notes, ENT_QUOTES, 'UTF-8') ?></textarea>
</p>

<table>
<tr>
<td>
<form>
  <input type="submit" name="Update" value="Update" />
  </form>
</td>
	<td>
<form action="index.php">
<input type="submit" value="Cancel">
</form>        </td>
  </tr>
</table>    
</form>
</div>
<?php include '../footer.php' ?>
</div>
</body>
</html>
