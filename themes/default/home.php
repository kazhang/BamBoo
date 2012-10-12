<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header');
?>
	<div id="main">
<?php foreach($posts as $post):?>
		<div class="article">
			<div class="article-title">
				<?=anchor($post['permalink'],$post['title'])?>
			</div>
			<div class="article-meta">
				发布于：<?=$post['published']?> 分类目录：<?=Common::implodeMetas($post['categories'],'category')?>
			</div>
			<div class="article-content">
				<?=$post['excerpt']?>
			</div>
			<div class="article-tags">
				标签：<?=Common::implodeMetas($post['tags'],'tag')?>
			</div>
<?php if($post['more']):?>
			<button>继续阅读</button>
<?php endif;?>
		</div>
<?php endforeach;?>
<?php $this->load->view('sidebar');?>
	</div><!--end of main-->
<?php $this->load->view('footer');?>
