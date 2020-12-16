<?php
require_once("Location.php");
require_once("DbConnect.php");
require_once("Ride.php");
require_once("User.php");
$r = false;
if (isset($_SESSION['user'])) {
	if($_SESSION['user']['role'] == 1) {
		header("Location:adminDashboard.php");
	}
}
else {
	$r = false;
}
if(isset($_SESSION['user'])) {
	if($_SESSION['user']['role'] == 0) {
		if(isset($_SESSION['ride'])) {
			if($_SESSION['ride'] != "" ) {
				echo '<script>alert("Booked successfully");</script>';
				unset($_SESSION['ride']);
			}
		}
		$db = new DbConnect();
		$ride = new Ride();
		$totalRide = $ride->fetchallRide($db->conn);
		$pendingRide = $ride->fetchPendingRequest($db->conn);
		$completedRide = $ride->fetchCompletedRide($db->conn);?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<title>
				Customer Dashboard
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
							<li><a href="index.php">Book New ride</a></li>
							<li><a href="logout.php">Logout</a></li>
							<li><a><?php echo "Hi ".ucfirst($_SESSION['user']['user_name']); ?></a></li>
						</ul>
					</nav>
				</header>
				<div id="midCustomer">
					<div id="sectionCustomer">
						<nav>
							<ul id="nav">
								<li><a class="btn active" href="customerDashboard.php">Home</a></li>
								<dl><dt><b>Ride</b></dt></dl>
								<li><a href="index.php">Book new Ride</a></li>
								<li><a class="request btn">Pending Rides</a></li>
								<li><a class="allowRide btn">completed Ride</a></li>
								<li><a class="ride btn">All Ride</a></li>
								<dl><dt><b>Account</b></dt></dl>
								<li><a class="updateuser btn">Update information</a></li>
								<li><a class="changePass btn">Change Password</a></li>
								<li><a href="logout.php">LOGOUT</a></li>
							</ul>
						</nav>
					</div>
					<div id="aside">
						<div class="sort"></div>
						<div class="detail">
							<div class="tilesCustomer nav">
								<div class="part ride btn">
									<p>Total Ride</p>
									<p class="sec">
										<?php
										if($totalRide->num_rows >= 0) {
											echo $totalRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a>More info</a></p>
								</div>
								<div class="part request btn">
									<p>Pending Ride</p>
									<p class="sec">
										<?php
										if($pendingRide->num_rows >= 0) {
											echo $pendingRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part allowRide btn">
									<p>Completed Ride</p>
									<p class="sec">
										<?php
										if($completedRide->num_rows >= 0) {
											echo $completedRide->num_rows;
										}?>
									</p>
									<p class="lnk"><a class="">More info</a></p>
								</div>
								<div class="part">
									<p>Total Spent</p>
									<p class="sec">
										<?php
										$total = 0;
										if($completedRide->num_rows >= 0) {
											while($row = $completedRide->fetch_assoc()){
												if($row['status'] == 2) {
												//var_dump($row['totalfare']);
													$total += $row['totalfare'];
												}
											}
											echo $total." Rs.";
										}?>
									</p>
									<p class="lnk"><a>More info</a></p>
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
			<script src="customer.js"></script>
		</body>
		</html>
	<?php }
}
else {
	header("Location:login.php");
}
?>