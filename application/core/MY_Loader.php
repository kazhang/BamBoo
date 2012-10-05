<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
/**
 * MY_Loader
 */

class MY_Loader extends CI_Loader
{
	public $theme='default';

	public function __construct()
	{
		parent::__construct();
	}

	public function switchThemeOn()
	{
		$this->_ci_view_paths=array(FCPATH.'themes'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR=>TRUE);
	}
}
/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
?>
