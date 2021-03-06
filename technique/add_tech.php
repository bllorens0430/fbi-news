<?php
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  $t = microtime(true);
  $micro = sprintf("%06d",($t - floor($t)) * 1000000);
  $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
  ?>

  <!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Add FBI News</title>
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div id='container'>
      <?php include '../header2.php' ?>
      <div id='content'>
  <p><strong>Cyber Technique Input</strong></p>

  <form id="technique" name="technique" method="post" action="index.php">
  <table>
  <tr>
  <td> Technique Index </td>
  <td> Technique Name</td>
  <td> Technique Category</td>
  </tr>
  <tr>
  <td>
    <input name="tech_index" type="text" id="tech_index" size="42" value="<?php echo $d->format("Y-m-d H:i:s.u") ?>" readonly/> </td>
    <td>
    <input name="tech_name" type="text" id="tech_name" size="42" /></td>
    <td><input name="tech_cat" type="text" id="tech_cat" size="42" /></td>
    </tr>
  </table>
  <p>Technique Details<br />
    <textarea name="tech_details" id="tech_details" cols="128" rows="5" form="technique"></textarea>
  </p>
  <p>Technique References<br />
    <textarea name="tech_refs" id="tech_refs" cols="128" rows="5" form="technique"></textarea>
  </p>

  <p>Notes<br />
    <textarea name="tech_notes" id="tech_notes" cols="128" rows="5" form="technique"></textarea>
  </p>
  <table>
  <tr>
  <td>
    <input type="submit" name="Add" value="Add" />
    </td>
  </tr>
  </table>
  </form>

<form action="index.php">
    <input type="submit" value="Cancel">
</form>
  </div>
  <?php include '../footer.php' ?>
  </div>
  </body>
  </html>
