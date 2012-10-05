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
	 * @return	array
	 */
	public function getPosts()
	{
		$query=$this->db->get(self::POSTS);

		return $query->result();
	}

	/**
	 * Get an article by post_ID
	 *
	 * @access 	public
	 * @param	int		post_ID
	 * @return	mixed	{object | FALSE}
	 */
	public function getPostByPostID($post_ID)
	{
		$this->db->where('post_ID',$post_ID);
		$query=$this->db->get(self::POSTS);
		$res=$query->result();

		if($res === FALSE)
		{
			return FALSE;
		}

		return $res[0];
	}

	/**
	 * Get an article by slug
	 * 
	 * @access 	public
	 * @param	string	article's slug
	 * @return	mixed	{object | FALSE}
	 */
	public function getPostBySlug($slug)
	{
		$this->db->where('slug',$slut);
		$query = $this->db->get(self::POSTS);
		$res = $query->result();

		if($res === FALSE)
		{
			return FALSE;
		}

		return $res[0];
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
}
/* End of file post_mdl.php */
/* Location: ./application/models/post_mdl.php */
?>
