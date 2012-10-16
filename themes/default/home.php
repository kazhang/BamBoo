<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header');
?>
<?php foreach($posts as $post):?>
		<div class="article">
			<div class="row">
				<div class="time span1">
					<div class="day"><?=date('j',$post['created'])?></div>
					<?=date('Y-m',$post['created'])?>
				</div>
				<div class="span8" style="margin-left:10px">
					<div class="article-title">
						<?=anchor($post['permalink'],$post['title'])?>
					</div>
					<div class="article-meta">
						<i class="icon-folder-open"></i>分类：<?=Common::implodeMetas($post['categories'],'category')?> | <i class="icon-comment"></i>评论：<?=$post['comment_cnt']?>
					</div>
				</div>
			</div>
			<div class="article-content">
				<?=$post['excerpt']?>
			</div>
			<div class="article-tags">
				<i class="icon-tags"></i>标签：<?=Common::implodeMetas($post['tags'],'tag')?>
			</div>
<?php if($post['more']):?>
			<?=anchor($post['permalink'],'继续阅读','class="btn btn-info btn-more"')?>
<?php endif;?>
		</div>
<?php endforeach;?>
<?php $this->load->view('footer');?>
