<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tag_mdl extends CI_Model
{
	const TAGS		= 'tags';
	const POST_TAG	= 'post_tag';

	/**
	 * map ID to tag name
	 *
	 * @acces private
	 */
	static private $names = NULL;

	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get tag name by tag_ID
	 *
	 * @access 	pubilc
	 * @param	int		tag_ID
	 * @return 	mixed	{name | FALSE}
	 */
	public function ID2Name($tag_ID)
	{
		if($names === NULL)
		{
			$names=array();
			$this->db->select('tag_ID,name');
			$query=$this->db->get(self::TAGS);
			foreach($query->result() as $item)
			{
				$names[$item->tag_ID]=$item->name;
			}
		}

		if(isset($names[$tag_ID]))
		{
			return $names[$tag_ID];
		}

		return FALSE;
	}

	/**
	 * Get tag information by name
	 *
	 * @access 	public
	 * @param	string 	tag name
	 * @return 	mixed 	{array | FALSE}
	 */
	public function getTagByName($name)
	{
		$this->db->where('name',$name);
		$query=$this->db->get(self::TAGS);

		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		
		return FALSE;
	}

	/**
	 * Add a tag
	 *
	 * @access 	public
	 * @param	string	tag name
	 * @param	string	tag description
	 * @return 	int		tag_ID
	 */
	public function addTag($name,$description = NULL)
	{
		if($description === NULL)
		{
			$description=$name;
		}

		$this->db->insert(self::TAGS,array('name'=>$name,'description'=>$description));

		return $this->db->insert_id();
	}

	/**
	 * Get all tags of an article
	 *
	 * @access 	public
	 * @param	int		post_ID
	 * @return	array
	 */
	public function getTagsByPostID($post_ID)
	{
		$this->db->select('*');
		$this->db->from(self::TAGS);
		$this->db->join(self::POST_TAG,self::TAGS.'.tag_ID = '.self::POST_TAG.'.tag_ID');
		$this->db->where('post_ID',$post_ID);
		$query=$this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result_array();
		}

		return array();
	}

	/**
	 * Set up relationship between tag and post
	 * @access	public
	 * @param	string	tag's name
	 * @param	int		post_ID
	 * @return boolean
	 */
	public function setTagPostRalation($tag,$post_ID)
	{
		if($tag=='')return FALSE;

		$tag_ID=$this->getTagByName($tag);

		if($tag_ID === FALSE)
		{
			$tag_ID=$this->addTag($tag);
		}
		else
		{
			$tag_ID=$tag_ID['tag_ID'];
		}

		$this->db->insert(self::POST_TAG,array('tag_ID'=>$tag_ID,'post_ID'=>$post_ID));
		$this->tagCountPlus($tag_ID);
		return $this->db->affected_rows()>0;
	}

	/**
	 * Remove relationship between tag and post
	 *
	 * @access 	public
	 * @param	string	tag's name
	 * @param	int		post_ID
	 * @return 	boolean
	 */
	public function removeTagPostRelation($tag,$post_ID)
	{
		if($tag=='')return FALSE;

		$tag_ID=$this->getTagByName($tag);

		if($tag_ID === FALSE)
		{
			return FALSE;
		}
		else
		{
			$tag_ID=$tag_ID['tag_ID'];
		}

		$this->db->where('tag_ID',$tag_ID);
		$this->db->where('post_ID',$post_ID);
		$this->db->delete(self::POST_TAG);

		$this->tagCountPlus($tag_ID,-1);
		return $this->db->affected_rows()>0;
	}

	/**
	 * Increase value of tag count
	 * 
	 * @access 	public
	 * @param	int		tag_ID
	 * @param	int		increment	
	 * @return boolean
	 */
	public function tagCountPlus($tag_ID,$delta = 1)
	{
		$this->db->query("UPDATE ".self::TAGS." SET `count`=(`count`+$delta) WHERE `tag_ID`=$tag_ID");

		return $this->db->affected_rows();
	}

}
/* End of file post_mdl.php */
/* Location: ./application/models/post_mdl.php */
?>
