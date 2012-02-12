<?php
require(dirname(__FILE__) . '/../config/config.php');

$ret = mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['password']) OR DIE('CONNECTION FAILURE');

query('USE `'.$config['db']['database'].'`');
query('SET NAMES utf8');

function execute(){
	$action = (isset($_GET['action']) ? $_GET['action'] : 'default').'Action';
	if(function_exists($action)) $action();
	else defaultAction();
}

/**
 * Database
 **/
function dq($str){
	return "'".mysql_real_escape_string($str)."'";
}
function de($str){
	return mysql_real_escape_string($str);
}
function query($sql){
	if($resource = mysql_query($sql)){
		return $resource;
	}else{
		echo error(mysql_error().' - '.$sql);
	}
}
function error($str){
	echo '<strong style="color:red">'.$str.'</strong>';
}
function get($sql){
	return mysql_fetch_assoc(query($sql));
}
function getAll($sql){
	for($result = query($sql), $rowArray = array(); $row = mysql_fetch_assoc($result) ; $rowArray[] = $row);
	return $rowArray;
}
function g($sql){
	$ret = mysql_fetch_assoc(query($sql));
	return is_array($ret) ? array_shift($ret) : false;
}
function gAll($sql){
	for($result = query($sql), $rowArray = array() ; $row = mysql_fetch_assoc($result) ; $rowArray[] = array_shift($row));
	return $rowArray;
}
function put($tableName, $dataStruct, $keyArray = array()){
	$fieldNames = array_keys($dataStruct);
	$fieldNames = array_map('backQuote', $fieldNames);
	$dataValues = array_values($dataStruct);
	$dataValues = array_map('quote', $dataValues);		
	if(!is_array($keyArray)){
		$keyArray = explode(',', $keyArray);
	}
	if(count($keyArray) > 0){
		$sql1 = 'SELECT COUNT(*) count FROM '.backQuote($tableName);
		if(count($keyArray)){
			for($i = 0 ; $i < count($keyArray) ; $i++){
				$searchKeyStruct[$keyArray[$i]] = $dataStruct[$keyArray[$i]];
			}
			$searchKeyStruct = array_map('quote', $searchKeyStruct);		
			$dataSearchCondition = array_map('makeEquation', array_keys($searchKeyStruct), array_values($searchKeyStruct));
			$sql1.= ' WHERE '.implode(' AND ', $dataSearchCondition);
		}
		$count = g($sql1);
	}
	if(count($keyArray) == 0 || $count == 0){
		return insert($tableName, $dataStruct);
	}else{
		update($tableName, $dataStruct, $keyArray);
	}
}
function insert($tableName, $dataStruct){
	$fieldNames = array_keys($dataStruct);
	$fieldNames = array_map('backQuote', $fieldNames);
	$dataValues = array_values($dataStruct);
	$dataValues = array_map('quote', $dataValues);
	$sql = 'INSERT INTO `'.$tableName.'`('.implode(',', $fieldNames).') VALUES ('.implode(',', $dataValues).')';
	query($sql);
	return mysql_insert_id();
}
function update($tableName, $dataStruct, $keyArray){
	$fieldNames = array_keys($dataStruct);
	$fieldNames = array_map('backQuote', $fieldNames);
	$dataValues = array_values($dataStruct);
	$dataValues = array_map('quote', $dataValues);		
	if(!is_array($keyArray))$keyArray = explode(',', $keyArray);
	foreach($fieldNames as $i => $name){
		if(in_array($name, $keyArray)){
			unset($fieldNames[$i]);
			unset($dataValues[$i]);
		}
	}
	for($i = 0 ; $i < count($keyArray) ; $i++){
		$searchKeyStruct[$keyArray[$i]] = $dataStruct[$keyArray[$i]];
	}
	$searchKeyStruct = array_map('quote', $searchKeyStruct);		
	$dataSearchCondition = array_map('makeEquation', array_keys($searchKeyStruct), array_values($searchKeyStruct));
	query('UPDATE '.backQuote($tableName).' SET '.implode(',', array_map('makeEquation', $fieldNames, $dataValues)).' WHERE '.implode(' AND ',$dataSearchCondition));
}
function quote($value){
	if($value === NULL){
		return 'NULL';
	}else{
		return "'".mysql_real_escape_string($value)."'";
	}
}
function backQuote($value){
	return '`'.$value.'`';
}
function makeEquation($key, $value){
	return $key.'='.$value;
}
/* Display multi-dimension array (for debugging) */
function out($data){
	if(is_object($data))$data = get_object_vars($data);
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
			echo h($data);
		}else{
			var_dump($data);
		}
		echo '</div>';
	}
}
/* Display 2-dimension array (for debugging) */
function table($table){
	if(!is_array($table)){
		echo 'Not an array';
		return;
	}
	echo '<table border="1" style="border:solid 2px black;border-collapse: collapse;" bgcolor="#ffffff">';
	echo '<tr bgcolor="#ffffaa">';
	echo '<td>-</td>';
	foreach($table as $row){
		foreach($row as $name => $td){
			echo '<td>'.h($name).'</td>';
		}
		break;
	}
	echo '</tr>';
	foreach($table as $name => $tr){
		echo '<tr>';
		echo '<td bgcolor="#ffffaa">'.h($name).'</td>';
		foreach($tr as $td){
			echo '<td>'.h($td).'</td>';
		}
		echo '</tr>';
	}
	echo '</table>'	;
}
function h($str){
	return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
}
function uh($str){
	return h(urlencode($str));
}
function location($url){
	header('location:'.$url);
}
function gu($list){
	$ret = array();
	foreach(explode(',', $list) as $name){
		if(isset($_GET[$name])){
			$ret[] = $name.'='.urlencode($_GET[$name]);
		}
	}
	return implode('&', $ret);
}
function mh($list = false){
	$ret = array();
	if($list === false){
		$list = array_keys($_POST);
	}elseif(is_array($list)){
	}else{
		$list = explode(',', $list);
	}
	foreach($list as $name){
		if(is_array($_POST[$name])){
			foreach($_POST[$name] as $elem){
				$ret[] = '<input type="hidden" name="'.h($name).'[]" value="'.h($elem).'"/>';
			}
		}else{
			$ret[] = '<input type="hidden" name="'.h($name).'" value="'.h($_POST[$name]).'"/>';
		}
	}
	return implode(chr(10), $ret);
}
function config($name){
	$names = explode('.', $name);
	$config_tmp = $GLOBALS['config'];
	foreach($names as $part){
		if(isset($config_tmp[$part])){
			$config_tmp = $config_tmp[$part];
		}else{
			return;
		}
	}
	return $config_tmp;
}