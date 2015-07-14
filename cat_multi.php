<?php
     require 'common.php';
  function cat_multi($db){
    $buttons=array();
    $buttonNames=array();
    //special case for 0 classification
    $buttonNames['0']='Unclassified';


          $sql="SELECT crime_classification, cat_name FROM crime_category GROUP BY crime_classification";
          foreach($db->query($sql) as $result){
            $class=strip_tags($result['crime_classification']);
            $name=strip_tags($result['cat_name']);
            if(!isset($buttons[substr($class, 0,4)])){
              $buttons[substr($class, 0,4)]="";
            }
            if(substr($class, 4,4)=='0000'){
              //general case
              $buttonNames[substr($class, 0,4)]=$name;
            }
            elseif($class!='0'){
              $buttons[substr($class, 0,4)].= "<option name='cases[]' value='".$class."'";
              if(isset($_POST['cases'])&&in_array($class, $_POST['cases'])){
                $buttons[substr($class, 0,4)].=" selected";
              }
              $buttons[substr($class, 0,4)].=">".$name."</option>";
            }


          }
          echo"(Select multiple classifications with (<span class='error'>command</span>) on mac and (<span class='error'>control</span>) on windows.) <Select multiple name=cases[]>";
          foreach ($buttons as $button => $input) {
            echo "<optgroup label='$buttonNames[$button]'>
            <option name='cases[]' value='".$button."'";
            if(isset($_POST['cases'])&&in_array($button, $_POST['cases'])){
              echo ' selected';
            }
            echo" >All $buttonNames[$button]</option>";
            echo $input;
            echo "</optgroup>";
          }
          echo "</select>";
   }



?>
