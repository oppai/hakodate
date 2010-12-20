<html>
<head>
<title>Sample1 -- list view</title>
</head>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
[ <a href="index.php?action=addForm">add</a> ]
<table border="1">
	<tr>
		<td>edit</td>
		<td>book_id</td>
		<td>book_name</td>
		<td>price</td>
		<td>delete</td>
	</tr>
<?php foreach(getAll('select * from books') as $book){?>
	<tr>
		<td><input type="button" onclick="location.href='index.php?action=edit&book_id=<?php echo h($book['book_id'])?>'" value="edit"></td>
		<td><?php echo h($book['book_id'])?></td>
		<td><?php echo h($book['book_name'])?></td>
		<td align="right"><?php echo number_format($book['price'])?></td>
		<td><input type="button" onclick="if(confirm('Are you sure to delete?'))location.href='index.php?action=delete&book_id=<?php echo h($book['book_id'])?>'" value="delete"></td>
	</tr>
<?}?>
</table>


[<a href="index.php"> back </a>]
</body>
</html>