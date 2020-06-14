<?php
    header("Content-Type: text/html; charset=utf8");

	//判断是否有submit操作
    if(!isset($_POST['submit'])){
        exit("错误执行");
    }

	//获取表单数据
    $username = $_POST['username'];//post获取表单里的username
    $password = $_POST['password'];//post获取表单里的password
	$repassword = $_POST['repassword'];//post获取表单里的repassword

	//判断密码输入是否一致
	if($password != $repassword){
		echo "<script language=\"JavaScript\">alert(\"密码输入不一致，请重新输入\");</script>";
		echo "<script>url=\"register.php\";window.location.href=url;</script>";
		exit();
	}
	
	//连接数据库
	include("connect_db.php");
	
	//判断用户名是否被占用
	$sql = "select userid from user where username = '$username'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0){
		echo "<script language=\"JavaScript\">alert(\"该用户名已被注册\");</script>";
		echo "<script>url=\"register.php\";window.location.href=url;</script>";
		exit();
	}
	
	//向数据库中插入新用户
    $sql = "insert into user(userid,username,password) values (null,'$username','$password')";
    $result = mysqli_query($conn,$sql);//执行sql
    if($result){
		echo "<script language=\"JavaScript\">alert(\"创建用户成功,前往登录\");</script>";
		echo "<script>url=\"login.php\";window.location.href=url;</script>";
    }else{
        die('Error: '.mysqli_error($conn));//如果sql执行失败输出错误
    }

	//关闭数据库
    mysqli_close($conn);
?>