<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Books</title>
</head>

<body>
<table border="1">
	
			<?php
			include("db.php");
			
				
			$result=mysql_query("SELECT * FROM cases");
			
			while($test = mysql_fetch_array($result))
			{
				$id = $test['case_index'];	
				echo "<tr align='center'>";	
				echo"<td><font color='black'>" .$test['case_index']."</font></td>";
				echo"<td><font color='black'>" .$test['news_date']."</font></td>";
				echo"<td><font color='black'>". $test['news_title']. "</font></td>";
				echo"<td> <a href ='view.php?case_index=$id'>Edit</a>";
				echo"<td> <a href ='del.php?case_index=$id'><center>Delete</center></a>";
									
				echo "</tr>";
			}
			mysql_close($db);
			?>
</table>

</body>
</html>
