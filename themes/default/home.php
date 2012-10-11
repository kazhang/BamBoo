<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header');
?>
	<div id="main">
<?php foreach($posts as $post):?>
		<div class="article">
			<div class="article-title">
				<?=anchor('post/'.$post['slug'],$post['title'])?>
			</div>
			<div class="article-meta">
				发布于：<?=date('Y年m月d日',$post['created'])?> 分类目录：<?=Common::implodeMetas($post['categories'],'category')?>
			</div>
			<div class="article-content">
				<?=$post['content']?>
			</div>
			<div class="article-tags">
				内容：<?=Common::implodeMetas($post['tags'],'tag')?>
			</div>
		</div>
<?php endforeach;?>
<?php $this->load->view('sidebar');?>
	</div><!--end of main-->
<?php $this->load->view('footer');?>
