<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends MY_Auth_Controller
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
		$data['pageTitle']='文章';
		$data['cur']='posts';

		$data['posts']=$this->post_mdl->getPosts(0,NULL,'created desc');

		foreach($data['posts'] as $key=>$value)
		{
			$tags=$this->tag_mdl->getTagsByPostID($value['post_ID'],'name');
			$tags=Common::getField('name',$tags);
			$data['posts'][$key]['tags']=implode(',',$tags);

			$categories=$this->category_mdl->getCategoriesByPostID($value['post_ID'],'name');
			$categories=Common::getField('name',$categories);
			$data['posts'][$key]['categories']=implode(',',$categories);
		}

		$this->load->view('admin/posts',$data);
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
		$this->form_validation->set_rules('tags','标签','trim');
		$this->form_validation->set_rules('created','创建日期','trim');

		//write new article
		if($postID === NULL)
		{
			if($this->form_validation->run() == FALSE)
			{
				$data['pageTitle']='写文章';
				$data['cur']='write';

				$data['categories']=$this->category_mdl->getCategories('category_ID,name,parent_ID');
				$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);

				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$isPublished=($this->input->post('publish') === FALSE ? FALSE : TRUE);

				$postData=$this->_getPostData();
				$postData['created']=time();
				$postData['modified']=time();
				$postData['author_ID']=1;
				$postData['type']='post';
				$postData['status']= $isPublished ? 1 : 0;
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

				if($isPublished)
				{
					$this->_updateCount($tags,$categories,1);
				}

				redirect('admin/posts/write/'.$postID);
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
			$data['cur']='write';
			$data['post']=$postData;

			if($this->form_validation->run() == FALSE)
			{
				$data['categories']=$this->category_mdl->getCategories('category_ID,name,parent_ID');
				$data['categories']=$this->category_mdl->setLevelCategory($data['categories']);

				$this->load->view('admin/post_write',$data);
			}
			else
			{
				$isPublished=($this->input->post('publish') === FALSE ? FALSE : TRUE);

				$postData=$this->_getPostData();
				$postData['created']=Common::date2timestamp($postData['created']);
				$postData['modified']=time();

				$postData['status']=$isPublished?1:0;

				$newTags=$postData['tags'];
				$newTags=str_replace('，',',',$newTags);
				$newTags=array_unique(array_map('trim',explode(',',$newTags)));
				unset($postData['tags']);

				$newCategories=$postData['categories'];
				unset($postData['categories']);

				if($isPublished)
				{
					$postData['status']=1;
				}

				$this->post_mdl->updatePost($postID,$postData);

				$this->_rebuildTagsPostRelation($oldTags,$newTags,$postID);
				$this->_rebuildCategoriesPostRelation($oldCategories,$newCategories,$postID);

				if($data['post']['status']==1)
				{
					$this->_updateCount($oldTags,$oldCategories,-1);
				}

				if($isPublished)
				{
					$this->_updateCount($newTags,$newCategories,1);
				}

				redirect('admin/posts/write/'.$postID);
			}
		}
		else
		{
			show_404();
		}
	}

	/**
	 * Put the post into trash
	 * 
	 * @access 	public
	 * @param	int		post ID
	 * @return void
	 */
	public function trash($post_ID,$updateCnt = FALSE)
	{
		$this->post_mdl->updateStatus($post_ID,-1);

		if($updateCnt == 1)
		{
			$tags=$this->tag_mdl->getTagsIDByPostID($post_ID,'tag_ID');	
			foreach($tags as $tag)
			{
				$this->tag_mdl->tagCountPlus($tag['tag_ID'],-1);
			}

			$categories=$this->category_mdl->getCategoriesIDByPostID($post_ID,'category_ID');
			foreach($categories as $cate)
			{
				$this->category_mdl->categoryCountPlus($cate['category_ID'],-1);
			}
		}
		redirect('admin/posts');
	}

	/**
	 * Pick up post from trash and save as draft
	 *
	 * @access	public
	 * @param	int		post ID
	 * @return void
	 */
	public function recover($post_ID)
	{
		$this->post_mdl->updateStatus($post_ID,0);

		redirect('admin/posts');
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
		if($categories==FALSE)return;
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
		if($categories==FALSE)return;
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
		if(!empty($oldCategories))
		{
			foreach($oldCategories as $item)
			{
				if(!in_array($item,$newCategories))
					$rmCate[]=$item;
			}
		}
		$this->_removeCategoryPostRelation($rmCate,$postID);

		$setCate=array();
		if(!empty($newCategories))
		{
			foreach($newCategories as $item)
			{
				if(!in_array($item,$oldCategories))
					$setCate[]=$item;
			}
		}
		$this->_setCategoriesPostRelation($setCate,$postID);
	}

	/**
	 * update count of tag and category
	 *
	 * @access	private
	 * @param	array	tags name
	 * @param	array	catgories ID
	 * @param	int		delta
	 * @return	void
	 */
	private function _updateCount($tags,$categories,$delta)
	{
		if(!empty($tags))
		{
			foreach($tags as $tag)
			{
				$this->tag_mdl->tagCountPlus($tag,$delta,'name');
			}
		}

		if(!empty($categories))
		{
			foreach($categories as $cate)
			{
				$this->category_mdl->categoryCountPlus($cate,$delta);
			}
		}
	}

}
/* End of file posts.php */
/* Location: ./application/controllers/admin/posts.php */
?>
