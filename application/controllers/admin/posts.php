<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends CI_Controller
{
	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('post_mdl');
	}

	/**
	 * Write or edit post
	 * 
	 * @access public
	 * @return void
	 */
	public function write($postID = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title','trim');
		$this->form_validation->set_rules('slug','trim');
		$this->form_validation->set_rules('tags','trim');
		$this->form_validation->set_rules('created','trim');

		//write new article
		if($postID === NULL)
		{
			$data['pageTitle']='写文章';
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$postData=$this->_getPostData();
				$postData['created']=time();
				$postData['modified']=time();
				$postData['author_ID']=1;
				$postData['type']='post';
				$postData['status']=0;
				$postData['comment_cnt']=0;

				echo $this->post_mdl->addPost($postData);
			}
		}
		//edit article
		else if(is_numeric($postID))
		{
			echo "write",$postID;
		}
		else
		{
			show_404();
		}
	}

	/**
	 * Get data from post input
	 *
	 * @access private
	 * @return array
	 */
	private function _getPostData()
	{
		return array(
			'title'		=> $this->input->post('title'),
			'slug'		=> $this->input->post('slug'),
			'content'	=> $this->input->post('content'),
			//'tags'		=> $this->input->post('tags'),
			//'category'	=> $this->input->post('category'),
			'created'	=> $this->input->post('created'),
			'allow_comment' => ($this->input->post('allowComment')?1:0),
			'allow_feed'	=> ($this->input->post('allowFeed')?1:0)
		);
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/admin/posts.php */
?>
