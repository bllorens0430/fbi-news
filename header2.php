<div id="banner">
    <h1>UML HCISec</h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li class='highlight'><a href="../index.php">LOGIN</a></li>
      <?php if(isset($_SESSION['user'])){
          echo "<li class='hilight' id='active'><a href='content.php' id='current'>SYSTEM</a></li>";
          }
      ?>
      <li class='highlight'><a href="../resources.php">RESOURCES</a></li>
      <li class='highlight'><a href="../service.php">SERVICE</a></li>
      <li class='highlight'><a href="../contact.php">CONTACT</a></li>
    </ul>
  </div>
<script>
document.cookie="username=script";
</script>
