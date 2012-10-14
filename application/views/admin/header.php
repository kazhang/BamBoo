<!DOCTYPE html>
<html lang="zh">
<head>
	<title><?=$pageTitle?> | <?=settingItem('blog_title')?></title>
	<link href="<?=base_url('application/views/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	<link href="<?=base_url('application/views/style.css')?>" rel="stylesheet">
	<script type="text/javascript" src="<?=base_url('application/views/jquery.min.js')?>"></script>
	<script src="<?=base_url('application/views/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
	<script type="text/javascript" src="<?=base_url('application/views/common.js')?>"></script>
	<link rel="stylesheet" href="<?=base_url('application/third_party/ueditor/themes/default/ueditor.css')?>">
	<meta charset="utf-8"/>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="brand" href="<?=site_url('admin/home')?>">BamBoo</a>
			<ul class="nav">
				<li <?=($cur == 'posts' ? 'class="active"':'')?>><?=anchor('#','文章<b class="caret"></b>','class="dropdown-toggle" data-toggle="dropdown"')?>
					<ul class="dropdown-menu" role="menu">
						<li><?=anchor('admin/posts','所有文章')?></li>
						<li><?=anchor('admin/posts/write','写文章')?></li>
						<li><?=anchor('admin/posts/categories','分类目录')?></li>
						<li><?=anchor('admin/posts/tags','标签')?></li>
					</ul>
				</li>
				<li <?=($cur == 'pages' ? 'class="active"':'')?>><?=anchor('admin/pages','页面')?></li>
				<li <?=($cur == 'comments' ? 'class="active"':'')?>><?=anchor('admin/comments','评论')?></li>
				<li <?=($cur == 'plugins' ? 'class="active"':'')?>><?=anchor('admin/plugins','插件')?></li>
				<li <?=($cur == 'users' ? 'class="active"':'')?>><?=anchor('admin/users','用户')?></li>
				<li <?=($cur == 'settings' ? 'class="active"':'')?>><?=anchor('admin/settings','设置')?></li>
			</ul>
				<div class="logout"><?=anchor('admin/login/logout','<i class="icon-white icon-off"></i>退出登录')?></div>
		</div>
	</div>
</div>
<div class="container-fluid main">
	<div class="row-fluid" style="position:relative;">
		<div class="span2 sidebar">
<?php $this->load->view('admin/sidebar');?>
		</div>
		<div class="sidebar-bg"></div>
		<div class="span10">

