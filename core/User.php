<?php
/**
 * SocialPlus - A light and agile social network
 *
 * @author      Paras Dahal <shree5paras@gmail.com>
 * @copyright   2015 Paras Dahal
 * @link        http://www.github.com/parasdahal/socialplus
 * @license     MIT licence
 * @version     1.0
 * @package     socialplus
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace socialplus\core;
require_once('DB.php');

/**
 * User: This class manages the session, user meta and user details.
 */
class User{
	/**
	 * Array Containing Messages related to the login error
	 * @var array
	 */
	public $user_login_error=array();

	/**
	 * Array Containing Messages related to the following error
	 * @var array
	 */
	public $user_follow_error=array();
	
	/**
	 * Array Containing Messages related to the unfollowing error
	 * @var array
	 */
	public $user_unfollow_error=array();
	
	/**
	 * Array with data from Users table retrieved after successful login
	 * @var array
	 */
	public $user_data=array();

	/**
	 * Array with data from Users Meta table retrieved after successful login
	 * @var array
	 */
	public $user_meta_data=array();

	private $DB;

	public function __construct()
	{
		//Establish connection to the database
		$this->DB= DB::getInstance();
	}

	/**
	 * Creates session when user tries to login. Session with contain user information if no errors,
	 * otherwise it will contain error messages. This session is stored for 2 weeks in the browser.
	 * 
	 * @param int  $id  Userid of the user from the database
	 * @param string  $username Username of the user from the login form
	 * @param int  $remember Value of Remember me checkbox in the login form
	 * @param boolean $error  True if there are no errors in login, false otherwise
	 *
	 * @return array Session information stored in user browser
	 */
	private function CreateSession($id,$username,$remember,$error=false)
	{

		session_name('SocialPlusLogin');

		//Create Cookie for two weeks
		session_set_cookie_params(2*7*24*60*60);
		session_start();
		
		//If no error, store user information in the session
		if($error==false)
		{
			//Store information about user in session
			$_SESSION['user']=$username;
			$_SESSION['id'] = $id;
			$_SESSION['remember'] = $remember;

			//Store remember info in the cookie
			setcookie('SocialPlusLogin',$remember);
		}
		else //If error, store errors in the session
		{
			$_SESSION['msg']['login-error'] = implode('<br/>',$this->user_login_error);
		}

		return $_SESSION;

	}
	
	/**
	 * Cleans the username and email strings from the login form.
	 * 
	 * @param array $login_data Array with the data from the login form.
	 *
	 * @return array $login_data Same parameter array with clean user and email
	 */
	private function LoginClean($login_data)
	{
		//Sanitize information obtained from login form
		$login_data['username']=trim($login_data['username']);
		$login_data['username']=htmlspecialchars($login_data['username']);
		$login_data['remember']=(int)$login_data['remember'];

		return $login_data;

	}
	/**
	 * It sanitizes information from login form, queries database for user data, creates errors
	 * and starts session info
	 * 
	 * @param array $login_data array with login data
	 * 
	 * @return Boolean $status True if login successful, array with login error messages if false
	 */
	public function Login($login_data)
	{
		//Sanitize form data
		$login_data=$this->LoginClean($login_data);

		if(empty($login_data['username']) or empty($login_data['password']))
			$this->user_login_error[]="All fields are required";

		//Get User from database
		$user=$this->DB->GetUser($login_data['username'],$login_data['password']);

		if($user==false)
		{	//Added error if user array is empty
			$this->user_login_error[]="Wrong Username or password";
			//Could not login
			$status=false;
		}
		else
		{
			//Create user session
			$id=$user['id'];
			$this->CreateSession($id,$login_data['username'],$login_data['remember']);

			//Update last signin value of the user
			$this->DB->UpdateLastSignin($id);

			//set user_data in Class variable 
			$this->user_data=$user;
			
			//set user_meta_data in Class variable
			$this->user_meta_data=$this->DB->GetUserMeta($id);
			
			//Login Successful
			return true;
		}

		// If error, create session with error information and userid as 0
		if(!empty($this->user_login_error))
			$this->CreateSession(0,$login_data['username'],$login_data['remember'],true);

		return $this->user_login_error;

	}


	/**
	 *Logs the user out by destroying the session data and usetting the cookie
	 *
	 *@return Boolean True when user is successfully loggedout
	 */
	public function Logout()
	{
		$_SESSION = array();
		session_destroy();
		unset($_COOKIE['SocialPlusLogin']);
		return true;
	}

	/**
	 * Checks if the user is logged in by checking session and cookie data
	 *
	 * @return Boolean True if is logged in, false otherwise
	 */
	public function IsLoggedIn()
	{
		if(isset($_SESSION['id']) && isset($_COOKIE['SocialPlusLogin']))
			return true;
		else return false;
	}

	/**
	 * Follows the user whose user_id is specified in the argument
	 * @param int $user_id User id of the user to follow
	 * @return Boolean True if followed, Array with error messages otherwise
	 */
	public function Follow($user_id)
	{
		//first check if the id we try to follow exists
		if($this->DB->CheckIfIdExists($user_id))
		{	

			//find id of the current user
			$this_user_id=$this->user_data['id'];

			//check if we are trying to follow ourself
			if($user_id==$this_user_id)
			{
				$this->user_follow_error[]='You are trying to follow yourself!';
			}
			else{
					//check if user already follows the other user
					if($this->DB->CheckIfFollows($this_user_id,$user_id))
					{
						$this->user_follow_error[]='You already follow the user!';
					}
					else{
						//Nope. now follow the user
						$followed=$this->DB->StartFollow($this_user_id,$user_id);
						if($followed==false)
							$this->user_follow_error[]='Could not follow!'; //something went wrong
					}
			}
		}
		else{
			//Other user id doesnt exist in the database
			$this->user_follow_error[]='The user you are trying to follow doesnt exist!';
		}
		//If any error did not occur during following
		if(empty($this->user_follow_error))
		{
			return true;
		}
		else return $this->user_follow_error;
	}


	/**
	 * Unfollows the user whose user_id is specified in the argument
	 * @param int $user_id User id of the user to follow
	 * @return Boolean True if unfollowed, array with error messages otherwise
	 */
	public function Unfollow($user_id)
	{
		//first check if the id we try to follow exists
		if($this->DB->CheckIfIdExists($user_id))
		{	

			//find id of the current user
			$this_user_id=$this->user_data['id'];

			//check if we are trying to unfollow ourself
			if($user_id==$this_user_id)
			{
				$this->user_unfollow_error[]='You are trying to unfollow yourself!';
			}
			else{
					//check if user already follows the other user
					if(!$this->DB->CheckIfFollows($this_user_id,$user_id))
					{
						$this->user_unfollow_error[]='You don\'t follow the user!';
					}
					else{
						//Nope. now follow the user
						$followed=$this->DB->StartUnfollow($this_user_id,$user_id);
						if($followed==false)
							$this->user_unfollow_error[]='Could not unfollow!'; //something went wrong
					}
			}
		}
		else{
			//Other user id doesnt exist in the database
			$this->user_unfollow_error[]='The user you are trying to unfollow doesnt exist!';
		}
		//If any error did not occur during following
		if(empty($this->user_unfollow_error))
		{
			return true;
		}
		else return $this->user_unfollow_error;
	}

	public function GetFollowingUsers()
	{
		$following=$this->DB->FollowingList($this->user_data['id']);
		return $following;
	}

	public function GetFollowers()
	{
		$followers=$this->DB->FollowerList($this->user_data['id']);
		return $followers;
	}
	


}


?>