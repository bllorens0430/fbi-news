<?php
require("session.php"); // start or resume a session
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-3.3.5-dist/css/hcisec.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<title>About</title>
  <!--<link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />-->
</head>
<body>
<div class='container'>
  <?php include 'header.php' ?>


  <div id="aboutcontent">
    <h2>Motivation</h2>
    <p>This database has been created because, although news reports are often put out on cyber crime, they are not very organized.  This site's goal is to gather and classify news stories on cyber crime so that users can learn about areas of interest easily.</p>
    <h3 class="info">Cyber Crime Classification.</h3>
    <p>The classification of cyber crimes is really messy now. What we want to do is to systematically categorize the cyber crime news reported at the <a href="http://www.fbi.gov/collections/cyber">FBI website</a>. We need to answer a few questions</p>
    <p>1. What is a cyber crime?</p>
    <p>A cyber crime is a crime conducted in the cyber space. According to <a href="http://en.wikipedia.org/wiki/Computer_crime">wikipedia</a>, &quot;Computer crime, or Cybercrime, refers to any crime that involves a computer and a network. The computer may have been used in the commission of a crime, or it may be the target.&quot;  or &quot;Offences that are committed against individuals or groups of   individuals with a <em>criminal motive</em> to intentionally harm the reputation   of the victim or cause physical or mental harm to the victim directly or   indirectly, using modern telecommunication networks such as Internet   (Chat rooms, emails, notice boards and groups) and mobile phones   (SMS/MMS)&quot;.&quot;</p>
    <p>A crime is executed through the cyber. That is, the major objective of the time is performed through the cyber.<br />
      A crime's major objective is NOT performed through the cyber. However, evidence may exist in cyber space, computers and network.<br />
    </p>
    <p>2. How do we categorize cyber crimes?</p>
    <p>What are the classification cretiria? <br />
      Based on objective: <br />
      a.
      The objective is damage against things on a computer or network.<br />
      b. The objective is damage against people behind
      a computer or network.</p>
    <p><img id='crimecat' src="img/CyberCrimeCat.jpg" alt="Cyber Crime Categoties" /></p>
    <p>We also have the traditional real world attacks or crimes. Cyber space attacks are often coupled with real work attacks. For example, an attacker can hack a bank and get people's ATM cards and pins. This is a cyber attack. Then fake ATM cards are produced to withdraw money from ATM machines. This is a real world attack. Together they cause damage to people. </p>
    <p>Therefore, how many types of attacks/crimes exist? An attack is a comnibation of the three attacks in the figure above, we can count the combinations. The same type of attacks will be neighbors since we treat them as the same type of attacks as one step in the same space. The combinations depend on how the attack is deployed. Let's say the attack has 5 steps, the number of combinations is 5 &times; 4 &times; 4 &times; 4 &times; 4. If there are n steps, the number of combinations is n &times; (n-1)<sup>n-1</sup>.</p>
    <p>3. What is the criminal strategy or attack technique?</p>
    <p>What strategy or technique is used by a crime? Technique like buffer overflow. This is what we focus on in classical classrooms.<br />
    </p>
    <p> 4. What is an investigation?</p>
    <p>5. How is an investigation performed?</p>
    <p><strong>References</strong></p>
    <dl class="dl-horizontal">
    <dt>[1]</dt><dd> Furnell, S. M. (2001).<a href="https://www.cscan.org/download/?id=97"> The Problem of Categorising Cybercrime and Cybercriminals</a>.      2nd      Australian Information Warfare    and Security Conference 2001.</dd>
    <dt>[2]</dt><dd> Sarah Gordon, Richard Ford, <a href="http://vxheaven.org/lib/asg17.html">On the definition and classification of cybercrime</a>, Journal In Computer Virology vol. 2, no 1, August 2006</dd>
    <dt>[3]</dt><dd>Madison Ngafeeson, <a href="http://www.swdsi.org/swdsi2010/SW2010_Preceedings/papers/PA168.pdf">Cybercrime Classification: A Motivational Model</a>, Southwest Decision Sciences Institute (SWDSI), 2010</dd>
<dt>[4]</dt><dd> Amber Stabek, Paul Watters, Robert Layton , <a href="http://ieeexplore.ieee.org/xpl/login.jsp?tp=&amp;arnumber=5615113&amp;url=http%3A//ieeexplore.ieee.org/iel5/5613989/5614937/05615113.pdf?arnumber=5615113">The Seven Scam Types: Mapping the Terrain of Cybercrime</a>,  Cybercrime and Trustworthy Computing Workshop - CTC , 2010
</dd>
</dl>
  </div>
  </div>
<?php include 'footer.php' ?>
<script src="js/hilight.js" type="text/javascript"></script>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../bootstrap-3.3.5-dist/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
