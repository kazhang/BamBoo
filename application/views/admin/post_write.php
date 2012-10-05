<?php $this->load->view('admin/header');?>
	<div id="main">
	<?php if(isset($post)):?>
		<h3>编辑文章：<?=$post->title?></h3>
	<?php else:?>
		<h3>新文章</h3>
	<?php endif;?>

		<form action="" method="post">
			<div><input type="text" name="title" value="<?=(isset($post)?$post->title:'')?>"/></div>
			<div>固定链接：http://www.yourdomain.com/posts/<input type="text" name="slug" value="<?=(isset($post)?$post->slug:'')?>"/></div>
			<div><textarea name="content"><?=(isset($post)?$post->content:'')?></textarea></div>
			<div><label for="tags">标签：</label><input type="text" name="tags" value="<?=(isset($post)?$post->tags:'')?>"/></div>
			<div><label for="created">发布日期：</label><input type="text" name="created" value="<?=(isset($post)?$post->created:'')?>"/></div>
			<div><label for="category">分类：</label><select name="category"/><option value="1">1</option><br /><option value="2">2</option></select></div>
			<div><input type="checkbox" name="allowComment" <?php if(isset($post) && $post->allow_chomment==1) echo 'checked';?>/>允许评论</div>
			<div><input type="checkbox" name="allowFeed" <?php if(isset($post) && $post->allow_feed==1) echo 'checked';?>/>允许Feed</div>
			<div><input type="submit" value="保存草稿"/><input type="submit" name="publish" value="发布"/></div>
		</form>
	</div><!--end of main-->
<?php $this->load->view('admin/footer');?>
