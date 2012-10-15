<div class="sidebar">
<h5>分类</h5>
<?php $this->plugin->trigger('Widget::Posts::Category','<li><a href="{permalink}">{title}</a></li>');?>
<h5>标签</h5>
<div>
<?php $this->plugin->trigger('Widget::Posts::Tag','<span><a href="{permalink}">{title}({count})</a></span>');?>
</div>
<ul>
<h5>日志归档</h5>
<?php $this->plugin->trigger('Widget::Posts::Archive','<li><a href="{permalink}">{title} [{count}]</a></li>','month','Y年m月');?>
</ul>
<h5>最近发表</h5>
<ul>
<?php $this->plugin->trigger('Widget::Posts::Recent_posts','<li><a href="{permalink}">{title}</a></li>');?>
</ul>
<h5>最近评论</h5>
<ul>
<?php $this->plugin->trigger('Widget::Comments::Recent_comments','<li><a href="{userLink}" rel="external nofollow">{user}</a>评论<a href="{postLink}">{title}</a></li>');?>
</ul>
</div><!--end fo sidebar-->
