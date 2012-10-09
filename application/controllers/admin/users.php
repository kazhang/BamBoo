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
		$data['users']=$this->user_mdl->getUsers();

		$this->load->view('admin/users',$data);
	}
}
/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
?>
