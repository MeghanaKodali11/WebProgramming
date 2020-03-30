<?php
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['user']) || empty($_POST['password'])) {
	$error = "Username or password is empty";
	}
	else if (!empty($_POST['password'])){
		$password = $_POST['password'];

		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);

		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
		   $error = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
		} else {

			$file=$_POST["user"].'.txt';
			$data=$_POST["password"].";".$_POST["name"]."\n";
			file_put_contents($file, $data,FILE_USE_INCLUDE_PATH | FILE_APPEND);
			$fileoutput=file_get_contents($file);
			header("location: index.php"); // Redirecting To Other Page
		}
		}
	else {
	$error = "Username or Password is invalid";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up Form </title>
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
			<form method="post" autocomplete="on" class="formLayout">
				<input type="text" placeholder="firstname" name="name"><br>
				<input type="text" placeholder="username" name="user"><br>
				<input type="password" placeholder="password" name="password"><br>
				<button type="submit" name="submit">Sign Up</button><br>
				<span><?php echo $error; ?></span>
			</form>
				<div class="signup">Already have a Account?<a href="index.php">Log in</a></div>
		</div>
</body>
</html>