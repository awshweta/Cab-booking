var header = document.getElementById("nav");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className = " active";
    });
}
var currentClass = "";
function allride() {
    currentClass = $(this);
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
}
function allCustomerRide(msg) {
    var html = '';
    html += '<table class="tblCustomer">'+
    '<tr>'+
    '<th>From</th>'+
    '<th>To</th>'+
    '<th>Cab_Type</th>'+
    '<th>Date<i class="asc fas fa-arrow-alt-circle-up"></i><i class="desc fas fa-arrow-alt-circle-down"></i></th>'+
    '<th>Totaldistance(km)</th>'+
    '<th>Luggage(kg)</th>'+
    '<th>Totalfare<i class="ascfare fas fa-arrow-alt-circle-up"></i><i class="descfare fas fa-arrow-alt-circle-down"></i>(Rs.)</th>'+
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
        '<td>'+msg[i]["from"]+'</td>'+
        '<td>'+msg[i]["to"]+'</td>'+
        '<td>'+msg[i]['cab_type']+'</td>'+
        '<td>'+msg[i]['date']+'</td>'+
        '<td>'+msg[i]['totaldistance']+'</td>'+
        '<td>'+msg[i]['luggage']+'</td>'+
        '<td>'+msg[i]['totalfare']+'</td>'+
        '<td>'+status+'</td>'+
        '</tr>';
    }
    for (var i = 0; i < msg.length; i++) {
        if(msg[i]['status'] == 2) {
            total = total + parseInt(msg[i]['totalfare']);
        }
    }
    html +='</table>';
    $(".detail").html(html);
    $(".detail").append("<b>Total Price:</b>"+total+" Rs.");
    html +='</table>';

}
$('.detail').on("click" ,'.deleteRide',function() {
    if(confirm("Are you sure you want to delete this ride?")) {
        var id= $(this).data('id');
        $.ajax({
            type: "POST",
            url: "request.php",
            data:{ id:id , action :'deleteRide' },
            dataType: "JSON",
            success:function( msg ) {
                allride();
            },
            error:function() {
                alert("error");
            }
        }); 
    }   
});
$('.detail').on("click" ,'.deleteCompRide',function() {
    if(confirm("Are you sure you want to delete this ride?")) {
        var id= $(this).data('id');
        $.ajax({
            type: "POST",
            url: "request.php",
            data:{ id:id , action :'deleteRide' },
            dataType: "JSON",
            success:function( msg ) {
             completedride();
         },
         error:function() {
            alert("error");
        }
    }); 
    }   
});
function completedride() {
    var html="";
    currentClass = $(this);
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
}
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
function customerCompletedRide(msg) {
    var html = '';
    html += '<table class="tblCustomer">'+
    '<tr>'+
    '<th>From</th>'+
    '<th>To</th>'+
    '<th>Cab_Type</th>'+
    '<th>Date<i class="ascComp fas fa-arrow-alt-circle-up"></i><i class="descComp fas fa-arrow-alt-circle-down"></i></th>'+
    '<th>Totaldistance(km)</th>'+
    '<th>Luggage(kg)</th>'+
    '<th>Totalfare<i class="ascCompfare fas fa-arrow-alt-circle-up"></i><i class="descCompfare fas fa-arrow-alt-circle-down"></i>(Rs.)</th>'+
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
        '<td>'+msg[i]["from"]+'</td>'+
        '<td>'+msg[i]["to"]+'</td>'+
        '<td>'+msg[i]['cab_type']+'</td>'+
        '<td>'+msg[i]['date']+'</td>'+
        '<td>'+msg[i]['totaldistance']+'</td>'+
        '<td>'+msg[i]['luggage']+'</td>'+
        '<td>'+msg[i]['totalfare']+'</td>'+
        '<td>'+status+'</td>'+
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
    $(".detail").append("<b>Total Price:</b>"+total+" Rs.");
    html +='</table>';

}
function pendingride() {
  var html="";
  currentClass = $(this);
  html +='<label for="sortCustomerPending">Sort:</label>'+
  '<select name="sortCustomerPending" class="sortCustomerPending">'+
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
    data:{ action :'pendingRequest' },
    dataType: "JSON",
    success:function( msg ) {
        $('.sort').html(html);
        customerPendingRide(msg);
    },
    error:function() {
        alert("error");
    }
});     
}
$('.detail').on("click" ,'.cancel',function() {
    if(confirm("Are you sure you want to cancel this ride?")) {
        var id= $(this).data('id');
        $.ajax({
            type: "POST",
            url: "request.php",
            data:{ id:id , action :'cancel' },
            dataType: "JSON",
            success:function( msg ) {
                 alert("your ride has been cancelled successfully");
                pendingride();
            },
            error:function() {
                alert("error");
            }
        }); 
    }   
});
function customerPendingRide(msg) {
    var html = '';
    html += '<table class="tblCustomer">'+
    '<tr>'+
    '<th>From</th>'+
    '<th>To</th>'+
    '<th>cab_type</th>'+
    '<th>Date<i class="ascPending fas fa-arrow-alt-circle-up"></i><i class="descPending fas fa-arrow-alt-circle-down"></th>'+
    '<th>Totaldistance(km)</th>'+
    '<th>Luggage(kg)</th>'+
    '<th>Totalfare<i class="ascfarePending fas fa-arrow-alt-circle-up"></i><i class="descfarePending fas fa-arrow-alt-circle-down"></i>(Rs.)</th>'+
    '<th>Status</th>'+
    '<th>Action</th>'+
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
        '<td>'+msg[i]["from"]+'</td>'+
        '<td>'+msg[i]["to"]+'</td>'+
        '<td>'+msg[i]['cab_type']+'</td>'+
        '<td>'+msg[i]['date']+'</td>'+
        '<td>'+msg[i]['totaldistance']+'</td>'+
        '<td>'+msg[i]['luggage']+'</td>'+
        '<td>'+msg[i]['totalfare']+'</td>'+
        '<td>'+status+'</td>'+
        '<td><input data-id='+msg[i]['id']+' type="button" class="cancel" value="cancel"></td>'+
        '</tr>';
    }
    html +='</table>';
    $(".detail").html(html);
}
$('.detail').on("click" , '.update' ,function() {
    var name = $('.name').val().trim();
    var mobile = $('#mobile').val().trim();
    var letters = /^([a-zA-Z]+\s?)*$/;
    if(name != "" && mobile != "") {
        if(name.match(letters)){
            if(!$('#mobile').val().trim().match('[0-9]{10}'))  {
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
        }
        else
        {
           alert('please enter alphabet character only and more than one space are not allow between word');
        }
    }
    else {
        alert("please enter name and mobile number");
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
                   window.location.href = "logout.php";
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
$('.detail').on("click" , '.ascPending' ,function() {
    $.ajax({
        type: "POST",
        url: "request.php",
        data:{action :'ascDateCustomerPending' },
        dataType: "JSON",
        success:function( msg ) {
            customerPendingRide(msg);
        },
        error:function() {
            alert("error");
        }
    });
});
$('.detail').on("click" , '.descPending' ,function() {
    $.ajax({
        type: "POST",
        url: "request.php",
        data:{action :'descDateCustomerPending' },
        dataType: "JSON",
        success:function( msg ) {
            customerPendingRide(msg);
        },
        error:function() {
            alert("error");
        }
    });
});
$('.detail').on("click" , '.ascfarePending' ,function() {
    $.ajax({
        type: "POST",
        url: "request.php",
        data:{action :'ascFareCustomerPending' },
        dataType: "JSON",
        success:function( msg ) {
            customerPendingRide(msg);
        },
        error:function() {
            alert("error");
        }
    });
});
$('.detail').on("click" , '.descfarePending' ,function() {
    $.ajax({
        type: "POST",
        url: "request.php",
        data:{action :'descFareCustomerPending' },
        dataType: "JSON",
        success:function( msg ) {
            customerPendingRide(msg);
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
$('.sort').on("click" , '.sortCustomerPending' ,function() {
    var val = $(this).val();
    //console.log(val);
    $.ajax({
        type: "POST",
        url: "request.php",
        data:{val:val,action :'sortCustomerPendingRide' },
        dataType: "JSON",
        success:function( msg ) {
            customerPendingRide(msg);
        },
        error:function() {
            alert("error");
        }
    });	
});
$('.detail').on("click" ,'.cancellast',function() {
    if(confirm("Are you sure you want to cancel this ride?")) {
        var id= $(this).data('id');
        $.ajax({
            type: "POST",
            url: "request.php",
            data:{ id:id , action :'cancel' },
            dataType: "JSON",
            success:function( msg ) {
                alert("your ride has been cancelled successfully");
                location.reload();
            },
            error:function() {
                alert("error");
            }
        }); 
    }   
});
$(document).ready(function(){
    var html = "";
    $.ajax({
        type: "POST",
        url: "request.php",
        data:{ action :'lastPendingCustomerRide' },
        dataType: "JSON",
        success:function( msg ) {
            if(msg != "") {
                var html = '';
                html += '<table class="tblCustomer last">'+
                '<tr>'+
                '<th>From</th>'+
                '<th>To</th>'+
                '<th>Date</th>'+
                '<th>Totaldistance(km)</th>'+
                '<th>Luggage(kg)</th>'+
                '<th>Totalfare(Rs.)</th>'+
                '<th>Status</th>'+
                '<th>Action</th>'+
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
                    '<td>'+msg[i]["from"]+'</td>'+
                    '<td>'+msg[i]["to"]+'</td>'+
                    '<td>'+msg[i]['date']+'</td>'+
                    '<td>'+msg[i]['totaldistance']+'</td>'+
                    '<td>'+msg[i]['luggage']+'</td>'+
                    '<td>'+msg[i]['totalfare']+'</td>'+
                    '<td>'+status+'</td>'+
                    '<td><input data-id='+msg[i]['id']+' type="button" class="cancellast" value="cancel"></td>'+
                    '</tr>';
                }
                html +='</table>';
                $("#lastRide").html(html);
            }
        },
        error:function() {
            alert("error");
        }
    });	
    $('.request').click(function (){
        pendingride();
    });
    $('.ride').click(function() {
        allride();
    });
    $('.allowRide').click(function(){
        completedride();
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