<?php 
require_once("User.php");
require_once("DbConnect.php");
if(isset($_POST['submit'])) {
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
	$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
	if(!empty($mobile)){
		if(preg_match('/^\d{10}$/',$mobile)){
			$db = new DbConnect();
			$user = new User();
			$ret = $user->register($username ,$name ,$pass ,$mobile , $db->conn);
			echo "<div id='error'>".$ret."</div>";	
		}
		else {
			echo '<script>alert("Please enter 10 digit mobile number !");</script>';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		Register
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="wrapper">
		<div id="form">
			<h2 id="heading">Register</h2>
			<form action="" method="POST">
				<p><label for="username">Username: <input type="text" class="username" name="username" required></label></p>
				<p><label for="name">name: <input type="text" class="name" name="name" required></label></p>
				<p><label for="password">Password: <input type="password" name="pass" required></label></p>
				<p><label for="name">Mobile : <input type="number" class="mobile" name="mobile" required></label></p>
				<p>
					<input type="submit" name="submit" class="register" value="Register">
				</p>
			</form>
			<span class="btn">Already have an account?<a  href="login.php">Login here</a></span>
		</div>
	</div>
</body>
</html>