<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>显示图片</title>
<style>
	*{
		padding: 0px;
		margin: 1px;
	}
</style>
</head>

<body>
	<?php
	$imgname = $_GET['imgname'];
	include("connect_db.php");
	$sql = "select 照片 from xs where 姓名 = '$imgname'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result);
//	echo $imgname."<br>";
	mysqli_close($conn);
	?>
	<img width="80px" height="100px" src="data:image/png;base64,<?=base64_encode($row['照片'])?>"/>
</body>
</html>