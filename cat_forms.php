<?php
class cats{
  #this will hold subcategories
  private $buttons=array();
  #this will hold main categories
  private $buttonNames=array();
  private $rad;
  private $multi;
  private $case;
  private $type;
  private $db;

  public function __construct($db, $rad=False, $multi=False){
    //special case for 0 classification
    $this->buttonNames['0']='Unclassified';
    $this->rad=$rad;
    $this->multi=$multi;
    if($rad){
      $this->case='cases';
      $this->type='radio';
    }
    else{
      $this->case='cases[]';
      $this->type='checkbox';
    }
    $this->db=$db;
    #get all categories from DB
    $sql="SELECT crime_classification, cat_name FROM crime_category GROUP BY crime_classification";
    foreach($this->db->query($sql) as $result){
         #Get rid of unwanted tags
      $class=strip_tags($result['crime_classification']);
         #allow bold tags through
      $name=strip_tags($result['cat_name'], '<b>');

         #For each major category we want to set a
      if(!isset($this->buttons[substr($class, 0,4)])){
        $this->buttons[substr($class, 0,4)]="";
      }
      if(substr($class, 4,4)=='0000'){
        //general case
        $this->buttonNames[substr($class, 0,4)]=$name;
      }
      elseif($class!='0'){
        if($multi){
          $this->buttons[substr($class, 0,4)].= "<option name='cases[]' value='".$class."'";
          if(isset($_POST['cases'])&&in_array($class, $_POST['cases'])){
            $this->buttons[substr($class, 0,4)].=" selected";
          }
          $this->buttons[substr($class, 0,4)].=">".$name."</option>";
        }
        else{
          $this->buttons[substr($class, 0,4)].= "<input type='$this->type' name='$this->case' value='".$class."'";
          if(isset($_POST['cases'])&&in_array($class, $_POST['cases'])){
            $this->buttons[substr($class, 0,4)].=" checked";
          }
          $this->buttons[substr($class, 0,4)].=">".$name."<br>";
        }
      }

    }

  }
  public function cat(){

     $tr_counter='evenrow';
        echo"<div class='dbtable'><table><tr><th>Category</th><th>Include in Data?</th><th>Show Subcategories</th></tr>";
        foreach ($this->buttons as $button => $input) {
          if ($tr_counter=='evenrow') {
            $tr_counter='oddrow';
          }
          else{
            $tr_counter='evenrow';
          }
          echo "<tr class='$tr_counter'>
          <td><h4><span class='overflow'>".$this->buttonNames[$button]."</span></h4></td>
          <td><input type='checkbox' name='$this->case' value='".$button."'";
          if(isset($_POST['cases'])&&in_array($button, $_POST['cases'])){
            echo ' checked';
          }
          echo" >Include</td>
          <td><button type='button' name='".$button."' class='styled-button-DV' onclick='toggleCase(this.name)'>Subcategories</button></td>

          <span  class='".$button." miniwindow hide'>
          <button type='button' name='".$button."' class='styled-button-DV' onclick='toggleCase(this.name)'>Hide</button><br>"
          .$input."</span></tr>";
        }
        echo "</table></div>";
    }

  public function cat_multi(){
    echo"(Select multiple classifications with (<span class='error'>command</span>) on mac and (<span class='error'>control</span>) on windows.) <Select multiple name=cases[]>";
    foreach ($this->buttons as $button => $input) {
      #strips bold
      $name=strip_tags($this->buttonNames[$button]);
      echo "<optgroup label='$name'>
      <option name='cases[]' value='".$button."'";
      if(isset($_POST['cases'])&&in_array($button, $_POST['cases'])){
        echo ' selected';
      }
      echo" >All $name </option>";
      echo $input;
      echo "</optgroup>";
    }
    echo "</select>";
  }
}

?>
