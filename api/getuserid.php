<?php

require_once('../core/User.php');
require_once('../core/NewUser.php');
require_once('../core/Posts.php');

$user = new \socialplus\core\User();
echo $user->GetIdByUsername($_GET['username']);
?>