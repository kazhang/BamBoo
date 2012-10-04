<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BB_Controller extends CI_Controller
{
	/**
	 * Constructor
	 * 
	 * @access protected 
	 * @return void
	 */
	protected function __construct()
	{
		parent::__construct();
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
	protected function load_theme_view($view,$vars=array(),$return=FALSE)
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
/* End of file BB_Controller.php */
/* Location: ./application/libraries/BB_Controller.php */
?>
