<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MY_Controller
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

		$post['comments']=$this->comment_mdl->getComments($post['post_ID'],1);

		$data['pageTitle']=$post['title'];
		$data['pageDescription']=mb_strimwidth(strip_tags(Common::getExcerpt($post['content'])),0,100,'...');
		$data['pageKeywords']=$post['title'];
		$data['curPage']=$slug;
		$data['post']=$post;

		$data['cmtAuthor']=$this->input->cookie('author');
		$data['cmtAuthorEmail']=$this->input->cookie('author_email');
		$data['cmtAuthorUrl']=$this->input->cookie('author_url');

		$data['commentMsg']=$this->session->flashdata('commentMsg');
		if($data['commentMsg'] == FALSE)
		{
			unset($data['commentMsg']);
		}

		$this->loadThemeView('page',$data);
	}
}
/* End of file post.php */
/* Location: ./application/controllers/post.php */
?>
