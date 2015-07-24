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
  private $cases;

  public function __construct($db, $rad=False, $multi=False){
    #for sticky forms
       $this->cases=array();
    if(isset($_POST['cases'])){
      $this->cases=$_POST['cases'];
    }
    if(isset($_GET['cases'])){
      $this->cases=$_GET['cases'];
    }



    //special case for 0 classification
    $this->buttonNames['0']='<b>Unclassified</b>';
    #radio button
    $this->rad=$rad;
    #multiple select for non js users
    $this->multi=$multi;
    if($rad){
      #form does not return an array
      $this->case='cases';
      $this->type='radio';
      #turn cases into array for handling radio code with the same code as checkboxes
      $this->cases=array($this->cases);
    }
    else{
      #form returns an array an array
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

      #For each major category we want to set use it as the key in an array using only the 1st 4 digits
      #so 1008003 and 1008005 both are stored in buttons['1008']
      if(!isset($this->buttons[substr($class, 0,4)])){
        $this->buttons[substr($class, 0,4)]="";
      }
      if(substr($class, 4,4)=='0000'){
        //general case, we make the form input for this guy later
        $this->buttonNames[substr($class, 0,4)]=$name;
      }
      #the 0 classification is handled differently
      elseif($class!='0'){
        # the multiple select needs html than radio/checkboxes
        if($multi){
          $this->buttons[substr($class, 0,4)].= "<option name='cases[]' value='".$class."'";
          if(in_array($class, $this->cases)){
            $this->buttons[substr($class, 0,4)].=" selected";
          }
          $this->buttons[substr($class, 0,4)].=">".$name."</option>";
        }
        # for radio and checkboxes
        else{
          $this->buttons[substr($class, 0,4)].= "<input type='$this->type' name='$this->case' value='".$class."'";
          # this should make the form sticky
          if(in_array($class, $this->cases)){
            $this->buttons[substr($class, 0,4)].=" checked";
          }
          $this->buttons[substr($class, 0,4)].=">".$name."<br>";
        }
      }

    }

  }
  public function cat(){

     $tr_counter='evenrow';
        echo"<table class='table-striped'><tr><th>Category</th><th>Include in Data?</th><th>Subcategories</th></tr>";
        foreach ($this->buttons as $button => $input) {
          if ($tr_counter=='evenrow') {
            $tr_counter='oddrow';
          }
          else{
            $tr_counter='evenrow';
          }
          echo "<tr class='$tr_counter'>
          <td><span class='overflow'>".$this->buttonNames[$button]."</span></td>
          <td><input type='$this->type' name='$this->case' value='".$button."'";
          if(in_array($button, $this->cases)){
            echo ' checked';
          }
          echo" >All ".$this->buttonNames[$button]."</td><td>";
          #only generate subcategories if there are subcategories to show
          if($input!=""){
           echo $input."</td></tr>";
          }
          else{
            echo "None</td></tr>";
          }
        }
        echo "</table></div>";
    }
  #creates multiple select for js disabled users
  public function cat_multi(){
    echo"(Select multiple classifications with (<span class='error'>command</span>) on mac and (<span class='error'>control</span>) on windows.) <Select multiple name=cases[]>";
    foreach ($this->buttons as $button => $input) {
      #strips bold
      $name=strip_tags($this->buttonNames[$button]);
      # set label as classification name
      # and set a select option for all of that category
      echo "<optgroup label='$name'>
      <option name='cases[]' value='".$button."'";
      if(isset($_GET['cases'])&&in_array($button, $_GET['cases'])){
        echo ' selected';
      }
      echo" >All $name </option>";
      #add in all the subcategories
      echo $input;
      echo "</optgroup>";
    }
    echo "</select>";
  }
}

?>
