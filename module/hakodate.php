<?php
mysql_connect('localhost', 'root', '');
mysql_query('use elm');

function execute(){
	$action = (isset($_POST['action']) ? $_POST['action'] : 'default').'Action';
	$action();
}