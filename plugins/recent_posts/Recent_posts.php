<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	Plugin Name: 最近文章列表Widget
 *	Plugin URI: http://www.zkgo.info/
 *	Description: 显示最近文章列表
 *	Version: 0.1
 *	Author: ZAKIR 
 *	Author Email: zakir.exe@gmail.com
*/
class Recent_posts
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
		$plugin->register('Widget::Posts::Recent_posts',$this,'show');
		$this->_CI=&get_instance();
	}

	/**
	 * Show recent post list
	 *
	 * @access	public
	 * @param	string	format
	 * @return 	void
	 */
	public function show($format)
	{
		if(empty($format))return;

		$posts=$this->_CI->post_mdl->getPosts('title,slug',1,'created desc',5);
		foreach($posts as $post)	
		{
			$permalink=site_url('post/'.$post['slug']);
			$wildcards=array(
				'{permalink}',
				'{title}',
			);
			$replaces=array(
				$permalink,
				$post['title']
			);
			echo str_replace($wildcards,$replaces,$format)."\r\n";
		}
	}
}
/* End of file Recent_posts.php */
/* Location: ./plugins/recent_posts/Recent_posts.php */
?>
