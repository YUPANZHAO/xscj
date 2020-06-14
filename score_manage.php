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
<title>成绩管理</title>
	<style>
	*{
		padding: 0px;
		margin: 0px;
	}
	input,select{
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
		<form action="<? logincheck('showdata_score.php') ?>" target="data" method="post" style="float: left; margin: 15px;">
			姓名:<select name="name" style="width: 100px;">
			<option>请选择</option>
			<?php
			include("connect_db.php");
			$result = mysqli_query($conn,"select 姓名 from xs");
			while($row = mysqli_fetch_array($result)){
				echo "<option>".$row['姓名']."</option>";
			}
			?>
			</select><br>
			课程名:<select name="kc" style="width: 100px;">
			<option>请选择</option>
			<?php
			$result = mysqli_query($conn,"select 课程名 from kc");
			while($row = mysqli_fetch_array($result)){
				echo "<option>".$row['课程名']."</option>";
			}
			mysqli_close($conn);
			?>
			</select><br>
			成绩:<input type="number" name="score" style="width:110px;">
			排序:<select name="sorttype"><option>无</option><option>升序</option><option>降序</option></select><br>
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