<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sidestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
 <?php include 'header.php' ?>
  <div id="sidebar">
    <h2>Crime Database</h2>
  </div>
  <div id="content">
    <h2>Search</h2>
	<form method="GET" action="service.html" onsubmit="return find"> 
 	Search for: <input type="text" name="find" /> in  
 	<Select NAME="table"> 
 	<Option VALUE="cases">Cases</option> 
 	<Option VALUE="crime_categories">Categories</option> 
 	<Option VALUE="techniques">Techniques</option> 
 	</Select> 
 	<input type="hidden" name="searching" value="yes" /> 
 	<input type="submit" name="search" value="Search" /> 
 	</form>

    <h2>Crime Cases</h3>
    <p>Our database has compiled various cases of cyber crime from the FBI and
     other sources. <a id='cases' href='cases.php'>Browse Cases</a></p>
    
    <h2>Crime Techniques</h3>
    <p>There are various techniques to carry out cyber 
      crime and corresponding defense mechanisms. Here is a list of some of them.
    <a id='techniques' href='techniques.php'>Browse Techniques</a></p>
    
    <h2>Crime Categories</h3>
    <p>The categories used by the FBI may use a mix of cyber crime techniques.  
      The categories are listed here for your convenience.
    <a id='classes' href='categories.php'>Browse Categories</a></p>
    
  </div>
  <?php include 'footer.php' ?>
</div>
</body>
</html>

