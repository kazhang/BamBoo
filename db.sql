-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 10 月 20 日 13:25
-- 服务器版本: 5.5.24-0ubuntu0.12.04.1
-- PHP 版本: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `bamboo`
--

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(100) NOT NULL COMMENT '分类名',
  `slug` varchar(100) DEFAULT NULL COMMENT '别名',
  `description` varchar(200) DEFAULT NULL COMMENT '分类描述',
  `count` int(11) DEFAULT '0' COMMENT '分类文章数',
  `parent_ID` int(10) unsigned DEFAULT '0' COMMENT '父分类ID',
  PRIMARY KEY (`category_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`category_ID`, `name`, `slug`, `description`, `count`, `parent_ID`) VALUES
(1, '未分类', 'uncategrized', '未分类文章', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `post_ID` int(10) unsigned NOT NULL COMMENT '评论文章ID',
  `author` varchar(100) NOT NULL COMMENT '评论人名字',
  `author_email` varchar(100) NOT NULL COMMENT '评论人email',
  `author_url` varchar(100) DEFAULT NULL COMMENT '评论人网址',
  `author_IP` varchar(100) NOT NULL COMMENT '评论人IP',
  `created` int(11) NOT NULL COMMENT '评论时间',
  `content` text NOT NULL COMMENT '评论内容',
  `approved` tinyint(4) NOT NULL COMMENT '审核',
  `agent` varchar(255) NOT NULL COMMENT '评论人信息',
  `parent_ID` int(10) unsigned DEFAULT NULL COMMENT '上级评论',
  PRIMARY KEY (`comment_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `comments`
--

INSERT INTO `comments` (`comment_ID`, `post_ID`, `author`, `author_email`, `author_url`, `author_IP`, `created`, `content`, `approved`, `agent`, `parent_ID`) VALUES
(1, 1, 'Zakir', 'zakir.exe@gmail.com', 'http://zkgo.info', '127.0.0.1', 1350393533, '欢迎使用BamBoo Blog.', 1, 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', 0);

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `slug` varchar(200) DEFAULT NULL COMMENT '缩略名',
  `created` int(11) DEFAULT NULL COMMENT '创建时间戳',
  `modified` int(11) DEFAULT NULL COMMENT '修改时间戳',
  `content` text COMMENT '内容',
  `author_ID` int(11) DEFAULT NULL COMMENT '作者ID',
  `type` varchar(16) DEFAULT 'post' COMMENT '类型',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `comment_cnt` int(11) DEFAULT NULL COMMENT '评论数',
  `allow_comment` tinyint(4) DEFAULT NULL COMMENT '允许评论',
  `allow_feed` tinyint(4) DEFAULT NULL COMMENT '允许Feed',
  PRIMARY KEY (`post_ID`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`post_ID`, `title`, `slug`, `created`, `modified`, `content`, `author_ID`, `type`, `status`, `comment_cnt`, `allow_comment`, `allow_feed`) VALUES
(1, '你好，世界！', 'hello-world', 1350393269, 1350394355, '<h1>欢迎使用BamBoo Blog!</h1><p style="text-indent:0em;">这是一篇由系统自动生成的文章，您可以在后台自由地对其编辑或删除。<br /></p><p style="text-indent:0em;">BamBoo Blog是一个简洁<span style="color:#333333;font-family:&#39;helvetica neue&#39;, helvetica, arial, sans-serif;font-size:14px;line-height:20px;background-color:#ffffff;">(lòu)</span>的基于<a href="http://codeigniter.com/" target="_self" title="CodeIgniter">CodeIgniter </a>2.1.2开发的博客系统，开发过程中借鉴（<span style="text-decoration:line-through;">照抄</span>）了Wordpress和STBlog的设计，它适合于以下用户：</p><ul style="list-style-type:disc;"><li><p>追求简单自由的撰写环境。</p></li><li><p>喜欢研究PHP代码的初级玩家。</p></li><li><p style="text-indent:0em;">自虐倾向。</p></li></ul><p style="text-indent:0em;"><!--more-->其他用户请点此下载<a href="http://wordpress.org/download/" target="_self" title="Wordpress">Wordpress</a>，不用谢。<br /></p><p><code>--EOF--</code></p>', 1, 'post', 1, 1, 1, 1),
(2, '测试页面', 'test-page', 1350394824, 1350394824, '<p>这是由系统自动生成的测试页面，您可以在后台对其自由地编辑或删除。</p><p>页面为您提供了自由的发挥空间，许多用户拿页面来做个人信息介绍，您或许想试试。</p>', 1, 'page', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `post_category`
--

CREATE TABLE IF NOT EXISTS `post_category` (
  `post_ID` int(10) unsigned NOT NULL,
  `category_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_ID`,`category_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `post_category`
--

INSERT INTO `post_category` (`post_ID`, `category_ID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `post_tag`
--

CREATE TABLE IF NOT EXISTS `post_tag` (
  `post_ID` int(10) unsigned NOT NULL,
  `tag_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_ID`,`tag_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`setting_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `settings`
--

INSERT INTO `settings` (`setting_ID`, `name`, `value`) VALUES
(1, 'blog_title', 'BamBoo Blog'),
(2, 'blog_slogan', 'A simple blog based on CodeIgniter'),
(3, 'blog_description', 'BamBoo Blog,a simple blog based on CodeIgniter.'),
(4, 'current_theme', 'default'),
(5, 'blog_keywords', 'BamBoo blog,MVC,PHP,CodeIgniter'),
(6, 'active_plugins', 'a:6:{i:0;a:8:{s:9:"directory";s:12:"recent_posts";s:4:"name";s:24:"最近文章列表Widget";s:10:"plugin_uri";s:21:"http://www.zkgo.info/";s:11:"description";s:24:"显示最近文章列表";s:6:"author";s:5:"ZAKIR";s:12:"author_email";s:19:"zakir.exe@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:1;a:8:{s:9:"directory";s:8:"category";s:4:"name";s:24:"文章分类目录Widget";s:10:"plugin_uri";s:21:"http://www.zkgo.info/";s:11:"description";s:33:"显示网站所有的分类目录";s:6:"author";s:5:"ZAKIR";s:12:"author_email";s:19:"zakir.exe@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:2;a:8:{s:9:"directory";s:3:"tag";s:4:"name";s:18:"文章标签Widget";s:10:"plugin_uri";s:21:"http://www.zkgo.info/";s:11:"description";s:54:"显示网站所有的标签以及标签中的文章数";s:6:"author";s:5:"ZAKIR";s:12:"author_email";s:19:"zakir.exe@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:3;a:8:{s:9:"directory";s:7:"archive";s:4:"name";s:24:"日志归档列表Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:30:"显示日志按月归档列表";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:4;a:8:{s:9:"directory";s:15:"recent_comments";s:4:"name";s:24:"最近文章评论Widget";s:10:"plugin_uri";s:21:"http://www.zkgo.info/";s:11:"description";s:30:"显示最近文章评论列表";s:6:"author";s:5:"ZAKIR";s:12:"author_email";s:19:"zakir.exe@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:5;a:8:{s:9:"directory";s:10:"navigation";s:4:"name";s:21:"网站导航栏Widget";s:10:"plugin_uri";s:21:"http://www.zkgo.info/";s:11:"description";s:50:"显示网站导航栏(包含首页和用户页面)";s:6:"author";s:5:"ZAKIR";s:12:"author_email";s:19:"zakir.exe@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}}'),
(7, 'smtp_host', ''),
(8, 'smtp_user', ''),
(9, 'smtp_pass', '');

-- --------------------------------------------------------

--
-- 表的结构 `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '标签编号',
  `name` varchar(100) NOT NULL COMMENT '标签名',
  `slug` varchar(100) DEFAULT NULL COMMENT '别名',
  `description` varchar(200) DEFAULT NULL COMMENT '标签描述',
  `count` int(11) DEFAULT '0' COMMENT '标签文章数',
  PRIMARY KEY (`tag_ID`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `nickname` varchar(100) NOT NULL COMMENT '昵称',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `registered` int(10) unsigned NOT NULL COMMENT '注册时间',
  `group` varchar(20) NOT NULL COMMENT '用户组',
  `email` varchar(100) DEFAULT NULL COMMENT 'email',
  `token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_ID`, `username`, `nickname`, `password`, `registered`, `group`, `email`, `token`) VALUES
(1, 'admin', 'BamBoo', '1b0842030e209f42fbd55ac41745b423', 1349789735, 'administrator', 'admin@bamboo.com', NULL),
(2, 'tmp', 'tmp_user', '1f78e57cd713733f51bcf7cb81e4b0ec', 1350203878, 'editor', 'tmp_user@tmp.com', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
