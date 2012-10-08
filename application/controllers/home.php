<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller
{
	/**
	 * Constructor
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default page
	 *
	 * @access 	public
	 * @param	int		page number
	 * @return 	void
	 */
	public function index($page = 1)
	{
		$data['posts']=$this->post_mdl->getPosts(1);

		foreach($data['posts'] as $key=>$value)
		{
			$data['posts'][$key]['tags']=$this->tag_mdl->getTagsByPostID($value['post_ID'],'name,slug');

			$data['posts'][$key]['categories']=$this->category_mdl->getCategoriesByPostID($value['post_ID'],'name,slug');
		}

		$data['pageTitle']='首页';
		$this->loadThemeView('home',$data);
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
?>
