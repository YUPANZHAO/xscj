<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
		<title>注册页面</title>
		<link rel="stylesheet" type="text/css" href="frame.css">
		<link rel="stylesheet" type="text/css" href="login_form.css">
    </head>
    <body>
		<div class="header">
			<h2 class="head_title">学生成绩管理系统</h2>
		</div>
		<div class="body" style="display: flex; justify-content: center; align-items: center;">
			<form action="register_check.php" method="post" class="form">
				<div class="loginbox">
					<h2 class="login_title" style="text-align: center;">注册</h2>
					<div class="item">
						<input name="username" id="username" type="text" required>
						<label for="username">用户名</label>
					</div>
					<div class="item">
						<input name="password" id="password" type="password" required>
						<label for="password">密码</label>
					</div>
					<div class="item">
						<input name="repassword" id="repassword" type="password" required>
						<label for="repassword">重复密码</label>
					</div>
					<button type="submit" class="btn" name="submit">
						注册
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</button>
					<a href="login.php" class="regbtn">去登录</a>
				</div>
			</form>
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