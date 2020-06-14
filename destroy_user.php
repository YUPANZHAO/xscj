<?php
	//销毁session跳转到login.html
	session_start();
	session_destroy();
	echo "<script>url=\"login.php\";window.location.href=url;</script>";
?>