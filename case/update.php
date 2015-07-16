<?php
  require("../session.php"); // start or resume a session
  require("../check.php"); // check if there is a session ongoing
  require("../common.php"); // connect to the database

  $id =$_REQUEST['case_index'];
  $id= substr($id, 0, 10) . ' ' . substr($id, 10);
  $sql = "SELECT * FROM cases WHERE case_index  = :case_index";
  $array_param=array(':case_index'=>$id);
  $sth = $db->prepare($sql);
  $sth->execute($array_param);
  $row = $sth->fetch();

  if (!$row)
  {
	  die("Error: Data not found..");
  }

  $case_index=$row['case_index'] ;
  $date = DateTime::createFromFormat('Y-m-d h:i:s', $row['news_date'] );
  $news_date=$date->format('m.d.y');

  $news_url= $row['news_url'] ;
  $news_title=$row['news_title'] ;
  $crime=$row['crime'] ;
  $crime_classification=$row['crime_classification'] ;
  $investigation=$row['investigation'] ;
  $notes=$row['notes'] ;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Edit News</title>
</head>

<body>

<div id="container">
  <?php include '../header2.php' ?>


  <div id="content">



<script type="text/javascript">
// Original JavaScript code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.
function checkDate() {
    var field=document.getElementById("news_date");
    var allowBlank = false;
    var minYear = 0;
    var maxYear = 99;

    var errorMsg = "";

    // regular expression to match required date format
    re = /^(\d{1,2}).(\d{1,2}).(\d{2})$/;

	if(field.value != '') {
		if(regs = field.value.match(re)) {
			if(regs[1] < 1 || regs[1] > 12) {
				errorMsg = "Invalid value for day: " + regs[1];
			} else
			if(regs[2] < 1 || regs[2] > 31) {
				errorMsg = "Invalid value for month: " + regs[2];
			} else
			if(regs[3] < minYear || regs[3] > maxYear) {
				errorMsg = "Invalid value for year: " + regs[3] + " - must be between " + minYear + " and " + maxYear;
			}
		} else {
			errorMsg = "Invalid date format: " + field.value + "must be mm.dd.yy!" ;
		}
	} else if(!allowBlank) {
		errorMsg = "Empty date not allowed!";
	}

	if(errorMsg != "") {
		alert(errorMsg);
		field.focus();
		return false;
	}

	return true;
}

</script>

<form id="fbi-news" name="FBI News" method="post" action="view.php" onsubmit="return checkDate();">
<table>
<tr>
<td> News Index </td>
<td> News Date </td>
<td> News URL </td>
</tr>
<tr>
<td>
  <input name="news_index" type="text" id="news_index" size="30"
  value="<?php echo htmlspecialchars(stripslashes($case_index ), ENT_QUOTES, 'UTF-8') ?>" readonly/> </td>
  <td>
  <input name="news_date" type="text" id="news_date" size="10"
  value="<?php echo $news_date ?>"/></td>
  <td>
  <input name="news_url" style="display:table-cell; width:100%" type="text" id="news_url" size="70"
  value="<?php echo htmlspecialchars(stripslashes($news_url), ENT_QUOTES, 'UTF-8') ?>" /></td>
	  </tr>
</table>

<p>News Title<br />
  <input name="news_title" style="display:table-cell; width:100%" type="text" id="news_title" size="128"
  value="<?php echo htmlspecialchars(stripslashes($news_title), ENT_QUOTES, 'UTF-8') ?>"/>
</p>

<p>Crime<br />
  <textarea style="display:table-cell; width:100%" name="crime" id="crime" cols="128" rows="5" form="fbi-news"><?php echo htmlspecialchars(stripslashes($crime), ENT_QUOTES, 'UTF-8') ?></textarea>
</p>

<table>
<tr>
  <td>Crime Classification</td>
  <td>Techniques Used (use (<span class='error'>ctrl</span>) on windows and (<span class='error'>command</span>) on mac to select multiple options)</td>
</tr>
<tr>
  <td><input name="crime_classification" type="text" id="crime_classification" size="53"
  value="<?php echo htmlspecialchars(stripslashes($crime_classification), ENT_QUOTES, 'UTF-8') ?>"/></td>
  <td><select name="has_technique[]" multiple>
 <?php
  $sql="SELECT technique_name, technique_index FROM technique";
  $sth=$db->prepare($sql);
  if ($sth->execute()) {
    if($sth->rowCount()>0){
    $options=[];
      while($result=$sth->fetch(PDO::FETCH_ASSOC)){
        $id=strip_tags($result['technique_index']);
        $name=strip_tags($result['technique_name']);
        $options[$id]=$name;
      }
      $sql="SELECT technique_technique_index FROM cases_has_technique WHERE cases_case_index='$case_index'";
      $sth=$db->prepare($sql);
        if ($sth->execute()) {
          $selected=[];
          while($result=$sth->fetch(PDO::FETCH_ASSOC)){
            $selected[]=$result['technique_technique_index'];
          }
        foreach ($options as $id => $name) {
          if(in_array($id, $selected)){
            echo "<option value='$id' selected>$name</option>";
          }
          else{
            echo "<option value='$id'>$name</option>";
          }
        }

      }
    }
  }
  ?>
  </select></td>
 </tr>
</table>

<p>Investigation<br />
  <textarea style="display:table-cell; width:100%" name="investigation" id="investigation" cols="128" rows="5" form="fbi-news"><?php echo htmlspecialchars(stripslashes($investigation), ENT_QUOTES, 'UTF-8') ?></textarea>
</p>

<p>Notes<br />
  <textarea name="notes" style="display:table-cell; width:100%" id="notes" cols="128" rows="5" form="fbi-news"><?php echo htmlspecialchars(stripslashes($notes), ENT_QUOTES, 'UTF-8') ?></textarea>
</p>

  <table>
  <tr>
  <td>
	<input type="submit" name="Update" value="Update" />
	</td>
  </tr>
  </table>
</form>

<form action="view.php">
<input type="submit" value="Cancel">
</form>

  </div>
  <?php include '../footer.php' ?>
</div>


</body>
</html>
