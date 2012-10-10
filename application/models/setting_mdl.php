<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting_mdl extends CI_Model 
{
	const SETTINGS	= 'settings';

	/**
	 * Get all settings
	 *
	 * @access	public
	 * @return 	array
	 */
	public function getSettings()
	{
		$res=array();
		$query=$this->db->get(self::SETTINGS);

		if($query->num_rows()>0)
		{
			foreach($query->result() as $item)
			{
				$res[$item->name]=$item->value;
			}
		}
		return $res;
	}

	/**
	 * Update setting
	 * 
	 * @access	public
	 * @param	string	setting name
	 * @param	string	setting	value
	 * @return boolean
	 */
	public function updateSettingItem($name,$value)
	{
		$this->db->where('name',$name);
		$this->db->update(self::SETTINGS,array('value'=>$value));

		return $this->db->affected_rows()>0;
	}
}
/* End of file settings.php */
/* Location: ./application/controllers/admin/settings.php */
?>
