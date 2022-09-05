<?php
class DB
{
	# @var, MySQL Hostname
	private $hostname;
	# @var, MySQL Database
	private $database;
	# @var, MySQL Username
	private $username;
	# @var, MySQL Password
	private $password;
	# @object, The PDO object
	private $pdo;
	# @object, PDO statement object
	private $sQuery;
	# @array,  The database settings
	private $settings;
	# @bool ,  Connected to the database
	private $bConnected = false;
	# @array, The parameters of the SQL query
	private $parameters;
		
       /**
	*   Default Constructor 
	*
	*	1. Instantiate Log class.
	*	2. Connect to database.
	*	3. Creates the parameter array.
	*/
		public function __construct($hostname, $database, $username, $password)
		{ 			
			$this->Connect($hostname, $database, $username, $password);
			$this->parameters = array();
		}
	
       /**
	*	This method makes connection to the database.
	*	
	*	1. Reads the database settings from a ini file. 
	*	2. Puts  the ini content into the settings array.
	*	3. Tries to connect to the database.
	*	4. If connection failed, exception is displayed and a log file gets created.
	*/
		private function Connect($hostname, $database, $username, $password)
		{
			global $settings;
			$dsn = 'mysql:dbname='.$database.';host='.$hostname.';charset=utf8;';
			try 
			{
				# Read settings from INI file, set UTF8
				$this->pdo = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_FOUND_ROWS => true));
				
				# We can now log any exceptions on Fatal error. 
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				# Disable emulation of prepared statements, use REAL prepared statements instead.
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
				
