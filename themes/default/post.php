<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
	<div id="main">
		<div class="post">
			<h3><strong><?php echo 'page title';?></strong></h3>

			<h4 class="meta-data">
				<span>发布于；</span>
				<span>分类：</span>
				<span>作者：</span>
			</h4>
		
			<div class="content">
				<?php echo $post;?>
			</div>

			<div class="related">
				<h4><strong>相关日志：</strong></h4>
					<ul>
					</ul>
			</div>
			
			<div class="tags">
			</div>
		</div>
		
		<div class="comments">
		</div>
	</div><!--end of main-->
