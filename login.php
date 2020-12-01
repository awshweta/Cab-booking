<?php 
require_once("User.php");
require_once("Ride.php");
require_once("DbConnect.php");
if(isset($_POST['submit'])) {
	$username = isset($_POST['username']) ? $_POST['username'] :'';
	$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
	$db = new DbConnect();
	$user = new User();
	$ret = $user->login($username , $pass , $db->conn);
	if($ret['success'] != "") {
		if($ret['admin'] == "yes") {
			header("Location:adminDashboard.php");
		}
		if($ret['admin'] == "no") {
			if(isset($_SESSION['ride'])) {
				$pickup = isset($_SESSION['ride']['pickup']) ? $_SESSION['ride']['pickup'] :'';
				$drop =isset($_SESSION['ride']['drop']) ? $_SESSION['ride']['drop'] : '';
				$wt = isset($_SESSION['ride']['wt']) ? $_SESSION['ride']['wt'] : '';
				$distance =isset($_SESSION['ride']['distance']) ? $_SESSION['ride']['distance'] : '';
				$cab =isset($_SESSION['ride']['cab']) ? $_SESSION['ride']['cab'] : '';
				$fare = isset($_SESSION['ride']['fare']) ? $_SESSION['ride']['fare'] : '';
				$db = new DbConnect();
				$ride = new Ride();
				$arr = $ride->booking($pickup , $drop ,$cab ,$wt ,$distance , $fare ,$db->conn);
			}
			header("Location:customerDashboard.php");
		}
	}
	else {
		echo '<p id="error">'.$ret['error'].'<p>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		Login
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="wrapper">
		<div id="form">
			<h2>Login</h2>
			<form action="" method="post">
				<p>
					<label for="username">Username: <input type="text"  value="<?php isset($_COOKIE["username"]) ? $_COOKIE["username"] :""; ?>" name="username" required></label>
				</p>
				<p>
					<label for="password">Password: <input type="password" class="pass" name="pass" required></label>
				</p>
				<p>
					<input type="submit" class="login" name="submit" value="Login">
				</p>
			</form>
			<span class="btn">Don't have an account?<a  href="register.php">Sign up</a></span>
		</div>
	</div>
</body>
</html>