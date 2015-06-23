<?php
	require 'common.php';
	function cat_box($db){
		$buttons=array();
		$buttonNames=array();
		//special case for 0 classification
		$buttonNames['0']='Unclassified';
	echo "<input type='checkbox' name='cases[]' value ='all' checked> All Cases"; 


     $sql="SELECT crime_classification, cat_name FROM crime_category GROUP BY crime_classification";
     foreach($db->query($sql) as $result){
     	$class=htmlspecialchars($result['crime_classification']);
     	$name=htmlspecialchars($result['cat_name']);
     	if(!isset($buttons[substr($class, 0,4)])){
     		$buttons[substr($class, 0,4)]="";
     	}
     	if(substr($class, 4,4)=='0000'){
     		//general case
     		$buttonNames[substr($class, 0,4)]=$name;
     	}
     	elseif($class!='0'){
     		$buttons[substr($class, 0,4)].= "<input type='checkbox' name='cases[]' value='".$class."' >".$name."<br>";
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
     	<td><input type='checkbox' name='cases[]' value='".$button."' >Include</td>
     	<td><button type='button' name='".$button."'class='styled-button-DV' onclick='toggleCase(this.name)'>Subcategories</button></td>
     	</tr>
     	<div  class='".$button." miniwindow hide'>
     	<button type='button' name='".$button."'class='styled-button-DV' onclick='toggleCase(this.name)'>Hide</button><br>"
     	.$input."</div>";
     }
     echo "</table></div>";
   }



?>