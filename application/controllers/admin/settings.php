<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends MY_Auth_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default page
	 *
	 * @access	public
	 * @return 	void
	 */
	public function index()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('blog_title','博客标题','trim|strip_tags');
		$this->form_validation->set_rules('blog_slogan','副标题','trim|strip_tags');
		$this->form_validation->set_rules('blog_description','博客描述','trim|strip_tags');
		$this->form_validation->set_rules('blog_keywords','博客关键字','trim|strip_tags');

		$this->load->model('setting_mdl');
		$settings=$this->setting_mdl->getSettings();

		if($this->form_validation->run() === TRUE)
		{
			$nSetting['blog_title']=$this->input->post('blog_title');
			$nSetting['blog_slogan']=$this->input->post('blog_slogan');
			$nSetting['blog_description']=$this->input->post('blog_description');
			$nSetting['blog_keywords']=$this->input->post('blog_keywords');

			foreach($nSetting as $key=>$value)
			{
				if($setting[$key] != $value)
					$this->setting_mdl->updateSettingItem($key,$value);
			}

			redirect('admin/settings');
		}
		else
		{
			$data['pageTitle']='基本设置';
			$data['setting']=$settings;
			$this->load->view('admin/settings',$data);
		}
	}
}
/* End of file settings.php */
/* Location: ./application/controllers/admin/settings.php */
?>
