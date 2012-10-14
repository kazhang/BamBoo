<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	Plugin Name: 最近文章评论Widget
 *	Plugin URI: http://www.zkgo.info/
 *	Description: 显示最近文章评论列表
 *	Version: 0.1
 *	Author: ZAKIR 
 *	Author Email: zakir.exe@gmail.com
*/
class Recent_comments
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
		$plugin->register('Widget::Comments::Recent_comments',$this,'show');
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

		$comments=$this->_CI->comment_mdl->getComments(NULL,1,'comment_ID,title,type,slug,author,author_url','posts','comments.created desc',NULL,5);

		foreach($comments as $comment)
		{
			$permalink=site_url($comment['type'].'/'.$comment['slug'].'#comment-'.$comment['comment_ID']);
			$wildcards=array(
				'{userLink}',
				'{user}',
				'{postLink}',
				'{title}'
			);
			$replaces=array(
				$comment['author_url'],
				$comment['author'],
				$permalink,
				$comment['title']
			);
			echo str_replace($wildcards,$replaces,$format)."\r\n";
		}
	}
}
/* End of file Recent_comments.php */
/* Location: ./plugins/recent_comments/Recent_comments.php */
?>
