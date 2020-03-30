<?php /*-----Functions-----*/
session_start();
if(!isset($_SESSION['login_user'])){
header("location: index.php");
}
?>
<!Doctype html>
<html>
<head>
	
	<meta charset="UTF-8"/>
	<title>
		Home Page
	</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="2048.css">
</head>
<body>
	<div class="page1">
		
		<header class="sub">
			<br/>
			<span class="title">
				<strong>
					It's Game Time
				</strong>
			</span>
			
			
			<span class="logout">
			<a href="logout.php" class="button7" >Logout</a>
		</span>
		</header>
		<br/>
		<div class="grid">
			<a href="2048.php">
<img  alt="2048" src="gif.gif" width="410" height="400">
</a>
		</div>
		<div class="grid">
			<a href="puzzle.php">
<img  alt="15 Tiles" src="gif1.gif" width="410" height="400">
</a>
		</div>
		
		
		<br/>
		
		
		
	</div>

	
</body>

</html>