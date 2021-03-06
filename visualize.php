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
	public function __construct( $db, $array=array('all'), $regress='', $begin=2003, $end=2015){

		$this->num_compare=count($array);
		$this->case_array=$array;


		$this->begin=$begin;
		$this->end=$end;
		$this->db=$db;


	}


	//sets the optional regression for the line chart
	public function set_regres($reg){
		//make sure there is a regression to set
		if($reg!=''){
			$this->regres= "trendlines: {";
			//
			for ($i=0; $i < $this->num_compare; $i++) {
				//the visualization API has you set regression for each line
				//using the format #: {regression information}
				//we only do one type of regression for every line
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
	public function set_sql(){
			//if invalid we set the dates to 2003 2015, currently hardcoded
		  if($this->begin>$this->end){
		    $this->begin=2003;
		    $this->end=2015;
		    $this->error.="<p class='error'> The start year must be earlier than the end year.</p>";

		  }
		  //if there are no points to compare just show them all cases
		  if($this->num_compare==0){
		  	$this->sql=$this->db->prepare("SELECT crime_classification, news_date
		  FROM cases   ORDER BY news_date");
		  	$this->error.="<p class='error'>Please select at least one crime classification</p>";
		  }
		  //for only 1 line
		  elseif($this->num_compare==1){
		  	$this->sql=$this->db->prepare("SELECT crime_classification, news_date
		  FROM cases WHERE crime_classification LIKE :c0  ORDER BY news_date");
		  	$caseArr=[];
		  	$caseArr[]="%".$this->case_array[0]."%";
		  	$this->sql->bindParam(':c0', $caseArr[0], PDO::PARAM_STR);

		  }
		  //for multiple lines
		  else{
		  	$this->sql="SELECT crime_classification, news_date
		  FROM cases WHERE crime_classification LIKE :c0";
		  	$caseArr=[];
		  	$caseArr[]="%".$this->case_array[0]."%";
		  	for ($i=1; $i < $this->num_compare; $i++) {
		  		$this->sql.=" OR crime_classification LIKE :c$i";
		  		$caseArr[]="%".$this->case_array[$i]."%";
		  	}
		  	$this->sql=$this->db->prepare($this->sql);
		  	for ($i=0; $i < $this->num_compare; $i++) {
		  		$this->sql->bindParam(":c$i", $caseArr[$i], PDO::PARAM_STR);
		  	}
		}
			//special case for all cases
		  if ($this->case_array[0]=='all') {
		    $this->sql=$this->db->prepare("SELECT crime_classification, news_date
		  FROM cases   ORDER BY news_date");
		}
	}


		//get the relevant data from the table

	function set_line(){
		  	//make an array that holds tallies for the number of cases during each year
		  	//for the specified classifications
		$datearr = array();
		for ($i=$this->begin; $i <= $this->end ; $i++) {
			//if only 1 classification we only need to keep one tally
			if($this->num_compare==1){
		  	$datearr[$i]=0;
		  }
		  //otherwise we add an array into the array for each classification
		  //this will later be filled with tallies based on DB data
		  else{
		  	for ($x=0; $x < $this->num_compare; $x++) {
		  	$datearr[$i][$this->case_array[$x]] =  0;
			}

		}
	}

		if ($this->sql->execute()) {
		  while($data=$this->sql->fetch(PDO::FETCH_ASSOC)){
		  	//For every entry we extract the year
		    $date = htmlspecialchars($data['news_date']);
		    $date=strval($date);
		    $date=strtotime($date);
		    $date = idate('Y', $date);
		    //if we have multiple tallies
		    if($this->num_compare>1){
					//make sure the year of the entry is in the specified time period
          if(isset($datearr[$date])){
       	  	//check which case to tally for this date
       	  	foreach ($this->case_array as $guess){
       	  		//if we are looking at all cases then we make a tally for every entry
	       	  	if ($guess=='all'){
	       	  		//make a tally for that year
	       	  		$datearr[$date][$guess]++;
	       	  	}
	       	  	//then we check the relevant classifications
	        		if(strpos(strval($data['crime_classification']),$guess)===0){
	        			//make a tally for that year
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
		    		//we only have 1 entry, so we make a tally for every year that falls withing the dates
		          if(isset($datearr[$date])){
		          //make a tally
		          $datearr[$date]++;
		        }
		      }

		  }
		}

		//create a string full of data points for the chart
		if($this->num_compare>1){
			//for every year put the tallies into the proper google chart format
		  foreach ($datearr as $year => $count) {
		    if($year!=0){
		    	$thisyear=strval($year);
		    	//every year has one bracket with however many data points for that year
		    	$this->mathdata.= "[new Date($thisyear, 0, 1),";
		    	foreach($this->case_array as $case) {
		    		//sum=number of tallies
		    		//each data point is: tally, "text for custom tooltip"
				    $sum=$count[$case];
				    	if($case=='all'){
		    				$this->mathdata.= "$sum, '<strong>".$thisyear."</strong><br>"."All".":<strong>$sum</strong>', ";
		   				}
		    			else{
							$this->mathdata.=" $sum, '<strong>".$thisyear."</strong><br>".$this->cat_names[$case].":<strong>$sum</strong>', ";
						}
				}

				 $this->mathdata.="],";

		  }
		  }

		}
		else{
			//case of 1 line
		  foreach ($datearr as $year => $count) {
		    if($this->case_array[0]=='all'){
		    	$this->mathdata.= "[new Date($year, 0, 1),$count, '<strong>".$year."</strong><br>".$this->case_array[0].":<strong>$count</strong>'], ";
		    }
		    else{
		    	$this->mathdata.= "[new Date($year, 0, 1),$count, '<strong>".$year."</strong><br>".$this->cat_names[$this->case_array[0]].":<strong>$count</strong>'], ";
			}
		  }
		}
	}
function set_pie(){
		//set pie uses the much of thesame functionality of the above set line
		//However if only one line is shown the pie chart splits that classification into years,
		//otherwise it makes a percentage of each classification over ALL years
		$datearr = array();
		for ($i=$this->begin; $i <= $this->end ; $i++) {
			if($this->num_compare==1){
				//make tally
		  	$datearr[$i]=0;
		  }
		  else{
		  	//make tally for seperate cases
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
		             	  		//make tally
		             	  		$datearr[$date][$guess]++;
		             	  	}
		              		if(strpos(strval($data['crime_classification']),$guess)===0){
		              			//make tally
									$datearr[$date][$guess]++;

		              		}
		         		 }

		            }
		    }
		    else{
		          if(isset($datearr[$date])){
		          	//make tally
		          $datearr[$date]++;
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
		    	//combine all tallies
		    	foreach($this->case_array as $case) {
				    $sum=$count[$case];
				    	if($case=='all'){
		    				if(isset($string_dat_arr['All'])){
							   	$string_dat_arr['All']=$string_dat_arr['All']+$sum;
							   }
							   else{
							   	$string_dat_arr['All']=$sum;
							   }
		   				}
		    			else{
							   if(isset($string_dat_arr[$this->cat_names[$case]])){
							   	$string_dat_arr[$this->cat_names[$case]]=$string_dat_arr[$this->cat_names[$case]]+$sum;
							   }
							   else{
							   	$string_dat_arr[$this->cat_names[$case]]=$sum;
							   }
						}
				}


		  }
		  }
		  $this->stringdata.="";
		  foreach ($string_dat_arr as $cat => $count) {
		  	$cat=strip_tags($cat);
		 	 $this->stringdata.="['$cat', $count],";
		}

		}
		else{
		  foreach ($datearr as $year => $count) {
		    if($this->case_array[0]=='all'){
		    	$this->stringdata.= "['$year',$count], ";
		    }
		    else{
		    	$this->stringdata.= "['$year',$count], ";
			}
		  }
		}
	}
	//gets the minimum year and the maximum year from cases
	function set_year(){
		$sql="SELECT MIN(news_date) AS min, MAX(news_date) AS max FROM cases";
		if($result=$this->db->query($sql)){

			$data = $result->fetch(PDO::FETCH_ASSOC);

			//we extract just the year from each entry
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

			$name=str_replace('<b>', '##b##', $result['cat_name']);
     		$name=str_replace('</b>', '##/b##', $name);
     		$name=htmlspecialchars($name);
     		$name=str_replace('##b##', '<b>', $name);
     		$name=str_replace('##/b##', '</b>', $name);
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
	//map is a seperate function that simultaneously sets and gets the map data. It is not meant to be used in congruence
	//with other visualizations as it requires a single case and isn't meant to take multiple cases
	function map(){
        $maparr="";
        $case=$this->case_array[0];
        $caselike = "%$case%";
        $beg="$this->begin-01-01";
        $end= "$this->end-12-31";
        if ($case=='all') {
          $sql=$this->db->prepare("SELECT case_location, COUNT(case_location) AS locount
          FROM cases WHERE news_date>= :beg AND news_date<= :end GROUP BY case_location");
          $mapdata="['States', 'Cases'], ";

        }
        else{
           $sql=$this->db->prepare("SELECT case_location, COUNT(case_location) AS locount
          FROM cases WHERE news_date>= :beg AND news_date<= :end AND crime_classification LIKE :case GROUP BY case_location");
           $sql->bindParam(':case', $caselike, PDO::PARAM_STR);

           $cat_name=$this->cat_names[$case];
           $mapdata="['States', '$cat_name'], ";
        }
        $sql->bindParam(':beg', $beg, PDO::PARAM_STR);
        $sql->bindParam(':end', $end, PDO::PARAM_STR);
        if($sql->execute()){
         while($data=$sql->fetch(PDO::FETCH_ASSOC)){
            $location=htmlspecialchars($data['case_location']);
            $locount=htmlspecialchars($data['locount']);
            $maparr[$location]=$locount;
          }
          if($maparr!=""){
          foreach ($maparr as $locname => $locnumb) {
            $mapdata.="['$locname', $locnumb], ";
          }
        }
        else{
          $this->errors.="<p class='error'>There are no recorded cases for $case</p>";
        }
          return $mapdata;
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
	//sets necessary data for map visualization
	function set_map_plus(){
		$this->set_cat_names();
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
    	<select name='begin'>".$this->fyeardropdown."</select><br><br>
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
	function get_cat_names(){
		return $this->cat_names;
	}

	function get_fy(){
		echo $this->firstyear;
	}
	function get_ly(){
		echo $this->lastyear;
	}

	function db_close(){
	$this->db=null;
}


//kill functions clear up data so that the server doesn't overload.
	function kill_dropdown(){
		$this->fyeardropdown=null;
		$this->lyeardropdown=null;

	}
	function kill_the_cat(){
		$this->cat_names=null;

	}
	function kill_pie(){
		$this->stringdata=null;
	}
	function kill_line(){
		$this->mathdata=null;
	}
}

?>
