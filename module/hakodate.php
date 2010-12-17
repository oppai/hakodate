<?php
require(dirname(__FILE__) . '/../config/config.php');

$ret = mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['password']);

mysql_query('use `'.$config['db']['database'].'`');
mysql_query('SET NAMES utf8');

function execute(){
	$action = (isset($_POST['action']) ? $_POST['action'] : 'default').'Action';
	$action();
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
		return $recourse;
	}else{
		echo '<strong style="color:red">'.mysql_error().' - '.$sql.'</strong>';
	}
}
function get($sql){
	return mysql_fetch_assoc(query($sql));
}
function getAll($sql){
	for($result = query($sql) ; $row = mysql_fetch_assoc($result) ; $rowArray[] = $row);
	return $rowArray;
}
function g($sql){
	return array_shift(mysql_fetch_assoc(query($sql)));
}
function gAll($sql){
	for($result = query($sql) ; $row = mysql_fetch_assoc($result) ; $rowArray[] = array_shift($row))out($row);
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
		$sql1 = 'select count(*) count from `'.$tableName.'`';
		if(count($keyArray)){
			for($i = 0 ; $i < count($keyArray) ; $i++){
				$searchKeyStruct[$keyArray[$i]] = $dataStruct[$keyArray[$i]];
			}
			$searchKeyStruct = array_map('quote', $searchKeyStruct);		
			$dataSearchCondition = array_map(array($this,'makeEquation'), array_keys($searchKeyStruct), array_values($searchKeyStruct));
			$sql1.= ' where '.implode(' and ', $dataSearchCondition);
		}
		$data = $this->fetch($this->query($sql1));
		$count = $data['count'];
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
	$sql = 'insert into `'.$tableName.'`('.implode(',', $fieldNames).')values('.implode(',', $dataValues).')';
	query($sql);
	return mysql_insert_id();
}
function update($tableName, $dataStruct, $keyArray){
	$fieldNames = array_keys($dataStruct);
	$fieldNames = array_map(backQuote, $fieldNames);
	$dataValues = array_values($dataStruct);
	$dataValues = array_map(quote, $dataValues);		
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
	$dataSearchCondition = array_map(array($this,'makeEquation'), array_keys($searchKeyStruct), array_values($searchKeyStruct));
	$sql2 = 'update `'.$tableName.'` set '.implode(',', array_map(array($this,'makeEquation'), $fieldNames, $dataValues));
	$sql2 .= ' where '.implode(' and ',$dataSearchCondition);
	$this->query($sql2);
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
			echo '<td>'.$name.'</td>';
		}
		break;
	}
	echo '</tr>';
	foreach($table as $name => $tr){
		echo '<tr>';
		echo '<td bgcolor="#ffffaa">'.$name.'</td>';
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