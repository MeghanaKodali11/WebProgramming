<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['user']) || empty($_POST['password'])) {
	$error = "Username or Password is empty";
	}
	else
	{
	// Define $username and $password
	$username=$_POST['user'];
	$password=$_POST['password'];
	$error="username is incorrect"; 
	if (file_exists($username.'.txt')) {
		$error="success1"; 
		$fileoutput=file_get_contents($username.'.txt');
		$str=explode(";",$fileoutput);
	   if ($str[0]== $password) {
		$_SESSION['login_user']=$username;
		$_SESSION['start']=1; 
		$_SESSION['start1']=1;
		$error="Use Username: Guest and Password: Guest123 to Login, as we having sever issues some times"; // Initializing Session
	   }
	   else {
	   	$error = "Password is invalid";
	   }
	}
	/*$file= 'usersdata.txt';
	$fileoutput=file_get_contents($file);
	$token = strtok($fileoutput, "\n");
 
	while ($token !== false)
   	{
	   $str=explode(";",$token);
	   if ($str[0]== $username && $str[1]== $password) {
		$_SESSION['login_user']=$username; // Initializing Session
	   }
	   else {
	   	$error = "Username or Password is invalid";
	   }
	}*/
	}
}
if(isset($_SESSION['login_user'])){
header("location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>
<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Stay Home<br>Saty Safe<br><span>Play a Game</span></div>
		</div>
		<br>
		<div class="login">
			<form method="post"  autocomplete="on" class="formLayout">
				<input type="text" placeholder="username" name="user"><br>
				<input type="password" placeholder="password" name="password"><br>
				<button type="submit" name="submit">Login</button><br>
				<div class="signup"><a href="signup.php">Create a Account</a></div>
				<span><?php echo $error; ?></span>
			</form>
		</div>
</body>
</html>