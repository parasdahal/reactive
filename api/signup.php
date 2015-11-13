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

namespace socialplus\api;

require_once('../core/NewUser.php');
require_once('../core/User.php');

if(isset($_POST['username']) and isset($_POST['password']) and isset($_POST['email']) )
{

	$newuser = new \socialplus\core\NewUser();

	$signup=array(
	'username'=>$_POST['username'],
	'password'=>$_POST['password'],
	'email'=>$_POST['email']
	);
		
	$result=$newuser->Signup($signup);

	if(is_array($result))
	{
		echo json_encode($result);
	}
	else
		echo $result;
}
if(isset($_POST['firstname']) and isset($_POST['username']) and isset($_POST['lastname']) and isset($_POST['bio']) and isset($_POST['propic']) )
{

	$newuser = new \socialplus\core\NewUser();
	$user = new \socialplus\core\User();
	$userid=$user->GetIdByUsername($_POST['username']);
	$user->user_data['id']=$userid;
	$user->Follow(11);
	$user->Follow(1);
	$meta=array(
	'firstname'=>$_POST['firstname'],
	'lastname'=>$_POST['lastname'],
	'bio'=>$_POST['bio'],
	'propic'=>$_POST['propic']
	);
	
	$result=$newuser->AddMeta($userid,$meta);

	if(is_array($result))
	{
		echo json_encode($result);
	}
	else
		echo 1;
}



?>