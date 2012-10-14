<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends MY_Auth_Controller
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
		$data['pageTitle']='用户';
		$data['cur']='users';
		$data['users']=$this->user_mdl->getUsers();

		$this->load->view('admin/users',$data);
	}

	/**
	 * Edit user profile
	 *
	 * @access	public
	 * @param	int		user ID
	 * @return 	void
	 */
	public function edit($userID = NULL)
	{
		$this->_setRules();	
		if($this->form_validation->run() === TRUE)
		{
			$userData=array(
				'username'	=> $this->input->post('username'),
				'password'	=> $this->input->post('password'),
				'nickname'	=> $this->input->post('nickname'),
				'email'		=> $this->input->post('email'),
				'group'		=> $this->input->post('group')
			);
			if($userID !== NULL)
			{
				$this->user_mdl->updateUser($userID,$userData);
			}
			else
			{
				$this->user_mdl->addUser($userData);
			}
			redirect('admin/users');
		}

		if($userID !== NULL && is_numeric($userID))
		{
			$data['pageTitle']='编辑个人资料';
			$data['cur']='editUser';
			$data['user']=$this->user_mdl->getUserBy('user_ID',$userID);

			if($data['user'] === FALSE)
			{
				show_error('用户不存在');
			}
		}
		else
		{
			$data['pageTitle']='添加用户';
			$data['cur']='addUser';
		}

		$data['errors']=validation_errors();

		$this->load->view('admin/users',$data);
	}

	/**
	 * Set form_validation rules
	 *
	 * @access	private
	 * @return 	void
	 */
	private function _setRules()
	{
		$this->form_validation->set_rules('username','用户名','required|alpha_dash|trim');	
		$this->form_validation->set_rules('password','密码','required|min_length[6]');	
		$this->form_validation->set_rules('passconf','重复密码','required|matches[password]');	
		$this->form_validation->set_rules('nickname','昵称','required');	
		$this->form_validation->set_rules('email','电子邮件','required|valid_email');	
	}
}
/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
?>
