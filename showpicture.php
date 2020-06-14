<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>显示图片</title>
<style>
	*{
		padding: 0px;
		margin: 0px;
	}	
</style>
</head>

<body>
	<?php
	header('Content-type: image/jpg');
	include "connect_db.php";
	$stuname = $_GET['stuname'];
	$sql = "select 照片 from xs where 姓名 = 'imagine7'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result);
	$image = base64_decode($row['照片']);
	echo $image;
	mysqli_close($conn);
	?>
</body>
</html>