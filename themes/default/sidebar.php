<div class="sidebar">
<h5>日志归档</h5>
<ul>
<?php $this->plugin->trigger('Widget::Posts::Archive','<li><a href="{permalink}">{title} [{count}]</a></li>','month','Y年m月');?>
</ul>
</div><!--end fo sidebar-->
