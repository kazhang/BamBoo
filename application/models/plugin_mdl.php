<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plugin_mdl extends CI_Model
{
	private $activePlugins = array();
	private $pluginDir ='';

	/**
	 * Construct()
	 * 
	 * @access	public
	 * @return 	void
	 */
	public function __construct()
	{
		$this->pluginDir=FCPATH.'plugins/';
		$this->activePlugins=$this->plugin->getActivePlugs();

		log_message('debug',"BamBooBlog: Plugins Model Class Initialized");
	}

	/**
	 * Active a plugin
	 *
	 * @access	public
	 * @param	plugin
	 */
	public function active($plugin)
	{
		if(in_array($plugin,$this->activePlugins))return;

		$this->activePlugins[]=$plugin;

		$activePlugins=serialize($this->activePlugins);
		$this->db->query("UPDATE `settings` SET VALUE='$activePlugins' WHERE `name`='active_plugins'");
	}

	/**
	 * Deactive a plugin
	 *
	 * @access	public
	 * @param	plugin
	 * @return 	boolean
	 */
	public function deactive($plugin)
	{
		foreach($this->activePlugins as $key=>$value)
		{
			if($plugin==$value['directory'])
			{
				unset($this->activePlugins[$key]);
				break;
			}
		}	

		$activePlugins=serialize($this->activePlugins);
		$this->db->query("UPDATE `settings` SET VALUE='$activePlugins' WHERE `name`='active_plugins'");

		return $this->db->affected_rows()>0;
	}


	/**
	 * Get information of a plugin
	 *
	 * @access	public
	 * @param	string
	 * @return 	array
	 */
	public function get($plugin)
	{
		$plugin=strtolower($plugin);
		$path=$this->pluginDir.$plugin;
		$file=$path.'/'.ucfirst($plugin).'.php';
		$config=$path.'/'.ucfirst($plugin).'.config.php';
		if(!is_file($path) && file_exists($file))
		{
			$fp=fopen($file,'r');
			$pluginData=fread($fp,4096);
			fclose($fp);

			preg_match('|Plugin Name:(.*)$|mi',$pluginData,$name);
			preg_match('|Plugin URI:(.*)$|mi',$pluginData,$uri);
			preg_match('|Version:(.*)$|mi',$pluginData,$version);
			preg_match('|Description:(.*)$|mi',$pluginData,$description);
			preg_match('|Author:(.*)$|mi',$pluginData,$author);
			preg_match('|Author Email:(.*)$|mi',$pluginData,$author_email);

			foreach(array('name','uri','version','description','author','author_email') as $field)
				${$field}=(!empty(${$field}))?trim(${$field}[1]):'';

			return array(
				'directory'	=> $plugin,
				'name'		=> ucfirst($name),
				'plugin_uri'=> $uri,
				'description'=> $description,
				'author'	=> $author,
				'author_email'=> $author_email,
				'version'	=> $version,
				'configurable'=> (file_exists($config))?TRUE:FALSE
			);
		}
		return array();
	}

	/**
	 * Get all plugins in plugins dir
	 * 
	 * @access public
	 * @return array
	 */
	public function getAllPluginsInfo()
	{
		$data=array();
		$this->load->helper('directory');
		$pluginDirs=directory_map($this->pluginDir,TRUE);
		if($pluginDirs)
		{
			foreach($pluginDirs as $pluginDir)
				$data[]=$this->get($pluginDir);
		}
		return $data;
	}
}
/* End of file plugin_mdl.php */
/* Location: ./application/models/plugin_mdl.php */
?>
