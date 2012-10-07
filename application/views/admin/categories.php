<?php $this->load->view('admin/header');?>
	<div class="main">
<?php if(!isset($category)):?>
<?php $this->load->view('admin/sidebar');?>
		<h3>分类管理</h3>
		<table>
			<tr>
				<th>&nbsp;</th><th>名称</th><th>别名</th><th>描述</th><th>文章数</th>
			</tr>
<?php foreach($categories as $item):?>
<?php if($item['parent_ID'] != 0) continue;?>
			<tr>
				<td><input type="checkbox" name="choosed[]" value="<?=$item['category_ID']?>"/></td>
				<td>
					<?=anchor('admin/categories/edit/'.$item['category_ID'],$item['name'],'title="编辑"')?><br />
					<?=anchor('admin/categories/edit/'.$item['category_ID'],'编辑')?> | 
					<?=anchor('admin/categories/delete/'.$item['category_ID'],'删除','onclick="return confirm(\'确定要删除\')"')?> | 
					<?=anchor('category/'.$item['slug'],'查看')?>
				</td>
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
				<td><input type="checkbox" name="choosed[]" value="<?=$subItem?>"/></td>
				<td>
					<?=anchor('admin/categories/edit/'.$subItem,'--'.$categories[$subItem]['name'],'title="编辑"')?><br />
					<?=anchor('admin/categories/edit/'.$subItem,'编辑')?> | 
					<?=anchor('admin/categories/delete/'.$subItem,'删除')?> | 
					<?=anchor('category/'.$categories[$subItem]['slug'],'查看')?>
				</td>
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
<?php endif;?>
<?php if(isset($category)) echo "<h3>编辑分类</h3>";?>
		<form action="" method="post">
			<div><label for="name">名称</label><input type="text" name="name" value="<?=isset($category)?$category['name']:''?>"/></div>
			<div><label for="slug">别名</label><input type="text" name="slug" value="<?=isset($category)?$category['slug']:''?>"/></div>
			<div><label for="parent_ID">父级</label>
				<select name="parent_ID">
					<option value="0" selected>无</option>
<?php foreach($categories as $item):?>
<?php if($item['parent_ID']!=0) continue;?>
					<option value="<?=$item['category_ID']?>" <?=(isset($category)&&$category['parent_ID']==$item['category_ID'])?'selected':''?>><?=$item['name']?></option>
<?php endforeach;?>
				</select>
			</div>
			<div><label for="description">描述</label><textarea name="description"><?=isset($category)?$category['description']:''?></textarea></div>
			<div><input type="submit" value="<?=isset($category)?'修改分类目录':'添加新分类目录'?>"/></div>
		</form>
	</div><!--end of main-->
<?php $this->load->view('admin/footer');?>
