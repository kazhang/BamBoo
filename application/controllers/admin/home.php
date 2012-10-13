<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Auth_Controller
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
	 * @return	void
	 */
	public function index()
	{
		$data['pageTitle']='管理中心';
		$data['cur']='home';

		$this->load->view('admin/home.php',$data);
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/admin/posts.php */
?>
