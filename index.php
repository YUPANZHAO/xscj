<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	function logincheck($to){
		if(isset($_SESSION['username'])) echo "$to";
		else echo "loginwarning.php";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<title>学生成绩管理系统主页</title>
	<link rel="stylesheet" type="text/css" href="frame.css">
	<style>
		.manage_option{
			float: left;
			box-sizing: border-box;
			padding: 5px;
			border: 2px solid rgba(255,255,255,0.6);
			border-radius: 10px;
			width: 200px;
			min-height: 450px;
			background: rgba(255,255,255,0.6);
		}
		.operator_page{
			float: left;
			padding: 0px;
			margin-left: 10px;
			border-radius: 10px;
			width: 1200px;
			min-height: 450px;
/*			background: rgba(255,255,255,0.6);*/
		}
		.button{
			margin-left: 40px;
			margin-right: 40px;
			margin-top: 30px;
			width: 100px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 5px;
			background: rgba(255,0,4,0.6);
		}
		.button:hover{
			background: rgba(255,0,4,1.0);
		}
		a{
			color: papayawhip;
			text-decoration: none;
		}
	</style>
</head>
	
<body>
	<div class="header">
		<h2 class="head_title">学生成绩管理系统</h2>
		<!--当前用户信息-->
		<?php
		if(isset($_SESSION['username'])){
			echo "<div class=\"username\">";
			echo "<a style=\"margin-right:5px;\">".$_SESSION['username']."</a>";
			echo "<text style=\"margin-right:5px;\">|</text>";
			echo "<a href=\"destroy_user.php\">注销</a>";
			echo "</div>";
		}else{
			echo "<div class=\"username\">";
			echo "<a style=\"margin-right:5px;\" href=\"login.php\">前往登录</a>";
			echo "<text style=\"margin-right:5px;\">|</text>";
			echo "<a href=\"register.php\">注册</a>";
			echo "</div>";
		}
		?>
	</div>
	<div class="body">
		<p style="color: transparent">123</p>
		<h2 align="center" style="color: rgba(255,0,4,0.8);">Welcome to the xscj system!</h2>
		<div style="width: 100%; min-height: 450px; display: flex; justify-content: center; margin-top: 20px;">
			<div class="manage_option">
				<a href="<? logincheck('student_manage.php'); ?>" target="main"><div class="button">学生管理</div></a>
				<a href="<? logincheck('score_manage.php'); ?>" target="main"><div class="button">成绩管理</div></a>
				<a href="<? logincheck('kc_manage.php'); ?>" target="main"><div class="button">课程管理</div></a>
				<a href="<? logincheck('operator_manage.php'); ?>" target="main"><div class="button">操作记录</div></a>
			</div>
			<div class="operator_page">
				<iframe name="main" frameborder="0" width="100%" height="100%" scrolling="no"></iframe>
			</div>
		</div>
	</div>
	<div class="footer">
		<div style="width: 600px; margin-left: 10px;">
			<div class="information">系别：计算机科学与工程学院</div>
			<div class="information">班级：19级软件工程2班</div>
			<div class="information">学号：1914080902271</div>
			<div class="information">姓名：赵煜潘</div>
			<div class="information">邮箱：2332998427@qq.com</div>
			<div class="information">电话号码：15017843132</div>
		</div>
		<div class="avator">
			<img src="./img/avator.jpg" alt="作者本人">
		</div>
	</div>
</body>
</html>