<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tag_mdl extends CI_Model
{
	const TAGS		= 'tags';
	const POST_TAG	= 'post_tag';

	/**
	 * map ID to tag name
	 *
	 * @access private
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
	 * Get all tags
	 * 
	 * @access	public
	 * @param	string	field
	 * @return	array
	 */
	public function getTags($field = '*')
	{
		$this->db->select($field);
		$query=$this->db->get(self::TAGS);
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		return array();
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
	 * Get tag information by slug
	 *
	 * @access 	public
	 * @param	string	tag slug
	 * @param	string	field
	 * @return 	mixed	{array | FALSE}
	 */
	public function getTagBySlug($slug,$field = NULL)
	{
		if($field !== NULL)
		{
			$this->db->select($field);
		}
	
		$this->db->where('slug',$slug);
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
	public function addTag($name,$slug = NULL,$description = NULL)
	{

		if($slug === NULL)
		{
			$slug=$name;
		}
		$slug=Common::repairSlugName($slug);

		//if there already exists a same slug
		$t=$this->getTagBySlug($slug,'tag_ID');
		if($t !== FALSE)
		{
			return $t['tag_ID'];
		}

		$this->db->insert(self::TAGS,array('name'=>$name,'slug'=>$slug,'description'=>$description));

		return $this->db->insert_id();
	}

	/**
	 * Update tag information
	 *
	 * @access	pubilc
	 * @param	int		tag ID
	 * @param	array	data
	 * @return 	boolean
	 */
	public function updateTag($tagID,$data)
	{
		$this->db->where('tag_ID',$tagID);
		$this->db->update(self::TAGS,$data);

		return $this->db->affected_rows()>0;
	}

	/**
	 * Delete a tag and remove all relation with post
	 *
	 * @access 	public
	 * @param	int		tag ID
	 * @return 	boolean
	 */
	public function deleteTag($tagID)
	{
		$this->db->where('tag_ID',$tagID);
		$this->db->delete(array(self::TAGS,self::POST_TAG));

		return $this->db->affected_rows()>0;
	}

	/**
	 * Get all tags of an article
	 *
	 * @access 	public
	 * @param	int		post_ID
	 * @param	string	field
	 * @return	array
	 */
	public function getTagsByPostID($post_ID,$field = NULL)
	{
		if($field === NULL)
		{
			$this->db->select('*');
		}
		else
		{
			$this->db->select($field);
		}
		$this->db->from(self::TAGS);
		$this->db->join(self::POST_TAG,self::TAGS.'.tag_ID = '.self::POST_TAG.'.tag_ID','inner');
		$this->db->where('post_ID',$post_ID);
		$query=$this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result_array();
		}

		return array();
	}

	/**
	 * Get a tag by ID
	 * 
	 * @access	public
	 * @param	int		tag ID
	 * @return 	mixed	array|FALSE
	 */
	public function getTagByID($tagID)
	{
		$this->db->where('tag_ID',$tagID);
		$query=$this->db->get(self::TAGS);

		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		return FALSE;
	}

	/**
	 * Look into relation table and get ID of tags related to an article
	 *
	 * @access	public
	 * @param	int		post_ID
	 * @return 	array
	 */
	public function getTagsIDByPostID($post_ID)
	{
		$this->db->where('post_ID',$post_ID);
		$query=$this->db->get(self::POST_TAG);

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
		return $this->db->affected_rows()>0;
	}

	/**
	 * Increase value of tag count
	 * 
	 * @access 	public
	 * @param	int|string		tag_ID or name
	 * @param	int		increment	
	 * @param	string	by name or ID
	 * @return boolean
	 */
	public function tagCountPlus($key,$delta,$term = 'ID')
	{
		if($term=='ID')
		{
			$this->db->query("UPDATE ".self::TAGS." SET `count`=(`count`+$delta) WHERE `tag_ID`=$key");
		}
		//TODO addsplash
		else if($term=='name')
		{
			$this->db->query("UPDATE ".self::TAGS." SET `count`=(`count`+$delta) WHERE `name`='$key'");
		}

		return $this->db->affected_rows();
	}

}
/* End of file post_mdl.php */
/* Location: ./application/models/tag_mdl.php */
?>
