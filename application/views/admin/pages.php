<?php $this->load->view('admin/header');?>
		<h3>页面</h3>
		<?=anchor('admin/pages/write','新页面','class="btn"')?>
		<table class="table table-hover table-condensed">
			<colgroup width="20"></colgroup>
			<colgroup></colgroup>
			<colgroup width="100"></colgroup>
			<colgroup width="60"></colgroup>
			<colgroup width="100"></colgroup>
			<thead>
			<tr>
				<th>&nbsp;</th><th>标题</th><th>作者</th><th>评论数</th><th>日期</th>
			</tr>
			</thead>
			<tbody>
<?php foreach($pages as $page):?>
			<tr class="no-op">
				<td><input type="checkbox" name="choosed[]" value="<?=$page['post_ID']?>"/></td>
				<td style="text-align:left">
				<?=anchor('admin/pages/write/'.$page['post_ID'],$page['title'],'title="编辑"')?><?=($page['status']==0 ? ' -草稿':'')?>
					<div class="op">
					<?=anchor('admin/pages/write/'.$page['post_ID'],'编辑')?> | <?=anchor('admin/pages/dump/'.$page['post_ID'].'/','移至回收站')?> | 
					<?=anchor('page/'.$page['slug'],'查看')?>
					</div>
				</td>
				<td>BamBoo</td>
				<td><?=$page['comment_cnt']?></td>
				<td><?=date('Y-m-d',$page['created'])?></td>
			</tr>
<?php endforeach;?>
		</tbody>
		</table>
<?php $this->load->view('admin/footer');?>
