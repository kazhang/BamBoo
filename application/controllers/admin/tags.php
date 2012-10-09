<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags extends MY_Auth_Controller
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
			$tagData=$this->_getPostData();
			$this->tag_mdl->addTag($tagData['name'],$tagData['slug'],$tagData['description']);
		}

		$data['pageTitle']='标签';
		
		$data['tags']=$this->tag_mdl->getTags();
		$this->load->view('admin/tags',$data);
	}

	/**
	 * Edit tag
	 * 
	 * @access	public
	 * @param	int
	 * @return	void
	 */
	public function edit($tagID)
	{
		$this->_setRules();

		if($this->form_validation->run() == TRUE)
		{
			$cateData=$this->_getPostData();
			$this->tag_mdl->updateTag($tagID,$cateData);
			redirect('admin/tags');
		}

		$data['pageTitle']='编辑标签';

		$data['tag']=$this->tag_mdl->getTagByID($tagID);

		if($data['tag']==FALSE)
		{
			show_404();
		}

		$this->load->view('admin/tags',$data);
	}

	/**
	 * Delete tag
	 * 
	 * @access 	public
	 * @param	int		tag ID
	 * @return 	void
	 */
	public function delete($tagID)
	{
		$this->tag_mdl->deleteTag($tagID);

		redirect('admin/tags');
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
	 * Get new tag data form post form
	 *
	 * @access private
	 * @return array
	 */
	private function _getPostData()
	{
		$tagData=array(
			'name'	=> $this->input->post('name'),
			'slug'	=> $this->input->post('slug'),
			'description'=> $this->input->post('description'),
		);

		$tagData['slug']=($tagData['slug']==FALSE) ? $tagData['name'] : $tagData['slug'];

		return $tagData;
	}
	
}
/* End of file tags.php */
/* Location: ./application/controllers/admin/tags.php */
?>
