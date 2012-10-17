<h5 class="title">分类</h5>
<ul class="unstyled">
<?php $this->plugin->trigger('Widget::Posts::Category','<li><a href="{permalink}">{title}</a></li>');?>
</ul>
<h5 class="title">标签</h5>
<div>
<?php $this->plugin->trigger('Widget::Posts::Tag','<span><a href="{permalink}" title="共{count}篇文章">{title}</a></span> ');?>
</div>
<h5 class="title">日志归档</h5>
<ul>
<?php $this->plugin->trigger('Widget::Posts::Archive','<li><a href="{permalink}">{title} [{count}]</a></li>','month','Y年m月');?>
</ul>
<h5 class="title">最近发表</h5>
<ul>
<?php $this->plugin->trigger('Widget::Posts::Recent_posts','<li><a href="{permalink}">{title}</a></li>');?>
</ul>
<h5 class="title">最近评论</h5>
<ul>
<?php $this->plugin->trigger('Widget::Comments::Recent_comments','<li><a href="{userLink}" rel="external nofollow">{user}</a> 发表在 <a href="{postLink}">{title}</a></li>');?>
</ul>
