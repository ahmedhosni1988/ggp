<?php


	define("OBJECT","OBJECT");
	define("ARRAY_A","ARRAY_A");
	define("ARRAY_N","ARRAY_N");

	// ==================================================================
	//	The Main Class
	
	class dba {
		public $connection;
		// ==================================================================
		//	DB Constructor - connects to the server and selects a database
		
		public function __construct($dbuser, $dbpassword, $dbname, $dbhost)
		{
	
			$this->connection = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname) or die(mysqli_error($this->connection));
			
			mysqli_query($this->connection,"SET NAMES utf8");
			mysqli_query($this->connection,"SET CHARACTER SET utf8");
		
			if ( ! $this->connection )
			{
				$this->print_error("<ol><b>Error establishing a database connection!</b><li>Are you sure you have the correct user/password?<li>Are you sure that you have typed the correct hostname?<li>Are you sure that the database server is running?</ol>");
			}
			
			return $this->connection;
				
		//	$this->select($dbname);
		
		}


		public function get_conn(){
			return $this->connection;
		}

		



		// ==================================================================
		//	Print SQL/DB error.
	
		function print_error($str = "")
		{
			
			if ( !$str ) $str = mysqli_error($this->db);
			
			// If there is an error then take note of it
			print "<blockquote><font face=arial size=2 color=ff0000>";
			print "<b>SQL/DB Error --</b> ";
			print "[<font color=000077>$str</font>]";
			print "</font></blockquote>";	
		}
	
	
		
		// ==================================================================
		//
		
		function RecordCount ( $query )
		{
			return mysqli_num_rows ( mysqli_query($this->db, $query ) );
		}
		

	
	
	///make insert query //
	function make_insert($table_name,$array){
	$sql = "";
	$sqlk = "";
	$sqlval = "";
	
	$sql = "insert into  ".$table_name;
     foreach ($array as $key => $value){
     $sqlk .=  $key.','; 
     $sqlval .= $m($value).',';
    }
    $s = $sql.'('.substr($sqlk,0,strlen($sqlk)-1).') values ('.substr($sqlval,0,strlen($sqlval)-1).');';


	return $s;
	}
	
	///make update///
	function make_update($table_name,$array,$updated_key,$updated_id){
	$sql = "update ".$table_name."  set ";
	$sqlk = "";
    foreach ($array as $key => $value){
      $sqlk .=  $key.'='.check_mysql_string($this->db,$value).' ,'; 
		}
	
    $s = $sql.' '.substr($sqlk,0,strlen($sqlk)-1).' where '.$updated_key.' = '.check_mysql_string($this->db,$updated_id);
	
	return $s;
	}
	
	function return_input_name($name){
	$name = str_replace("_1_"," ",$name);
	return $name;
	}

	function build_array($date_array){
	$category = array();
while ($row = mysqli_fetch_assoc($date_array)){

  foreach($row as $key => $value){
      
	   $arr[$key] = $value; 
  }
	
       $category[] =$arr;
 }
 
 
return $category;

	}
	
	function get_table_by_id($query,$key,$val){
		
		$result = array();
		$query = mysqli_query($this->connection,"select * from ".$query) or die (mysqli_error($this->db));
		while($row=mysqli_fetch_array($query)){
			$result[$row[$key]] = $row[$val];
		}
		
		return $result;
	}
	
	
	function get_table($table_name){
		//echo "select * from ".$table_name."<br>";
	$q = mysqli_query($this->connection,"select * from ".$table_name) or die (mysqli_error($this->db));
	
	return $this->build_array($q);
	}
		// ==================================================================
		//	Get one variable from the DB - see docs for more detail
		
		function get_var($query=null,$x=0,$y=0)
		{
			
			// Log how the function was called
			$this->func_call = "\$db->get_var(\"$query\",$x,$y)";
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}
			
			// Extract var out of cached results based x,y vals
			if ( $this->last_result[$y] )
			{
				$values = array_values(get_object_vars($this->last_result[$y]));
			}
			
			// If there is a value return it else return null
			return $values[$x]?$values[$x]:null;
		}
	
		// ==================================================================
		//	Get one row from the DB - see docs for more detail
		
		function getRow($query=null,$y=0,$output=OBJECT)
		{
			
			// Log how the function was called
			$this->func_call = "\$db->getRow(\"$query\",$y,$output)";
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}
	
			// If the output is an object then return object using the row offset..
			if ( $output == OBJECT )
			{
				return $this->last_result[$y]?$this->last_result[$y]:null;
			}
			// If the output is an associative array then return row as such..
			elseif ( $output == ARRAY_A )
			{
				return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;	
			}
			// If the output is an numerical array then return row as such..
			elseif ( $output == ARRAY_N )
			{
				return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
			}
			// If invalid output type was specified..
			else
			{
				$this->print_error(" \$db->getRow(string query,int offset,output type) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N ");	
			}
	
		}
	
		// ==================================================================
		//	Function to get 1 column from the cached result set based in X index
		// se docs for usage and info
	
		function get_col($query=null,$x=0)
		{
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}
			
			// Extract the column values
			for ( $i=0; $i < count($this->last_result); $i++ )
			{
				$new_array[$i] = $this->get_var(null,$x,$i);
			}
			
			return $new_array;
		}
	
		// ==================================================================
		// Return the the query as a result set - see docs for more details
		
		function get_results($query=null, $output = OBJECT)
		{
			
			// Log how the function was called
			$this->func_call = "\$db->get_results(\"$query\", $output)";
			
			// If there is a query then perform it if not then use cached results..
			if ( $query )
			{
				$this->query($query);
			}		
	
			// Send back array of objects. Each row is an object		
			if ( $output == OBJECT )
			{
				return $this->last_result; 
			}
			elseif ( $output == ARRAY_A || $output == ARRAY_N )
			{
				if ( $this->last_result )
				{
					$i=0;
					foreach( $this->last_result as $row )
					{
						
						$new_array[$i] = get_object_vars($row);
						
						if ( $output == ARRAY_N )
						{
							$new_array[$i] = array_values($new_array[$i]);
						}
	
						$i++;
					}
				
					return $new_array;
				}
				else
				{
					return null;	
				}
			}
		}
	
	
		// ==================================================================
		// Function to get column meta data info pertaining to the last query
		// see docs for more info and usage
		
		function get_col_info($info_type="name",$col_offset=-1)
		{
	
			if ( $this->col_info )
			{
				if ( $col_offset == -1 )
				{
					$i=0;
					foreach($this->col_info as $col )
					{
						$new_array[$i] = $col->{$info_type};
						$i++;
					}
					return $new_array;
				}
				else
				{
					return $this->col_info[$col_offset]->{$info_type};
				}
			
			}
			
		}
	
	


	
	function make_query($query){
	$q = mysqli_query($this->connection,$query) or die (mysqli_error($this->db));
	if($q) return true;
	else return false;
	
	}
	
	//
	function get_select($query){
	$q = mysqli_query($this->connection,$query);
	return $this->build_array($q);
	}

	function get_query_assoc($query){
	
		$q = mysqli_query($this->connection,$query);
		return mysqli_fetch_assoc($q);
	
	}


	//*get the current Date-Time and adjust for Local Timezone.
function adjusteddatetime() {
global $timezone_adj;                                     //set in dbconnect.php
if ($timezone_adj == "")  $timezone_adj = "+0 hours";
$adjdate = date("Y-m-d-H-i", strtotime("$timezone_adj"));
return $adjdate;
}

//*get the current Date and adjust for Local Timezone.
function adjusteddate() {
global $timezone_adj;                                     //set in dbconnect.php
if ($timezone_adj == "")  $timezone_adj = "+0 hours";
$adjdate = date("Y-m-d", strtotime("$timezone_adj"));
return $adjdate;
}


	
	}

?>