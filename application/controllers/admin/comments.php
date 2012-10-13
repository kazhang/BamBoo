<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends MY_Auth_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default page
	 *
	 * @access 	public
	 * @return	void
	 */
	public function index()
	{
		$data['pageTitle']='评论';
		$data['cur']='comments';
		$data['comments']=$this->comment_mdl->getComments(NULL,'ALL','comments.*,posts.slug,posts.title','posts');

		$this->load->view('admin/comments',$data);
	}

	/**
	 * Approve or unapprove a comment
	 *
	 * @access	public
	 * @param	int		comment ID
	 * @param	int		poat ID
	 * @param	int		approve or unapprove
	 */
	public function approve($commentID,$postID,$flag)
	{
		$this->db->where('comment_ID',$commentID);
		$this->db->update('comments',array('approved'=>$flag));

		if($flag==1)
		{
			$this->post_mdl->commentCntPlus($postID,1);
		}
		else
		{
			$this->post_mdl->commentCntPlus($postID,-1);
		}

		redirect('admin/comments');
	}

	/**
	 * Delete a comment
	 *
	 * @access	public
	 * @param	int		comment ID
	 * @param	int		post ID
	 * @param	int		approved or not
	 * @return	void
	 */
	public function delete($commentID,$postID,$approved = NULL)
	{
		if($approved == 1)
		{
			$this->post_mdl->commentCntPlus($postID,-1);
		}
		$this->db->where('comment_ID',$commentID);
		$this->db->delete('comments');

		redirect('admin/comments');
	}
}
/* End of file comments.php */
/* Location: ./application/controllers/admin/comments.php */
?>
