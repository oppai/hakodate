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
/* Display multi-dimension array (for debugging) */
function out($data){
	if(is_object($data)){
		$data = get_object_vars($data);
	}
	if(is_array($data)){
		echo '<table border="1" style="border:solid 2px black;border-collapse: collapse;" bgcolor="#ffffff">';
		echo '<tr bgcolor="#ffffaa"><td>key</td><td>value</td></tr>';
		foreach($data as $key => $value){
			echo '<tr><td>';
			echo $key;
			echo '</td><td>';
			if($key !== 'GLOBALS'){
				out($value);
			}
			echo '</td></tr>';
		}
		echo '</table>';
	}else{
		echo '<div>';
		if(is_string($data)){
			echo htmlspecialchars($data);
		}else{
			var_dump($data);
		}
		echo '</div>';
	}
}
/* Display 2-dimension array (for debugging) */
function table($table){
	if(count($table) == 0){
		echo 'Empty';
		return;
	}
	echo '<table border="1" style="border:solid 2px black;border-collapse: collapse;" bgcolor="#ffffff">';
	echo '<tr bgcolor="#ffffaa">';
	echo '<td>-</td>';
	foreach($table as $row){
		foreach($row as $name => $td){
			echo '<td>'.$name.'</td>';
		}
		break;
	}
	echo '</tr>';
	foreach($table as $name => $tr){
		echo '<tr>';
		echo '<td bgcolor="#ffffaa">'.$name.'</td>';
		foreach($tr as $td){
			echo '<td>'.$td.'</td>';
		}
		echo '</tr>';
	}
	echo '</table>'	;
}
