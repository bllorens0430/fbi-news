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
	public function __construct($num_comp=1, $array=array('all'), $regress='', $begin=2003, $end=2015, $db){
		$this->num_compare=$num_comp;
		$this->case_array=$array;

		$this->error = '';
		$this->regres = '';
		$this->linear = '' ;
		$this->poly = '' ;
		$this->exp = '' ;
		$this->sql = '';
		$this->mathdata= '';
		$this->stringdata='';
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
		  if ($this->case_array[0]=='all') {
		    $this->sql=$this->db->prepare("SELECT crime_classification, news_date 
		  FROM cases   ORDER BY news_date");
		}
		  else{
		  $this->sql=$this->db->prepare(
		  "SELECT crime_classification, news_date 
		  FROM cases  
		  WHERE crime_classification 
		  LIKE '%1002%'
		  OR crime_classification
		  LIKE '%1003%'
		  ORDER BY news_date");
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
		  	$datearr[$i] = array('1002' => 0, '1003' => 0);
			}
		}
		  //these variables are going to be passed to a form to dynamically generate the first and last relevant years.
		  //Note if it turns out cybercrim happened before 0 b.c. or after 3000, then these constants will need to be changed.
		  
		if ($this->sql->execute()) {
		  while($data=$this->sql->fetch(PDO::FETCH_ASSOC)){

		    $date = htmlspecialchars($data['news_date']);
		    $date=strval($date);
		    $date=strtotime($date);
		    $date = idate('Y', $date);
		    if($this->num_compare>1){
		                if(isset($datearr[$date])){
		                  
		              if(strpos(strval($data['crime_classification']),'1002')===0){
		              
		              $datearr[$date]['1002']++;
		              }
		              else{

		                $datearr[$date]['1003']++;
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
		$stringdata2="";
		$stringdata3="";
		if($this->num_compare>1){
		  foreach ($datearr as $year => $count) {
		    if($year!=0){
		    $count2=$count['1002'];
		    $count3=$count['1003'];
		 
		    $thisyear=strval($year);
		    $this->mathdata.= "[new Date($thisyear, 0, 1),$count2,$count3, '<strong>".$thisyear."</strong><br>Cases:<strong>$count2, $count3</strong>'], ";  
		    $stringdata2= $stringdata2+$count2;
		    $stringdata3=$stringdata3+$count3;
		  }
		  }
		  $this->stringdata.="['1002', $stringdata2], ['1003', $stringdata3]";

		}
		else{
		  foreach ($datearr as $year => $count) {
		    
		    $this->mathdata.= "[new Date($year, 0, 1),$count, '<strong>".$year."</strong><br>Cases:<strong>$count</strong>'], ";  
		    $this->stringdata.= "['$year',$count], ";
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
	
	function set_everything($reg){
		$this->set_regres($reg);
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
    	<b>Start Year</b>
    	<select name='begin'>.".$this->fyeardropdown."</select><br>
    	<b>End Year</b>
    	<select name='end'>".$this->lyeardropdown."</select><br>
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
?>