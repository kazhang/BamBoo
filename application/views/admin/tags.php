<?php $this->load->view('admin/header');?>
	<div class="main">
<?php $this->load->view('admin/sidebar');?>
<?php if(!isset($tag)):?>
		<h3>标签</h3>
		<table>
			<tr>
				<th>&nbsp;</th><th>标签名</th><th>别名</th><th>描述</th><th>文章数</th>
			</tr>
<?php foreach($tags as $item):?>
			<tr>
				<td><input type="checkbox" name="choosed[]" value="<?=$item['tag_ID']?>"/></td>
				<td>
					<?=$item['name']?><br />
					<?=anchor('admin/tags/edit/'.$item['tag_ID'],'编辑')?> | 
					<?=anchor('admin/tags/delete/'.$item['tag_ID'],'删除','onclick="return conf()"')?> | 
					<?=anchor('tags/'.$item['slug'],'查看')?>
				</td>
				<td><?=$item['slug']?></td>
				<td><?=$item['description']?></td>
				<td><?=$item['count']?></td>
			</tr>
<?php endforeach;?>
		</table>
		<script type="text/javascript">
			function conf(){return confirm('您将永远删除所选项目。\r\n点击“取消”停止，点击“确定”删除。');}
		</script>
		<h3>新标签</h3>
<?php endif;?>
<?php if(isset($tag)) echo "<h3>编辑标签</h3>";?>
		<form action="" method="post">
			<div><label for="name">标签名</label><input type="text" name="name" value="<?=isset($tag)?$tag['name']:''?>"/></div>
			<div><label for="slug">别名</label><input type="text" name="slug" value="<?=isset($tag)?$tag['slug']:''?>"/>
				<dt>在URL中显示的别称，它可以使URL更美观。通常使用小写字母，只能包含字母、数字和连字符(-)。</dt>
			</div>
			<div><label for="description">描述</label><textarea name="description"><?=isset($tag)?$tag['description']:''?></textarea></div>
			<div><input type="submit" value="<?=isset($tag)?'修改标签':'添加新标签'?>"/></div>
		</form>
	</div><!--end of main-->
<?php $this->load->view('admin/footer');?>
