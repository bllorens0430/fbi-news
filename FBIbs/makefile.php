<?php
require 'common.php';

$sql=$db->prepare('SELECT notes, crime, crime_classification, news_title, news_url FROM cases');

if($sql->execute()){
  echo "let's make a  file";
  $file=fopen('nlpme.tsv', 'a');
  $i=0;
  $array = array();
  $array[]=array('content','crime', 'url', 'class');
  while ($data=$sql->fetch(PDO::FETCH_ASSOC)) {
    $line=array();
    $content='';
    if($data['notes']!=null&&$data['notes']!=''){
    $content.= $data['notes'];
    }
    if($data['news_title']!=null&&$data['news_title']!=''){
    $content.= $data['news_title'];
    }
    if($content!=''){
      $line[]=preg_replace( "/\r|\n/", "", $content);
    }
    else{
      $line[]='-';
    }
    if($data['crime']!=''&&$data['crime']!=null){
      $line[]=preg_replace( "/\r|\n/", "", $data['crime']);
    }
    else{
      $line[]='-';
    }
    if($data['news_url']!=''&&$data['news_url']!=null){
      $url=$data['news_url'];
      $line[]=preg_replace( "/\r|\n/", "",$url);
    }
    else{
      $line[]='-';
    }
    if($data['crime_classification']!=''&&$data['crime_classification']!=null){
      $line[]=preg_replace( "/\r|\n/", "", $data['crime_classification']);
    }
    else{
      $line[]='-';
    }



    echo "<br>";
    echo $i;
    $i++;
    $array[]=$line;
  }
  foreach ($array as $line) {
  fputcsv($file, $line, '|');
}
}
?>
