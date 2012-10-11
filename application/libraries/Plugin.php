<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plugin
{
	/**
	 * listended plugins
	 *
	 * @access private
	 * @var	array
	 */
	private $_listeners = array();

	/**
	 * CI
	 * 
	 * @access	private
	 * @var	object
	 */
	private $_CI;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		$this->_CI=&get_instance();
		$plugins=$this->getActivePlugs();

		if($plugins && is_array($plugins))
		{
			foreach($plugins as $plugin)
			{
				$pluginDir = $plugin['directory'].'/'.ucfirst($plugin['directory']).'.php';
				$path = FCPATH .'plugins/'.$pluginDir;

				//TODO need preg?
				if(preg_match("/^[\w\-\/]+\.php$/",$pluginDir) && file_exists($path))
				{
					include_once($path);

					$class=ucfirst($plugin['directory']);
					if(class_exists($class))
					{
						new $class($this);
					}
				}
			}
		}
	}

	/**
	 * Register hook to listener
	 *
	 * @access	public
	 * @param	string	hook
	 * @param	object	reference
	 * @param	string	method
	 * @return 	void
	 */
	public function register($hook,&$reference,$method)
	{
		$key=get_class($reference).'->'.$method;
		$this->_listeners[$hook][$key]=array(&$reference,$method);

		log_message('debug',"$hook Registered:$key");
	}

	/**
	 * trigger hook to run spcific function
	 *
	 * @access	public
	 * @param	string	hook
	 * @param	mixed	data
	 * @return 	mixed
	 */
	public function trigger($hook)
	{
		$result='';
		if($this->checkHookExist($hook))
		{
			foreach($this->_listeners[$hook] as $listener)
			{
				$class=&$listener[0];
				$method=$listener[1];

				if(method_exists($class,$method))
				{
					$args=array_slice(func_get_args(),1);
					$result=call_user_func_array(array($class,$method),$args);
				}
			}
		}
		log_message('debug',"Hook Triggerred: $hook");
	}

	/**
	 * Check if spcific hook exists
	 *
	 * @access	public
	 * @param	string	hook
	 * @return 	array
	 */
	public function checkHookExist($hook)
	{
		if(isset($this->_listeners[$hook]) && is_array($this->_listeners[$hook]) && count($this->_listeners[$hook])>0)
			return TRUE;
		return FALSE;
	}

	/**
	 * Get active plugins
	 * 
	 * @access	public	
	 * @return	array
	 */
	public function getActivePlugs()
	{
		$activePlugins=settingItem('active_plugins');
		if(empty($activePlugins))
		{
			return array();
		}

		$plugins=unserialize($activePlugins);

		return $plugins ? (is_array($plugins) ? $plugins : array($plugins)):array();
	}
}	
/* End of file Plugin.php */
/* Location: ./application/libraries/Plugin.php */
?>
