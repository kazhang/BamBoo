<?php $this->load->view('admin/header');?>
		<h3>基本设置</h3>
		<form action="" method="post">
		<table>
			<tr><td>网站标题：</td><td><input type="text" name="blog_title" value="<?=$setting['blog_title']?>"/></td></tr>
			<tr><td>网站副标题：</td><td><input type="text" name="blog_slogan" class="input-xlarge" value="<?=$setting['blog_slogan']?>"/></td></tr>
			<tr><td>网站关键词：</td><td><input type="text" name="blog_keywords" class="input-xlarge" value="<?=$setting['blog_keywords']?>"/></td></tr>
			<tr><td>网站描述：</td><td><textarea name="blog_description"/><?=$setting['blog_description']?></textarea></td></tr>
			<tr><td>&nbsp;</td><td><input type="submit" value="更改设置"/></td></tr>
		</table>
		</form>
<?php $this->load->view('admin/footer');?>
