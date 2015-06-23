<?php
//this class queries the database and then prepares the data for google charts
//to create dynamically generated visualizations of data
class visualize{
	//for form errors
	private $error='';

	//these variables are to handle googles regressions
	private $regres='';
	private $linear='';
	private $poly='';
	private $exp='';

	//sql
	private $sql='';
	
	//start&end year
	private $begin='';
	private $end='';

	//to handle the cases that will be part of the data
	private $num_compare='';
	private $case_array='';
	private $cat_names='';

	//actual data to be passed to js constructor
		//for line graph
	private $mathdata='';
		//for pie chart
	private $stringdata='';

	//drop down for form dynamically changed by database entries
	private $firstyear='';
	private $lastyear='';
	private $fyeardropdown='';
	private $lyeardropdown='';

	private $db='';

	//constructor
	public function __construct( $array=array('all'), $regress='', $begin=2003, $end=2015, $db){
		
		$this->num_compare=count($array);
		$this->case_array=$array;

	
		$this->begin=$begin;
		$this->end=$end;
		$this->db=$db;

		
	}


	//sets the variable
	public function set_regres($reg){
		if($reg!=''){
			$this->regres= "trendlines: {";
			for ($i=0; $i < $this->num_compare; $i++) { 
			
				if($reg=='linear'){
			    $this->linear='checked';
			    $this->regres.=" 
			     $i: {
			      type:'linear',
			        opacity: .5,
			      },";
			  	}
			  	elseif($reg=='polynomial'){
			      $this->poly='checked';
			      $this->regres.="
			     $i: {
			      type:'polynomial',
			        opacity: .5,
			      },";

			    }
			  	elseif($reg=='exponential'){
			      $this->exp='checked';
			      $this->regres.="
			     $i: {
			      type:'exponential',
			        opacity: .5,
			      },";
			      }
			  }
			  $this->regres.='}';
			}
	}
	//Gets the proper sql call
	//num_compare = the number of kinds of cases (currently 1 or 2)
	public function set_sql( $begin, $end){


		  if($begin>$end){
		    $this->begin=2003;
		    $this->end=2015;
		    $this->error.="<p class='error'> The start year must be earlier than the end year.</p>";

		  }
		  if($this->num_compare==0){
		  	$this->sql=$this->db->prepare("SELECT crime_classification, news_date 
		  FROM cases   ORDER BY news_date");
		  	$this->error.="<p class='error'>Please select at least one crime classification</p>";
		  }
		  elseif($this->num_compare==1){
		  	$this->sql=$this->db->prepare("SELECT crime_classification, news_date 
		  FROM cases WHERE crime_classification LIKE '%".$this->case_array[0]."%'  ORDER BY news_date");
		  }
		  else{
		  	$this->sql="SELECT crime_classification, news_date 
		  FROM cases WHERE crime_classification LIKE '%".$this->case_array[0]."%'";
		  	for ($i=1; $i < $this->num_compare; $i++) { 
		  		$this->sql.="OR crime_classification LIKE '%".$this->case_array[$i]."%'";
		  	}	
		  	$this->sql=$this->db->prepare($this->sql);
		}
		  if ($this->case_array[0]=='all') {
		    $this->sql=$this->db->prepare("SELECT crime_classification, news_date 
		  FROM cases   ORDER BY news_date");
		}
	}


		//get the relevant data from the table

	function set_data(){

		//this needs to be fixed so that it is scaleable, right now it creates seperate arrays for different cases
		$datearr = array();
		for ($i=$this->begin; $i <= $this->end ; $i++) { 
			if($this->num_compare==1){
		  	$datearr[$i]=0;
		  }
		  else{
		  	for ($x=0; $x < $this->num_compare; $x++) { 
		  	$datearr[$i][$this->case_array[$x]] =  0;
			}
			
		}
	}
		 
		if ($this->sql->execute()) {
		  while($data=$this->sql->fetch(PDO::FETCH_ASSOC)){

		    $date = htmlspecialchars($data['news_date']);
		    $date=strval($date);
		    $date=strtotime($date);
		    $date = idate('Y', $date);
		    if($this->num_compare>1){
		                if(isset($datearr[$date])){
		             	  foreach ($this->case_array as $guess){
		             	
		             	  	if ($guess=='all'){
		             	  		$datearr[$date][$guess]++;
		             	  	}
		              		if(strpos(strval($data['crime_classification']),$guess)===0){
					
									$datearr[$date][$guess]++;            
		              				
		              		}
		         		 }
		              
		            }

		            if($date<$this->firstyear){
		              $this->firstyear=$date;
		            }
		            if($date>$this->lastyear){
		              $this->lastyear=$date;
		            }
		    }
		    else{
		          if(isset($datearr[$date])){
		          $datearr[$date]++;
		        }

		        if($date<$this->firstyear){
		          $this->firstyear=$date;
		        }
		        if($date>$this->lastyear){
		          $this->lastyear=$date;
		        }
		      }

		  }
		}

		//create a string full of data points for the chart
		$string_dat_arr= array();
		if($this->num_compare>1){
		  foreach ($datearr as $year => $count) {
		    if($year!=0){
		    	$thisyear=strval($year);
		    	
		    	$this->mathdata.= "[new Date($thisyear, 0, 1),";
		    	foreach($this->case_array as $case) {
				    $sum=$count[$case];
				    	if($case=='all'){
		    				$this->mathdata.= "$sum, '<strong>".$thisyear."</strong><br>"."All".":<strong>$sum</strong>', ";
		    				if(isset($string_dat_arr['All'])){
							   	$string_dat_arr['All']=$string_dat_arr['All']+$sum;
							   }
							   else{
							   	$string_dat_arr['All']=$sum;
							   }
		   				}
		    			else{
							$this->mathdata.=" $sum, '<strong>".$thisyear."</strong><br>".$this->cat_names[$case].":<strong>$sum</strong>', ";
					  	
							   if(isset($string_dat_arr[$this->cat_names[$case]])){
							   	$string_dat_arr[$this->cat_names[$case]]=$string_dat_arr[$this->cat_names[$case]]+$sum;
							   }
							   else{
							   	$string_dat_arr[$this->cat_names[$case]]=$sum;
							   }
						}
				}
				 
				 $this->mathdata.="],";

		  }
		  }
		  $this->stringdata.="";
		  foreach ($string_dat_arr as $cat => $count) {
		 	 $this->stringdata.="['$cat', $count],";
		}

		}
		else{
		  foreach ($datearr as $year => $count) {
		    if($this->case_array[0]=='all'){
		    	$this->mathdata.= "[new Date($year, 0, 1),$count, '<strong>".$year."</strong><br>".$this->case_array[0].":<strong>$count</strong>'], ";  
		    	$this->stringdata.= "['$year',$count], ";
		    }
		    else{
		    	$this->mathdata.= "[new Date($year, 0, 1),$count, '<strong>".$year."</strong><br>".$this->cat_names[$this->case_array[0]].":<strong>$count</strong>'], ";  
		    	$this->stringdata.= "['$year',$count], ";
			}
		  }
		}
	}

	function set_year(){
		$sql="SELECT MIN(news_date) AS min, MAX(news_date) AS max FROM cases";
		if($result=$this->db->query($sql)){

			$data = $result->fetch(PDO::FETCH_ASSOC);

			$min = htmlspecialchars($data['min']);
		    $min=strval($min);
		    $min=strtotime($min);
		    $min = idate('Y', $min);

		    $max = htmlspecialchars($data['max']);
		    $max=strval($max);
		    $max=strtotime($max);
		    $max = idate('Y', $max);

		    $this->firstyear=$min;
		    $this->lastyear=$max;
		}

	}

	//note this function depends on set_year() having gotten firstyear/lastyear data
	function set_dropdown(){
		
		for ($i=$this->firstyear; $i<=$this->lastyear; $i++) { 
		  if ($i==$this->begin) {
		     $this->fyeardropdown.="<option value=$i selected='selected'>$i</option>";
		  }
		  else{
		  $this->fyeardropdown.="<option value=$i>$i</option>";
		}
		  if ($i==$this->end) {
		     $this->lyeardropdown.="<option value=$i selected='selected'>$i</option>";
		  }
		  else{
		  $this->lyeardropdown.="<option value=$i>$i</option>";
		}
		}
	
	}
	function set_cat_names(){
		$this->cat_names=array();
		$sql="SELECT cat_name, crime_classification FROM crime_category";
		foreach ($this->db->query($sql) as $result) {
			
			$name=htmlspecialchars($result['cat_name']);
			$class=htmlspecialchars($result['crime_classification']);
			if(substr($class, 4,4)=='0000'){
				$this->cat_names[substr($class, 0,4)]=$name;
			}
			elseif($class!='0'){
				$this->cat_names[$class]=$name;
			}
			else{
				$this->cat_names[$class]='unclassified';
			}
		}
	}
	
	function set_everything($reg){
		$this->set_regres($reg);
		$this->set_cat_names();
		$this->set_sql($this->begin, $this->end);
		$this->set_data();
		$this->set_year();
		$this->set_dropdown();
	}

	function get_mathdata(){
		echo $this->mathdata;
	}
	function get_stringdata(){
		echo $this->stringdata;
	}
	function get_dropdown(){

	echo"<td>
    	<b>Start Year</b><br>
    	<select name='begin'>.".$this->fyeardropdown."</select><br><br>
    	<b>End Year</b><br>
    	<select name='end'>".$this->lyeardropdown."</select><br><br>
  		</td>";
	}
	function get_regres(){
		echo $this->regres;
	}

	function get_error(){
		echo $this->error;
	}
	function get_linear(){
		echo $this->linear;
	}
	function get_poly(){
		echo $this->poly;
	}
	function get_exp(){
		echo $this->exp;
	}
}
function db_close(){
	$this->db=null;
}
?>