<?php  

   $db = mysql_connect("localhost","root","fxw0528t");
   if(!$db) die("Error connecting to MySQL database.");
   mysql_select_db("mydb" ,$db);
?>

