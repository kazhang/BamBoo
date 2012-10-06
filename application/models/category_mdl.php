<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_mdl extends CI_Model
{
	const CATEGORIES	= 'categories';
	const POST_CATEGORY	= 'post_category';

	/**
	 * Get all categories
	 *
	 * @access 	public
	 * @param	array	fields
	 * @return 	array
	 */
	public function getCategories($fields = NULL)
	{
		if($fields!== NULL)
		{
			$this->db->select($fields);
		}

		$query=$this->db->get(self::CATEGORIES);

		return $query->result_array();
	}

	/**
	 * Get categories of an article
	 *
	 * @access 	public
	 * @param	int		post ID
	 * @return	array
	 */
	public function getCategoriesByPostID($post_ID)
	{	
		$this->db->select('*');
		$this->db->from(self::CATEGORIES);
		$this->db->join(self::POST_CATEGORY,self::CATEGORIES.'.category_ID = '.self::POST_CATEGORY.'.category_ID');
		$this->db->where('post_ID',$post_ID);
		$query=$this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result_array();
		}

		return array();
	}

	/**
	 * Add a new category
	 *
	 * @access 	public
	 * @param	array
	 * @return 	int		new category's id
	 */
	public function addCategory($data)
	{
		$this->db->insert(self::CATEGORIES,$data);

		return $this->db->insert_id();
	}

	/**
	 * Set up two level relationship
	 *
	 * @access 	public
	 * @param	array	categories
	 * @return 	array
	 */
	public function setLevelCategory($categories)
	{
		$res=array();
		foreach($categories as $cate)
		{
			$id=$cate['category_ID'];

			if(!isset($res[$id]))
			{
				$res[$id]=array();
				$res[$id]['children']=array();
			}
			
			$res[$id]=array_merge($res[$id],$cate);

			if($cate['parent_ID'] != 0)
			{
				$pid=$cate['parent_ID'];
				if(!isset($res[$pid]))
				{
					$res[$pid]=array();
					$res[$pid]['children']=array();
				}

				$res[$pid]['children'][]=$id;
			}
		}

		return $res;
	}

	/**
	 * Set up relation between category and post
	 *
	 * @access 	pubic
	 * @param	int		category ID
	 * @param	int		post ID
	 * @return 	boolean
	 */
	public function setCategoryPostRelation($categoryID,$postID)
	{
		$this->db->insert(self::POST_CATEGORY,array('category_ID'=>$categoryID,'post_ID'=>$postID));

		$this->categoryCountPlus($categoryID,1);

		return $this->db->affected_rows()>0;
	}

	/**
	 * Remove relationship between category and post
	 *
	 * @access	public
	 * @param	int		category_ID
	 * @param	int		post ID
	 * @return 	boolean
	 */
	public function removeCategoryPostRelation($categoryID,$postID)
	{
		$this->db->where('category_ID',$categoryID);
		$this->db->where('post_ID',$postID);
		$this->db->delete(self::POST_CATEGORY);

		$this->categoryCountPlus($categoryID,-1);

		return $this->db->affected_rows()>0;
	}

	/**
	 * Add up a number to category count
	 *
	 * @access 	public
	 * @param	int		category ID
	 * @param	int		delta
	 * @return boolean
	 */
	public function categoryCountPlus($categoryID,$delta)
	{
		$this->db->query("UPDATE ".self::CATEGORIES." SET `count`=(`count`+$delta) WHERE `category_ID`=$categoryID");

		return $this->db->affected_rows();
	}
}
/* End of file category_mdl.php */
/* Location: ./application/models/category_mdl.php */
?>