<?php $this->load->view('admin/header');?>
<?php if($cur=='users'):?>
	<h3>用户</h3>
	<table class="table table-hover table-condensed">
		<thead>
		<tr><th>&nbsp;</th><th>用户名</th><th>姓名</th><th>电子邮件</th><th>角色</th><th>文章</th></tr>
		</thead>
		<tbody>
<?php foreach($users as $item):?>
		<tr class="no-op">
			<td><input type="checkbox" name="choosed[]" value="<?=$item['user_ID']?>"/></td>
			<td><?=$item['username']?><div class="op"><?=anchor('admin/users/edit/'.$item['user_ID'],'编辑')?></div></td>
			<td><?=$item['nickname']?></td>
			<td><?=$item['email']?></td>
			<td><?=$item['group']?></td>
			<td>NULL</td>
		</tr>
<?php endforeach;?>
		</tbody>
	</table>
	<a class="btn" href="<?=site_url('admin/users/edit')?>">添加用户</a>
<?php else:?>
	<h3><?=isset($user)?'编辑用户':'添加用户'?></h3>
	<?php if(!empty($errors)):?>
	<div class="alert alert-block"><?=$errors?></div>
	<?php endif;?>
	<form action="" method="post">
		<label for="username">用户名</label>
		<input type="text" name="username" value="<?=isset($user)?$user['username']:''?>" required/>
		<label for="password">密码</label>
		<input type="password" name="password" required/>
		<label for="passconf">重复密码</label>
		<input type="password" name="passconf" required/>
		<label for="nickname">昵称</label>
		<input type="text" name="nickname" value="<?=isset($user)?$user['nickname']:''?>" required/>
		<label for="email">Email</label>
		<input type="email" name="email" value="<?=isset($user)?$user['email']:''?>" required/>
		<label for="group">用户组</label>
		<select name="group" class="input-small">
			<option value="administrator" <?=(isset($user)&&$user['group']=='administrator')?'selected':''?>>管理员</option>
			<option value="editor" <?=(isset($user)&&$user['group']=='editor')?'selected':''?>>编辑</option>
		</select>
		<br />
		<input type="submit" value="<?=isset($user)?'更改':'添加'?>" class="btn btn-primary"/><?=anchor('admin/users','返回','class="btn" style="margin-left:10px"')?>
	</form>
<?php endif;?>
<?php $this->load->view('admin/footer');?>
