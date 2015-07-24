<?php
require 'common2.php';
$sql="SELECT * FROM evil";
$mysql=$db->prepare($sql);
echo "<h1>Stolen Information:</h1>";
if($mysql->execute()){
  while($result=$mysql->fetch(PDO::FETCH_ASSOC)){
    echo"user: ".$result['name']." pw: ".$result['pw']."<br>";
  }
}
?>
