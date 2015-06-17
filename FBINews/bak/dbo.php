<?php  
   $dsn = 'mysql:host=localhost;dbname=mydb';
   $databaseUsername="root";
   $databasePassword="fxw0528t";
   try {
	   $dboh = new PDO($dsn, $databaseUsername, $databasePassword,
	   array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   } catch (PDOException $e) {
	   echo $e->getMessage();
   }
?>

