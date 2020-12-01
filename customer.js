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
			var mobile = $('.mobile').val();
			$.ajax({
				type: "POST",
				url: "request.php",
				data:{ name:name ,mobile:mobile , action :'updateUserInfo' },
				dataType: "JSON",
				success:function( msg ) {
					$(".detail").html(msg.user);
				},
				error:function() {
					alert("error");
				}
			});	
		});
		$('.detail').on("click" , '.save' ,function() {
			var oldPass = $('.oldPass').val();
			var newPass = $('.newPass').val();
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
				'<option></option>'+
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
				'<option></option>'+
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
							'<p>Mobile No: <input type="text" name="mobile" value="'+msg[i]['mobile']+'"class="mobile" required></p>'+
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