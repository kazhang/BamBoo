<html>
<head>
	<title><?=$pageTitle?> | <?=settingItem('blog_title')?></title>
	<meta charset="utf-8">
	<meta type="Keywords" content="<?=settingItem('blog_keywords')?>">
	<meta type="Description" content="<?=$pageDescription?>">
	<meta type="generator" content="BamBoo blog">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url('themes/default/function.js')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url('themes/default/style.css')?>">
	<script type="text/javascript">
		$(document).ready(function(){
			$('#search-btn').click(function(){
				var keyword=$('#keyword').val();
				if(keyword=='')return;
				document.location="<?=site_url()?>/search/?q="+keyword;
			});
		});
	</script>
</head>
<body>
<input type="text" name="keyword" id="keyword"/><button id="search-btn">搜索</button>
