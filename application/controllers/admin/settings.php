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
				if($settings[$key] != $value)
					$this->setting_mdl->updateSettingItem($key,$value);
			}

			redirect('admin/settings');
		}
		else
		{
			$data['pageTitle']='基本设置';
			$data['cur']='settings';
			$data['setting']=$settings;
			$this->load->view('admin/settings',$data);
		}
	}

	/**
	 * 邮件设置
	 *
	 * @access public
	 * @return void
	 */
	public function email()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('smtp_host','SMTP地址','trim|required');
		$this->form_validation->set_rules('smtp_user','SMTP用户名','trim|required');
		$this->form_validation->set_rules('smtp_pass','SMTP密码','required');

		$this->load->model('setting_mdl');
		$settings=$this->setting_mdl->getSettings();

		if($this->form_validation->run() === TRUE)
		{
			$nSetting['smtp_host']=$this->input->post('smtp_host');
			$nSetting['smtp_user']=$this->input->post('smtp_user');
			$nSetting['smtp_pass']=$this->input->post('smtp_pass');

			foreach($nSetting as $key=>$value)
			{
				if($settings[$key] != $value)
					$this->setting_mdl->updateSettingItem($key,$value);
			}

			redirect('admin/settings/email');
		}
		else
		{
			$data['pageTitle']='邮件设置';
			$data['cur']='mail_settings';
			$data['setting']=$settings;
			$this->load->view('admin/mail_settings',$data);
		}
	}	
}
/* End of file settings.php */
/* Location: ./application/controllers/admin/settings.php */
?>
