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
	 * @param	string 	order by
	 * @param	int		limit
	 * @param	int		page	
	 * @return	array
	 */
	public function getPosts($field = '*',$status = 1,$orderBy = NULL,$limit = NULL ,$page = NULL)
	{
		$this->db->select($field);
		if($orderBy !== NULL)
		{
			$this->db->order_by($orderBy);
		}

		$this->db->where('type','post');
		if($status == -1)
			$this->db->where('status',-1);
		else
			$this->db->where('status >=',$status);

		if($page !== NULL)
		{
			$this->db->limit(B_PER_PAGE,($page-1)*B_PER_PAGE);
		}
		else if($limit !== NULL && is_numeric($limit))
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
	 * @param	string	field
	 * @param	int		status
	 * @param	string	order by
	 * @return 	array
	 */
	public function getPages($field = '*',$status = 1,$orderBy = NULL)
	{
		$this->db->select($field);
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
	 * @param	int		page
 	 * @param	int		total count	 
	 * @return 	array
	 */
	public function getPostsByTagID($tag_ID,$status = 1,$page = 1,&$total = 0)
	{
		//TODO seperate two queries
		$this->db->from(self::POSTS);
		$this->db->join('post_tag',self::POSTS.'.post_ID = post_tag.post_ID');
		$this->db->where('tag_ID',$tag_ID);
		$this->db->where('status',$status);
		$this->db->order_by('created','desc');
		$total=$this->db->count_all_results();

		$this->db->join('post_tag',self::POSTS.'.post_ID = post_tag.post_ID');
		$this->db->where('tag_ID',$tag_ID);
		$this->db->where('status',$status);
		$this->db->order_by('created','desc');
		$this->db->limit(B_PER_PAGE,($page-1)*B_PER_PAGE);
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
	 * @param	int		$page
	 * @param	int		total count
	 * @return	array
	 */
	public function getPostsByCategoriesID($CID,$status = 1,$page = 1,&$total = 0)
	{
		$this->db->from(self::POSTS);
		$this->db->join('post_category',self::POSTS.'.post_ID = post_category.post_ID');
		$this->db->where('status',$status);
		$this->db->where_in('category_ID',$CID);
		$this->db->distinct(self::POSTS.'post_ID');
		$this->db->order_by('created','desc');
		$total=$this->db->count_all_results();

		$this->db->select('`posts.post_ID`,`slug`,`title`,`created`,`content`,`author_ID`,`comment_cnt`');
		$this->db->join('post_category',self::POSTS.'.post_ID = post_category.post_ID');
		$this->db->where('status',$status);
		$this->db->where_in('category_ID',$CID);
		$this->db->distinct(self::POSTS.'post_ID');
		$this->db->order_by('created','desc');
		$this->db->limit(B_PER_PAGE,($page-1)*B_PER_PAGE);
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
	 * @param	int		page	
	 * @param	int		total count
	 * @return	array
	 */
	public function getPostsByDate($year,$month = NULL,$day = NULL,$page = NULL,&$total = 0)
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

		$this->db->from(self::POSTS);
		$this->db->where('type','post');
		$this->db->where('created >=',$from);
		$this->db->where('created <=',$to);
		$this->db->where('status',1);

		$total=$this->db->count_all_results();

		$this->db->from(self::POSTS);
		$this->db->where('type','post');
		$this->db->where('created >=',$from);
		$this->db->where('created <=',$to);
		$this->db->where('status',1);
		$this->db->order_by('created','desc');
		if($page !== NULL)
		{
			$this->db->limit(B_PER_PAGE,($page-1)*B_PER_PAGE);
		}
		$query=$this->db->get();
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

	/**
	 * count number of posts
	 *
	 * @access	public
	 * @param	string	status
	 * @return	int		
	 */
	public function getNumPost($status = NULL)
	{
		$this->db->from(self::POSTS);
		if($status !== NULL)
		{
			if($status === 'normal')
			{
				$this->db->where('status >=',0);
			}
			else if($status === 'published')
			{
				$this->db->where('status',1);
			}
			else if($status === 'trash')
			{
				$this->db->where('status',-1);
			}
		}

		return $this->db->count_all_results();
	}
}
/* End of file post_mdl.php */
/* Location: ./application/models/post_mdl.php */
?>
