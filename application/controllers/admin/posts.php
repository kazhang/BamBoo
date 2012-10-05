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
		$this->load->model('tag_mdl');
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

				$tags=explode(',',$postData['tags']);
				unset($postData['tags']);

				$postID=$this->post_mdl->addPost($postData);

				$this->_setTagsPostRelation($tags,$postID);
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

			$data['pageTitle']='编辑文章';
			$data['post']=$postData;

			$oldTags=$this->tag_mdl->getTagsByPostID($postID);
			$oldTags=$this->_getTagsName($oldTags);
			if(!empty($oldTags))
			{
				$data['tags']=implode(',',$oldTags);
			}
			else
			{
				$data['tags']='';
			}

			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$postData=$this->_getPostData();
				$postData['created']=Common::date2timestamp($postData['created']);
				$postData['modified']=time();

				$newTags=$postData['tags'];
				$newTags=explode(',',$newTags);
				unset($postData['tags']);

				$this->post_mdl->updatePost($postID,$postData);

				$this->_rebuildTagsPostRelation($oldTags,$newTags,$postID);
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
			'tags'		=> $this->input->post('tags'),
			//'category'	=> $this->input->post('category'),
			'created'	=> $this->input->post('created'),
			'allow_comment' => ($this->input->post('allowComment')?1:0),
			'allow_feed'	=> ($this->input->post('allowFeed')?1:0)
		);
	}

	/**
	 * Set up relation between tags and post
	 *
	 * @access 	private
	 * @param 	array	tags' name
	 * @param	int		post ID
	 * @return 	void
	 */
	private function _setTagsPostRelation($tags,$postID)
	{
		foreach($tags as $tag)
		{
			$this->tag_mdl->setTagPostRalation($tag,$postID);
		}
	}

	/**
	 * Remove relation between tags and post
	 *
	 * @access 	private
	 * @param	array	tags' name
	 * @param	int		post ID
	 * @return	void
	 */
	private function _removeTagsPostRelation($tags,$postID)
	{
		foreach($tags as $tag)
		{
			$this->tag_mdl->removeTagPostRelation($tag,$postID);
		}
	}

	/**
	 * Rebuild relation between tags and post
	 *
	 * @access	private
	 * @param	array	old tags' name
	 * @param	array	new tags' name
	 * @param	int		post ID
	 * @return void
	 */
	private function _rebuildTagsPostRelation($oldTags,$newTags,$postID)
	{
		if(empty($oldTags) && empty($newTags))return;

		$rmTags=array();
		foreach($oldTags as $tag)
		{
			if(!in_array($tag,$newTags))
				$rmTags[]=$tag;
		}
		$this->_removeTagsPostRelation($rmTags,$postID);

		$setTags=array();
		foreach($newTags as $tag)
		{
			if(!in_array($tag,$oldTags))
				$setTags[]=$tag;
		}
		$this->_setTagsPostRelation($setTags,$postID);
	}

	/**
	 * Get tags' name from result_row
	 *
	 * @access 	private
	 * @param	array
	 * @return 	array
	 */
	private function _getTagsName($tags)
	{
		$res=array();
		foreach($tags as $tag)
			$res[]=$tag['name'];
		return $res;
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/admin/posts.php */
?>
