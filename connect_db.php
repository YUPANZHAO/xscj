<?php
    $conn = mysqli_connect('localhost','root','123456');//链接数据库

    if(!$conn){
        die("connect error: ".mysqli_error($conn));//如果链接失败输出错误
    }
    
	mysqli_select_db($conn, 'xscj');   //选择数据库
	mysqli_set_charset($conn, 'utf8');   //选择字符集
?>