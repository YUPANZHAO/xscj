<?php
	session_start();

	//连接数据库
	include("connect_db.php");

	//获取表单数据
	$username = $_POST['username'];//用户名
	$password = $_POST['password'];//密码
	
	//查询用户是否存在
	$sql = "select userid from user where username = '$username'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) <= 0){
		echo "<script language=\"JavaScript\">alert(\"该用户名不存在\");</script>";
		echo "<script>url=\"login.php\";window.location.href=url;</script>";
		exit();
	}
	
	//查询用户
	$sql = "select userid from user where username = '$username' and password = '$password'";//SQL查询语句
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0){//查询到数据，跳转到系统主页index.php
		$_SESSION['username'] = $_POST['username'];
		echo "<script>url=\"index.php\";window.location.href=url;</script>";
	}
	else{//没有查询到数据，弹出一个对话框
		echo "<script>alert(\"用户名或密码错误\");</script>";
		echo "<script>url=\"login.php\";window.location.href=url;</script>";
	}
	
	//关闭数据库
    mysqli_close($conn);
?>