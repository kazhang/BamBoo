<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller
{
	/**
	 * Constructor
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default page
	 *
	 * @access 	public
	 * @param	int		page number
	 * @return 	void
	 */
	public function index($page = 1)
	{
		$data['pageTitle']='首页';
		$this->loadThemeView('home',$data);
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
?>
