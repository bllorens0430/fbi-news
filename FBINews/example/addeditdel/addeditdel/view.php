<?php
require("db.php");
$id =$_REQUEST['BookID'];

$result = mysql_query("SELECT * FROM books WHERE BookID  = '$id'");
$test = mysql_fetch_array($result);
if (!$result) 
		{
		die("Error: Data not found..");
		}
				$Title=$test['Title'] ;
				$Author= $test['Author'] ;					
				$PublisherName=$test['PublisherName'] ;
				$CopyrightYear=$test['CopyrightYear'] ;

if(isset($_POST['save']))
{	
	$title_save = $_POST['title'];
	$author_save = $_POST['author'];
	$name_save = $_POST['name'];
	$copy_save = $_POST['copy'];

	mysql_query("UPDATE books SET Title ='$title_save', Author ='$author_save',
		 PublisherName ='$name_save',CopyrightYear ='$copy_save' WHERE BookID = '$id'")
				or die(mysql_error()); 
	echo "Saved!";
	
	header("Location: index.php");			
}
mysql_close($conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form method="post">
<table>
	<tr>
		<td>Title:</td>
		<td><input type="text" name="title" value="<?php echo $Title ?>"/></td>
	</tr>
	<tr>
		<td>Author</td>
		<td><input type="text" name="author" value="<?php echo $Author ?>"/></td>
	</tr>
	<tr>
		<td>Publisher Name</td>
		<td><input type="text" name="name" value="<?php echo $PublisherName ?>"/></td>
	</tr>
	<tr>
		<td>Copyright Year</td>
		<td><input type="text" name="copy" value="<?php echo $CopyrightYear ?>"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="save" value="save" /></td>
	</tr>
</table>

</body>
</html>
