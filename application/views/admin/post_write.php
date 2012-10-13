<?php $this->load->view('admin/header');?>
	<?php if(isset($post)):?>
		<h3>编辑文章：<?=$post['title']?></h3>
	<?php else:?>
		<h3>新文章</h3>
	<?php endif;?>

		<form action="" method="post">
			<div><input type="text" name="title" value="<?=(isset($post)?$post['title']:'')?>"/></div>
			<div>固定链接：http://www.yourdomain.com/posts/<input type="text" name="slug" value="<?=(isset($post)?$post['slug']:'')?>"/></div>
			<div><textarea name="content"><?=(isset($post)?$post['content']:'')?></textarea></div>
			<div><label for="tags">标签：</label><input type="text" name="tags" value="<?=(isset($post)?$post['tags']:'')?>"/></div>
<?php if(isset($post)):?>
			<div><label for="created">发布日期：</label><input type="text" name="created" value="<?=(isset($post)?$post['created']:'')?>"/></div>
<?php endif;?>
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
			<div><input type="checkbox" name="allowComment" <?php if(isset($post) && $post['allow_comment']==1) echo 'checked';?>/>允许评论</div>
			<div><input type="checkbox" name="allowFeed" <?php if(isset($post) && $post['allow_feed']==1) echo 'checked';?>/>允许Feed</div>
			<div><input type="submit" value="保存为草稿"/><input type="submit" name="publish" value="发布"/></div>
		</form>
<?php $this->load->view('admin/footer');?>
