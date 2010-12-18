<h2>Get a value</h2>
<?php out(g('select book_name from books'));?>

<h2>Get values</h2>
<?php out(gAll('select * from books'));?>

<h2>Get a row</h2>
<?php out(get('select * from books limit 1'));?>

<h2>Get rows</h2>
<?php out(getAll('select book_name from books'));?>

<h2>Get rows and display in table</h2>
<?php table(getAll('select * from books'));?>
<br>
[<a href="index.php"> back </a>]