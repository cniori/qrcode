<?php
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    header("Location: search.php");
    exit();
}

if(isset($_POST['submit'])){
    $password = $_POST['password'];
    if($password == "yourpassword"){
        $_SESSION['logged_in'] = true;
        header("Location: search.php");
        exit();
    }else{
        $message = "密码错误！";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./src/style.css">
	<title>检测报告查询</title>
</head>
<body>
	<form class="smart-green" method="post" action="">
		<label>请输入访问密码：</label>
		<input type="password" name="password"><br><br>
		<input type="submit" name="submit" class="button" value="登录">
	</form>
	<?php if(isset($message)) { ?>
		<p><?php echo $message; ?></p>
	<?php } ?>
</body>
</html>
