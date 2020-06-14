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
	$name = $_POST['name'];
	$kc = $_POST['kc'];
	$score = $_POST['score'];
	$sorttype = $_POST['sorttype'];
	
	if(isset($_POST['查询'])){
		//成绩范围0<=score<=100
		if(strlen($score) && ((int)$score < 0 || (int)$score > 100)){
			echo "<script>alert(\"成绩范围必须在0到100之间\");</script>";
			exit();
		}
		
		//执行SQL语句
		$sql = "select 姓名,课程名,成绩 from cj";
		$where = " where true";
		if($name != "请选择") $where = $where." and 姓名 = '$name'";
		if($kc != "请选择") $where = $where." and 课程名 = '$kc'";
		if(strlen($score) && (int)$score >= 0 && (int)$score <= 100) $where = $where." and 成绩 = '$score'";
 		if($name != "请选择" || $kc != "请选择" || strlen($score)) $sql = $sql.$where;
		if($sorttype == "降序") $sql = $sql." order by 成绩 desc";
		else if($sorttype == "升序") $sql = $sql." order by 成绩 asc";
		$result = mysqli_query($conn,$sql);
		
		//记录用户操作
		$username = $_SESSION['username'];
		$time =  date('Y-m-d H:i:s');
		$opertype = "查询";
		$sql = str_replace("'","''","$sql");
		$record = "insert into operator_record values(null,'$username','$time','$opertype','$sql')";
		mysqli_query($conn,$record);
		
		//以表格形式显示数据
		echo "<table border=1><tr><th>姓名</th><th>课程名</th><th>成绩</th></tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr><th>".$row['姓名']."</th>";
			echo "<th>".$row['课程名']."</th>";
			echo "<th>".$row['成绩']."</th></tr>";
		}
		echo "</table>";
	}
	if(isset($_POST['录入'])){
		//姓名性别不能为空
		if($name == "请选择" || $kc == "请选择" || !strlen($score)){
			echo "<script>alert(\"姓名、课程名和成绩不能为空\");</script>";
			exit();
		}
		
		//成绩范围0<=score<=100
		if((int)$score < 0 || (int)$score > 100){
			echo "<script>alert(\"成绩范围必须在0到100之间\");</script>";
			exit();
		}
		
		//主键冲突
		$sql = "select * from cj where 姓名 = '$name' and 课程名 = '$kc'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)){
			echo "<script>alert(\"数据库中已有该学生的课程记录\");</script>";
			echo "<table border=1><tr><th>姓名</th><th>课程名</th><th>成绩</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['姓名']."</th>";
				echo "<th>".$row['课程名']."</th>";
				echo "<th>".$row['成绩']."</th></tr>";
			}
			echo "</table>";
			exit();
		}
		
		//执行SQL语句
		$sql = "insert into cj(姓名,课程名,成绩) values('$name','$kc','$score')";
		$result = mysqli_query($conn,$sql);
		
		//输出录入数据
		if($result){
			echo "<script>alert(\"录入成功\")</script>";
			$result = mysqli_query($conn,"select * from cj where 姓名 = '$name'");
			echo "<table border=1><tr><th>姓名</th><th>课程名</th><th>成绩</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['姓名']."</th>";
				echo "<th>".$row['课程名']."</th>";
				echo "<th>".$row['成绩']."</th></tr>";
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
		//姓名和课程必须输入
		if($name == "请选择" || $kc == "请选择"){
			echo "<script>alert(\"必须输入姓名和课程\")</script>";
			exit();
		}
		
		//检查数据库中是否有该学生的课程记录
		$sql = "select 姓名 from cj where 姓名 = '$name' and 课程名 = '$kc'";
		$result = mysqli_query($conn,$sql);
		if(!mysqli_num_rows($result)){
			echo "<script>alert(\"未找到该学生的课程记录\")</script>";
			exit();
		}
		
		//执行删除SQL语句
		$sql = "delete from cj where 姓名 = '$name' and 课程名 = '$kc'";
		$result = mysqli_query($conn,$sql);
		if($result){
			echo "<script>alert(\"删除成功\")</script>";
			$result = mysqli_query($conn,"select * from cj where 姓名 = '$name'");
			echo "<table border=1><tr><th>姓名</th><th>课程名</th><th>成绩</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['姓名']."</th>";
				echo "<th>".$row['课程名']."</th>";
				echo "<th>".$row['成绩']."</th></tr>";
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
		//姓名和课程必须输入
		if($name == "请选择" || $kc == "请选择"|| !strlen($score)){
			echo "<script>alert(\"必须输入姓名和课程,以及要修改的成绩\")</script>";
			exit();
		}
		
		//成绩范围0<=score<=100
		if((int)$score < 0 || (int)$score > 100){
			echo "<script>alert(\"成绩范围必须在0到100之间\");</script>";
			exit();
		}
		
		//查找是否存在该学生
		$sql = "select 姓名 from cj where 姓名 = '$name' and 课程名 = '$kc'";
		$result = mysqli_query($conn,$sql);
		if(!mysqli_num_rows($result)){
			echo "<script>alert(\"未找到该学生的课程记录\")</script>";
			exit();
		}
		
		//执行更新SQL语句
		$sql = "update cj set 成绩 = '$score' where 姓名 = '$name' and 课程名 = '$kc'";
		$result = mysqli_query($conn,$sql);
		
		//显示更新后的数据
		if($result){
			echo "<script>alert(\"更新成功\")</script>";
			$result = mysqli_query($conn,"select * from cj where 姓名 = '$name'");
			echo "<table border=1><tr><th>姓名</th><th>课程名</th><th>成绩</th></tr>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr><th>".$row['姓名']."</th>";
				echo "<th>".$row['课程名']."</th>";
				echo "<th>".$row['成绩']."</th></tr>";
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