<?php $this->load->view('admin/header');?>
		<h3>邮件设置</h3>
		<form action="" method="post">
		<table>
			<tr><td align="right">SMTP地址：</td><td><input type="text" name="smtp_host" value="<?=$setting['smtp_host']?>"/></td></tr>
			<tr><td align="right">SMTP用户名：</td><td><input type="text" name="smtp_user" value="<?=$setting['smtp_user']?>"/></td></tr>
			<tr><td align="right">SMTP密码：</td><td><input type="password" name="smtp_pass" value="<?=$setting['smtp_pass']?>"/></td></tr>
			<tr><td>&nbsp;</td><td><input type="submit" value="更改设置"/></td></tr>
		</table>
		</form>
<?php $this->load->view('admin/footer');?>
