<?php $this->load->view('admin/header');?>
		<div class="row-fluid">
<?php if(!isset($tag)):?>
			<div class="span8">
				<h3>标签</h3>
				<table class="table table-hover table-condensed">
					<colgroup width="20"></colgroup>
					<colgroup></colgroup>
					<colgroup width="80"></colgroup>
					<colgroup></colgroup>
					<colgroup width="60"></colgroup>
					<thead>
					<tr>
						<th>&nbsp;</th><th>标签名</th><th>别名</th><th>描述</th><th>文章数</th>
					</tr>
					</thead>
					<tbody>
<?php foreach($tags as $item):?>
					<tr class="no-op">
						<td><input type="checkbox" name="choosed[]" value="<?=$item['tag_ID']?>"/></td>
						<td style="text-align:left">
							<?=$item['name']?>
							<div class="op">
								<?=anchor('admin/tags/edit/'.$item['tag_ID'],'编辑')?> | 
								<?=anchor('admin/tags/delete/'.$item['tag_ID'],'删除','class="del"')?> | 
								<?=anchor('tags/'.$item['slug'],'查看')?>
							</div>
						</td>
						<td><?=$item['slug']?></td>
						<td style="text-align:left"><?=$item['description']?></td>
						<td><?=$item['count']?></td>
					</tr>
<?php endforeach;?>
				</tbody>
				</table>
				<script type="text/javascript">

				</script>
			</div>
<?php endif;?>
			<div class="span<?=isset($tag)?6:4?>">
				<h3><?=isset($tag)?'编辑标签':'新标签'?></h3>
				<form action="" method="post">
					<div><label for="name">标签名</label><input type="text" name="name" value="<?=isset($tag)?$tag['name']:''?>" required/></div>
					<div><label for="slug">别名</label><input type="text" name="slug" value="<?=isset($tag)?$tag['slug']:''?>"/>
						<span class="help-block">在URL中显示的别称，它可以使URL更美观。通常使用小写字母，只能包含字母、数字和连字符(-)。</span>
					</div>
					<div><label for="description">描述</label><textarea name="description"><?=isset($tag)?$tag['description']:''?></textarea></div>
					<div><input type="submit" value="<?=isset($tag)?'修改标签':'添加新标签'?>" class="btn btn-primary"/></div>
				</form>
			</div>
		</div>
<?php $this->load->view('admin/footer');?>
