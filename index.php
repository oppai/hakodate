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
function addFormAction(){
	include('inc_add_form.php');
}
function editAction(){
	$_POST = get('SELECT * FROM books WHERE book_id = '.dq($_GET['book_id']));
	include('inc_add_form.php');
}
function addAction(){
	if($_POST['book_name'] && $_POST['price']){
		if(isset($_GET['book_id']))$_POST['book_id'] = $_GET['book_id'];
		put('books', $_POST, 'book_id');
	}
	location('index.php?action=sample');
}
function deleteAction(){
	query('DELETE FROM books WHERE book_id = '.dq($_GET['book_id']));
	location('index.php?action=sample');
}