				# Connection succeeded, set the boolean to true.
				$this->bConnected = true;
			}
			catch (PDOException $e) 
			{
				# Write into log
				$this->ExceptionLog($e->getMessage());
				die();
			}
		}
	/*
	 *   You can use this little method if you want to close the PDO connection
	 *
	 */
	 	public function CloseConnection()
	 	{
	 		# Set the PDO object to null to close the connection
	 		# http://www.php.net/manual/en/pdo.connections.php
	 		$this->pdo = null;
	 	}
		
       /**
	*	Every method which needs to execute a SQL query uses this method.
	*	
	*	1. If not connected, connect to the database.
	*	2. Prepare Query.
	*	3. Parameterize Query.
	*	4. Execute Query.	
	*	5. On exception : Write Exception into the log + SQL query.
	*	6. Reset the Parameters.
	*/	
		private function Init($query,$parameters = "")
		{
		# Connect to database
		if(!$this->bConnected) { $this->Connect(); }
		try {

				# Prepare query
				//$query=$this->pdo->quote($query);
				$this->sQuery = $this->pdo->prepare($query);
				
				# Add parameters to the parameter array	
				$this->bindMore($parameters);
				# Bind parameters
				
				if(!empty($this->parameters)) {
					foreach($this->parameters as $param)
					{
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					}		
				}
				
				# Execute SQL 
				$this->success = $this->sQuery->execute();	
			}
			catch(PDOException $e)
			{
					# Write into log and display Exception
					$this->ExceptionLog($e->getMessage(), $query );
			}
			# Reset the parameters
			$this->parameters = array();
		}
		
		
       /**
	*	@void 
	*
	*	Add the parameter to the parameter array
	*	@param string $para  
	*	@param string $value 
	*/	
		public function bind($para, $value)
		{	
			$this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . utf8_encode($value);
		}
       /**
	*	@void
	*	
	*	Add more parameters to the parameter array
	*	@param array $parray
	*/	
		public function bindMore($parray)
		{
			if(empty($this->parameters) && is_array($parray)) {
				$columns = array_keys($parray);
				foreach($columns as $i => &$column)	{
					$this->bind($column, $parray[$column]);
				}
			}
		}
       /**
	*   	If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
	*	If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
	*
	*   	@param  string $query
	*	@param  array  $params
	*	@param  int    $fetchmode
	*	@return mixed
	*/			
		public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC)
		{
			$query = trim($query);
			$this->Init($query,$params);
			$rawStatement = explode(" ", $query);
			
			# Which SQL statement is used 
			$statement = strtolower($rawStatement[0]);
			
			if ($statement === 'select' || $statement === 'show') {
				return $this->sQuery->fetchAll($fetchmode);
			}
			elseif ( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
				return $this->sQuery->rowCount();	
			}	
			else {
				return NULL;
			}
		}
		
      /**
       *  Returns the last inserted id.
       *  @return string
       */	
		public function lastInsertId() {
			return $this->pdo->lastInsertId();
		}	
		
       /**
	*Fetching Column:
	*/	
		public function column($query,$params = null)
		{
			$this->Init($query,$params);
			$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
			
			$column = null;
			foreach($Columns as $cells) {
				$column[] = $cells[0];
			}
			return $column;
			
		}	
       /**
	*Get 1 row by Primery Key:
	*/	
	
	
	public function getByKey($table_name, $id = 0, $p_key = 'id', $column_name= '*')
	{
	    $sql = "SELECT " . $column_name .  " FROM " . $table_name . " WHERE " . $p_key . "=" ;
	    if (is_string($id)) {
	        $sql .= "'" . $id . "'";
	    }
	    else $sql .=  $id;
	    $this->Init($sql);
		echo sql;
	    return $this->sQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getOneByKey($table_name, $id = 0, $p_key = 'id', $column_name= '*')
	{
	    $sql = "SELECT " . $column_name .  " FROM " . $table_name . " WHERE " . $p_key . "=" ;
	    if (is_string($id)) {
	        $sql .= "'" . $id . "'";
	    }
	    else $sql .=  $id;
	    $sql .= " LIMIT 1" ;
	    $this->Init($sql);
	    return $this->sQuery->fetch(PDO::FETCH_ASSOC);
	}
       /**
	*Fetching Single Value:
	*/	
	public function single($query,$params = null){
		$this->Init($query,$params);
		return $this->sQuery->fetchColumn();
	}
    /*  
	*Inserts row to a table
	*/
	public function insert($table_name ,$info){
		$fieldsvals="";
		$values='';
		$columns = array_keys($info);

		foreach($columns as $column)
		{
			$fieldsvals .= "`" .$column . "`,";
			$values     .= ($info[$column]===null)?"NULL ,":"'".htmlentities(addslashes($info[$column])) . "',";
		}
		$fieldsvals = substr_replace($fieldsvals , '', -1);
		$values = substr_replace($values , '', -1);
		$sql 		= "INSERT INTO ".$table_name." (".$fieldsvals.") VALUES (".$values.")";
		//echo $sql;
		$this->query($sql, $info);			
		return $this->pdo->lastInsertId();
	}
	/*  
	*Update table row
	*/
	public function update($table_name ,$id ,$info, $p_key = 'id') {
		$fieldsvals="";
		$columns = array_keys($info);
		
		foreach($columns as $column)
		{
			if($column !== $p_key){
				$fieldsvals .= $column . " = ";
				$fieldsvals .= ($info[$column]===null)?"NULL ,":"'".htmlentities(addslashes($info[$column])) . "',";
			}			
		}
		$fieldsvals = substr_replace($fieldsvals , '', -1);

		if($fieldsvals != ""){
			$sql = "UPDATE " . $table_name .  " SET " . $fieldsvals . " WHERE " . $p_key . " = '" . $id . "'";
			return $this->query($sql, $info);
		}
		//echo $sql;
		return null;
	}
	/*  
	*Delete table row
	*/
	
	public function delete($table_name, $id = 0, $p_key = 'id') {
		if($id) {
			$sql = "DELETE FROM " . $table_name . " WHERE " . $p_key . "=" . $id . " LIMIT 1" ;
		}
		return $this->query($sql);
	}
	/**
	* @param array $fields.
	* @param array $sort.
	* @return array of Collection.
	* Example: $user = new User;
	* $found_user_array = $user->search(array('sex' => 'Male', 'age' => '18'), array('dob' => 'DESC'));
	* // Will produce: SELECT * FROM {$this->table_name} WHERE sex = :sex AND age = :age ORDER BY dob DESC;
	* // And rest is binding those params with the Query. Which will return an array.
	* // Now we can use for each on $found_user_array.
	* Other functionalities ex: Support for LIKE, >, <, >=, <= ... Are not yet supported.
	*/
	public function search($table_name, $fields = array(), $sort = array(), $or_separator=false) {
	    $sql = "SELECT * FROM " . $table_name;
		$or_and = ($or_separator)?" OR ":" AND ";
		if (!empty($fields)) {
			$fieldsvals = array();
			$columns = array_keys($fields);
			foreach($columns as $column) {
				$fieldsvals [] = $column . " = '". $fields[$column] ."' ";
			}
			$sql .= " WHERE " . implode($or_and, $fieldsvals);
		}
		if (!empty($sort)) {
			$sortvals = array();
			foreach ($sort as $key => $value) {
				$sortvals[] = $key . " " . $value;
			}
			$sql .= " ORDER BY " . implode(", ", $sortvals);
		}
		return $this->query($sql, $fields);
	}	
function db_query_array($query,$key='',$first_record=false,$unbuffered=false,$val_field='',$fetchmode = PDO::FETCH_ASSOC)
{
	global $CFG;
	$result = $this->db_query($query,false,true,false,$unbuffered, PDO::FETCH_ASSOC);

    if ($result==false) return false;
	
	if ($key && !$first_record)
		for ($i=0;$i< count($result); $i++) {
			$row=$result[$i];
			$return_arr[$row[$key]] = ($val_field) ? $row[$val_field] : $row;
		}
	else
			for ($i=0;$i< count($result); $i++) {
            $row=$result[$i];
			$return_arr[] = ($val_field) ? $row[$val_field] : $row;
		}



	if ($first_record && isset($return_arr[0]))
		return $return_arr[0];
	else if (!$first_record)
		return @$return_arr;
	else
		return false;
}

function db_query($query, $debug=false, $die_on_debug=true, $silent=false, $unbuffered=false, $is_retry=false, $fetchmode = PDO::FETCH_ASSOC)
{
	
	global $DB_DIE_ON_FAIL, $DB_DEBUG, $CFG, $cache, $db;
	
	if (!$db) { 
          $db = new DB($CFG->dbhost, $CFG->dbname, $CFG->dbuser, $CFG->dbpass);
	}


	if (isset($CFG->store_queries) && $CFG->store_queries) {
		$time = microtime(1);
	}

	if ($debug) {
		echo "<pre>" . htmlspecialchars($query) . "</pre>";

		if ($die_on_debug) die;
	}

	if ($unbuffered)
		$db->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
	else
		$db->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	
	$result=$db->query($query,'',$fetchmode);
	
	if (count($result)===0){
		return false;
	}
    
	if (!$result && !$is_retry && $db->ExceptionLog() ) {
		// try reconnecting
		$db = new DB($CFG->dbhost, $CFG->dbname, $CFG->dbuser, $CFG->dbpass);
		return $db->db_query($query, $debug, $die_on_debug, $silent, $unbuffered, true);
	}

	if (! $result && ! $silent) {
		if ($DB_DEBUG) {
			echo "<h2>Can't execute query</h2>";
			echo "<pre>" . htmlspecialchars($query) . "</pre>";
			echo "<p><b>MySQL Error</b>: ".$db->ExceptionLog();
			echo "<p><b>Debug</b>: ";
			print_ar( debug_backtrace() );
		} else {
			echo "<h2>Database error encountered</h2>Query:".$query. "<br/>Error:".$db->ExceptionLog();
			$params = func_get_args();
			//db_error_mail("$_SERVER[HTTP_HOST] DB Error", "$query\r\nMySQL Error:".mysql_error()."\r\nIn " . __FILE__ .' on Line '. __LINE__,true);
		}

		if ($DB_DIE_ON_FAIL) {
			echo "<p>This script cannot continue, terminating.";
			echo "<a href=\"./\">Click here</a> to return to the homepage.";

			if ($cache && is_object($cache) && method_exists($cache,'cancel')) {
			    $cache->cancel();
			}

			die();
		}
	}

	
	if (isset($CFG->store_queries) && $CFG->store_queries) {
		$diff = microtime(1) - $time;
		global $qs;

		if(isset($CFG->min_qs_store_diff) && $diff > $CFG->min_qs_store_diff){
			if ($diff > 2.0)  {
				$debug = debug_backtrace();
			}
			else {
				$debug = '';
			}

			$qs[] = array('time'=>$diff,'query'=>$query,'debug'=>$debug);
		}
	}
	
	return $result;
}

function db_querybetween($col, $value_1, $value_2, $prefix = 'AND')
{
	$col = /*pg_escape_string*/addslashes($col);

	$value_1 = "'" . /*pg_escape_string*/addslashes($value_1) . "'";
	$value_2 = "'" . /*pg_escape_string*/addslashes($value_2) . "'";

	return " $prefix $col BETWEEN $value_1 AND $value_2 ";
}

function db_queryrange($col, $range_begin, $range_end, $prefix = 'AND')
{
	global $db;
	$q = "";

	if ($range_begin && !$range_end) {
		$q .= $db->db_restrict($col, $range_begin, ' ', ' ', '>=', $prefix);
	}
	else if (!$range_begin && $range_end) {
		$q .= $db->db_restrict($col, $range_end, ' ', ' ', '<=', $prefix);
	}
	else if ($range_begin && $range_end) {
		$q .= $db->db_querybetween($col, $range_begin, $range_end, $prefix);
	}

	return $q;

}

function db_restrict($var_name, $var_eq, $before = " ", $after = " ", $op = '=', $prefix='AND')
{
	$var_eq = addslashes($var_eq);
	return "{$before}{$prefix} {$var_name} $op '{$var_eq}'{$after}";
}


	/**	
	* Writes the log and returns the exception
	*
	* @param  string $message
	* @param  string $sql
	* @return string
	*/
	private function ExceptionLog($message , $sql = "")
	{
		$exception  = 'Unhandled Exception. <br />';
		$exception .= $message;
		$exception .= "<br /> You can find the error back in the log.";
		if(!empty($sql)) {
			# Add the Raw SQL to the Log
			$message .= "\r\nRaw SQL : "  . $sql;
		}
		throw new Exception($message);
		echo $exception;
		#return $exception;
	}			
}

?>