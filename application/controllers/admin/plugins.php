<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plugins extends MY_Auth_Controller
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
		$this->load->model('plugin_mdl');
	}

	/**
	 * Default page
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$data['pageTitle']='插件';

		$data['plugins']=$this->plugin_mdl->getAllPluginsInfo();

		$this->load->view('admin/plugins',$data);
	}

	/**
	 * Active plugin
	 *
	 * @access	public
	 * @param	string	name
	 * @return	void
	 */
	public function activate($name)
	{
		$plugin=$this->plugin_mdl->get($name);
		if($plugin && is_array($plugin))
		{
			$this->plugin_mdl->active($plugin);
		}
	}
}
/* End of file tags.php */
/* Location: ./application/controllers/admin/tags.php */
?>
