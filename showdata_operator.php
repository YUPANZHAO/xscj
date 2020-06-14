<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>显示数据页面</title>
	<style>
		th{
			padding-left: 10px;
			padding-right: 10px;
		}
	</style>
</head>
	
<body>
	<?php
	//连接数据库
	include("connect_db.php");

	//获取表单数据
	$username = $_POST['username'];
	$time = $_POST['time'];
	$sorttype = $_POST['sorttype'];
	$opertype = $_POST['opertype'];
	
	if(isset($_POST['查询'])){
		//执行SQL语句
		$sql = "select 编号,用户名,时间,操作类型,SQL语句 from operator_record";
		$where = " where true";
		if($username != "请选择") $where = $where." and 用户名 = '$username'";
		if(strlen($time)) $where = $where." and 时间 = '$time'";
		if($opertype != "无") $where = $where." and 操作类型 = '$opertype'";
 		if(strlen($username) || strlen($time) || $opertype != "无") $sql = $sql.$where;
		if($sorttype == "降序") $sql = $sql." order by 时间 desc";
		else if($sorttype == "升序") $sql = $sql." order by 时间 asc";
		$result = mysqli_query($conn,$sql);
		
		//以表格形式显示数据
		echo "<table border=1><tr><th width=40px>编号</th><th>用户名</th><th width=100px>时间</th><th width=70px>操作类型</th><th>SQL语句</th></tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr><th>".$row['编号']."</th>";
			echo "<th>".$row['用户名']."</th>";
			echo "<th>".$row['时间']."</th>";
			echo "<th>".$row['操作类型']."</th>";
			echo "<th>".$row['SQL语句']."</th></tr>";
		}
		echo "</table>";
	}
	
	//关闭数据库
	mysqli_close($conn);
	?>
</body>
</html>