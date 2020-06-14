<?php
	session_start();
	function logincheck($to){
		if(isset($_SESSION['username'])) echo "$to";
		else echo "loginwarning.php";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>课程管理</title>
	<style>
	*{
		padding: 0px;
		margin: 0px;
	}
	input{
		margin-bottom: 15px;
		margin-left: 5px;
	}
	button{
		margin-bottom: 15px;
	}
	body{
		width: 1200px;
		display: flex;
		justify-content: center;
	}
	.operator_page{
		box-sizing: border-box;
		padding: 5px;
		border: 2px solid rgba(255,255,255,0.6);
		border-radius: 10px;
		width: 300px;
		min-height: 450px;
		background: rgba(255,255,255,0.6);
	}
	.showdate_page{
		box-sizing: border-box;
		padding: 5px;
		margin-left: 10px;
		border: 2px solid rgba(255,255,255,0.6);
		border-radius: 10px;
		width: 900px;
		min-height: 450px;
		background: rgba(255,255,255,0.6);
	}
</style>
</head>
<body>
	<div class="operator_page">
		<form action="<? logincheck('showdata_kc.php') ?>" target="data" method="post" style="float: left; margin: 15px;">
			课程名:<input type="text" name="kcm"><br>
			学时:<input type="number" name="xs"><br>
			学分:<input type="number" name="xf"><br>
			<button type="submit" name="查询">查询</button>
			<button type="submit" name="录入">录入</button>
			<button type="submit" name="删除">删除</button>
			<button type="submit" name="更新">更新</button>
			<button type="reset" name="重置">重置</button>
		</form>
	</div>
	<iframe name="data" class="showdate_page" scrolling="auto"></iframe>
</body>
</html>