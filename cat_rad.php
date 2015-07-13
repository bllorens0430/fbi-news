<?php
	require 'common.php';
	function cat_rad($db){
		$buttons=array();
		$buttonNames=array();
		//special case for 0 classification
		$buttonNames['0']='Unclassified';


     $sql="SELECT crime_classification, cat_name FROM crime_category GROUP BY crime_classification";
     foreach($db->query($sql) as $result){
     	$class=htmlspecialchars($result['crime_classification']);
     	$name=str_replace('<b>', '##b##', $result['cat_name']);
          $name=str_replace('</b>', '##/b##', $name);
          $name=htmlspecialchars($name);
          $name=str_replace('##b##', '<b>', $name);
          $name=str_replace('##/b##', '</b>', $name);
     	if(!isset($buttons[substr($class, 0,4)])){
     		$buttons[substr($class, 0,4)]="";
     	}
     	if(substr($class, 4,4)=='0000'){
     		//general case
     		$buttonNames[substr($class, 0,4)]=$name;
     	}
     	elseif($class!='0'){
     		$buttons[substr($class, 0,4)].= "<input type='radio' name='cases' value='".$class."'";
     		if(isset($_POST['cases'])&&$class==$_POST['cases']){
     			$buttons[substr($class, 0,4)].=" checked";
     		}
     		$buttons[substr($class, 0,4)].=">".$name."<br>";
     	}


     }
     $tr_counter='evenrow';
     echo"<div id='dbtable'><table><tr><th>Category</th><th>Include in Data?</th><th>Show Subcategories</th></tr><tr>";
     foreach ($buttons as $button => $input) {
     	if ($tr_counter=='evenrow') {
     		$tr_counter='oddrow';
     	}
     	else{
     		$tr_counter='evenrow';
     	}
     	echo "<tr class='$tr_counter'>
     	<td><h4><span class='overflow'>".$buttonNames[$button]."</span></h4></td>
     	<td><input type='radio' name='cases' value='".$button."'";
     	if(isset($_POST['cases'])&&$button==$_POST['cases']&&$_POST['cases']!='all'){
     		echo ' checked';
     	}
     	echo" >Include</td>
     	<td><button type='button' name='".$button."'class='styled-button-DV' onclick='toggleCase(this.name)'>Subcategories</button></td>
     	</tr>
     	<div  class='".$button." miniwindow hide'>
     	<button type='button' name='".$button."'class='styled-button-DV' onclick='toggleCase(this.name)'>Hide</button><br>"
     	.$input."</div>";
     }
     echo "</table></div>";
   }



?>
