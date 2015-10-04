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
	 * Array Containing Messages related to the signup error
	 * @var array
	 */
	public $user_signup_error=array();

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
	 * @param string $username Username of the user from the login form
	 * @param string $password Password of the user
	 * @param int $remember Value of remember checkbox from the login form
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
	 * Validates the signup data in the server side. Validates email and username string. Then also
	 * checks if they are already used in the database. Stores errors in the the errors array.
	 * 
	 * @param array $signup_data Array with the data from the signup form
	 *
	 * @return Boolean True if no errors, false if errors in validation
	 */
	private function SignupValidate($signup_data)
	{
		if(strlen($signup_data['username'])<4 || strlen($signup_data['username'])>30)
		{
			$this->user_signup_error[]='Your username must be between 3 and 30 characters!';
		}

		if(preg_match('/[^a-z0-9\-\_\.]+/i',$signup_data['username']))
		{
			$this->user_signup_error[]='Your username contains invalid characters!';
		}


		if($this->DB->CheckIfUsernameExists($signup_data['username']))
		{
			$this->user_signup_error[]='This username is already taken!';	
		}

		if(!filter_var($signup_data['email'],FILTER_VALIDATE_EMAIL))
		{
			$this->user_signup_error[]='Your email is not valid!';
		}

		if($this->DB->CheckIfEmailExists($signup_data['email']))
		{
			$this->user_signup_error[]='This email is already in use!';	
		}

		if(strlen($signup_data['password'])<6)
		{
			$this->user_signup_error[]='Your password must be at least 6 characters!';
		}

		if(empty($this->user_signup_error))
			return true;
		return false;

	}

	/**
	 * Cleans the username and email strings from the signup form.
	 * 
	 * @param array $signup_data Array with the data from the signup form.
	 *
	 * @return array $signup_data Same parameter array with clean user and email
	 */
	private function SignupClean($signup_data)
	{
		$signup_data['username']=trim($signup_data['username']);
		$signup_data['email']=filter_var(trim($signup_data['email']), FILTER_SANITIZE_EMAIL);
		return $signup_data;
	}

	/**
	 * Signsup a user by cleaning the data from registration form, then validating the data
	 * If no errors are present, it will create the user in the database, otherwise returns
	 * array with signup error messages
	 * 
	 * @param array $signup_data Array containing username, email and password
	 *
	 * @return Boolean True if User is registered, array with error messages otherwise
	 */
	public function Signup($signup_data)
	{
		//Clean the form data, remove whitespaces and other chars
		$signup_data=$this->SignupClean($signup_data);
		//if the information submitted is valid
		if($this->SignupValidate($signup_data)){
			//create new user in the database
			$create=$this->DB->CreateUser($signup_data);
			return true;
		}
		else
			return $this->user_signup_error;

	}

}


?>