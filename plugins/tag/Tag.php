<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	Plugin Name: 文章标签Widget
 *	Plugin URI: http://www.zkgo.info/
 *	Description: 显示网站所有的标签以及标签中的文章数
 *	Version: 0.1
 *	Author: ZAKIR 
 *	Author Email: zakir.exe@gmail.com
*/
class Tag 
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
		$plugin->register('Widget::Posts::Tag',$this,'show');
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
		$tags=$this->_CI->tag_mdl->getTags('name,slug,count');
		foreach($tags as $tag)
		{
			$permalink=site_url('tag/'.$tag['slug']);
			$wildcards=array(
				'{permalink}',
				'{title}',
				'{count}'
			);
			$replaces=array(
				$permalink,
				$tag['name'],
				$tag['count']
			);
			echo str_replace($wildcards,$replaces,$format),"\r\n";
		}
	}

}
/* End of file Tags.php */
/* Location: ./plugins/tag/Tags.php */
?>
