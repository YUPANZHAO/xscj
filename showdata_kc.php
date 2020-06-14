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
	//开启session会话
	session_start();
	
	//连接数据库
	include("connect_db.php");

	//获取表单数据
	$kcm = $_POST['kcm'];
	$xs = $_POST['xs'];
	$xf = $_POST['xf'];
	
	if(isset($_POST['查询'])){
		//执行SQL语句
		$sql = "select 课程名,学时,学分 from kc";
		$where = " where true";
		if(strlen($kcm)) $where = $where." and 课程名 = '$kcm'";
		if(strlen($xs)) $where = $where." and 学时 = '$xs'";
		if(strlen($xf)) $where = $where." and 学分 = '$xf'";
 		if(strlen($kcm) || strlen($xs) || strlen($xf)) $sql = $sql.$where;
		$result = mysqli_query($conn,$sql);
		
		//记录用户操作
		$username = $_SESSION['username'];
		$time =  date('Y-m-d H:i:s');
		$opertype = "查询";
		$sql = str_replace("'","''","$sql");
		$record = "insert into operator_record values(null,'$username','$time','$opertype','$sql')";
		mysqli_query($conn,$record);
		
		//以表格形式显示数据
		echo "<table border=1><tr><th>课程名</th><th>学时</th><th>学分</th></tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr><th>".$row['课程名']."</th>";
			echo "<th>".$row['学时']."</th>";
			echo "<th>".$row['学分']."</th></tr>";
		}
		echo "</table>";
	}
	if(isset($_POST['录入'])){
		//课程名、学时和学分不能为空
		if(!strlen($kcm) || !strlen($xs) || !strlen($xf)){
			echo "<script>alert(\"课程名、学时和学分不能为空\");</script>";
			exit();
		}
		
		//学时和学分必须为非负整数
		if((int)$xs < 0 || (int)$xf < 0){
			echo "<script>alert(\"学时和学分必须为非负整数\");</script>";
			exit();
		}
		
		//主键冲突
		$sql = "select * from kc where 课程名 = '$kcm'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)){
			echo "<script>alert(\"数据库中已有该课程\");</script>";
			echo "<table border=1><tr><th>课程名</th><th>学时</th><th>学分</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['课程名']."</th>";
				echo "<th>".$row['学时']."</th>";
				echo "<th>".$row['学分']."</th></tr>";
			}
			echo "</table>";
			exit();
		}
		
		//执行SQL语句
		$sql = "insert into kc(课程名,学时,学分) values('$kcm','$xs','$xf')";
		$result = mysqli_query($conn,$sql);
		
		//输出录入数据
		if($result){
			echo "<script>alert(\"录入成功\")</script>";
			$result = mysqli_query($conn,"select * from kc where 课程名 = '$kcm'");
			echo "<table border=1><tr><th>课程名</th><th>学时</th><th>学分</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['课程名']."</th>";
				echo "<th>".$row['学时']."</th>";
				echo "<th>".$row['学分']."</th></tr>";
			}
			echo "</table>";
			
			//记录用户操作
			$username = $_SESSION['username'];
			$time =  date('Y-m-d H:i:s');
			$opertype = "录入";
			$sql = str_replace("'","''","$sql");
			$record = "insert into operator_record values(null,'$username','$time','$opertype','$sql')";
			mysqli_query($conn,$record);
		}else{
			echo "<script>alert(\"录入失败\");</script>";
		}
	}
	if(isset($_POST['删除'])){
		//课程必须输入
		if(!strlen($kcm)){
			echo "<script>alert(\"课程名不能为空\")</script>";
			exit();
		}
		
		//检查数据库中是否有该课程名
		$sql = "select 课程名 from kc where 课程名 = '$kcm'";
		$result = mysqli_query($conn,$sql);
		if(!mysqli_num_rows($result)){
			echo "<script>alert(\"未找到该课程\")</script>";
			exit();
		}
		
		//执行删除SQL语句
		$sql = "delete from kc where 课程名 = '$kcm'";
		$result = mysqli_query($conn,$sql);
		if($result){
			echo "<script>alert(\"删除成功\")</script>";
			$result = mysqli_query($conn,"select * from kc");
			echo "<table border=1><tr><th>课程名</th><th>学时</th><th>学分</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['课程名']."</th>";
				echo "<th>".$row['学时']."</th>";
				echo "<th>".$row['学分']."</th></tr>";
			}
			echo "</table>";
			
			//记录用户操作
			$username = $_SESSION['username'];
			$time =  date('Y-m-d H:i:s');
			$opertype = "删除";
			$sql = str_replace("'","''","$sql");
			$record = "insert into operator_record values(null,'$username','$time','$opertype','$sql')";
			mysqli_query($conn,$record);
		}else{
			echo "<script>alert(\"删除失败\")</script>";
		}
	}
	if(isset($_POST['更新'])){
		//课程名必须输入
		if(!strlen($kcm)){
			echo "<script>alert(\"课程名必须输入\")</script>";
			exit();
		}
		
		//至少填写一个修改项
		if(!strlen($xs) && !strlen($xf)){
			echo "<script>alert(\"至少填写一个修改项\");</script>";
			exit();
		}
		
		//学时和学分必须为非负整数
		if((int)$xs < 0 || (int)$xf < 0){
			echo "<script>alert(\"学时和学分必须为非负整数\");</script>";
			exit();
		}
		
		//查找是否存在该课程名
		$sql = "select 课程名 from kc where 课程名 = '$kcm'";
		$result = mysqli_query($conn,$sql);
		if(!mysqli_num_rows($result)){
			echo "<script>alert(\"未找到该课程\")</script>";
			exit();
		}
		
		//执行更新SQL语句
		$sql = "update kc set 课程名 = '$kcm'";
		$set = "";
		if(strlen($xs)) $set = $set.",学时 = '$xs'";
		if(strlen($xf)) $set = $set.",学分 = '$xf'";
		$sql = $sql.$set." where 课程名 = '$kcm'";
		$result = mysqli_query($conn,$sql);
		
		//显示更新后的数据
		if($result){
			echo "<script>alert(\"更新成功\")</script>";
			$result = mysqli_query($conn,"select * from kc");
			echo "<table border=1><tr><th>课程名</th><th>学时</th><th>学分</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['课程名']."</th>";
				echo "<th>".$row['学时']."</th>";
				echo "<th>".$row['学分']."</th></tr>";
			}
			echo "</table>";
			
			//记录用户操作
			$username = $_SESSION['username'];
			$time =  date('Y-m-d H:i:s');
			$opertype = "更新";
			$sql = str_replace("'","''","$sql");
			$record = "insert into operator_record values(null,'$username','$time','$opertype','$sql')";
			mysqli_query($conn,$record);
		}else{
			echo "<script>alert(\"更新失败\")</script>";
		}
	}
	
	//关闭数据库
	mysqli_close($conn);
	?>
<!--	<iframe src="imgview.php?imgname=imagine7" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe>-->
</body>
</html>