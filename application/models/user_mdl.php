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
}
/* End of file user_mdl.php */
/* Location: ./application/models/user_mdl.php */
?>
