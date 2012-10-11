<?php $this->load->view('admin/header');?>
	<div class="main">
	<form action="" method="post">
		<div><label for="username">用户名</label><input type="text" name="username" autofocus /></div>
		<div><label for="password">密码</label><input type="password" name="password"/></div>
		<div><input type="submit" value="登录"/></div>
	</form>
	<div><!--end of main-->
<?php $this->load->view('admin/footer');?>
