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
class Post
{
	private $user_id;

	private $DB;

	public function __construct(User $user)
	{
		//Get user id
		$this->user_id=$user->user_data['id'];
		
		//Establish connection to the database
		$this->DB= DB::getInstance();
	}

	public function UserFeed()
	{
		$posts=$this->DB->GetUserFeedPosts($this->user_id);

		$feed=array();
		$count=0;
		foreach($posts as $post)
		{	
			$feed[$count]['post']=$post;

			//get user for this post
			$user=$this->DB->GetUserMeta($post['user_id']);
			$username=$this->DB->GetUsernameById($post['user_id']);
			//get votes for this post
			$votes=$this->DB->GetPostVotes($post['id']);
			//get comments for this post
			$comments=$this->DB->GetPostComments($post['id']);
			

			//add user to feed posts
			if($user!=false){
				$feed[$count]['usermeta']=$user;
				$feed[$count]['usermeta']['username']=$username['username'];
			}
			else
				$feed[$count]['usermeta']=array();

			//add votes to feed posts
			if($votes!=false)
				$feed[$count]['votes']=$votes;
			else
				$feed[$count]['votes']=array();

			//add comments to feed votes
			if($comments!=false)
				$feed[$count]['comments']=$comments;
			else
				$feed[$count]['comments']=array();
			
			$count++;
		}
		return $feed;
	}

	public function UserTimeline()
	{
		$posts=$this->DB->GetUserTimelinePosts($this->user_id);
		
		$feed=array();
		$count=0;
		foreach($posts as $post)
		{	
			$feed[$count]['post']=$post;
			//get user for this post
			$user=$this->DB->GetUserMeta($post['user_id']);
			
			$username=$this->DB->GetUsernameById($post['user_id']);
			//get votes for this post
			$votes=$this->DB->GetPostVotes($post['id']);
			//get comments for this post
			$comments=$this->DB->GetPostComments($post['id']);
			
			//add user to feed posts
			if($user!=false){
				$feed[$count]['usermeta']=$user;
				$feed[$count]['usermeta']['username']=$username['username'];
			}
			else
				$feed[$count]['usermeta']=array();

			//add votes to feed posts
			if($votes!=false)
				$feed[$count]['votes']=$votes;
			else
				$feed[$count]['votes']=array();

			//add comments to feed votes
			if($comments!=false)
				$feed[$count]['comments']=$comments;
			else
				$feed[$count]['comments']=array();
			
			$count++;
		}
		return $feed;
	}


}

?>