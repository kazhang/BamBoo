<?php $this->load->view('admin/header');?>
	<div class="main">
		<h3>分类管理</h3>
		<table>
			<tr>
				<th>&nbsp;</th><th>名称</th><th>别名</th><th>描述</th><th>文章数</th>
			</tr>
<?php foreach($categories as $item):?>
<?php if($item['parent_ID'] != 0) continue;?>
			<tr>
				<td><input type="checkbox" name="<?=$item['category_ID']?>"/></td>
				<td><?=$item['name']?></td>
				<td><?=$item['slug']?></td>
				<td><?=$item['description']?></td>
				<td><?=$item['count']?></td>
			</tr>
<?php 
	if(!empty($item['children']))
	{
		foreach($item['children'] as $subItem)
		{
?>
			<tr>
				<td><input type="checkbox" name="<?=$subItem?>"/></td>
				<td>-- <?=$categories[$subItem]['name']?></td>
				<td><?=$categories[$subItem]['slug']?></td>
				<td><?=$categories[$subItem]['description']?></td>
				<td><?=$categories[$subItem]['count']?></td>
			</tr>
<?php
		}
	}
?>
<?php endforeach;?>
		</table>
		<h3>新分类</h3>
		<form action="" method="post">
			<div><label for="name">名称</label><input type="text" name="name"/></div>
			<div><label for="slug">别名</label><input type="text" name="slug"/></div>
			<div><label for="parent_ID">父级</label>
				<select name="parent_ID">
					<option value="0" selected>无</option>
<?php foreach($categories as $item):?>
<?php if($item['parent_ID']!=0) continue;?>
					<option value="<?=$item['category_ID']?>"><?=$item['name']?></option>
<?php endforeach;?>
				</select>
			</div>
			<div><label for="description">描述</label><textarea name="description"></textarea></div>
			<div><input type="submit" value="添加新分类目录"/></div>
		</form>
	</div><!--end of main-->
<?php $this->load->view('admin/footer');?>
