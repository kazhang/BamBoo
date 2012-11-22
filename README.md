BamBoo Blog
===========
BamBoo Blog是一个简洁(lòu)的基于[CodeIgniter 2.1.2](http://www.codeigniter.com)开发的博客系统，开发过程中借鉴（照抄）了[Wordpress](http://wordpress.org)和[STBlog](code.google.com/p/stblog/)的设计，它适合于以下用户：
* 追求简单自由的撰写环境。
* 喜欢研究PHP代码的初级玩家。
* 自虐倾向。

其他用户请点此下载[Wordpress](http://wordpress.org/download/)，不用谢。

其实只是给自己的[博客](http://blog.wamaker.net)用的。

安装
----
因为本来是写来给自己用的，所以还没写安装程序。

以下是手动安装过程：

1. 下载源代码。
2. 添加数据库bamboo,将db.sql内数据导入数据库。
3. 按照自己的实际情况，修改application/config/database.php里面的username,password,database。
4. 修改application/config/config.php里面的$config['base_url']为bamboo的访问地址。
5. 修改application/third_party/ueditor/editor_config.js里面的URL为ueditor在的对于网站根目录的绝对地址。
6. 访问 http://网站访问地址/index.php/admin。登录管理后台，初始用户名为admin，密码为BamBooBlog。在基本设置中对网站进行设置，在邮件设置中设置接收回复通知的邮箱。
