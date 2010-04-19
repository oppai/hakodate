<?php
include('module/hakodate.php');

execute();

function defaultAction(){
	$data = getAll('select * from books');
	include('inc_index.php');
}