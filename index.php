<?php
include('module/hakodate.php');

execute();

function defaultAction(){
	$data = get('select * from test');
	include('inc_index.php');
}