<?php $this->load->view('admin/header');?>
	<div class="main">
<?php $this->load->view('admin/sidebar');?>
	<h3>用户</h3>
	<table>
		<tr><th>&nbsp;</th><th>用户名</th><th>姓名</th><th>电子邮件</th><th>角色</th><th>文章</th></tr>
<?php foreach($users as $item):?>
		<tr>
			<td><input type="checkbox" name="choosed[]" value="<?=$item['user_ID']?>"/></td>
			<td><?=$item['username']?></td>
			<td><?=$item['nickname']?></td>
			<td><?=$item['email']?></td>
			<td><?=$item['group']?></td>
			<td>NULL</td>
		</tr>
<?php endforeach;?>
	</table>
	</div><!--end of main-->
<?php $this->load->view('admin/footer');?>
