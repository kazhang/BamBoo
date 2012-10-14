<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feed extends CI_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('feedwriter');
		$this->load->model('user_mdl');
	}

	/**
	 * Distribute request
	 *
	 * @access	public
	 * @param	string	key
	 * @param	string	value
	 * @return	void
	 */
	public function index($key = '',$value = '')
	{
		$this->generateFeed();
	}

	/**
	 * Generate new posts feed
	 *
	 * @access	public
	 * @return	void
	 */
	public function generateFeed()
	{
		$posts=$this->post_mdl->getPosts('*',1,10,'created');

		$this->feedwriter->setTitle(settingItem('blog_title'));
		$this->feedwriter->setLink(site_url());
		$this->feedwriter->setDescription(settingItem('blog_description'));
		$this->feedwriter->setChannelElement('language','zh-CN');
		$this->feedwriter->setChannelElement('pugDate',date(DATE_RSS,time()));

		$this->_generate($posts);
	}

	/**
	 * Generate nodes
	 *
	 * @access	private
	 * @param	array	posts
	 * @return	void
	 */
	private function _generate($posts)
	{
		if(count($posts)>0)
		{
			foreach($posts as $post)
			{
				$permalink=site_url('post/'.$post['slug']);
				$description=Common::getExcerpt($post['slug']);
				$author=$this->user_mdl->getAuthorName($post['author_ID']);

				$newItem=$this->feedwriter->createNewItem();
				$newItem->setTitle(htmlspecialchars($post['title']));
				$newItem->setLink($permalink);
				$newItem->setDate($post['created']);
				$newItem->setDescription($description);
				$newItem->addElement('author',$author);
				$newItem->addElement('guid',$permalink,array('isPermaLink'=>'true'));

				$this->feedwriter->addItem($newItem);
			}	
		}
		$this->feedwriter->genarateFeed();
	}
}
/* End of file Feed.php */
/* Location: ./application/controllers/Feed.php */
?>
