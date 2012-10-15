<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends MY_Auth_Controller
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
	}

	/**
	 * Default page
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data['pageTitle']='页面';
		$data['cur']='pages';

		$data['pages']=$this->post_mdl->getPages('title,slug,post_ID,author_ID,comment_cnt,status,created',0,'created desc');

		$this->load->view('admin/pages',$data);
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

		$this->form_validation->set_rules('title','标题','trim');
		$this->form_validation->set_rules('slug','别名','trim');
		$this->form_validation->set_rules('created','创建日期','trim');

		//write new article
		if($postID === NULL)
		{
			if($this->form_validation->run() == FALSE)
			{
				$data['pageTitle']='新页面';
				$data['cur']='write';
				$data['type']='page';
				$data['msg']=$this->session->flashdata('success');

				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$user=unserialize($this->session->userdata('user'));
				$isPublished=($this->input->post('publish') === FALSE ? FALSE : TRUE);

				$postData=$this->_getPostData();
				$postData['created']=time();
				$postData['modified']=time();
				$postData['author_ID']=$user['user_ID'];
				$postData['type']='page';
				$postData['status']= $isPublished ? 1 : 0;
				$postData['comment_cnt']=0;

				$postID=$this->post_mdl->addPost($postData);

				if($isPublished)
				{
					$this->session->set_flashdata('success','页面发布成功，'.anchor('page/'.$postData['slug'],'点击查看','target="_blank"'));
				}
				else
				{
					$this->session->set_flashdata('success','页面保存成功，'.anchor('page/'.$postData['slug'],'点击查看','target="_blank"'));
				}

				redirect('admin/pages/write/'.$postID);
			}
		}
		//edit article
		else if(is_numeric($postID))
		{
			$postData=$this->post_mdl->getPostByPostID($postID);

			if($postData == FALSE)
			{
				show_404();
			}

			$postData['created']=Common::timestamp2date($postData['created']);
			$postData['created']=$postData['created']['string'];

			$data['pageTitle']='编辑页面';
			$data['cur']='write';
			$data['type']='page';
			$data['post']=$postData;

			if($this->form_validation->run() == FALSE)
			{
				$data['msg']=$this->session->flashdata('success');
				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$isPublished=($this->input->post('publish') === FALSE ? FALSE : TRUE);

				$postData=$this->_getPostData();
				$postData['created']=Common::date2timestamp($postData['created']);
				$postData['modified']=time();

				$postData['status']=$isPublished?1:0;

				if($isPublished)
				{
					$postData['status']=1;
					$this->session->set_flashdata('success','页面发布成功，'.anchor('page/'.$postData['slug'],'点击查看','target="_blank"'));
				}
				else
				{
					$this->session->set_flashdata('success','页面保存成功.'.anchor('page/'.$postData['slug'],'点击查看','target="_blank"'));
				}

				$this->post_mdl->updatePost($postID,$postData);

				redirect('admin/pages/write/'.$postID);
			}
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
			'created'	=> $this->input->post('created'),
			'allow_comment' => ($this->input->post('allowComment')?1:0),
			'allow_feed'	=> ($this->input->post('allowFeed')?1:0)
		);
	}

	/**
	 * Put the page into trash
	 * 
	 * @access 	public
	 * @param	int		post ID
	 * @return void
	 */
	public function dump($post_ID)
	{
		$this->post_mdl->updateStatus($post_ID,-1);

		redirect('admin/posts');
	}

}
/* End of file posts.php */
/* Location: ./application/controllers/admin/posts.php */
?>
