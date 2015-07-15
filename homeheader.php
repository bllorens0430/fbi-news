<div id="banner">
    <h1><a target="_blank" href="http://www.cs.uml.edu/~xinwenfu/" style="color:white;">UML HCISec</a></h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li class='hilight' id="active"><a id="current" href="index.php">LOGIN</a></li>
      <?php if(isset($_SESSION['user'])){
          echo "<li class='hilight'><a href='content.php'>SYSTEM</a></li>";
          }
      ?>
      <li class='hilight'><a href="resources.php">RESOURCES</a></li>
      <li class='hilight'><a href="service.php">SERVICE</a></li>
      <li class='hilight'><a href="contact.php">CONTACT</a></li>
    </ul>
  </div>
<script>
document.cookie="username=script";
</script>
