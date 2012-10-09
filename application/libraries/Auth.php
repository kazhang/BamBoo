<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth
{
	private $_CI;
	private $_user = FALSE;
	private $_hasLogin = NULL;

	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->_CI= &get_instance();
		$this->_user=unserialize($this->_CI->session->userdata('user'));
	}

	/**
	 * Check if user has login
	 *
	 * @access public
	 * @return boolean
	 */
	public function hasLogin()
	{
		if($this->_hasLogin !== NULL)
		{
			return $this->_hashLogin;
		}
		else
		{
			//TODO set/check user token to make sure user can only log in one browser at the same time.
			if(!empty($this->_user))
			{
				return $this->_hashLogin=TRUE;
			}
			return $this->_hashLogin=FALSE;
		}
		return $this->_hashLogin=FALSE;
	}

	/**
	 * Set session
	 *
	 * @access 	public
	 * @param	array	user data
	 * @return 	void
	 */
	public function setSession($userData)
	{
		$data=array('user'=>serialize($userData));
		$this->_CI->session->set_userdata($data);
	}
}
/* End of file auth.php */
/* Location: ./application/libraries/Auth.php */
?>
