<!DOCTYPE html>
<html lang="zh">
<head>
	<title><?=$pageTitle?> | <?=settingItem('blog_title')?></title>
	<meta charset="utf-8">
	<meta type="Keywords" content="<?=$pageKeywords?>">
	<meta type="Description" content="<?=$pageDescription?>">
	<meta type="generator" content="BamBoo blog">
	<link href="<?=base_url('application/views/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url('themes/default/function.js')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('themes/default/style.css')?>">
</head>
<body>
<div class="container">
	<div class="header">
		<h1><?=settingItem('blog_title')?></h1>
		<h5><?=settingItem('blog_slogan')?></h5>
		<div class="navbar">
			<div class="navbar-inner">
				<ul class="nav">
					<?php $this->plugin->trigger('Widget::Navigation','<li {class}><a href="{permalink}">{title}</a></li>',$curPage);?>
				</ul>
				<form class="form-search navbar-search pull-right" action="<?=site_url('search/')?>" method="get">
					<div class="input-append">
						<input type="text" class="search-query span1" id="keyword" name="q" placeholder="搜索"/>
						<button type="submit" class="btn"><i class="icon-search"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span9">
