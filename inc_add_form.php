<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sample1 -- form</title>
</head>
<body>
<form action="index.php?action=conf&amp;<?=gu('book_id')?>" method="post">
<fieldset style="width:350px">
<legend>Add a new book</legend>
Book Name:
	<input type="text" name="book_name" value="<?=h($_POST['book_name'])?>"><br>
Price:
	<input type="text" name="price" value="<?=h($_POST['price'])?>"><br>

<input type="button" value=" back " onclick="location.href='index.php?action=sample'">
<?if(isset($_GET['book_id'])){?>
	<input type="submit" value=" confirm ">
<?}else{?>
	<input type="submit" value=" add ">
<?}?>
</fieldset>
</form>
</body>
</html>