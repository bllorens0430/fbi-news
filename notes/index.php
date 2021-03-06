<?php
require("../session.php"); // start or resume a session
require("../check.php"); // check if there is a session ongoing
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
  <?php include '../header2.php' ?>
  <div id='sidebar'>
        <h2>Motivation</h2>
  </div>
  <div id="content">
    <p class="info"><img class="noborder" src="img/flower.jpg" alt="flower" title="flower"/>Design of the FBI cyber crime news database.</p>
    <p><img  src="img/DB.png" width="500" alt="Cyber Crime DB"  /></p>

    <p class="info"><img class="noborder" src="img/flower.jpg" alt="flower" title="flower"/>Cyber Crime Classification.</p>
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
    <p><img src="img/CyberCrimeCat.jpg" width="500" alt="Cyber Crime Categoties" /></p>
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
  <?php include '../footer.php' ?>
</div>
</body>
</html>
