<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_mdl');
		$this->load->library('form_validation');
		$this->load->library('auth');
		//$this->load->helper('security');
	}

	/**
	 * Default page
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function index()
	{
		$this->form_validation->set_rules('username','用户名','required|trim');
		$this->form_validation->set_rules('password','密码','required');

		if($this->form_validation->run() === TRUE)
		{
			$user=$this->user_mdl->validateUser(
				$this->security->xss_clean($this->input->post('username')),
				$this->input->post('password')
			);

			if($user !== FALSE)
			{
				$this->auth->setSession($user);
				$ref=$this->input->get('ref');
				redirect($ref ? $ref : 'admin/home');
			}
		}
		$data['pageTitle']='用户登录';
		$data['cur']='login';
		$this->load->view('admin/login',$data);
	}

	/**
	 * Logout
	 *
	 * @access	public
	 * @return 	void
	 */
	public function logout()
	{
		$this->session->sess_destroy();

		redirect('admin/login');
	}
}
/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */
?>
