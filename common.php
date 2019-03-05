<?php
require_once("./creds.php"); 

function sanitzeString($var){
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = rtrim($var);
	return $var;
}
function sanatizeMySQL($var){
	$connection = new mysqli($GLOBALS['db_hostname'] , $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_database']) or die($connection->connect_error); // connect to db
	$var = $connection->real_escape_string($var);
	//$var = sanitzeString($var);
	return $var;
}

function send_query($query){
	$connection = new mysqli($GLOBALS['db_hostname'] , $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_database']) or die($connection->connect_error); // connect to db
	$result = $connection->query($query) or die($connection->error); //retrieve results
	return $result;
}
?>