<?php
require_once("Location.php");
require_once("DbConnect.php");
require_once("Ride.php");
require_once("User.php");
if($_SESSION['user']['role'] == 0) {
	if(isset($_SESSION['ride'])) {
		echo '<script>alert("Booked successfully");</script>';
		unset($_SESSION['ride']);
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
			Dashboard
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	</head>
	<body>
		<div>
			<header>
				<h1>CEDCAB</h1>
			</header>
			<div id="midCustomer">
				<div id="sectionCustomer">
					<nav>
						<ul id="nav">
							<li><a class="" href="customerDashboard.php">Home</a></li>
							<dl><dt><b>Ride</b></dt></dl>
							<li><a href="index.php">Book new Ride</a></li>
							<li><a class="request">Pending Rides</a></li>
							<li><a class="allowRide">completed Ride</a></li>
							<li><a class="ride">All Ride</a></li>
							<dl><dt><b>Account</b></dt></dl>
							<li><a class="updateuser">Update information</a></li>
							<li><a class="changePass">Change Password</a></li>
							<li><a href="logout.php">LOGOUT</a></li>
						</ul>
					</nav>
				</div>
				<div id="aside">
					<div class="sort"></div>
					<div class="detail">
						<div class="tilesCustomer">
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
								<p>Total Spent</p>
								<p class="sec">
									<?php
									$total = 0;
									if($completedRide->num_rows > 0) {
										while($row = $completedRide->fetch_assoc()){
											if($row['status'] == 2) {
												//var_dump($row['totalfare']);
												$total += $row['totalfare'];
											}
										}
										echo $total;
									}?>
								</p>
								<p class="lnk"><a>More info</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer>
				<p>copyright @2020</p>
			</footer>
		</div>
		<script>
			function allCustomerRide(msg) {
				var html = '';
				html += '<table class="tbl">'+
				'<tr>'+
				'<th>From</th>'+
				'<th>To</th>'+
				'<th>Cab_Type</th>'+
				'<th>Date<i class="asc fas fa-arrow-alt-circle-up"></i><i class="desc fas fa-arrow-alt-circle-down"></i></th>'+
				'<th>Totaldistance</th>'+
				'<th>Luggage</th>'+
				'<th>Totalfare<i class="ascfare fas fa-arrow-alt-circle-up"></i><i class="descfare fas fa-arrow-alt-circle-down"></i></th>'+
				'<th>Status</th>'+
				'<th>Action</th>'+
				'</th>'+
				'</tr>';
				var status ="";
				var total = 0;
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['status']== 1) {
						status = "Pending";
					}
					else if(msg[i]['status'] == 2){
						status = "completed";
					}
					else {
						status = "cancelled";
					}
					html +='<tr>'+
					'<td>'+msg[i]['from']+'</td>'+
					'<td>'+msg[i]['to']+'</td>'+
					'<td>'+msg[i]['cab_type']+'</td>'+
					'<td>'+msg[i]['date']+'</td>'+
					'<td>'+msg[i]['totaldistance']+'</td>'+
					'<td>'+msg[i]['luggage']+'</td>'+
					'<td>'+msg[i]['totalfare']+'</td>'+
					'<td>'+status+'</td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="deleteRide" value="delete"></td>'+
					'</tr>';
				}
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['status'] == 2) {
						total = total + parseInt(msg[i]['totalfare']);
					}
				}
				html +='</table>';
				$(".detail").html(html);
				$(".detail").append("<b>Total Price:</b>"+total);
				html +='</table>';

			}
			function customerCompletedRide(msg) {
				var html = '';
				html += '<table class="tbl">'+
				'<tr>'+
				'<th>From</th>'+
				'<th>To</th>'+
				'<th>Cab_Type</th>'+
				'<th>Date<i class="ascComp fas fa-arrow-alt-circle-up"></i><i class="descComp fas fa-arrow-alt-circle-down"></i></th>'+
				'<th>Totaldistance</th>'+
				'<th>Luggage</th>'+
				'<th>Totalfare<i class="ascCompfare fas fa-arrow-alt-circle-up"></i><i class="descCompfare fas fa-arrow-alt-circle-down"></i></th>'+
				'<th>Status</th>'+
				'<th>Action</th>'+
				'</tr>';
				var status ="";
				var total = 0;
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['status']== 1) {
						status = "Pending";
					}
					else if(msg[i]['status'] == 2){
						status = "completed";
					}
					else {
						status = "cancelled";
					}
					html +='<tr>'+
					'<td>'+msg[i]['from']+'</td>'+
					'<td>'+msg[i]['to']+'</td>'+
					'<td>'+msg[i]['cab_type']+'</td>'+
					'<td>'+msg[i]['date']+'</td>'+
					'<td>'+msg[i]['totaldistance']+'</td>'+
					'<td>'+msg[i]['luggage']+'</td>'+
					'<td>'+msg[i]['totalfare']+'</td>'+
					'<td>'+status+'</td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="deleteRide" value="delete"></td>'+
					'</tr>';
				}
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['status'] == 2) {
						total = total + parseInt(msg[i]['totalfare']);
					}
				}
				html +='</table>';

				$(".detail").html(html);
				$(".detail").append("<b>Total Price:</b>"+total);
				html +='</table>';

			}
			function customerPendingRide(msg) {
				var html = '';
				html += '<table class="tbl">'+
				'<tr>'+
				'<th>From</th>'+
				'<th>To</th>'+
				'<th>cab_type</th>'+
				'<th>Date</th>'+
				'<th>Totaldistance</th>'+
				'<th>Luggage</th>'+
				'<th>Totalfare</th>'+
				'<th>Status</th>'+
				'</tr>';
				var status = '';
				var total = 0;
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['status']== 1) {
						status = "Pending";
					}
					else if(msg[i]['status'] == 2){
						status = "completed";
					}
					else {
						status = "cancelled";
					}
					html +='<tr>'+
					'<td>'+msg[i]['from']+'</td>'+
					'<td>'+msg[i]['to']+'</td>'+
					'<td>'+msg[i]['cab_type']+'</td>'+
					'<td>'+msg[i]['date']+'</td>'+
					'<td>'+msg[i]['totaldistance']+'</td>'+
					'<td>'+msg[i]['luggage']+'</td>'+
					'<td>'+msg[i]['totalfare']+'</td>'+
					'<td>'+status+'</td>'+
					'</tr>';
				}
				html +='</table>';
				$(".detail").html(html);

			}
			$('.detail').on("click" , '.update' ,function() {
				var name = $('.name').val();
				var mobile = $('#mobile').val();
				if(!$('#mobile').val().match('[0-9]{10}'))  {
					alert("Please put 10 digit mobile number");
				}
				else {  
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ name:name ,mobile:mobile , action :'updateUserInfo' },
						dataType: "JSON",
						success:function( msg ) {
							alert(msg.user);
						},
						error:function() {
							alert("error");
						}
					});	
				}
			});
			$('.detail').on("click" , '.save' ,function() {
				var oldPass = $('.oldPass').val().trim();
				var newPass = $('.newPass').val().trim();
				if(oldPass !="" && newPass !="") {
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ oldPass:oldPass ,newPass:newPass , action :'savePass' },
						dataType: "JSON",
						success:function( msg ) {
							if(msg.success !="") {
								window.location.href = "login.php";
							}
							else {
								alert(msg.error);
							}
						},
						error:function() {
							alert("error");
						}
					});	
				}
				else {
					alert("Please enter password.");
				}
			});
			$('.detail').on("click" , '.asc' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'ascRide' },
					dataType: "JSON",
					success:function( msg ) {
						allCustomerRide(msg);
					},
					error:function() {
						alert("error");
					}
				});
			});
			$('.detail').on("click" , '.ascComp' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'ascCompDate' },
					dataType: "JSON",
					success:function( msg ) {
						customerCompletedRide(msg);
					},
					error:function() {
						alert("error");
					}
				});
			});
			$('.detail').on("click" , '.ascCompfare' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'ascCompfare' },
					dataType: "JSON",
					success:function( msg ) {
						customerCompletedRide(msg);
					},
					error:function() {
						alert("error");
					}
				});
			});
			$('.detail').on("click" , '.descCompfare' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'descCompfare' },
					dataType: "JSON",
					success:function( msg ) {
						customerCompletedRide(msg);
					},
					error:function() {
						alert("error");
					}
				});
			});
			$('.detail').on("click" , '.descComp' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'descCompDate' },
					dataType: "JSON",
					success:function( msg ) {
						customerCompletedRide(msg);
					},
					error:function() {
						alert("error");
					}
				});
			});
			$('.detail').on("click" , '.ascfare' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'ascallfare'},
					dataType: "JSON",
					success:function( msg ) {
						allCustomerRide(msg);
					},
					error:function() {
						alert("error");
					}
				});	
			});
			$('.detail').on("click" , '.desc' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'descDate' },
					dataType: "JSON",
					success:function( msg ) {
						allCustomerRide(msg);
					},
					error:function() {
						alert("error");
					}
				});	
			});
			$('.detail').on("click" , '.descfare' ,function() {
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{action :'descCustomerfare' },
					dataType: "JSON",
					success:function( msg ) {
						allCustomerRide(msg);
					},
					error:function() {
						alert("error");
					}
				});	
			});
			$('.sort').on("click" , '.sort' ,function() {
				var val = $(this).val();
				console.log(val);
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{val:val,action :'sortCustomerAllRide' },
					dataType: "JSON",
					success:function( msg ) {
						allCustomerRide(msg);
					},
					error:function() {
						alert("error");
					}
				});	
			});
			$('.sort').on("click" , '.sortCompletedRide' ,function() {
				var val = $(this).val();
				console.log(val);
				$.ajax({
					type: "POST",
					url: "request.php",
					data:{val:val,action :'sortCustomerCompletedRide' },
					dataType: "JSON",
					success:function( msg ) {
						customerCompletedRide(msg);
					},
					error:function() {
						alert("error");
					}
				});	
			});
			$(document).ready(function(){
				$('.request').click(function(){
					$('.sort').html("");
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ action :'pendingRequest' },
						dataType: "JSON",
						success:function( msg ) {
							customerPendingRide(msg);
						},
						error:function() {
							alert("error");
						}
					});		
				});
				$('.ride').click(function(){
					var html="";
					html +='<label for="sort">Sort:</label>'+
					'<select name="sort" class="sort">'+
					'<option selected disabled>Choose</option>'+
					'<option value="CedMicro">CedMicro</option>'+
					'<option value="CedMini">CedMini</option>'+
					'<option value="CedRoyal">CedRoyal</option>'+
					'<option value="CedSUV">CedSUV</option>'+
					'<option value="LastWeek">LastWeek</option>'+
					'<option value="LastMonth">LastMonth</option>'+
					'</select>';
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ action :'allride' },
						dataType: "JSON",
						success:function( msg ) {
							$(".sort").html(html);
							allCustomerRide(msg);
						},
						error:function() {
							alert("error");
						}
					});		
				});
				$('.allowRide').click(function(){
					var html="";
					html +='<label for="sort">Sort:</label>'+
					'<select name="sort" class="sortCompletedRide">'+
					'<option selected disabled>Choose</option>'+
					'<option value="CedMicro">CedMicro</option>'+
					'<option value="CedMini">CedMini</option>'+
					'<option value="CedRoyal">CedRoyal</option>'+
					'<option value="CedSUV">CedSUV</option>'+
					'<option value="LastWeek">LastWeek</option>'+
					'<option value="LastMonth">LastMonth</option>'+
					'</select>';
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ action :'completedRide' },
						dataType: "JSON",
						success:function( msg ) {
							$(".sort").html(html);
							customerCompletedRide(msg);
						},
						error:function() {
							alert("error");
						}
					});		
				});
				$('.updateuser').click(function(){
					$('.sort').html("");
					var html ='';
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ action :'updateUser' },
						dataType: "JSON",
						success:function( msg ) {
							for (var i = 0; i < msg.length; i++) {
								html = '<div class="form">'+
								'<p>Username : '+msg[i]['user_name']+'</p>'+
								'<p>Name : <input type="text" name="name" class="name" value="'+msg[i]['name']+'" required></p>'+
								'<p>Mobile No: <input type="tel" minlength="10" maxlength="10" id="mobile" name="mobile" value='+msg[i]['mobile']+' title="10 digit mobile number" required></p>'+
								'<p><input type="button" name="update" class="update" value="update"></p>'+
								'</div>';
							}
							$(".detail").html(html);
						},
						error:function() {
							alert("error");
						}
					});		
				});
				$('.changePass').click(function(){
					var html ='';
					$('.sort').html("");
					$.ajax({
						type: "POST",
						url: "request.php",
						data:{ action :'updateUser' },
						dataType: "JSON",
						success:function( msg ) {
							for (var i = 0; i < msg.length; i++) {
								html = '<div class="form">'+
								'<p>Username : '+msg[i]['user_name']+'</p>'+
								'<p>Old Password : <input type="password" name="oldPass" class="oldPass" required></p>'+
								'<p>new Password : <input type="password" name="newPass" class="newPass" required></p>'+
								'<p><input type="button" name="save" class="save" value="update"></p>'+
								'</div>';
							}
							$(".detail").html(html);
						},
						error:function() {
							alert("error");
						}
					});		
				});
			});
		</script>
	</body>
	</html>
<?php }
else {
	header("Location:login.php");
}
?>