<script>
  document.cookie="username=script";
</script>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img alt="HCISec" class="lock" src="img/lock-logo.png" ></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="hilight"><a href="service.php">Home</a></li>
          <?php if(isset($_SESSION['user'])){
                echo "<li class='hilight'><a href='logout.php'>Logout</a></li>";
                echo "<li class='hilight'><a href='content.php'>System</a></li>";
                }
                else{
                  echo"<li class='hilight'><a href='login.php'>Login</a></li>";
                }
            ?>
            <li class='hilight'><a href="about.php">About</a></li>
            <li class='hilight'><a href="contact.php">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
