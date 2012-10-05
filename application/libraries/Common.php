<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common
{
	/**
	 * Transfer timestamp to date array
	 *
	 * @access	public
	 * @param	int		timestamp
	 * @return 	array
	 */
	static public function timestamp2date($timestamp)
	{
		if(!is_numeric($timestamp))
		{
			return FALSE;
		}

		$res=array();
		list($res['year'],$res['month'],$res['day'],$res['hour'],$res['minute'],$res['second'])=explode(' ',date('Y n j G i s',$timestamp));
		$res['string']=date('Y-m-d H:i:s',$timestamp);

		return $res;
	}

	/**
	 * Transfer date time string to timestamp
	 *
	 * @access 	public
	 * @param	string	date tiem string (2012-01-01 00:00:00)
	 * @return 	int
	 */
	static public function date2timestamp($dateTime)
	{
		list($date,$time)=explode(' ',$dateTime);
		list($year,$month,$day)=explode('-',$date);
		list($hour,$minute,$second)=explode(':',$time);

		return mktime($hour,$minute,$second,$month,$day,$year);
	}
}
/* End of file Common.php */
/* Location: ./application/libraries/Common.php */
?>
