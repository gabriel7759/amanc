<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Contento Auth driver.
 *
 * @package    Contento/Auth
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Kohana_Auth_Contento extends Auth {
	
	/**
	* Login types for session log
	*/
	const LOGIN     = 1;
	const AUTOLOGIN = 2;
	const LOGOUT    = 3;
	const PASSWORD  = 4;
	
	/**
	 * Checks if a session is active.
	 *
	 * @return  boolean
	 */
	public function logged_in($role = NULL)
	{
		// Get the user from the session
		$user = $this->get_user();

		if ( ! $user)
			return FALSE;

		return TRUE;
	}

	/**
	 * Logs a user in.
	 *
	 * @param   string   username
	 * @param   string   password
	 * @param   boolean  enable autologin
	 * @return  boolean
	 */
	protected function _login($username, $password, $remember)
	{
		// Load the user
		$user = Model::factory('Sys_User')->fetch_by_email($username);
		
		if (is_string($password))
		{
			// Create a hashed password
			$password = $this->hash($password);
		}

		// If the passwords match, perform a login
		if ($user AND $user['password'] === $password)
		{
			/*
			if ($remember === TRUE)
			{
				// Token data
				$data = array(
					'user_id'    => $user['id'],
					'expires'    => time() + $this->_config['lifetime'],
					'user_agent' => sha1(Request::$user_agent),
				);
				// Create a new autologin token
				$token = Model::factory('Sys_User_Token')->create($data);
				// Set the autologin cookie
				Cookie::set('authautologin', $token, $this->_config['lifetime']);
			}
			*/
			// Finish the login
			$this->_log($user, self::LOGIN);
			$this->complete_login($user);

			return TRUE;
		}

		// Login failed
		return FALSE;
	}
	
	/**
	 * Logs a user in, based on the authautologin cookie.
	 *
	 * @return  mixed
	 */
	public function auto_login()
	{
		if ($token = Cookie::get('authautologin'))
		{
			// Load the token and user
			$token = Model::factory('Sys_User_Token')->fetch(array(
				'token' => $token, 
			));
			$user = Model::factory('Sys_User')->fetch(array(
				'id' => $token['id'], 
			));
			/*
			if ($token AND $user)
			{
				if ($token['user_agent'] === sha1(Request::$user_agent))
				{
					// Save the token to create a new unique token
					//$token->save();
					$token = Model::factory('Sys_User_Token')->update(
						'id' => $token['id'],
					);

					// Set the new token
					Cookie::set('authautologin', $token->token, $token->expires - time());

					// Complete the login with the found data
					$this->_log($user, self::AUTOLOGIN);
					$this->complete_login($user);

					// Automatic login was successful
					return $token->user;
				}

				// Token is invalid
				$token->delete();
			}
			*/
		}

		return FALSE;
	}

	/**
	 * Gets the currently logged in user from the session (with auto_login check).
	 * Returns FALSE if no user is currently logged in.
	 *
	 * @return  mixed
	 */
	public function get_user($default = NULL)
	{
		$user = parent::get_user($default);

		if ( ! $user)
		{
			// check for "remembered" login
			$user = $this->auto_login();
		}

		return $user;
	}

	/**
	 * Log a user out and remove any autologin cookies.
	 *
	 * @param   boolean  completely destroy the session
	 * @param	boolean  remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		$this->_log($this->get_user(), self::LOGOUT);
		
		if ($token = Cookie::get('authautologin'))
		{
			// Delete the autologin cookie to prevent re-login
			Cookie::delete('authautologin');

			// Clear the autologin token from the database
			$token = Model::factory('Sys_User_Token')->fetch(array(
				'token' => $token, 
			));

			if ($token AND $logout_all)
			{
				Model::factory('Sys_User_Token')->delete(array(
					'user_id' => $token['user_id'], 
				));
			}
			elseif ($token)
			{
				Model::factory('Sys_User_Token')->delete(array(
					'id' => $token['id'], 
				));
			}
		}

		return parent::logout($destroy);
	}


	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   username string, or user ORM object
	 * @return  string
	 */
	public function password($user)
	{
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = ORM::factory('user');
			$user->where($user->unique_key($username), '=', $username)->find();
		}

		return $user->password;
	}
	
	/**
	 * Complete the login for a user by logging user's session
	 *
	 * @param   array  user data
	 * @param   int  login type
	 * @return  void
	 */
	protected function complete_login($user)
	{
		 Model::factory('Sys_User')->complete_login($user);
		
		return parent::complete_login($user);
	}
	
	public function refresh($email)
	{
		if ($this->logged_in())
		{
			$user = Model::factory('sys_user')->fetch_by_email($email);
			return $this->_session->set($this->_config['session_key'], $user);
		}
		
		return FALSE;
	}
	
	protected function _log($user, $action)
	{
		return Model::factory('sys_log_session')->save($user['id'], $action, Request::$client_ip, Request::$user_agent, time());
	}
	
	/**
	 * Compare password with original (hashed). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		$user = $this->get_user();

		if ( ! $user)
			return FALSE;

		return ($this->hash($password) === $user['password']);
	}

} // End Auth Contento