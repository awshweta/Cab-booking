<?php 
require_once("User.php");
require_once("Ride.php");
require_once("DbConnect.php");
$r = false;
if (isset($_SESSION['user'])) {
	if($_SESSION['user']['role'] == 1) {
		header("Location:adminDashboard.php");
	}
	else {
		header("Location:customerDashboard.php");
	}
}
else {
	$r = false;
}
$usernameErr="";
if(isset($_POST['submit'])) {
	$r = false;
	$username = isset($_POST['username']) ?  trim($_POST['username']) :'';
	$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
	$db = new DbConnect();
	$user = new User();
	if (preg_match ("/^[a-zA-z]*$/", $username) ) { 
		$username =  trim($_POST['username']);
		$r= false;
	} 
	else { 
		$username =  trim($_POST['username']);
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		if (!preg_match ($pattern, $username) ) {  
			$usernameErr = "Please enter character only or follow name@example.com format";
			$r = true;  
		}  
	} 
	if($r == false) {
		$ret = $user->login($username , $pass , $db->conn);
		if($ret['success'] != "") {
			if($ret['admin'] == "yes") {
				header("Location:adminDashboard.php");
			}
			if($ret['admin'] == "no") {
				if(isset($_SESSION['ride'])) {
					$now = time();
					if ($now > $_SESSION['expire']) {
						unset($_SESSION['ride']);
					}
					else {
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
				}
				header("Location:customerDashboard.php");
			}
		}
		else {
			echo '<script>alert("'.$ret['error'].'");</script>';
		}
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
	<div id="header">
		<header>
			<h1><span class="a">CED<span class="b">CAB</span></span></h1>
			<nav>
				<ul>
					<li><a href="index.php">Book New ride</a></li>
					<?php if(isset($_SESSION['user'])) { ?>
						<li><a href="logout.php">Logout</a></li>
					<?php } 
					else  { ?>
						<li><a href="register.php">Sign up</a></li>
					<?php } ?>
				</ul>
			</nav>
		</header>
	</div>
	<div id="wrapper">
		<div id="form">
			<h2>Login</h2>
			<form action="" method="post">
				<p>
					<label for="username">Username: <input type="text"  value="<?php isset($_COOKIE["username"]) ? $_COOKIE["username"] :""; ?>" name="username" required></label>
				</p>
				<span class="error"><?php echo $usernameErr;?></span>
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
	<footer>
		<p>copyright @2020</p>
	</footer>
</body>
</html>