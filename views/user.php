<?php 

require_once('core/User.php');
	
$url=explode('/',$_SERVER['REQUEST_URI']);
$user= new \socialplus\core\User();
$id=$user->GetIdByUsername($url[2]);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf=8"/>
	<title>Social+ | Your Profile </title>
	<!--SocialPlus Files-->
	<link rel="stylesheet" href="assets/css/main.css"/>
	<script type="text/javascript" src="lib/jquery.min.js"></script>
	<!-- Bootstrap Libraries -->
	<link rel="stylesheet" href="assets/css/bootstrap.css"/>
	<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>	
</head>
<body style="overflow-x:hidden">

	<!-- React Libraries -->
	<script type="text/javascript" src="lib/react/build/react.js"></script>
	<script type="text/javascript" src="lib/react/JSXTransformer.js"></script>
	<!--React Componentes -->

	<script type="text/jsx" src="views/components/home.jsx"></script>
	<script type="text/jsx" src="views/components/header.jsx"></script>
	<script type="text/jsx" src="views/components/feed.jsx"></script>
	<script type="text/jsx" src="views/components/status.jsx"></script>
	<script type="text/jsx" src="views/components/comment.jsx"></script>
	<script type="text/jsx" src="views/components/vote.jsx"></script>
	<script type="text/jsx" src="views/components/badge.jsx"></script>
	<script type="text/jsx" src="views/components/user.jsx"></script>
			<script type="text/jsx" src="views/components/statusBox.jsx"></script>

	<script type="text/jsx">
	
		React.render(<User id="<?php echo $id ?>" />,document.body);
			
	</script>

</body>
</html>