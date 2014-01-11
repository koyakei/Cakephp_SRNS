<html>
<head>
<title>Top</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<br>
<table border="1">
<tr><td><?php $id; ?></td><td><?php $name; ?></td></tr>

</table>
<form action="search.php" method="post">
AND  <input type="text" name="andSearch1"> <input type="text" name="andSearch2"><br>
OR  <input type="text" name="orSearch"><br>
NOT  <input type="text" name="notSearch"><br>
<input value="検索" type="submit" name="Search">
</form>

</html>