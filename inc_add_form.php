<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<form action="index.php?action=add&<?=gu('book_id')?>" method="post">
<fieldset style="width:350px">
<legend>Add a new book</legend>
Book Name:
	<input type="text" name="book_name" value="<?=h($_POST['book_name'])?>"><br>
Price:
	<input type="text" name="price" value="<?=h($_POST['price'])?>"><br>
<?if(isset($_GET['book_id'])){?>
	<input type="submit" value=" update ">
<?}else{?>
	<input type="submit" value=" add ">
<?}?>
</fieldset>
</form>
