<?php $this->load->view('admin/header');?>
				<h3>文章</h3>
				<table>
					<tr>
						<th>&nbsp;</th><th>标题</th><th>作者</th><th>分类目录</th><th>标签</th><th>评论数</th><th>日期</th>
					</tr>
		<?php foreach($posts as $post):?>
					<tr>
						<td><input type="checkbox" name="choosed[]" value="<?=$post['post_ID']?>"/></td>
						<td>
						<?=anchor('admin/posts/write/'.$post['post_ID'],$post['title'])?><?=($post['status']==0 ? ' -草稿':'')?><br />
							<?=anchor('admin/posts/write/'.$post['post_ID'],'编辑')?> | <?=anchor('admin/posts/trash/'.$post['post_ID'].'/'.$post['status'],'移至回收站')?> | 
							<?=anchor('post/'.$post['slug'],'查看')?>
						</td>
						<td>BamBoo</td>
						<td><?=$post['categories']?></td>
						<td><?=$post['tags']?></td>
						<td><?=$post['comment_cnt']?></td>
						<td><?=date('Y-m-d',$post['created'])?></td>
					</tr>
		<?php endforeach;?>
				</table>
<?php $this->load->view('admin/footer');?>
