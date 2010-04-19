<?php
require(dirname(__FILE__) . '/../config/config.php');

$ret = mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['password']);

mysql_query('use `'.$config['db']['database'].'`');

function execute(){
	$action = (isset($_POST['action']) ? $_POST['action'] : 'default').'Action';
	$action();
}

/**
 * Database
 **/
function dq(){
	return "'".mysql_real_escape_string($value)."'";
}
function de(){
	return mysql_real_escape_string($value);
}
function query($sql){
	return mysql_query($sql);
}
function get($sql){
	return mysql_fetch_assoc(query($sql));
}
function getAll($sql){
	for($result = query($sql) ; ($row = mysql_fetch_assoc($result)) !== false ; $rowArray[] = $row);
	return $rowArray;
}
function g($sql){
	return array_shift(mysql_fetch_assoc(query($sql)));
}
function gAll($sql){
	for($result = query($sql) ; ($row = mysql_fetch_assoc($result)) !== false ; $rowArray[] = array_shift($row));
	return $rowArray;
}
function hakoVarDump($data){
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}