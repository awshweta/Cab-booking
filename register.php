<?php 
require_once("User.php");
require_once("DbConnect.php");
$r = false;
$error ="";
$usernameErr="";
$nameErr = "";
$mobileErr ="";
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
if(isset($_POST['submit'])) {
	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
	$name = isset($_POST['name']) ? trim($_POST['name']) : '';
	$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
	$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

	if(preg_match('/^([a-zA-Z]+\s?)*$/', $name)) { 
		$name =trim($_POST['name']);
	}
	else {
		$nameErr ="please enter alphabet character only and more than one space are not allow between word";
	}
	if (preg_match ("/^[a-zA-z]*$/", $username) ) { 
		$username = trim($_POST['username']);
	} 
	else { 
		$username = trim($_POST['username']);
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		if (!preg_match ($pattern, $username) ) {  
			$usernameErr = "Please enter character only or follow name@example.com format";
		}  
	}  
	if(!empty($mobile)){
		if(preg_match('/^\d{10}$/',$mobile)){
			$mobile = trim($_POST['mobile']);
		}
		else {
			$mobileErr = "Please enter 10 digit mobile number !";
		}
	}
	if($nameErr == "" && $usernameErr == "" && $mobileErr =="") {
		$db = new DbConnect();
		$user = new User();
		$ret = $user->register($username ,$name ,$pass ,$mobile , $db->conn);
		echo '<script>alert("'.$ret.'");</script>';
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
						<li><a href="login.php">Login</a></li>
					<?php } ?>
				</ul>
			</nav>
		</header>
	</div>
	<div id="wrapper">
		<div id="form">
			<h2 id="heading">Register</h2>
			<form action="" method="POST">
				<p><label for="username">Username: <input type="text" class="username" name="username" required></label></p>
				<span class="error"><?php echo $usernameErr;?></span>
				<p><label for="name">name: <input type="text" class="name" name="name" required></label></p>
				<span class="error"><?php echo $nameErr;?></span>
				<p><label for="password">Password: <input type="password" name="pass" required></label></p>
				<p><label for="name">Mobile : <input type="number" class="mobile" name="mobile" required></label></p>
				<span class="error"><?php echo $mobileErr;?></span>
				<p>
					<input type="submit" name="submit" class="register" value="Register">
				</p>
			</form>
			<span class="btn">Already have an account?<a  href="login.php">Login here</a></span>
		</div>
	</div>
	<footer>
		<p>copyright @2020</p>
	</footer>
</body>
</html>