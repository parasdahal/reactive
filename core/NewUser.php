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
 * NewUser: This class creates a new user, handles activation etc.
 */
class NewUser{
	
	/**
	 * Array Containing Messages related to the signup error
	 * @var array
	 */
	public $user_signup_error=array();

	private $DB;

	public function __construct()
	{
		//Establish connection to the database
		$this->DB= DB::getInstance();
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
			return $create;
		}
		else
			return $this->user_signup_error;

	}

	public function AddMeta($userid,$meta)
	{
		foreach($meta as $key => $value)
		{
			$this->DB->AddMeta($userid,$key,$value);
		}
	}

}


?>