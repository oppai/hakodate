<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sample1 -- confirm</title>
</head>
<body>
<form name="form" action="index.php?action=add&amp;<?=h(gu('book_id'))?>" method="post">
<fieldset style="width:350px">
<legend>Add a new book</legend>
Book Name: <?=h($_POST['book_name'])?><br>
Price: <?=h($_POST['price'])?><br>
<?=mh()?>
<input type="button" onclick="form.action='index.php?action=confToForm&<?=gu('book_id')?>';form.submit();" value=" back ">
<?if(isset($_GET['book_id'])){?>
	<input type="submit" value=" update ">
<?}else{?>
	<input type="submit" value=" add ">
<?}?>
</fieldset>
</form>
</body>
</html>