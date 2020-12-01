var currentClass = "";
$('.detail').on("click" , '.approve' ,function() {
	var id= $(this).data('id');
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{ id:id , action :'approve' },
		dataType: "JSON",
		success:function( msg ) {
			$(".request").trigger("click");
		},
		error:function() {
			alert("error");
		}
	});	
});
$('.detail').on("click" ,'.cancel',function() {
	if(confirm("Are you sure you want to cancel this ride?")) {
		var id= $(this).data('id');
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'cancel' },
			dataType: "JSON",
			success:function( msg ) {
				$(".request").trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.deleteRide',function() {
	if(confirm("Are you sure you want to delete this ride?")) {
		var id= $(this).data('id');
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'deleteRide' },
			dataType: "JSON",
			success:function( msg ) {
				currentClass.trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.unblock',function() {
	if(confirm("Are you sure you want to unblock user?")) {
		var id= $(this).data('id');
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'unblock' },
			dataType: "JSON",
			success:function( msg ) {
				$(".blocked").trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.block',function() {
	if(confirm("Are you sure you want to block user?")) {
		var id= $(this).data('id');
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'block' },
			dataType: "JSON",
			success:function( msg ) {
				$(".approvedUser").trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.deleteUser',function() {
	if(confirm("Are you sure you want to block user?")) {
		var id= $(this).data('id');
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'deleteUser' },
			dataType: "JSON",
			success:function( msg ) {
				currentClass.trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.deleteLocation',function() {
	if(confirm("Are you sure you want to delete Location?")) {
		var id= $(this).data('id');
		//console.log(id);
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'deleteLocation' },
			dataType: "JSON",
			success:function( msg ) {
				$(".getlocation").trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.dissableLocation',function() {
	if(confirm("Are you sure you want to dissable Location?")) {
		var id= $(this).data('id');
		//console.log(id);
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'dissableLocation' },
			dataType: "JSON",
			success:function( msg ) {
				$(".getlocation").trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.enableLocation',function() {
	if(confirm("Are you sure you want to enable Location?")) {
		var id= $(this).data('id');
		//console.log(id);
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'enableLocation' },
			dataType: "JSON",
			success:function( msg ) {
				$(".getlocation").trigger("click");
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.editLocation',function() {
	if(confirm("Are you sure you want to edit Location?")) {
		var id= $(this).data('id');
		//console.log(id);
		var html = "";
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ id:id , action :'editlocation' },
			dataType: "JSON",
			success:function( msg ) {
				for (var i = 0; i < msg.length; i++) {
					html +='<div class="form">'+
					'<p>Location : <input type="text" class="name" value="'+msg[i]["name"]+'"></p>'+
					'<p>Distance : <input type="text" class="distance" value='+msg[i]['distance']+'></p>'+
					'<p><input  data-id='+msg[i]['id']+' type="button" class="saveLocation" value="save"></p>'+
					'</form>';
				}
				$(".detail").html(html);
			},
			error:function() {
				alert("error");
			}
		});	
	}	
});
$('.detail').on("click" ,'.saveLocation',function() {
	var id= $(this).data('id');
	var name = $(".name").val();
	var distance = $('.distance').val();
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{ id:id ,name:name , distance:distance , action :'saveLocation' },
		dataType: "JSON",
		success:function( msg ) {
			$(".getlocation").trigger("click");
		},
		error:function() {
			alert("error");
		}
	});	
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
		alert("Please enter password");
	}
});
$('.detail').on("click" , '.print' ,function() {
	var divToPrint=document.getElementById('inv');
	var newWin=window.open('','Print-Window');
	newWin.document.open();
	newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	newWin.document.close();
	setTimeout(function(){newWin.close();},10);

});
$('.detail').on("click" ,'.invoice',function() {
	var id= $(this).data('id');
	var html = '';
	$('.sort').html("");
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{ id:id , action :'invoice' },
		dataType: "JSON",
		success:function( msg ) {
			for (var i = 0; i < msg.length; i++) {
				html = '<div id="inv" class="invoicedetail">'+
				'<h2>Invoice</h2>'+
				'<p>'+
				'User id :'+msg[i]['user_id']+''+
				'</p>'+
				'<p>'+
				'From : '+msg[i]["from"]+''+
				'</p>'+
				'<p>'+
				'To : '+msg[i]["to"]+''+
				'</p>'+
				'<p>'+
				'Cab type : '+msg[i]['cab_type']+''+
				'</p>'+
				'<p>'+
				'Luggage :'+msg[i]['luggage']+''+
				'</p>'+
				'<p>'+
				'Date : '+msg[i]['date']+''+
				'</p>'+
				'<p>'+
				'Fare : '+msg[i]['totalfare']+''+
				'</p>'+
				'<p>'+
				'<input type="button" name="print" class="print" value="Print">'+
				'</p>'+
				'</div>';	
			}
			$(".detail").html(html);
		},
		error:function() {
			alert("error");
		}
	});		
});
function allRide(msg) {
	var html = '';
	html += '<table class="tbl">'+
	'<tr>'+
	'<th>From</th>'+
	'<th>To</th>'+
	'<th>Cab_type</th>'+
	'<th>Date<i class="asc fas fa-arrow-alt-circle-up"></i><i class="desc fas fa-arrow-alt-circle-down"></i></th>'+
	'<th>Totaldistance</th>'+
	'<th>Luggage</th>'+
	'<th>Totalfare<i class="ascfare fas fa-arrow-alt-circle-up"></i><i class="descfare fas fa-arrow-alt-circle-down"></i></th>'+
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
function allCompletedRide(msg) {
	var html = '';
	html += '<table class="tbl">'+
	'<tr>'+
	'<th>From</th>'+
	'<th>To</th>'+
	'<th>cab_type</th>'+
	'<th>Date<i class="ascCompletedRide fas fa-arrow-alt-circle-up"></i><i class="descCompletedRide fas fa-arrow-alt-circle-down"></i></th>'+
	'<th>Totaldistance</th>'+
	'<th>Luggage</th>'+
	'<th>Totalfare<i class="ascCompletedfare fas fa-arrow-alt-circle-up"></i><i class="descCompletedfare fas fa-arrow-alt-circle-down"></i></th>'+
	'<th>Status</th>'+
	'<th colspan=2>Action</th>'+
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
		'<td><input  data-id='+msg[i]['id']+' type="button" class="invoice" value="Invoice"></td>'+
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
$('.sort').on("click" , '.sortallRide' ,function() {
	var val = $(this).val();
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{val:val ,action :'sortallRide' },
		dataType: "JSON",
		success:function( msg ) {
			allRide(msg);
		},
		error:function() {
			alert("error");
		}
	});	
});
$('.sort').on("click" , '.sortCompletedRide' ,function() {
	var val = $(this).val();
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{val:val ,action :'sortCompletedRide' },
		dataType: "JSON",
		success:function( msg ) {
			allCompletedRide(msg);
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
		data:{action :'asc' },
		dataType: "JSON",
		success:function( msg ) {
			allRide(msg);
		},
		error:function() {
			alert("error");
		}
	});
});
$('.detail').on("click" , '.ascName' ,function() {
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{action :'ascName' },
		dataType: "JSON",
		success:function( msg ) {
			allUser(msg);
		},
		error:function() {
			alert("error");
		}
	});
});
$('.detail').on("click" , '.descName' ,function() {
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{action :'descName' },
		dataType: "JSON",
		success:function( msg ) {
			allUser(msg);
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
		data:{action :'ascfare' },
		dataType: "JSON",
		success:function( msg ) {
			allRide(msg);
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
		data:{action :'descfare' },
		dataType: "JSON",
		success:function( msg ) {
			allRide(msg);
		},
		error:function() {
			alert("error");
		}
	});	
});
$('.detail').on("click" , '.ascCompletedRide' ,function() {
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{action :'ascCompletedRide' },
		dataType: "JSON",
		success:function( msg ) {
			allCompletedRide(msg);
		},
		error:function() {
			alert("error");
		}
	});	
});
$('.detail').on("click" , '.ascCompletedfare' ,function() {
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{action :'ascCompletedfare' },
		dataType: "JSON",
		success:function( msg ) {
			allCompletedRide(msg);
		},
		error:function() {
			alert("error");
		}
	});	
});
$('.detail').on("click" , '.descCompletedRide' ,function() {
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{action :'descCompletedRide' },
		dataType: "JSON",
		success:function( msg ) {
			allCompletedRide(msg);
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
		data:{action :'desc' },
		dataType: "JSON",
		success:function( msg ) {
			allRide(msg);
		},
		error:function() {
			alert("error");
		}
	});	
});
$('.detail').on("click" , '.descCompletedfare' ,function() {
	$.ajax({
		type: "POST",
		url: "request.php",
		data:{action :'descCompletedfare' },
		dataType: "JSON",
		success:function( msg ) {
			allCompletedRide(msg);
		},
		error:function() {
			alert("error");
		}
	});	
});
function allPendingRide(msg) {
	var html = '';
	html += '<table class="tbl">'+
	'<tr>'+
	'<th>From</th>'+
	'<th>To</th>'+
	'<th>Date</th>'+
	'<th>Totaldistance</th>'+
	'<th>Luggage</th>'+
	'<th>Totalfare</th>'+
	'<th>Status</th>'+
	'<th colspan=2>Action</th>'+
	'</tr>';
	var status = '';
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
		'<td>'+msg[i]['date']+'</td>'+
		'<td>'+msg[i]['totaldistance']+'</td>'+
		'<td>'+msg[i]['luggage']+'</td>'+
		'<td>'+msg[i]['totalfare']+'</td>'+
		'<td>'+status+'</td>'+
		'<td><input data-id='+msg[i]['id']+' type="button" class="approve" value="approve"></td>'+
		'<td><input data-id='+msg[i]['id']+' type="button" class="cancel" value="cancel"></td>'+
		'</tr>';
	}
	html +='</table>';
	$(".detail").html(html);
}
function allUser(msg) {
	var html = '';
	html += '<table class="tbl">'+
	'<tr>'+
	'<th>Username</th>'+
	'<th>Name<i class="ascName fas fa-arrow-alt-circle-up"></i><i class="descName fas fa-arrow-alt-circle-down"></i></th>'+
	'<th>Dateofsignup</th>'+
	'<th>mobile</th>'+
	'<th>isblock</th>'+
	'<th>Action</th>'+
	'</tr>';
	var isblock ='';
	for (var i = 0; i < msg.length; i++) {
		if(msg[i]['isblock']== 1) {
			isblock = "Unblock";
		}
		else {
			isblock = "block";
		}
		html +='<tr>'+
		'<td>'+msg[i]['user_name']+'</td>'+
		'<td>'+msg[i]['name']+'</td>'+
		'<td>'+msg[i]['dateofsignup']+'</td>'+
		'<td>'+msg[i]['mobile']+'</td>'+
		'<td>'+isblock+'</td>'+
		'<td><input data-id='+msg[i]['id']+' type="button" class="deleteUser" value="delete"></td>'+
		'</tr>';
	}
	html +='</table>';
	$(".detail").html(html);

}
$( document ).ready( function() {
	$('.request').click(function request(){
		$('.sort').html("");
		currentClass = $(this);
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ action :'riderequest' },
			dataType: "JSON",
			success:function( msg ) {
				allPendingRide(msg);
			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.ride').click(function ride(){
		currentClass = $(this);
		var html="";
		html +='<label for="sort">Sort:</label>'+
		'<select name="sort" class="sortallRide">'+
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
			data:{ action :'ride' },
			dataType: "JSON",
			success:function( msg ) {
				$('.sort').html(html);
				allRide(msg);
			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.allowRide').click(function(){
		currentClass = $(this);
		var html="";
		html += '<label for="sort">Sort:</label>'+
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
			data:{ action :'allowRide' },
			dataType: "JSON",
			success:function( msg ) {
				$('.sort').html(html);
				allCompletedRide(msg);
			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.cancelRequest').click(function(){
		currentClass = $(this);
		$('.sort').html("");
		var html = '';
		html += '<table class="tbl">'+
		'<tr>'+
		'<th>From</th>'+
		'<th>To</th>'+
		'<th>Date</th>'+
		'<th>Totaldistance</th>'+
		'<th>Luggage</th>'+
		'<th>Totalfare</th>'+
		'<th>Status</th>'+
		'<th>Action</th>'+
		'</tr>';
		var status ='';
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ action :'cancelledRequest' },
			dataType: "JSON",
			success:function( msg ) {
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
					'<td>'+msg[i]['date']+'</td>'+
					'<td>'+msg[i]['totaldistance']+'</td>'+
					'<td>'+msg[i]['luggage']+'</td>'+
					'<td>'+msg[i]['totalfare']+'</td>'+
					'<td>'+status+'</td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="deleteRide" value="delete"></td>'+
					'</tr>';
				}
				html +='</table>';
				//console.log(html);
				$(".detail").html(html);
			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.blocked').click(function(){
		currentClass = $(this);
		$('.sort').html("");
		var html = '';
		html += '<table class="tbl">'+
		'<tr>'+
		'<th>Username</th>'+
		'<th>Name</th>'+
		'<th>Dateofsignup</th>'+
		'<th>mobile</th>'+
		'<th>isblock</th>'+
		'<th colspan=2>Action</th>'+
		'</tr>';
		var isblock ='';
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ action :'blocked' },
			dataType: "JSON",
			success:function( msg ) {
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['isblock']== 1) {
						isblock = "Unblock";
					}
					else {
						isblock = "block";
					}
					html +='<tr>'+
					'<td>'+msg[i]['user_name']+'</td>'+
					'<td>'+msg[i]['name']+'</td>'+
					'<td>'+msg[i]['dateofsignup']+'</td>'+
					'<td>'+msg[i]['mobile']+'</td>'+
					'<td>'+isblock+'</td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="unblock" value="unblock"></td>'+
					'<td><input data-id='+msg[i]['id']+' type="button" class="deleteUser" value="delete"></td>'+
					'</tr>';
				}
				html +='</table>';
				$(".detail").html(html);

			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.alluser').click(function(){
		currentClass = $(this);
		$('.sort').html("");
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ action :'users' },
			dataType: "JSON",
			success:function( msg ) {
				allUser(msg);
			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.approvedUser').click(function(){
		currentClass = $(this);
		$('.sort').html("");
		var html = '';
		html += '<table class="tbl">'+
		'<tr>'+
		'<th>Username</th>'+
		'<th>Name</th>'+
		'<th>Dateofsignup</th>'+
		'<th>mobile</th>'+
		'<th>isblock</th>'+
		'<th colspan=2>Action</th>'+
		'</tr>';
		var isblock ='';
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ action :'approvedUser' },
			dataType: "JSON",
			success:function( msg ) {
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['isblock']== 1) {
						isblock = "Unblock";
					}
					else {
						isblock = "block";
					}
					html +='<tr>'+
					'<td>'+msg[i]['user_name']+'</td>'+
					'<td>'+msg[i]['name']+'</td>'+
					'<td>'+msg[i]['dateofsignup']+'</td>'+
					'<td>'+msg[i]['mobile']+'</td>'+
					'<td>'+isblock+'</td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="block" value="block"></td>'+
					'<td><input data-id='+msg[i]['id']+' type="button" class="deleteUser" value="delete"></td>'+
					'</tr>';
				}
				html +='</table>';
				$(".detail").html(html);
			},
			error:function() {
				alert("error");
			}
		});		
	});
	$('.addlocation').click(function(){
		var html = '';
		$('.sort').html("");
		html += '<div class="form">'+
		'<h2> Add Location</h2>'+
		'<form action="" method="post">'+
		'<p>'+
		'<label for="name">name: <input type="text" class="name" name="name" required></label>'+
		'</p>'+
		'<p>'+
		'<label for="distance">Distance: <input type="number" class="distance" name="distance" required></label>'+
		'</p>'+
		'<p>'+
		'<input type="submit" class="add" name="submit" value="Add Location">'+
		'</p>'+
		'</form></div>';	
		$(".detail").html(html);
	});
	$('.getlocation').click(function getlocation(){
		$('.sort').html("");
		var html = '';
		html += '<table class="tbl">'+
		'<tr>'+
		'<th>Location Name</th>'+
		'<th>Distance</th>'+
		'<th>is_available</th>'+
		'<th>Action</th>'+
		'</tr>';
		var is_available="";
		$.ajax({
			type: "POST",
			url: "request.php",
			data:{ action :'getlocation' },
			dataType: "JSON",
			success:function( msg ) {
				for (var i = 0; i < msg.length; i++) {
					if(msg[i]['is_available'] == 0) {
						is_available = "dissable";
					}
					else {
						is_available = "enable";
					}
					html +='<tr>'+
					'<td>'+msg[i]['name']+'</td>'+
					'<td>'+msg[i]['distance']+'</td>'+
					'<td>'+is_available+'</td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="deleteLocation" value="delete"></td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="editLocation" value="edit"></td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="dissableLocation" value="dissable Location"></td>'+
					'<td><input  data-id='+msg[i]['id']+' type="button" class="enableLocation" value="enable Location"></td>'+
					'</tr>';
				}
				html +='</table>';
				//console.log(html);
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