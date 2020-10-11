<?php

require('config.php');

class MySQLDatabase {
	
	public $last_query;
	
	private $_connection;
	private $_magic_quotes_active;
	private $_real_escape_string_exists;
	
	function __construct() {
		$this->open_connection();
		$this->_magic_quotes_active = get_magic_quotes_gpc();
		$this->_real_escape_string_exists = function_exists( "mysql_real_escape_string" );
	}
	
	public function open_connection() {
		$this->_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS);
		if(!$this->_connection)
			die('Database connection failed: ' . mysql_error());
		else {
			$db_select = mysql_select_db(DB_NAME, $this->_connection);
			if(!$db_select)
				die('Database selection failed: ' . mysql_error());
		}
	}
	
	public function close_connection() {
		if(isset($this->_connection)) {
			mysql_close($this->_connection);
			unset($this->_connection);	
		}
	}
	
	public function query($sql) {
		$this->last_query = $sql;
		$result = mysql_fetch_array(mysql_query($sql, $this->_connection),MYSQL_ASSOC);
		//$this->_confirm_query($result);
		return $result;	
	}
	
	public function escape_value( $value ) {
		if( $this->_real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->_magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->_magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	public function fetch_array($result_set) {
		return mysql_fetch_array($result_set);	
	}
	
	public function num_rows($result_set) {
		return mysql_num_rows($result_set);	
	}
	
	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysql_insert_id($this->_connection);	
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->_connection);	
	}
	
	private function _confirm_query($result) {
		if(!$result) {
			$output  = "Database query failed: " . mysql_error();
			
			// uncomment below line when you want to debug your last query
			// $output .= "<br /><br />Last SQL Query: " . $this->last_query;
			die($output);
		}
		
	}
	
}
?>