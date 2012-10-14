<!DOCTYPE html>
<html lang="zh">
<head>
	<title><?=$pageTitle?> | <?=settingItem('blog_title')?></title>
	<link href="<?=base_url('application/views/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	<link href="<?=base_url('application/views/style.css')?>" rel="stylesheet">
	<script type="text/javascript" src="<?=base_url('application/views/jquery.min.js')?>"></script>
	<script src="<?=base_url('application/views/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?=base_url('application/views/common.js')?>"></script>
	<meta charset="utf-8"/>
</head>
<body>
	<div class="container login">
		<h3>用户登录</h3>
		<form action="" method="post">
			<div><label for="username">用户名</label><input type="text" name="username" autofocus required /></div>
			<div><label for="password">密码</label><input type="password" name="password" required /></div>
			<div><input type="submit" value="登录" class="btn btn-primary"/></div>
		</form>
	<div><!--end of login-->
</body>
</html>
