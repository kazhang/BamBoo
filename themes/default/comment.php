		<div class="comments" id="comments">
<?php if(isset($commentMsg)):?>
			<div class="alert alert-success"><?=$commentMsg?></div>
<?php endif;?>
			<h4><?=$post['comment_cnt']?> 条评论</h4>
<?php foreach($post['comments'] as $item):?>
			<div class="comment row" id="comment-<?=$item['comment_ID']?>">
				<div class="avatar span1"><?=Common::getGravatar($item['author_email'])?></div>
				<div class="comment-wrap span8">
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
<?php if($post['allow_comment'] == 1):?>
		<div id="respond">
			<legend>添加评论</legend>
			<form action="<?=site_url('comment/'.$post['post_ID'])?>" method="post">
			<span class="reply-op pull-right"><a href="javascript:;" onclick="return comment.moveRespond('comments',0)">取消回复</a></span>
			<label class="reply-op"><input type="checkbox" name="cite"/>同时引用原文</label>
			<p>电子邮件地址不会被公开。</p>
				<div class="input-prepend">
				<span class="add-on">@</span><input type="text" name="author" placeholder="称呼（必填）" required value="<?=$cmtAuthor?$cmtAuthor:''?>"/>
				</div>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-envelope"></i></span><input type="email" name="email" placeholder="电子邮件（必填）" required  value="<?=$cmtAuthorEmail?$cmtAuthorEmail:''?>"/>
				</div>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-home"></i></span><input type="url" name="url" placeholder="您的网站"  value="<?=$cmtAuthorUrl?$cmtAuthorUrl:''?>"/>
				</div>
				<textarea name="content" placeholder="您的评论..." class="span5" rows="5"></textarea>
				<input type="hidden" name="postSlug" value="<?=$post['slug']?>"/><input type="hidden" name="replyTo" value="0" id="replyTo"/>
				<div><input type="submit" class="btn btn-primary" value="发表评论"/></div>
			</form>
		</div>
<?php endif;?>
