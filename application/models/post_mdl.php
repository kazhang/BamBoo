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
	 * @param	int		status
	 * @return	array
	 */
	public function getPosts($status = 1)
	{
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
