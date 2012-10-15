<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller
{
	/**
	 * posts
	 *
	 * @access 	private
	 * @var		array
	 */
	private $_posts = array();

	/**
	 * Constructor
	 *
	 * @access 	public
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
	 * @param	int		page number
	 * @return 	void
	 */
	public function index($page = 1)
	{
		$this->_posts=$this->post_mdl->getPosts('*',1);

		$this->_preparePosts();
		$data['pageTitle']='首页';
		$data['pageDescription']=settingItem('blog_description');
		$data['pageKeywords']=settingItem('blog_keywords');
		$data['curPage']='home';
		$data['posts']=$this->_posts;
		$this->loadThemeView('home',$data);
	}

	/**
	 * Tag page
	 *
	 * @access	public
	 * @param	string	tag slug
	 * @return	void
	 */
	public function tag($slug = '')
	{
		if(empty($slug))
			redirect(site_url());

		$tag=$this->tag_mdl->getTagBySlug($slug);
		if($tag === FALSE)
		{
			show_error('标签不存在或已被主人删除');
			exit();
		}

		$this->_posts=$this->post_mdl->getPostsByTagID($tag['tag_ID']);
		$this->_preparePosts();
		$data['pageTitle']='标签：'.$slug;
		$data['pageDescription']='标签：'.$tag['name'].'下的所有文章';
		$data['pageKeywords']=settingItem('blog_keywords');
		$data['curPage']='tag';
		$data['posts']=$this->_posts;
		$this->loadThemeView('home',$data);
	}

	/**
	 * Category page
	 * 
	 * @access	public
	 * @param	string	category slug
	 * @return 	void
	 */
	public function category($slug = '')
	{
		if(empty($slug))
			redirect(site_url());
		$category=$this->category_mdl->getCategoryBySlug($slug);
		$categoryID=array($category['category_ID']);
		if($category['parent_ID']!=0)
		{
			$categoryID=array_merge($categoryID,$this->category_mdl->getChild($category['category_ID']));	
		}
		
		$this->_posts=$this->post_mdl->getPostsByCategoriesID($categoryID);
		$this->_preparePosts();	
		$data['pageTitle']='分类：'.$slug;
		$data['pageDescription']='分类：'.$category['name'].'下的所有文章';
		$data['pageKeywords']=settingItem('blog_keywords');
		$data['curPage']='category';
		$data['posts']=$this->_posts;
		$this->loadThemeView('home',$data);
	}

	/**
	 * Search page
	 *
	 * @access	public
	 * @return void
	 */
	public function search()
	{
		$keywords=strip_tags($this->input->get('q'));

		$this->_posts=$this->db->where('status',1)->like('title',$keywords)->get('posts')->result_array();
		$this->_preparePosts();
		$data['pageTitle']="\"$keywords\"的搜索结果";
		$data['pageDescription']=settingItem('blog_description');
		$data['pageKeywords']=settingItem('blog_keywords');
		$data['curPage']='search';
		$data['posts']=$this->_posts;
		$this->loadThemeView('home',$data);
	}

	/**
	 * Archives page
	 *
	 * @access	public
	 * @param	int		year
	 * @param	int		month
	 * @param	int		day	
	 * @return	void
	 */
	public function archives($year,$month = NULL,$day = NULL)
	{
		if(empty($year))redirect(site_url());

		$this->_posts=$this->post_mdl->getPostsByDate($year,$month,$day);
		$this->_preparePosts();
		$data['pageTitle']=$this->_dateString($year,$month,$day)."文章归档";
		$data['pageDescription']=$data['pageTitle'];
		$data['pageKeywords']=settingItem('blog_keywords');
		$data['curPage']='archives';
		$data['posts']=$this->_posts;
		$this->loadThemeView('home',$data);
	}

	/**
	 * prepare posts information(tags,categories,links)
	 *
	 * @access	private
	 * @return 	void
	 */
	private function _preparePosts()
	{
		foreach($this->_posts as $key=>$value)
		{
			$this->_posts[$key]['permalink']=site_url('post/'.$value['slug']);
			$this->_posts[$key]['published']=date('Y年m月d日',$value['created']);
			$this->_posts[$key]['tags']=$this->tag_mdl->getTagsByPostID($value['post_ID'],'name,slug');
			$this->_posts[$key]['categories']=$this->category_mdl->getCategoriesByPostID($value['post_ID'],'name,slug');
			$this->_posts[$key]['excerpt']=Common::getExcerpt($value['content']);
			$this->_posts[$key]['more']=(strpos($value['content'],B_CONTENT_BREAK) === FALSE)?FALSE:TRUE;
			unset($this->_posts[$key]['slug']);
			unset($this->_posts[$key]['content']);
		}
	}

	/**
	 * Return date string
	 *
	 * @access	private
	 * @param	int		year
	 * @param	int		month
	 * @param	int 	day
	 * @return	string
	 */
	private function _dateString($year,$month = NULL,$day = NULL)
	{
		$res=$year."年";
		if($month !== NULL)
		{
			$res.=$month."月";
			if($day !== NULL)
			{
				$res.=$day."日";
			}
		}
		return $res;
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
?>
