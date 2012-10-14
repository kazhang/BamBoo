<?php $this->load->view('admin/header');?>
	<h3>评论</h3>
<?php if(!empty($pagination)):?>
	<div class="pagination"><?=$pagination?></div>
<?php endif;?>
	<table class="table table-hover table-condensed">
		<colgroup width="20"></colgroup>
		<colgroup width="80"></colgroup>
		<colgroup></colgroup>
		<colgroup width="100"></colgroup>
		<thead>
		<tr><th>&nbsp;</th><th>作者</th><th>评论</th><th>回应给</th></tr>
		</thead>
		<tbody>
<?php foreach($comments as $item):?>
<tr class="no-op" <?=$item['approved']==0?'style="background-color:whiteSmoke"':''?>>
			<td><input type="checkbox" name="choosed[]" value="<?=$item['comment_ID']?>"/></td>
			<td style="text-align:left"><?=$item['author']?><br /><?=$item['author_email']?><br /><?=$item['author_IP']?></td>
			<td style="text-align:left">
				<?=$item['content']?>
				<div class="op">
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
				</div>
			</td>
			<td><?=anchor('post/'.$item['slug'].'/#comment-'.$item['comment_ID'],$item['title'])?></td>
		</tr>
<?php endforeach;?>
	</tbody>
	</table>
<?php if(!empty($pagination)):?>
	<div class="pagination"><?=$pagination?></div>
<?php endif;?>
<?php $this->load->view('admin/footer');?>
