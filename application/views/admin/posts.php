<?php $this->load->view('admin/header');?>
		<h3>文章<?=$mode=='recycle'?'：回收站':'：所有文章'?></h3>
<ul class="nav nav-tabs">
	<li <?=$mode=='normal'?'class="active"':''?>><?=anchor('admin/posts','所有文章')?></li>
	<li <?=$mode=='recycle'?'class="active"':''?>><?=anchor('admin/posts/recycle','回收站')?></li>
</ul>
		<table class="table table-hover table-condensed">
			<colgroup width="20"></colgroup>
			<colgroup></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="60"></colgroup>
			<colgroup width="100"></colgroup>
			<thead>
			<tr>
				<th>&nbsp;</th><th>标题</th><th>作者</th><th>分类目录</th><th>标签</th><th>评论数</th><th>日期</th>
			</tr>
			</thead>
			<tbody>
<?php foreach($posts as $post):?>
			<tr class="no-op">
				<td><input type="checkbox" name="choosed[]" value="<?=$post['post_ID']?>"/></td>
				<td style="text-align:left">
				<?=anchor('admin/posts/write/'.$post['post_ID'],$post['title'],'title="编辑"')?><?=($post['status']==0 ? ' -草稿':'')?>
					<div class="op">
					<?=anchor('admin/posts/write/'.$post['post_ID'],'编辑')?> | 
<?php if($mode=='normal'):?>
					<?=anchor('admin/posts/dump/'.$post['post_ID'].'/'.$post['status'],'移至回收站')?> | 
<?php elseif($mode=='recycle'):?>
					<?=anchor('admin/posts/recover/'.$post['post_ID'],'恢复')?> | 
<?php endif;?>
					<?=anchor('post/'.$post['slug'],'查看')?>
					</div>
				</td>
				<td><?=$post['authorName']?></td>
				<td><?=$post['categories']?></td>
				<td><?=$post['tags']?></td>
				<td><?=$post['comment_cnt']?></td>
				<td><?=date('Y-m-d',$post['created'])?></td>
			</tr>
<?php endforeach;?>
		</tbody>
		</table>
<?php $this->load->view('admin/footer');?>
