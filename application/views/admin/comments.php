<?php $this->load->view('admin/header');?>
	<h3>评论</h3>
	<table>
		<tr><th>&nbsp;</th><th>作者</th><th>评论</th><th>回应给</th></tr>
<?php foreach($comments as $item):?>
		<tr>
			<td><input type="checkbox" name="choosed[]" value="<?=$item['comment_ID']?>"/></td>
			<td><?=$item['author']?><br /><?=$item['author_email']?><br /><?=$item['author_IP']?></td>
			<td>
				<?=$item['content']?><br />
<?php 
if($item['approved']==0) 
{
	echo anchor('admin/comments/approve/'.$item['comment_ID'].'/'.$item['post_ID'].'/1','批准');
	echo ' | ';
	echo anchor('admin/comments/delete/'.$item['comment_ID'].'/'.$item['post_ID'],'删除');
}
else
{
	echo anchor('admin/comments/approve/'.$item['comment_ID'].'/'.$item['post_ID'].'/0','驳回');
	echo ' | ';
	echo anchor('admin/comments/delete/'.$item['comment_ID'].'/'.$item['post_ID'].'/1','删除');
}
?> 
			</td>
			<td><?=anchor('post/'.$item['slug'],$item['title'])?></td>
		</tr>
<?php endforeach;?>
	</table>
<?php $this->load->view('admin/footer');?>
