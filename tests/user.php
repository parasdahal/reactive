<?php

require_once('../core/User.php');

$user = new \socialplus\core\User();

$signup=array(
	'username' => 'parasdahal921',
	'email' => 'see62parasgmail.com',
	'password' => 'sd'
	);

var_dump($user->Signup($signup));

$login=array(
	'username'=>'parasdasahal',
	'password'=>'',
	'remember'=>1
	);

var_dump($user->Login($login));

var_dump($user->IsLoggedIn());
var_dump($user->Logout());
var_dump($user->IsLoggedIn());

?>