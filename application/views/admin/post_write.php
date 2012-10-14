<?php $this->load->view('admin/header');?>
	<?php if(isset($post)):?>
		<h3>编辑<?=$type=='post'?'文章':'页面'?>：<?=$post['title']?></h3>
	<?php else:?>
		<h3>新<?=$type=='post'?'文章':'页面'?></h3>
	<?php endif;?>
		<form action="" method="post">
		<div class="span8">
<?php if(!empty($msg)):?>
			<div class="alert alert-success"><?=$msg?></div>
<?php endif;?>
			<div><input type="text" name="title" value="<?=(isset($post)?$post['title']:'')?>" placeholder="在此键入标题" class="input-xxlarge"/></div>
			<div><span style="display:block;height:30px;line-height:30px;float:left;">固定链接：http://www.yourdomain.com/<?=$type?>s/</span><input type="text" name="slug" value="<?=(isset($post)?$post['slug']:'')?>"/></div>
			<script type="text/plain" id="myEditor" name="content"><?=(isset($post)?$post['content']:'')?></script>
			<br />
		</div>
		<div class="span4">
<?php if(isset($post)):?>
			<div><label for="created">发布日期：</label><input type="text" name="created" value="<?=(isset($post)?$post['created']:'')?>"/></div>
<?php endif;?>
<?php if($type == 'post'):?>
			<div><label for="tags">标签：</label><input type="text" name="tags" value="<?=(isset($post)?$post['tags']:'')?>"/></div>
			<div><label for="category">分类：</label>
<?php foreach($categories as $item):?>
<?php if($item['parent_ID'] != 0)continue;?>
					<input type="checkbox" name="categories[]" value="<?=$item['category_ID']?>" <?=((isset($post) && in_array($item['category_ID'],$post['categories']))?'checked':'')?>/><?=$item['name']?><br />
<?php 
	if(!empty($item['children']))
	{
		foreach($item['children'] as $subItem)
		{
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="categories[]" value="',$subItem,'"';
			if(isset($post) && in_array($subItem,$post['categories'])) echo " checked ";
			echo '/>',$categories[$subItem]["name"],'<br />';
		}
	}
?>
<?php endforeach;?>
			</div>
<?php endif;?>
			<br />
			<div><input type="checkbox" name="allowComment" <?php if(isset($post) && $post['allow_comment']==1) echo 'checked';?>/>允许评论</div>
			<div><input type="checkbox" name="allowFeed" <?php if(isset($post) && $post['allow_feed']==1) echo 'checked';?>/>允许Feed</div>
			<br />
			<div><input type="submit" value="保存为草稿" class="btn"/><input type="submit" name="publish" value="发布" class="btn btn-primary" style="margin-left:10px;"/></div>
		</div>
		</form>
<script type="text/javascript" src="<?=base_url('application/third_party/ueditor/editor_config.js')?>"></script>
<script type="text/javascript" src="<?=base_url('application/third_party/ueditor/editor_all.js')?>"></script>
<script type="text/javascript">
var editor = new baidu.editor.ui.Editor();
    editor.render("myEditor");
</script>
<?php $this->load->view('admin/footer');?>
