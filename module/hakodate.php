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
	$result = query($sql);
	while(($rowArray[] = mysql_fetch_assoc($result)) !== false);
	return $rowArray;
}
function hakoVarDump($data){
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}