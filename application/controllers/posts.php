<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends MY_Controller
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

		$post="This is a test";
		$comments=array('This is a comment');

		$data['pageTitle']='page title';
		$data['pageDescription']='page description';
		$data['pageKeywords']='page keywords';
		$data['parsedFeed']='parsed feed';
		$data['post']=$post;
		$data['comments']=$comments;

		$this->loadThemeView('post',$data);
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/posts.php */
?>
