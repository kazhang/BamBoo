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
		$this->load->model('category_mdl');
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
			if($this->form_validation->run() == FALSE)
			{
				$data['pageTitle']='写文章';

				$data['categories']=$this->category_mdl->getCategories('category_ID,name,parent_ID');
				$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);

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

				$tags=$postData['tags'];
				$tags=str_replace('，',',',$tags);
				$tags=array_unique(array_map('trim',explode(',',$tags)));
				unset($postData['tags']);

				$categories=$postData['categories'];
				unset($postData['categories']);

				$postID=$this->post_mdl->addPost($postData);

				$this->_setTagsPostRelation($tags,$postID);
				$this->_setCategoriesPostRelation($categories,$postID);
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

			$oldTags=$this->tag_mdl->getTagsByPostID($postID);
			$oldTags=Common::getField('name',$oldTags);
			if(!empty($oldTags))
			{
				$postData['tags']=implode(',',$oldTags);
			}
			else
			{
				$postData['tags']='';
			}

			$oldCategories=$this->category_mdl->getCategoriesByPostID($postID);
			$oldCategories=Common::getField('category_ID',$oldCategories);
			$postData['categories']=$oldCategories;

			$data['pageTitle']='编辑文章';
			$data['post']=$postData;

			if($this->form_validation->run() == FALSE)
			{
				$data['categories']=$this->category_mdl->getCategories('category_ID,name,parent_ID');
				$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);

				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$postData=$this->_getPostData();
				$postData['created']=Common::date2timestamp($postData['created']);
				$postData['modified']=time();

				$newTags=$postData['tags'];
				$newTags=str_replace('，',',',$newTags);
				$newTags=array_unique(array_map('trim',explode(',',$newTags)));
				unset($postData['tags']);

				$newCategories=$postData['categories'];
				unset($postData['categories']);

				$this->post_mdl->updatePost($postID,$postData);

				$this->_rebuildTagsPostRelation($oldTags,$newTags,$postID);
				$this->_rebuildCategoriesPostRelation($oldCategories,$newCategories,$postID);
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
			'categories'	=> $this->input->post('categories'),
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
	 * Set up relationship between categories and post
	 *
	 * @access 	private
	 * @param	array	categories ID
	 * @param	int		post ID
	 * @return 	void
	 */
	private function _setCategoriesPostRelation($categories,$postID)
	{
		foreach($categories as $item)
		{
			$this->category_mdl->setCategoryPostRelation($item,$postID);
		}
	}

	/**
	 * Remove relationship between categories and post
	 *
	 * @access 	private
	 * @param	array	categories ID
	 * @param	int		post ID
	 * @return 	void
	 */
	private function _removeCategoryPostRelation($categories,$postID)
	{
		foreach($categories as $item)
		{
			$this->category_mdl->removeCategoryPostRelation($item,$postID);
		}
	}

	/**
	 * Rebuild relationship between categories and post
	 *
	 * @access 	private
	 * @param	array	old categories ID
	 * @param	array	new categories ID
	 * @param	int		post ID
	 */
	private function _rebuildCategoriesPostRelation($oldCategories,$newCategories,$postID)
	{
		$rmCate=array();
		foreach($oldCategories as $item)
		{
			if(!in_array($item,$newCategories))
				$rmCate[]=$item;
		}
		$this->_removeCategoryPostRelation($rmCate,$postID);

		$setCate=array();
		foreach($newCategories as $item)
		{
			if(!in_array($item,$oldCategories))
				$setCate[]=$item;
		}
		$this->_setCategoriesPostRelation($setCate,$postID);
	}
}
/* End of file posts.php */
/* Location: ./application/controllers/admin/posts.php */
?>