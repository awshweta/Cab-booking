<?php 
require_once("Location.php");
require_once("DbConnect.php");
require_once("Ride.php");
require_once("User.php");
$r = false;
$ret = "";
if (isset($_SESSION['user'])) {
	if($_SESSION['user']['role'] == 0) {
		header("Location:customerDashboard.php");
	}
}
else {
	$r = false;
}
if(isset($_SESSION['user'])) {
	if($_SESSION['user']['role']==1) {
		$db = new DbConnect();
		$location = new Location();
		$user = new User();
		$ride = new Ride();
		if(isset($_POST['submit'])) {
			$name = isset($_POST['name']) ? trim($_POST['name']) :'';
			$distance = isset($_POST['distance']) ? $_POST['distance'] : '';
			if(preg_match('/^([a-zA-Z]+\s?)*$/', $name)) { 
				$name =trim($_POST['name']);
				$r = false;
			}
			else {
				$r = true;
				echo '<script>alert("please enter character only");</script>';
			}
			if($r == false) {
				$ret = $location->add($name , $distance , $db->conn);
				if($ret['success'] !=""){
					echo '<script>alert("'.$ret['success'].'");</script>';
				}
				else {
					echo '<script>alert("'.$ret['error'].'");</script>';
				}
			}
		}
		$data = array();
		$arr = $location->getAvailableLocation($db->conn);
		$totalRide = $ride->fetchRide($db->conn);
		$pendingRide = $ride->fetchRideRequest($db->conn);
		$completedRide = $ride->fetchApprovedRide($db->conn);
		$cancelledRide = $ride->fetchCancelRide($db->conn);
		$pendingUser = $user->fetchBlockedUser($db->conn);
		$approvedUser = $user->fetchApprovedUser($db->conn);
		$allUser = $user->fetchAllUser($db->conn);
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<title>
				Admin Dashboard
			</title>
			<link rel="stylesheet" type="text/css" href="style.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://kit.fontawesome.com/a076d05399.js"></script>
		</head>
		<body>
			<div>
				<header>
					<h1><span class="a">CED<span class="b">CAB</span></span></h1>
					<nav>
						<ul>
							<li><a href="logout.php">Logout</a></li>
							<li><a><?php echo "Hi ".ucfirst($_SESSION['user']['user_name']); ?></a></li>
						</ul>
					</nav>
				</header>
				<div id="mid">
					<div id="section">
						<nav>
							<ul id="navbar">
								<li><a class="btn active" href="adminDashboard.php">Dashboard</a></li>
								<dl><dt><b>Ride</b></dt></dl>
								<li><a class="request btn">Pending Ride</a></li>
								<li><a class="allowRide btn">completed Ride</a></li>
								<li><a class="cancelRequest btn">cancelled Ride</a></li>
								<li><a class="ride btn">All Ride</a></li>
								<dl><dt><b>Users</b></dt></dl>
								<li><a class="blocked btn">Pending User request</a></li>
								<li><a class="approvedUser btn">Approved User request</a></li>
								<li><a class="alluser btn">All User</a></li>
								<dl><dt><b>Location</b></dt></dl>
								<li><a class="addlocation btn">Add Location</a></li>
								<li><a class="getlocation btn">Location list</a></li>
								<dl><dt><b>Account</b></dt></dl>
								<li><a class="changePass btn">Change Password</a></li>
								<li><a href="logout.php">LOGOUT</a></li>
							</ul>
						</nav>
					</div>
					<div id="aside">
						<div class="sort"></div>
						<div class="detail">
							<div class="tiles">
								<div class="part ride">
									<p>Total Ride</p>
									<p class="sec">
										<?php
										if($totalRide->num_rows >= 0) {
											echo $totalRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part request">
									<p>Pending Ride</p>
									<p class="sec">
										<?php
										if($pendingRide->num_rows >= 0) {
											echo $pendingRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part allowRide">
									<p>Completed Ride</p>
									<p class="sec">
										<?php
										if($completedRide->num_rows >= 0) {
											echo $completedRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part cancelRequest">
									<p>Cancelled Ride</p>
									<p class="sec">
										<?php
										if($cancelledRide->num_rows >= 0) {
											echo $cancelledRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
							</div>
							<div class="tiles">
								<div class="part blocked">
									<p>Pending User</p>
									<p class="sec">
										<?php
										if($pendingUser->num_rows >= 0) {
											echo $pendingUser->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part approvedUser">
									<p>Approved User</p>
									<p class="sec">
										<?php
										if($approvedUser->num_rows >= 0) {
											echo $approvedUser->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part alluser">
									<p>All User</p>
									<p class="sec">
										<?php
										if($allUser->num_rows >= 0) {
											echo $allUser->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part getlocation">
									<p>Location List</p>
									<p class="sec">
										<?php
										if($arr->num_rows > 0) {
											echo $arr->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
							</div>
							<div id="lastRide"></div>
						</div>
					</div>
				</div>
				<footer>
					<p>copyright @2020</p>
				</footer>
			</div>
			<script src="admin.js"></script>
		</body>
		</html>
	<?php }
}
else {
	header("Location:login.php");
}
?>