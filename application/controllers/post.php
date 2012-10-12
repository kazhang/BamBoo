<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post extends MY_Controller
{
	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default page
	 *
	 * @access public
	 * @return void
	 */
	public function index($slug='')
	{
		if($slug=='')
		{
			redirect(site_url());
		}

		$post=$this->post_mdl->getPostBySlug($slug);

		if($post == FALSE)
		{
			show_404();
		}

		$post['tags']=$this->tag_mdl->getTagsByPostID($post['post_ID']);
		$post['categories']=$this->category_mdl->getCategoriesByPostID($post['post_ID']);
		$post['comments']=$this->comment_mdl->getComments($post['post_ID'],1);

		$comments=array('This is a comment');

		$data['pageTitle']=$post['title'];
		$data['pageDescription']=Common::getExcerpt($post['content']);
		$data['pageKeywords']='page keywords';
		$data['parsedFeed']='parsed feed';
		$data['post']=$post;

		$data['commentMsg']=$this->session->flashdata('commentMsg');
		if($data['commentMsg'] == FALSE)
		{
			unset($data['commentMsg']);
		}

		$this->loadThemeView('post',$data);
	}
}
/* End of file post.php */
/* Location: ./application/controllers/post.php */
?>
