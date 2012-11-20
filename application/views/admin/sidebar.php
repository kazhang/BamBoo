<ul class="nav nav-list">
	<li <?=($cur == 'home' ? 'class="active"':'')?>><?=anchor('admin/home','<i class="icon-home"></i>管理中心')?></li>
	<li class="nav-header">文章</li>
	<li <?=($cur == 'posts' ? 'class="active"':'')?>><?=anchor('admin/posts','<i class="icon-book"></i>所有文章')?></li>
	<li <?=($cur == 'write' ? 'class="active"':'')?>><?=anchor('admin/posts/write','<i class="icon-edit"></i>写文章')?></li>
	<li <?=($cur == 'categories' ? 'class="active"':'')?>><?=anchor('admin/categories','<i class="icon-folder-open"></i>分类目录')?></li>
	<li <?=($cur == 'tags' ? 'class="active"':'')?>><?=anchor('admin/tags','<i class="icon-tags"></i>标签')?></li>
	<li class="nav-header">页面</li>
	<li <?=($cur == 'pages' ? 'class="active"':'')?>><?=anchor('admin/pages','<i class="icon-file"></i>页面')?></li>
	<li class="nav-header">评论</li>
	<li <?=($cur == 'comments' ? 'class="active"':'')?>><?=anchor('admin/comments','<i class="icon-comment"></i>评论')?></li>
	<li class="nav-header">插件</li>
	<li <?=($cur == 'plugins' ? 'class="active"':'')?>><?=anchor('admin/plugins','<i class="icon-magnet"></i>插件')?></li>
	<li class="nav-header">用户</li>
	<li <?=($cur == 'users' ? 'class="active"':'')?>><?=anchor('admin/users','<i class="icon-user"></i>用户')?></li>
	<li class="nav-header">设置</li>
	<li <?=($cur == 'settings' ? 'class="active"':'')?>><?=anchor('admin/settings','<i class="icon-wrench"></i>基本设置')?></li>
	<li <?=($cur == 'mail_settings' ? 'class="active"':'')?>><?=anchor('admin/settings/email','<i class="icon-envelope"></i>邮件设置')?></li>
</ul>
