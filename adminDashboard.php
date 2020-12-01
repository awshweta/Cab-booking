<?php 
require_once("Location.php");
require_once("DbConnect.php");
require_once("Ride.php");
require_once("User.php");
$r = false;
if($_SESSION['user']['role']==1) {
$db = new DbConnect();
$location = new Location();
$user = new User();
$ride = new Ride();
if(isset($_POST['submit'])) {
	$name = isset($_POST['name']) ? $_POST['name'] :'';
	$distance = isset($_POST['distance']) ? $_POST['distance'] : '';
	$ret = $location->add($name , $distance , $db->conn);
	echo '<script>alert($ret);</script>';
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
		Dashboard
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
	<div>
		<header>
			<h1>Admin</h1>
		</header>
		<div id="mid">
			<div id="section">
				<nav>
					<ul id="navbar">
						<li><a class="" href="adminDashboard.php">Dashboard</a></li>
						<dl><dt><b>Ride</b></dt></dl>
						<li><a class="request">Pending Ride</a></li>
						<li><a class="allowRide">completed Ride</a></li>
						<li><a class="cancelRequest">cancelled Ride</a></li>
						<li><a class="ride">All Ride</a></li>
						<dl><dt><b>Users</b></dt></dl>
						<li><a class="blocked">Pending User request</a></li>
						<li><a class="approvedUser">Approved User request</a></li>
						<li><a class="alluser">All User</a></li>
						<dl><dt><b>Location</b></dt></dl>
						<li><a class="addlocation">Add Location</a></li>
						<li><a class="getlocation">Location list</a></li>
						<dl><dt><b>Account</b></dt></dl>
						<li><a class="changePass">Change Password</a></li>
						<li><a href="logout.php">LOGOUT</a></li>
					</ul>
				</nav>
			</div>
			<div id="aside">
				<div class="sort"></div>
				<div class="detail">
					<div class="tiles">
						<div class="part">
							<p>Total Ride</p>
							<p class="sec">
								<?php
								if($totalRide->num_rows >= 0) {
									echo $totalRide->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="ride">More info</a></p>
						</div>
						<div class="part">
							<p>Pending Ride</p>
							<p class="sec">
								<?php
								if($pendingRide->num_rows >= 0) {
									echo $pendingRide->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="request">More info</a></p>
						</div>
						<div class="part">
							<p>Completed Ride</p>
							<p class="sec">
								<?php
								if($completedRide->num_rows >= 0) {
									echo $completedRide->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="allowRide">More info</a></p>
						</div>
						<div class="part">
							<p>Cancelled Ride</p>
							<p class="sec">
								<?php
								if($cancelledRide->num_rows >= 0) {
									echo $cancelledRide->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="cancelRequest">More info</a></p>
						</div>
					</div>
					<div class="tiles">
						<div class="part">
							<p>Pending User</p>
							<p class="sec">
								<?php
								if($pendingUser->num_rows >= 0) {
									echo $pendingUser->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="blocked">More info</a></p>
						</div>
						<div class="part">
							<p>Approved User</p>
							<p class="sec">
								<?php
								if($approvedUser->num_rows >= 0) {
									echo $approvedUser->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="approvedUser">More info</a></p>
						</div>
						<div class="part">
							<p>All User</p>
							<p class="sec">
								<?php
								if($allUser->num_rows >= 0) {
									echo $allUser->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="alluser">More info</a></p>
						</div>
						<div class="part">
							<p>Location List</p>
							<p class="sec">
								<?php
								if($arr->num_rows > 0) {
									echo $arr->num_rows;
								}?>
							</p>
							<p class="lnk"><a class="getlocation">More info</a></p>
						</div>
					</div>
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
else {
	header("Location:login.php");
}
?>