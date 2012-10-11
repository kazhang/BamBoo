<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *	Plugin Name: 日志归档列表Widget
 *	Plugin URI: http://www.cnsaturn.com/
 *	Description: 显示日志按月归档列表
 *	Version: 0.1
 *	Author: Saturn
 *	Author Email: huyanggang@gmail.com
*/
class Archive
{
	private $_CI;

	public function __construct(&$plugin)
	{
		$plugin->register('Widget::Posts::Archive',$this,'show');
		$this->_CI=&get_instance();
	}

	/**
	 * Show archives
	 *
	 * @access	public
	 * @param	string	format
	 * @param	string	type
	 * @param	string	date formate
	 * @return void
	 */
	public function show($format,$type='month',$dateFormat='Y年m月',$limit = NULL)
	{
		if(empty($format))return;

		//TODO add cache
		$posts=$this->_CI->db->select('created')
			->from('posts')
			->where(array('type'=>'post','status'=>1))
			->order_by('created','DESC')
			->get()
			->result();
		$data=array();
		if($posts)
		{
			foreach($posts as $post)
			{
				$timestamp=$post->created;
				$date=date($dateFormat,$timestamp);

				if(isset($data[$date]))
				{
					$data[$date]['count']++;
				}
				else
				{
					if($limit !== NULL)
					{
						if(count($data) == $limit)
						{
							break;
						}
					}
					$data[$date]['year']=date('Y',$timestamp);
					$data[$date]['month']=date('m',$timestamp);
					$data[$date]['day']=date('d',$timestamp);
					$data[$date]['date']=$date;
					$data[$date]['count']=1;
				}
			}
		}
		foreach($data as $key=>$val)
		{
			$permalink=site_url('archives').'/'.$val['year'].'/'.$val['month'];
			$wildcards=array(
				'{permalink}',
				'{title}',
				'{count}'
			);
			$replaces=array(
				$permalink,
				$val['date'],
				$val['count']
			);
			echo str_replace($wildcards,$replaces,$format)."\r\n";
		}
	}

}	
/* End of file Archive.php */
/* Location: ./plugins/Archive.php */
?>
