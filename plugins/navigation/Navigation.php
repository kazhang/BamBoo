<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	Plugin Name: 网站导航栏Widget
 *	Plugin URI: http://www.zkgo.info/
 *	Description: 显示网站导航栏(包含首页和用户页面)
 *	Version: 0.1
 *	Author: ZAKIR 
 *	Author Email: zakir.exe@gmail.com
*/
class Navigation 
{
	private $_CI;

	/**
	 * Constructor
	 * 
	 * @access	public
	 * @return	void
	 */
	public function __construct(&$plugin)
	{
		$plugin->register('Widget::Navigation',$this,'show');
		$this->_CI=&get_instance();
	}

	/**
	 * Show site navigation
	 *
	 * @access	public
	 * @param	string	format
	 * @param	string	current page name	
	 * @return 	void
	 */
	public function show($format,$curPage)
	{
		$wildcards=array(
			'{permalink}',
			'{class}',
			'{title}'
		);
		$replaces=array(
			site_url(),
			$curPage=='home'?'class="active"':'',
			'首页'
		);
		echo str_replace($wildcards,$replaces,$format);

		$pages=$this->_CI->post_mdl->getPages('slug,title',1,'created asc');
		foreach($pages as $page)
		{
			$replaces=array(
				site_url('page/'.$page['slug']),
				$curPage==$page['slug']?'class="active"':'',
				$page['title']
			);
			echo str_replace($wildcards,$replaces,$format);
		}
	}
}
