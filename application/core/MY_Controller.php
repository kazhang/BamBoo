<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
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
		$this->load->switchThemeOn();
	}

	/**
	 * Load theme
	 *
	 * @access protected
	 * @param string 	theme file name
	 * @param mixed		data
	 * @param boolean	send to browser
	 * @return void
	 */
	protected function loadThemeView($view,$vars=array(),$return=FALSE)
	{
		if(file_exists(FCPATH.'themes'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$view.'.php'))
		{
			echo $this->load->view($view,$vars,$return);
		}
		else
		{
			show_404();
		}
	}

}

class MY_Auth_Controller extends CI_Controller
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
		$this->load->library('Auth');
		if($this->auth->hasLogin() === FALSE)
		{
			redirect('admin/login?ref='.urlencode($this->uri->uri_string()));
		}

		$this->load->model('user_mdl');
	}
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
?>
