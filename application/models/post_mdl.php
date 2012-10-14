<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Post_mdl extends CI_Model
{
	const POSTS	='posts';
	
	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		log_message('debug','BBBlog: Posts Model Class Initialized');
	}

	/**
	 * Get all articles
	 * 
	 * @access 	public
	 * @param	string	filed
	 * @param	int		status
	 * @param	int		limit
	 * @param	string 	order by
	 * @return	array
	 */
	public function getPosts($field = '*',$status = 1,$limit = NULL ,$orderBy = NULL)
	{
		$this->db->select($field);
		if($orderBy !== NULL)
		{
			$this->db->order_by($orderBy);
		}

		$this->db->where('type','post');
		$this->db->where('status >=',$status);

		if($limit !== NULL && is_numeric($limit))
		{
			$this->db->limit($limit);
		}

		$query=$this->db->get(self::POSTS);

		return $query->result_array();
	}

	/**
	 * Get pages
	 * 
	 * @access	public
	 * @param	int		status
	 * @param	string	order by
	 * @return 	array
	 */
	public function getPages($status = 1,$orderBy = NULL)
	{
		if($orderBy !== NULL)
		{
			$this->db->order_by($orderBy);
		}
		$this->db->where('type','page');
		$this->db->where('status >=',$status);
		$query=$this->db->get(self::POSTS);

		return $query->result_array();
	}

	/**
	 * Get an article by post_ID
	 *
	 * @access 	public
	 * @param	int		post_ID
	 * @return	mixed	{array | FALSE}
	 */
	public function getPostByPostID($post_ID)
	{
		$this->db->where('post_ID',$post_ID);
		$query=$this->db->get(self::POSTS);

		if($query->num_rows()>0)
			return $query->row_array();

		return FALSE;
	}

	/**
	 * Get posts by tag ID
	 *
	 * @access	public
	 * @param	int		tag ID
	 * @param	int		status
	 * @return 	array
	 */
	public function getPostsByTagID($tag_ID,$status = 1)
	{
		$this->db->join('post_tag',self::POSTS.'.post_ID = post_tag.post_ID');
		$this->db->where('tag_ID',$tag_ID);
		$this->db->where('status',$status);
		$query=$this->db->get(self::POSTS);

		if($query->num_rows()>0)
			return $query->result_array();
		return array();
	}

	/**
	 * Get posts by categories ID
	 * 
	 * @access	public
	 * @param	array	categories ID
	 * @return	array
	 */
	public function getPostsByCategoriesID($CID,$status = 1)
	{
		$this->db->join('post_category',self::POSTS.'.post_ID = post_category.post_ID');
		$this->db->where('status',$status);
		$this->db->where_in('category_ID',$CID);
		$query=$this->db->get(self::POSTS);

		if($query->num_rows()>0)
			return $query->result_array();
		return array();
	}

	/**
	 * Get an article by slug
	 * 
	 * @access 	public
	 * @param	string	article's slug
	 * @param	string	field
	 * @return	mixed	{array | FALSE}
	 */
	public function getPostBySlug($slug,$field = NULL)
	{
		if($field !== NULL)
		{
			$this->db->select($field);
		}

		$this->db->where('slug',$slug);
		$query = $this->db->get(self::POSTS);

		if($query->num_rows()>0)
			return $query->row_array();

		return FALSE;
	}

	/**
	 * Get posts by date
	 *
	 * @access	public
	 * @param	int		year
	 * @param	int		month
	 * @param	int		day
	 * @return	array
	 */
	public function getPostsByDate($year,$month = NULL,$day = NULL)
	{
		if(empty($year) && empty($month) && empty($day))exit();

		if(!empty($year))
		{
			if(!empty($month))
			{
				if(!empty($day))
				{
					$from=mktime(0,0,0,$month,$day,$year);
					$to=mktime(23,59,59,$month,$day,$year);
				}
				else
				{
					$from=mktime(0,0,0,$month,1,$year);
					$to=mktime(23,59,59,$month,date('t',$from),$year);
				}
			}
			else
			{
				$from=mktime(0,0,0,1,1,$year);
				$to=mktime(23,59,59,12,31,$year);
			}
		}
		else
		{
			$from=0;
			$to=time();
		}

		$this->db->where('type','post');
		$this->db->where('created >=',$from);
		$this->db->where('created <=',$to);
		$this->db->where('status',1);

		$query=$this->db->get(self::POSTS);
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		return array();
	}

	/**
	 * Add a new article
	 *
	 * @access 	public
	 * @param	array	post data
	 * @return 	mixed	{post_ID | FALSE}
	 */
	public function addPost($postData)
	{
		$this->db->insert(self::POSTS,$postData);
		return ($this->db->affected_rows()==1) ? $this->db->insert_id():FALSE;
	}

	/**
	 * Update an article
	 *
	 * @access 	public
	 * @param	int 	post_ID
	 * @param	array	post data
	 * @return 	boolean	
	 */
	public function updatePost($post_ID,$postData)
	{
		$this->db->where('post_ID',intval($post_ID));
		$this->db->update(self::POSTS,$postData);

		return $this->db->affected_rows()>0;
	}

	/**
	 * Change status of an article
	 *
	 * @access	public
	 * @param	int		post_ID
	 * @param	int		new status
	 * @return	boolean
	 */
	public function updateStatus($post_ID,$status)
	{
		$this->db->where('post_ID',$post_ID);
		$this->db->update(self::POSTS,array('status'=>$status));

		return $this->db->affected_rows()>0;
	}

	/**
	 * update number of an aritcle comments
	 * 
	 * @access 	public
	 * @param	int		post ID
	 * @param	int		delta
	 * @return	boolean
	 */
	public function commentCntPlus($postID,$delta)
	{
		$this->db->query("UPDATE ".self::POSTS." SET `comment_cnt`=(`comment_cnt`+$delta) WHERE `post_ID`=$postID");
	}
}
/* End of file post_mdl.php */
/* Location: ./application/models/post_mdl.php */
?>
