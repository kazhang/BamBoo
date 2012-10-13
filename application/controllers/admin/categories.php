<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories extends MY_Auth_Controller
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
		$this->load->library('form_validation');
	}

	/**
	 * Default page
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->_setRules();

		if($this->form_validation->run() == TRUE)
		{
			$cateData=$this->_getPostData();
			$this->category_mdl->addCategory($cateData);
		}

		$data['pageTitle']='分类目录';
		$data['cur']='categories';

		$data['categories']=$this->category_mdl->getCategories();
		$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);

		$this->load->view('admin/categories',$data);
	}

	/**
	 * Edit category 
	 *
	 * @access	public
	 * @param	int		category ID
	 * @return	void
	 */
	public function edit($categoryID)
	{
		$this->_setRules();

		if($this->form_validation->run() == TRUE)
		{
			$cateData=$this->_getPostData();
			$this->category_mdl->updateCategory($categoryID,$cateData);
			redirect('admin/categories');
		}
		else
		{
			show_error(validation_errors());
		}

		$data['pageTitle']='编辑分类';
		$data['cur']='categories';

		$data['categories']=$this->category_mdl->getCategories();
		$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);
		$data['category']=$this->category_mdl->getCategoryByID($categoryID);

		if($data['category']==FALSE)
		{
			show_404();
		}

		$this->load->view('admin/categories',$data);
	}

	/**
	 * Delete category 
	 * 
	 * @access 	public
	 * @param	int		category ID
	 * @return 	void
	 */
	public function delete($categoryID)
	{
		$this->category_mdl->deleteCategory($categoryID);

		redirect('admin/categories');
	}

	/**
	 * Set form validation rules
	 *
	 * @access	private
	 * @return 	void
	 */
	private function _setRules()
	{
		$this->form_validation->set_rules('name','名称','required|trim');
		$this->form_validation->set_rules('slug','别名','trim');
		$this->form_validation->set_rules('description','描述','trim');
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
