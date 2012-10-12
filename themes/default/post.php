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

<?php if(isset($commentMsg)):?>
		<div class="msg"><?=$commentMsg?></div>
<?php endif;?>

		<div class="comments" id="comments">
<?php foreach($post['comments'] as $item):?>
			<div class="comment" id="comment-<?=$item['comment_ID']?>">
				<div class="avatar"></div>
				<div class="comment-wrap">
					<div class="comment-meta">
						<?=$item['author_url']?"<a href=\"{$item['author_url']}\" rel=\"external nofollow\">{$item['author']}</a>":$item['author']?>
						 在<?=date('Y年m月d日',$item['created'])?>说道：
					</div>
					<div class="comment-content">
						<?=$item['content']?>
					</div>
					<span><a href="javascript:;" onclick="return comment.moveRespond('<?=$item['comment_ID']?>',1)">回复</a></span>
				</div>
			</div>
<?php endforeach;?>
		</div>

		<div id="respond">
			<h3>发表评论</h3>
			<form action="<?=site_url('comment/'.$post['post_ID'])?>" method="post">
			<span class="reply-op"><a href="javascript:;" onclick="return comment.moveRespond('comments',0)">取消回复</a></span>
			<p class="reply-op"><input type="checkbox" name="cite"/>同时引用原文</p>
			<p>电子邮件地址不会被公开。必填项已用*标注</p>
				<div><label for="author">姓名</label><input type="text" name="author" placeholder="称呼" required /><span class="red">*</span></div>
				<div><label for="email">电子邮件</label><input type="text" name="email" placeholder="电子邮件" required /><span class="red">*</span></div>
				<div><label for="url">站点</label><input type="text" name="url" placeholder="网站" /></div>
				<div><label for="content">评论</label><textarea name="content"></textarea></div>
				<div><input type="hidden" name="postSlug" value="<?=$post['slug']?>"/><input type="hidden" name="replyTo" value="0" id="replyTo"/></div>
				<div><input type="submit" value="发表评论"/></div>
			</form>
		</div>
		
	</div><!--end of main-->
<?php $this->load->view('footer');?>
