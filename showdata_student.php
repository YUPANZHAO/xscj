<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>显示数据页面</title>
	<style>
		th{
			padding-left: 5px;
			padding-right: 5px;
		}
		label:hover{
			opacity: 0;
		}
		label:hover+iframe{
			width: 90px;
			height: 100px;
			position: absolute;
			top: -60px;
			left: -80px;
		}
		label{
			widows: 80px;
			height: 20px;
		}
		iframe{
			width: 0px;
			height: 0px;
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
	$sex = $_POST['sex'];
	$birthday = $_POST['birthday'];
	$kcs = $_POST['kcs'];
	$bz = $_POST['bz'];
	$photo = $_POST['photo'];
	
	if(isset($_POST['查询'])){
		//执行SQL语句
		$sql = "select 姓名,性别,出生日期,已修课程数,备注 from xs";
		$where = " where true";
		if($name) $where = $where." and 姓名 = '$name'";
		if((int)strlen($sex) > 0){ $sex = '0'.$sex; $where = $where." and 性别 = '$sex'";}
		if($birthday) $where = $where." and 出生日期 = '$birthday'";
		if((int)strlen($kcs) > 0){ $kcs = '0'.$kcs; $where = $where." and 已修课程数 = '$kcs'";}
		if(strlen($bz)) $where = $where." and 备注 = '$bz'";
 		if($name || $sex || $birthday || $kcs || $bz) $sql = $sql.$where;
		$result = mysqli_query($conn,$sql);
		
		//记录用户操作
		$username = $_SESSION['username'];
		$time =  date('Y-m-d H:i:s');
		$opertype = "查询";
		$sql = str_replace("'","''","$sql");
		$record = "insert into operator_record values(null,'$username','$time','$opertype','$sql')";
		mysqli_query($conn,$record);
		
		//以表格形式显示数据
		echo "<table border=1><tr><th>姓名</th><th>性别</th><th>出生日期</th><th>已修课程数</th><th>备注</th><th>照片</th></tr>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr><th width=70px>".$row['姓名']."</th>";
			echo "<th width=40px>";
			if($row['性别'] == 1) echo "男";
			else echo "女";
			echo "</th>";
			echo "<th width=120px>".$row['出生日期']."</th>";
			echo "<th width=60px>".$row['已修课程数']."</th>";
			echo "<th width=50%>".$row['备注']."</th>";
			echo "<th width=80px style=\"position: relative;\"><label>查看图片</label><iframe src=\"imgview.php?imgname=".$row['姓名']."\" scrolling=\"no\" frameborder=\"0\"></iframe></th></tr>";
		}
		echo "</table>";
	}
	if(isset($_POST['录入'])){
		//姓名性别不能为空
		if(!strlen($name) || !strlen($sex)){
			echo "<script>alert(\"姓名和性别不能为空\");</script>";
			exit();
		}
		
		//主键冲突
		$sql = "select 姓名 from xs where 姓名 = '$name'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)){
			echo "<script>alert(\"数据库中已有该学生\");</script>";
			exit();
		}
		
		//执行SQL语句
		$sql = "insert into xs(姓名,性别";
		$value = "values('$name','$sex'";
		if(strlen($birthday)){$sql = $sql.",出生日期"; $value = $value.",'$birthday'";}
		if(strlen($kcs)){$sql = $sql.",已修课程数"; $value = $value.",'$kcs'";}
		if(strlen($bz)){$sql = $sql.",备注"; $value = $value.",'$bz'";}
		$record_sql = $sql; $record_value = $value;
		if(strlen($photo)){
			$PSize = filesize($photo);   
			$Picture = addslashes(fread(fopen($photo, "r"), $PSize));
			$sql = $sql.",照片"; $value = $value.",'$Picture'";
			$record_sql = $sql; $record_value = $record_value.",'xxx'";
		}
		$record_sql = $record_sql.") ".$record_value.") ";
		$sql = $sql.") ".$value.")";
		$result = mysqli_query($conn,$sql);
		
		//输出录入数据
		if($result){
			echo "<script>alert(\"录入成功\")</script>";
			$result = mysqli_query($conn,"select * from xs where 姓名 = '$name'");
			$row = mysqli_fetch_array($result);
			echo "<table border=1><tr><th>姓名</th><th>性别</th><th>出生日期</th><th>已修课程数</th><th>备注</th><th>照片</th></tr>";
			echo "<tr><th>".$row['姓名']."</th>";
			echo "<th width=40px>";
			if($row['性别'] == 1) echo "男";
			else echo "女";
			echo "</th>";
			echo "<th width=120px>".$row['出生日期']."</th>";
			echo "<th width=60px>".$row['已修课程数']."</th>";
			echo "<th width=50%>".$row['备注']."</th>";
			echo "<th width=80px style=\"position: relative;\"><label>查看图片</label><iframe src=\"imgview.php?imgname=".$row['姓名']."\" scrolling=\"no\" frameborder=\"0\"></iframe></th></tr>";
			echo "</table>";
			
			//记录用户操作
			$username = $_SESSION['username'];
			$time =  date('Y-m-d H:i:s');
			$opertype = "录入";
			$record_sql = str_replace("'","''","$record_sql");
			$record = "insert into operator_record values(null,'$username','$time','$opertype','$record_sql')";
			mysqli_query($conn,$record);
		}else{
			echo "<script>alert(\"录入失败\");</script>";
		}
	}
	if(isset($_POST['删除'])){
		//姓名必须输入
		if(!strlen($name)){
			echo "<script>alert(\"必须输入姓名\")</script>";
			exit();
		}
		
		//检查数据库中是否有该学生
		$sql = "select 姓名 from xs where 姓名 = '$name'";
		$result = mysqli_query($conn,$sql);
		if(!mysqli_num_rows($result)){
			echo "<script>alert(\"未找到该学生\")</script>";
			exit();
		}
		
		//执行删除SQL语句
		$sql = "delete from xs where 姓名 = '$name'";
		$result = mysqli_query($conn,$sql);
		if($result){
			echo "<script>alert(\"删除成功\")</script>";
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
		//姓名必须输入
		if(!strlen($name)){
			echo "<script>alert(\"必须输入姓名\")</script>";
			exit();
		}
		
		//至少填写一项修改内容
		if(!(strlen($sex) || strlen($birthday) || strlen($kcs) || strlen($bz) || strlen($photo))){
			echo "<script>alert(\"至少填写一项修改内容\")</script>";
			exit();
		}
		
		//查找是否存在该学生
		$sql = "select 姓名 from xs where 姓名 = '$name'";
		$result = mysqli_query($conn,$sql);
		if(!mysqli_num_rows($result)){
			echo "<script>alert(\"未找到该学生\")</script>";
			exit();
		}
		
		//执行更新SQL语句
		$sql = "update xs set";
		$record_sql = $sql;
		$set = " 姓名 = '$name'";
		if(strlen($sex)) $set = $set.",性别 = '$sex'";
		if(strlen($birthday)) $set = $set.",出生日期 = '$birthday'";
		if(strlen($kcs)) $set = $set.",已修课程数 = '$kcs'";
		if(strlen($bz)) $set = $set.",备注 = '$bz'";
		if(strlen($photo)){
			$PSize = filesize($photo);   
			$Picture = addslashes(fread(fopen($photo, "r"), $PSize));
			$record_sql = $record_sql.$set.",照片 = 'xxx'";
			$set = $set.",照片 = '$Picture'";
		}
		$sql = $sql.$set." where 姓名 = '$name'";
		$record_sql = $record_sql." where 姓名 = '$name'";
		$result = mysqli_query($conn,$sql);
		
		//显示更新后的数据
		if($result){
			echo "<script>alert(\"更新成功\")</script>";
			$result = mysqli_query($conn,"select * from xs where 姓名 = '$name'");
			$row = mysqli_fetch_array($result);
			echo "<table border=1><tr><th>姓名</th><th>性别</th><th>出生日期</th><th>已修课程数</th><th>备注</th><th>照片</th></tr>";
			echo "<tr><th>".$row['姓名']."</th>";
			echo "<th width=40px>";
			if($row['性别'] == 1) echo "男";
			else echo "女";
			echo "</th>";
			echo "<th width=120px>".$row['出生日期']."</th>";
			echo "<th width=60px>".$row['已修课程数']."</th>";
			echo "<th width=50%>".$row['备注']."</th>";
			echo "<th width=80px style=\"position: relative;\"><label>查看图片</label><iframe src=\"imgview.php?imgname=".$row['姓名']."\" scrolling=\"no\" frameborder=\"0\"></iframe></th></tr>";
			echo "</table>";
			
			//记录用户操作
			$username = $_SESSION['username'];
			$time =  date('Y-m-d H:i:s');
			$opertype = "更新";
			$record_sql = str_replace("'","''","$record_sql");
			$record = "insert into operator_record values(null,'$username','$time','$opertype','$record_sql')";
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