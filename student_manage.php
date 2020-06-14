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
<title>学生管理</title>
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
		<form action="<? logincheck('showdata_student.php') ?>" target="data" method="post" style="float: left; margin: 15px;">
			姓名:<input type="text" name="name"><br>
			性别:<input type="radio" name="sex" value="1">男<input type="radio" name="sex" value="0">女<br>
			出生日期:<input type="date" name="birthday"><br>
			已修课程数:<input type="number" name="kcs"><br>
			备注:<input type="text" name="bz"><br>
			照片:<input type="file" name="photo" id="file" onchange="changepic(this)"><br>
			<img src="" id="show" width="100px" height="120px" style="border: 3px ridge; margin-bottom: 10px; background-color: #E3E3E3;"><br>
			<button type="submit" name="查询">查询</button>
			<button type="submit" name="录入">录入</button>
			<button type="submit" name="删除">删除</button>
			<button type="submit" name="更新">更新</button>
			<button type="reset" name="重置" onClick="resetpic()">重置</button>
			<script>
				function changepic(obj) {
					//console.log(obj.files[0]);//这里可以获取上传文件的name
					var newsrc=getObjectURL(obj.files[0]);
					document.getElementById('show').src=newsrc;
				}
				//建立一個可存取到該file的url
				function getObjectURL(file) {
					var url = null ;
					// 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已
					if (window.createObjectURL!=undefined) { // basic
						url = window.createObjectURL(file) ;
					} else if (window.URL!=undefined) { // mozilla(firefox)
						url = window.URL.createObjectURL(file) ;
					} else if (window.webkitURL!=undefined) { // webkit or chrome
						url = window.webkitURL.createObjectURL(file) ;
					}
					return url ;
				}
				function resetpic(){
					document.getElementById('show').src="";
				}
			</script>
		</form>
	</div>
	<iframe name="data" class="showdate_page" scrolling="auto"></iframe>
</body>
</html>