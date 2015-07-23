<?php

require 'common2.php';
echo'<h1>SECRET#.com home of the Secret #</h1>';
if(isset($_POST['(re)generate'])){
  $sql="
  CREATE TABLE IF NOT EXISTS dummy
  (
  number int NOT NULL AUTO_INCREMENT,
  name varchar(255),
  pw varchar(255),
  PRIMARY KEY (number)
  );";
  $mysql=$db->prepare($sql);
  $mysql->execute();
  $sql="DELETE FROM dummy";
  $mysql=$db->prepare($sql);
  $mysql->execute();
  $user='user';
  for ($i=0; $i < 11; $i++) {
    if($i==0){
      $name='admin';
    }
    else{
      $name=$user.$i;
    }
    $sql="INSERT INTO dummy (name, pw) VALUES ('$name', 'pw')";
    $mysql=$db->prepare($sql);
    $mysql->execute();
  }
}
if(isset($_POST['User'])){
  $name=$_POST['name'];
  $pw=$_POST['pw'];
  $sql="INSERT INTO dummy (name, pw) VALUES ('$name', '$pw')";
  echo $sql;
  $mysql=$db->prepare($sql);
  $mysql->execute();
}
if(isset($_POST['login'])){
  $name=$_POST['name'];
  $pw=$_POST['pw'];
  $id=$_POST['id'];
  $sql="SELECT * FROM dummy WHERE name='$name' and pw='$pw' and number=$id";
  echo $sql;
  $mysql=$db->prepare($sql);
  if($mysql->execute()&&$mysql->rowCount()===1){
    if($name=='admin'){
      echo 'The Secret # is: 2893';
    }
    else{
      echo'Your account does not have access to the Secret #';
    }
  }
  else{
    echo"<br>LOGIN FAILED<br>";
  }

}

?>
<!--generate/restore table data-->
<form method='POST' action='dummy.php'>
  <input name='(re)generate' type='submit' value='(re)generate table'>
</form>

<!--create account-->
<form method='POST' action='dummy.php'>
  <input name='name' type='text'>
  <input name='pw' type='password'>
  <input name='User' type='submit' value='Add User'>
</form>

<!--login-->
<form method='POST' action='dummy.php'>
  Name<input name='name' type='text'>
  PW<input name='pw' type='password'>
  ID<input name='id' type='text'>
  <input name='login' type='submit' value='login'>
</form>
<?php

$sql="SELECT name, number FROM dummy";
$mysql=$db->prepare($sql);
if($mysql->execute()){
  echo"<h2> These are the users of the table </h2>";
  while($result=$mysql->fetch(PDO::FETCH_ASSOC)){
    echo $result['name'];
    echo " ID:".$result['number'];
    echo '<br>';
  }
}
else{
  echo "O no something went wrong!";
}
?>
