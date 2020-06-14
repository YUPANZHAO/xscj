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
<title>操作记录</title>
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
		<form action="<? logincheck('showdata_operator.php') ?>" target="data" method="post" style="float: left; margin: 15px;">
			用户名:<select name="username" style="width: 100px;">
			<option>请选择</option>
			<?php
			include("connect_db.php");
			$result = mysqli_query($conn,"select username from user");
			while($row = mysqli_fetch_array($result)){
				echo "<option>".$row['username']."</option>";
			}
			mysqli_close($conn);
			?>
			</select><br>
			时间:<input type="datetime" name="time" style="width:110px;">
			排序:<select name="sorttype"><option>无</option><option>升序</option><option>降序</option></select><br>
			操作类型:<select name="opertype">
			<option>无</option>
			<option>查询</option>
			<option>录入</option>
			<option>删除</option>
			<option>更新</option>
			</select><br>
			<button type="submit" name="查询">查询</button>
			<button type="reset" name="重置">重置</button>
		</form>
	</div>
	<iframe name="data" class="showdate_page" scrolling="auto"></iframe>
</body>
</html>