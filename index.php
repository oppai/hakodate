<?php
include('module/hakodate.php');

execute();

function defaultAction(){
	include('inc_index.php');
}
function sampleAction(){
	if(array_search('books', gAll('SHOW TABLES')) === false){
		location('index.php?action=setupForm');
	}else{
		include('inc_sample.php');
	}
}
function setupFormAction(){
	include('inc_setup_form.php');
}