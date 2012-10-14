<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header');
?>
	<div id="main">
		<div class="post">
			<h3><strong><?=$post['title']?></strong></h3>

			<h4 class="meta-data">
				<span>发布于：<?=date('Y年m月d日 H:i:s',$post['created'])?></span>
				<span>分类：<?=Common::implodeMetas($post['categories'],'category')?></span>
				<span>评论：<a href="#comments" title="查看评论"><?=$post['comment_cnt']?></a></span>
			</h4>
		
			<div class="content">
				<?php echo $post['content'];?>
			</div>

			<div class="tags">
				标签：<?=Common::implodeMetas($post['tags'],'tag')?>
			</div>
		</div>
		<?php $this->load->view('comment');?>
	</div><!--end of main-->
<?php $this->load->view('footer');?>
