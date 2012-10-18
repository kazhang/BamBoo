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

	/**
	 * Get required field from result row
	 *
	 * @access 	public
	 * @param	string	required field
	 * @param	array	result row
	 */
	static public function getField($field,$rows)
	{
		$res=array();
		foreach($rows as $item)
			$res[]=$item[$field];
		return $res;
	}

	/**
	 * Implode metas in result array
	 *
	 * @access	public
	 * @param	array	metas like categories and tags
	 * @param	string	meta type,category or tag?
	 * @return 	string
	 */
	static public function implodeMetas($metas,$type)
	{
		if(empty($metas))return '';

		$buf=array();
		foreach($metas as $item)
		{
			$buf[]=anchor("$type/".$item['slug'],$item['name'],'title="查看'.$item['name'].'中的全部文章"');
		}
		return implode('、',$buf);
	}

	/**
	 * strip invalid characters to build a slug
	 *
	 * @access	public
	 * @param	string	str
	 * @param	string	default value
	 * @param	int		maxLength
	 * @param	string	charset
	 * @return 	string
	 */
	static public function repairSlugName($str,$default = NULL,$maxLength = 100,$charset = 'UTF-8')
	{
		$str = str_replace(array("'", ":", "\\", "/"), "", $str);
		$str = str_replace(array("+", ",", " ", ".", "?", "=", "&", "!", "<", ">", "(", ")", "[", "]", "{", "}","%"), "_", $str);
		//$str = trim($str,'_');
		$str = empty($str) ? $default : $str;

		return function_exists('mb_get_info') ? mb_strimwidth($str, 0, $maxLength, '', $charset) : substr($str, $maxLength);
	}

	/**
	 * Get excerpt by separator
	 *
	 * @access	public
	 * @param	string content	
	 * @return	string	
	 */
	static public function getExcerpt($string)
	{
		list($excerpt)=explode(B_CONTENT_BREAK,$string);
		$excerpt=empty($excerpt)?$string:$excerpt;
		return $excerpt;
	}

	/**
	 * Get avatar
	 *
	 * @access	public
	 * @param	string	email
	 * @param	int		size
	 * @param	string	default image
	 * @param	string	maximum rating
	 * @param	boolean	generate image address?
	 * @return	string
	 */
	static public function getGravatar($email,$size = 60,$d = 'mm',$r = 'g',$img = TRUE)
	{
		$url='http://www.gravatar.com/avatar/';
		$url.=md5(strtolower(trim($email)));
		$url.="?s=$size&d=$d&r=$r";
		if($img)
		{
			$url='<img src="'.$url.'"/>';
		}
		return $url;
	}
}
/**
 * Get all settings
 * 
 * @access	public
 * @return	array
 */
function &getSetting()
{
	static $settings;
	if(!isset($settings))
	{
		$CI=&get_instance();
		$query=$CI->db->get('settings');

		foreach($query->result() as $item)
		{
			$settings[$item->name]=$item->value;
		}
		$query->free_result();
	}

	return $settings;
}

/**
 * Get a setting item
 *
 * @access	public
 * @param	string	setting name
 * @return	mixed	
 */
function settingItem($name)
{
	static $settingItem=array();
	if(!isset($settingItem[$name]))
	{
		$settings=&getSetting();
		if(!isset($settings[$name]))
		{
			return FALSE;
		}
		$settingItem[$name]=$settings[$name];
	}
	return $settingItem[$name];
}

/* End of file Common.php */
/* Location: ./application/libraries/Common.php */
?>
