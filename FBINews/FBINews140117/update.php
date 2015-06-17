	<?php
    
    require("check.php");
    
    require("db.php");
    $id =$_REQUEST['case_index'];
    
    $result = mysql_query("SELECT * FROM cases WHERE case_index  = '$id'");
    $test = mysql_fetch_array($result);
    if (!$result) 
            {
            die("Error: Data not found..");
            }
                    $case_index=$test['case_index'] ;
                    $news_date= $test['news_date'] ;					
                    $news_url= $test['news_url'] ;					
                    $news_title=$test['news_title'] ;
                    $crime=$test['crime'] ;
                    $crime_classification=$test['crime_classification'] ;
                    $investigation=$test['investigation'] ;
                    $notes=$test['notes'] ;
    mysql_close($db);
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Edit News</title>
    </head>
    
    <body>
    
    <form id="fbi-news" name="FBI News" method="post" action="index.php">
    <table> 
    <tr> 
    <td> News Index </td>
    <td> News Date </td>
    </tr>
    <tr>
    <td>
      <input name="news_index" type="text" id="news_index" size="42" 
      value="<?php echo $case_index ?>"/> </td>
      <td>
      <input name="news_date" type="text" id="news_date" size="42" 
      value="<?php echo $news_date ?>"/></td>
      <td>
      <input name="news_url" type="text" id="news_url" size="42" 
      value="<?php echo $news_url ?>"/></td>
          </tr>
    </table>
    
    <p>News Title<br />
      <input name="news_title" type="text" id="news_title" size="128" value="<?php echo $news_title ?>"/>
    </p>
      
    <p>Crime<br />
      <textarea name="crime" id="crime" cols="128" rows="5" form="fbi-news"><?php echo $crime ?></textarea>
    </p>
    
    <p>Crime Classification<br />
      <input name="crime_classification" type="text" id="crime_classification" size="53" value="<?php echo $crime_classification ?>"/>
     </p>
     
    <p>Investigation<br />
      <textarea name="investigation" id="investigation" cols="128" rows="5" form="fbi-news"><?php echo $investigation ?></textarea>
    </p>
  
    <p>Notes<br />
      <textarea name="notes" id="notes" cols="128" rows="5" form="fbi-news"><?php echo $notes ?></textarea>
    </p>  
    
      <table>
      <tr>
      <td>
        <input type="submit" name="Update" value="Update" />
        </td>
        <td>
<form action="index.php">
    <input type="submit" value="Cancel">
</form>        </td>
      </tr>
      </table>    
    </form>
    
    </body>
    </html>
