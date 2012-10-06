<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends CI_Controller
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
		$this->load->model('category_mdl');
	}

	/**
	 * Default page
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name','required|trim');
		$this->form_validation->set_rules('slug','trim');
		$this->form_validation->set_rules('description','trim');

		if($this->form_validation->run() == TRUE)
		{
			$cateData=$this->_getPostData();
			$this->category_mdl->addCategory($cateData);
		}

		$data['pageTitle']='分类目录';

		$data['categories']=$this->category_mdl->getCategories();
		$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);

		$this->load->view('admin/categories',$data);
	}

	/**
	 * Get new category data form post form
	 *
	 * @access private
	 * @return array
	 */
	private function _getPostData()
	{
		$cateData=array(
			'name'	=> $this->input->post('name'),
			'slug'	=> $this->input->post('slug'),
			'description'=> $this->input->post('description'),
			'parent_ID'	=> $this->input->post('parent_ID')
		);

		if($cateData['slug']==FALSE)
		{
			$cateData['slug']=$cateData['name'];
		}

		return $cateData;
	}
}
/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */
?>
