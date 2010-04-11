<?php
	function sanitize($str)
	{
		if (function_exists( "mysql_real_escape_string" ))
		{ // If PHP version > 4.3.0
			$str = mysql_real_escape_string($str) ;
		} else
		{ // If PHP version < 4.3.0
 			// Precede sensitive characters with a slash \
 			$str = addslashes($str) ;
		}
		return $str ;
	}
    define('SQL_SERVER','localhost'); 
    define('SQL_USER','mrapple'); 
    define('SQL_PASS','inspiron'); 
    define('SQL_DB','bzweb'); 
        
    // Creating the connection using the above configuration
    mysql_connect(SQL_SERVER,SQL_USER,SQL_PASS) or die("Error: ".mysql_error()); // Connecting to the server
    mysql_select_db(SQL_DB) or die("Error: ".mysql_error()); // Connecting to the database
    
?>