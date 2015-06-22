<?php


$arr=array();

for ($i=0; $i < 5; $i++) { 
	$arr[$i]=array('two'=>$i,'three' => $i+1);
}

foreach($arr as $thing => $stored){
	echo $thing;
	echo $stored['two'];
	echo $stored['three'];
}
?>