<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header');
?>
<?php if(isset($curTitle)):?>
	<h1 class="cur-title"><?=$curTitle?></h1>
<?php endif;?>
<?php foreach($posts as $post):?>
		<div class="entry">
			<div class="row">
				<div class="time span1">
					<time datetime="<?=date('Y-m-d')?>" pubdate></time>
					<div class="day"><?=date('j',$post['created'])?></div>
					<?=date('Y-m',$post['created'])?>
				</div>
				<div class="span8" style="margin-left:10px">
					<div class="entry-title">
						<?=anchor($post['permalink'],$post['title'],'title="链接到'.$post['title'].'"')?>
					</div>
					<div class="entry-meta">
						<i class="icon-folder-open"></i>分类：<?=Common::implodeMetas($post['categories'],'category')?> | <i class="icon-comment"></i>评论：<?=$post['comment_cnt']?>
					</div>
				</div>
			</div>
			<div class="entry-content">
				<?=$post['excerpt']?>
			</div>
			<div class="entry-tags">
				<i class="icon-tags"></i>标签：<?=Common::implodeMetas($post['tags'],'tag')?>
			</div>
<?php if($post['more']):?>
			<?=anchor($post['permalink'],'继续阅读','class="btn btn-info btn-more"')?>
<?php endif;?>
		</div>
<?php endforeach;?>
<?php if(isset($pagination) && !empty($pagination)):?>
	<div class="pagination"><?=$pagination?></div>
<?php endif;?>
<?php $this->load->view('footer');?>
