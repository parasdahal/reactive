<?php

require_once('../core/User.php');
require_once('../core/NewUser.php');
require_once('../core/Posts.php');


$newuser = new \socialplus\core\NewUser();

$user = new \socialplus\core\User();

$signup=array(
	'username' => 'asdasaasdy',
	'email' => 'asdax@gmsail.com',
	'password' => 'demo123'
	);

echo $newuser->Signup($signup);

// $login=array(
// 	'username'=>'ellen',
// 	'password'=>'demo123',
// 	'remember'=>1
// 	);
// print_r($_SESSION);
();

// $feed= new \socialplus\core\Post($user);

// //$user->Follow(15);
// //var_dump($user->Unfollow(3));
// //print_r($user->user_data);
// //var_dump($user->Follow(5));

// var_dump($user->Unvote(52,11));

// //print_r($user->GetFollowers());

// // //print_r($user->GetFollowingUsers());
// print_r($feed->UserFeed());
// //var_dump($user->PostComment(47,11,'Test is done using test.php'));

?>