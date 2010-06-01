<html>
<head>
<title>Samples of Hakodate framework</title>
</head>
<body>
<h1>Hello Hakodate Framework!</h1>

<h2>Get a row</h2>
&lt;?php out(get('select&nbsp;*&nbsp;from&nbsp;books'));&nbsp;/*&nbsp;get&nbsp;the&nbsp;first&nbsp;row&nbsp;*/?&gt;
<?php out(get('select * from books limit 1')); /* get the first row */?>

<h2>Get rows</h2>
&lt;?php out(g('select&nbsp;book_name&nbsp;from&nbsp;books'));/*&nbsp;get&nbsp;first&nbsp;column&nbsp;of&nbsp;the&nbsp;first&nbsp;row*/?&gt;
<?php out(g('select book_name from books limit 1'));/* get first column of the first row*/?>

<h2>Get a value</h2>
&lt;?php out(gAll('select&nbsp;book_name&nbsp;from&nbsp;books'));/*&nbsp;get&nbsp;first&nbsp;columns&nbsp;of&nbsp;all&nbsp;rows&nbsp;*/?&gt;
<?php out(gAll('select book_name from books'));/* get first columns of all rows */?>

<h2>Get values</h2>
&lt;?php out(getAll('select&nbsp;*&nbsp;from&nbsp;books'));/*&nbsp;get&nbsp;all&nbsp;rows&nbsp;*/?&gt;
<?php echo "<?php out(getAll('select * from books'));/* get all rows */?>"?>
<?php out(getAll('select * from books'));/* get all rows */?>


<h2>Get rows and display in table</h2>
&lt;?php table(getAll('select&nbsp;*&nbsp;from&nbsp;books'));/*&nbsp;get&nbsp;all&nbsp;and&nbsp;display&nbsp;as&nbsp;table&nbsp;*/?&gt;
<?php table(getAll('select * from books'));/* get all and display as table */?>

<?php

put('books', array('book_name' => 'Book AAA', 'price' => 1980));

?>
</body>
</table>