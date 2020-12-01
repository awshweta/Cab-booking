<?php include_once("DbConnect.php");
$db = new DbConnect();
include_once("Location.php");
$location = new Location();
$data = array();
$arr = $location->getAvailableLocation($db->conn);
$arr1 = $location->getAvailableLocation($db->conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Php task</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="cab.css?=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-sm navbar-expand-sm bg-dark navbar-dark">
			<span class="a bg-dark text-white">CED<span class="b bg-dark text-primary">CAB</span></span>
			<a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</a>
			<div class="n collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item pull-sm-right">
						<a class="nav-link text-white" href="customerDashboard.php">Home</a>
					</li>
					<li class="nav-item pull-sm-right">
						<?php if(isset($_SESSION['user'])) { 
							if($_SESSION['user']['role'] == 0) { ?>
								<a class="nav-link text-white" href="logout.php">Logout</a>
							<?php }
						}
						else { ?>
							<a class="nav-link text-white" href="login.php">Login</a>
						<?php } ?>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="clearfix"></div>
	<div class="container-fluid clearfix content">
		<div class="background"></div>
		<div class="text-center head">
			<h2>Book a city Taxi to your destination in town</h2>
			<p>Choose from a range of categories and price</p>
		</div>
		<div class="row t">
			<div class="left col-lg-4">
				<h1 class="text-center" href="#"><span class="clr">CITY TAXY</span></h1>
				<p class="text-center para"><strong>Your everyday travel partner</strong></p>
				<p class="text-center">AC Cab for point to point travel</p>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<label class="input-group-text" for="inputGroupSelect01">Pickup</label>
					</div>
					<select name="pickup" class="pickup custom-select" id="inputGroupSelect01">
						<option value="" selected>Current location</option>
						<?php
						if($arr->num_rows > 0) {
							while($row = $arr1->fetch_assoc()) {?>
								<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
							<?php }
						}
						?>
					</select>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<label class="input-group-text" for="inputGroupSelect02">Drop</label>
					</div>
					<select name="drop" class="drop custom-select" id="inputGroupSelect02">
						<option value="" selected>Enter drop for ride estimate</option>
						<?php
						if($arr->num_rows > 0) {
							while($row = $arr->fetch_assoc()) {?>
								<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
							<?php }
						}?>
					</select>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<label class="input-group-text" for="inputGroupSelect03">CabType</label>
					</div>
					<select name="cab" class="cab custom-select" id="inputGroupSelect03">
						<option value="" selected>Drop down to select cab type</option>
						<option value="CedMicro">CedMicro</option>
						<option value="CedMini">CedMini</option>
						<option value="CedRoyal">CedRoyal</option>
						<option value="CedSUV">CedSUV</option>
					</select>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="luggage input-group-text">luggage</span>
					</div>
					<input type="text" name="txt" class="txt form-control" placeholder="Enter wt in KG" name="username">
					<p class="err"></p>
				</div>
				<button type="button" name="calculate" class="btn btn-primary mb-3">Calculate fare</button>
			</div>
			<div class="mid"></div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="clearfix footer-content">
		<footer>
			<div class="part row text-white text-center">
				<div class="col-sm-12 col-xl-4 col-md-4 col-lg-4">
					<i class="fab fa-facebook-f"></i>
					<i class="fab fa-twitter"></i>
					<i class="fas fa-camera"></i>
				</div>
				<div class="part col-sm-12 col-xl-4 col-md-4 col-lg-4">
					<span class="a text-white">CED<span class="b text-primary">CAB</span></span>
				</div>
				<div class="part col-sm-12 col-xl-4 col-md-4 col-lg-4">
					<nav>
						<a class="text-white" href="#">Features</a>
						<a class="text-white" href="#">Reviews</a>
						<a class="text-white" href="#">Sign up</a>
					</nav>
				</div>
			</div>
		</footer>
	</div>
	<div class="clearfix"></div>
	
	<script>
		$('.mid').on("click" ,".close" , function() {
			$('.right').hide();
		});
		$('.mid').on("click" , ".book", function(ev){
			ev.preventDefault();
			var pickup = $(this).data("pickup");
			var drop = $(this).data("drop");
			var cab = $(this).data("cab");
			var wt = $(this).data('wt');
			var distance = $(this).data('distance');
			var fare = $(this).data('fare');
			var html = "";
			$.ajax({
				type: "POST",
				url: "request.php",
				data:{ pickup:pickup ,wt:wt ,cab:cab, distance:distance , drop:drop ,fare:fare,action:'booking' },
				dataType: "JSON",
				success:function( msg ) {
					if(msg != "") {
						html = '<div class="right">'+
						'<h2 class="text-center">Status</h2>'+
						'<p>Your Location:"'+msg["from"]+'"" </p>'+
						'<p>Drop Location : "'+msg["to"]+'"</p>'+
						'<p>Total distance : '+msg['totaldistance']+'</p>'+
						'<p>Total Fare :'+msg['totalfare']+'</p>'+
						'<p>Status : '+msg['status']+'<a class="close">close</a></p></div>';
						$(".mid").html(html);
					}
					else {
						window.location.href = "login.php";
					}
				},
				error:function() {
					alert("error");
				}
			});
		});
		$( document ).ready( function() {
			$('.cab').change(function(){
				var cab = $(".cab").val();
				if(cab === "CedMicro") {
					$('.txt').attr('disabled', 'disabled');
				}
				else {
					$( ".txt" ).prop( "disabled", false );
				}
			});
			$(".txt").keypress(function (e) {
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					$(".err").html("Digits Only").show().css('color' , 'red');
				}
				else {
					$(".err").html("Digits Only").hide();
				}
			});
			$('.btn').click(function(ev){
				ev.preventDefault();
				var pickup = $(".pickup").val();
				var drop = $(".drop").val();
				var cab = $('.cab').val();
				var wt = $('.txt').val();
				//console.log(wt);
				var html = '';
				if(pickup != "" && drop != "" && cab !="") {
					if(cab == "CedMicro") {
						$.ajax({
							type: "POST",
							url: "request.php",
							data:{ pickup:pickup , cab:cab , drop:drop ,action:'calculatefare' },
							dataType: "JSON",
							success:function( msg ) {
								if(msg['distance'] !=0) {
									html= '<div class="right">'+
									'<h2 class="text-center">Calculate Fare</h2>'+
									'<p>Your Location : "'+pickup+'"</p><p>Drop Location : "'+drop+'"</p><p>Cab Type : "'+cab+'"</p>'+
									'<p>Total Fare :"'+msg['totalfare']+'"</p>'+
									'<p><input data-pickup ="'+pickup+'" data-drop="'+drop+'" data-cab='+cab+' data-wt="'+msg['luggage']+'" data-distance='+msg['distance']+' data-fare='+msg['totalfare']+' type="button" name="book" class="book" value="Book Now">'+
									'<input type="button" name="cancel" class="close" value="Cancel"></p>'+
									'</div>';
									$(".mid").html(html);
								}
								else {
									alert("Please change location");
								}
							},
							error:function() {
								alert("error");
							}
						});
					}
					else {
						$.ajax({
							type: "POST",
							url: "request.php",
							data:{ pickup:pickup ,wt:wt , cab:cab , drop:drop ,action:'calculatefare' },
							dataType: "JSON",
							success:function( msg ) {
								if(msg['distance'] !=0) {
									html= "<div class='right'>"+
									"<h2 class='text-center'>Calculate Fare</h2>"+
									"<p>Your Location : '"+pickup+"'</p><p>Drop Location : '"+drop+"'</p><p>Cab Type : '"+cab+"'</p>"+
									"<p>Total Fare :'"+msg['totalfare']+"'</p>"+
									"<p><input data-pickup ='"+pickup+"' data-drop="+drop+" data-wt='"+msg['luggage']+"' data-cab="+cab+" data-distance="+msg['distance']+" data-fare="+msg['totalfare']+" type='button' name='book' class='book' value='Book Now'>"+
									"<input type='button' name='cancel' class='close' value='Cancel'></p>"+
									"</div>";
									console.log(html);
									$(".mid").html(html);
								}
								else {
									html= "<div class='right'>"+
									"<h2 class='text-center'>Calculate Fare</h2>"+
									"<p>Your Location : '"+pickup+"'</p><p>Drop Location : '"+drop+"'</p><p>Cab Type : '"+cab+"'</p>"+
									"<p>Total Fare :'"+msg['totalfare']+"'</p>"+
									"</div>";
								//console.log(html);
								$(".mid").html(html);
							}
						},
						error:function() {
							alert("error");
						}
					});
					}
				}
				else {
					alert("Please fill all fields");
				}
			});
		});
	</script>
</body>
</html>