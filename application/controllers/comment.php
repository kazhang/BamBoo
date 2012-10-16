<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends CI_Controller
{
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	/**
	 * Default page
	 *
	 * @access	public
	 * @param	int		post ID
	 * @return 	void
	 */
	public function index($postID)
	{
		$this->form_validation->set_rules('author','称呼','required|trim|htmlspecialchars');
		$this->form_validation->set_rules('email','邮件','required|valid_email|trim');
		$this->form_validation->set_rules('postSlug','别名','required');
		$this->form_validation->set_rules('url','网址','trim|prep_url');

		if($this->form_validation->run() === FALSE)
		{
			echo show_error(validation_errors());
		}
		else
		{
			$post=$this->post_mdl->getPostBySlug($this->input->post('postSlug'),'post_ID,allow_comment');

			if($post == FALSE)
			{
				show_404();
			}
			
			if($post['allow_comment'] == 0)
			{
				show_error('文章评论已关闭');
			}

			$cid=$this->comment_mdl->addComment(array(
				'post_ID'	=> $postID,
				'author'	=> $this->input->post('author'),
				'author_email'	=> $this->input->post('email'),
				'author_url'	=> $this->input->post('url'),
				'author_IP'	=> $this->input->ip_address(),
				'created'	=> time(),
				'content'	=> $this->_contentFilter($this->input->post('content')),
				'approved'	=> 0,
				'agent'		=> $_SERVER['HTTP_USER_AGENT'],
				'parent_ID'	=> $this->input->post('replyTo')
				),
				$this->input->post('cite')
			);

			if($cid !== FALSE)
			{
				$this->session->set_flashdata('commentMsg','评论发布成功，正在等待审核。');	
			}
			else
			{
				$this->session->set_flashdata('commentMsg','您的评论貌似有点问题，请检查后再试试。');	
			}

			redirect('post/'.$this->input->post('postSlug'));
		}
	}

	/**
	 * Remove tags from content
	 *
	 * @access	private
	 * @param	string	content
	 * @return	string
	 */
	private function _contentFilter($content)
	{
		$content=strip_tags($content);
		$content=nl2br($content);

		return $content;
	}
}
/* End of file comment.php */
/* Location: ./application/controllers/comment.php */
?>
