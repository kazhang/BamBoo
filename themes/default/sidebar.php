<div class="sidebar">
<h5>日志归档</h5>
<ul>
<?php $this->plugin->trigger('Widget::Posts::Archive','<li><a href="{permalink}">{title} [{count}]</a></li>','month','Y年m月');?>
</ul>
<ul>
<?php $this->plugin->trigger('Widget::Posts::Recent_posts','<li><a href="{permalink}">{title}</a></li>');?>
</ul>
<ul>
<?php $this->plugin->trigger('Widget::Comments::Recent_comments','<li><a href="{userLink}" rel="external nofollow">{user}</a>评论<a href="{postLink}">{title}</a></li>');?>
</ul>
</div><!--end fo sidebar-->
