<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_mdl extends CI_Model
{
	const USERS	= 'users';
	const SALT	= 'whosyourdaddy';

	/**
	 * Get users
	 *
	 * @access	pubilc
	 * @param	string	field
	 * @return	array
	 */
	public function getUsers($field = NULL)
	{
		if($field !== NULL)
		{
			$this->db->select($field);
		}
		$query=$this->db->get(self::USERS);
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		return array();
	}

	/**
	 * Get user by term
	 *
	 * @access	public
	 * @param	string	term
	 * @param	mixed	value
	 * @param	string	field
	 * @return	mixed	{array|FALSE}
	 */
	public function getUserBy($term,$value,$field = NULL)
	{
		if($field !== NULL)
		{
			$this->db->select($field);
		}
		$this->db->where($term,$value);
		$query=$this->db->get(self::USERS);
		if($query->num_rows>0)
		{
			return $query->row_array();
		}
		return FALSE;
	}

	/**
	 * validate user
	 * 
	 * @access	pubilc
	 * @param	string	username
	 * @param	string	password
	 * @return	mixed	{array|FALSE}
	 */
	public function validateUser($username,$password)
	{
		$user=$this->getUserBy('username',$username);

		if($user === FALSE)
		{
			return FALSE;
		}

		if($user['password'] !== md5(self::SALT.$password))
		{
			return FALSE;
		}
		return $user;
	}

	/**
	 * Get author name by author ID
	 *
	 * @access	public 
	 * @param	int		author ID
	 * @return	string
	 */
	public function getAuthorName($authorID)
	{
		static $names=array();

		if(isset($names[$authorID]))
			return $names[$authorID];

		$this->db->select('nickname');
		$this->db->where('user_ID',$authorID);
		$query=$this->db->get(self::USERS);
		if($query->num_rows()>0)
		{
			$user=$query->row();
			return $names[$authorID]=$user->username;
		}
		return '';
	}

	/**
	 * Add a user
	 *
	 * @access	public
	 * @param	array
	 * @return 	int
	 */
	public function addUser($userData)
	{
		$userData['password']=md5(self::SALT.$userData['password']);
		$userData['registered']=time();

		$this->db->insert(self::USERS,$userData);
		return $this->db->insert_id();
	}

	/**
	 * Update user profile
	 *
	 * @access	public
	 * @param	int		user ID
	 * @param	array	user data
	 * @return 	boolean
	 */
	public function updateUser($userID,$userData)
	{
		$this->db->where('user_ID',$userID);
		$userData['password']=md5(self::SALT.$userData['password']);
		$this->db->update(self::USERS,$userData);

		return $this->db->affected_rows()>0;
	}
}
/* End of file user_mdl.php */
/* Location: ./application/models/user_mdl.php */
?>
