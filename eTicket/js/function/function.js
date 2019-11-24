var bookedSeat=new Array;
var n_seat=0;

function init() {

	var toBuy=new Array;

	if (!navigator.cookieEnabled) {
		if (window.location.toString().indexOf("nocookie.php") == -1) {
			window.location = "./nocookie.php";
		}

	}
	else {
		if (window.location.toString().indexOf("nocookie.php") != -1) {
			window.location = "./index.php";
		}

	}

	if(window.location.toString().indexOf("index.php") != -1){

		toBuy=$(".matrix" ).find( "button" ).filter(function(){
			var color = $(this).css("background-color").toLowerCase();
			return color === "#ffff00" || color === "rgb(255, 255, 0)" ;
		});

		toBuy.each(function() {
			n_seat++;
			$("#selected-seats").append("<li id=s_"+$(this).attr('id')+"><i class='fas fa-chair' aria-hidden='true' style='color:black'></i>&nbsp;"+$( this ).attr('id')+"</li>");
			bookedSeat.push($( this ).attr('id'));
		});


		$("#counter").html(n_seat);
		if(n_seat==0)
			$("#buy").attr("disabled", true);

		console.log(bookedSeat);
	}

}

function validateEmail(email) {
	let re = /^\S+@\S+[.][\w\d]+$/;
	return re.test(String(email).toLowerCase());
}

function checkForm(){

	let username = $('#username').val();
	let pass = $('#password').val();
	let psw_regex = /(?=.*?[a-z])(?=.*?[0-9A-Z])(?=.{2,})/;

	if (pass.match(psw_regex)) {
		if(validateEmail(username)){
			return true;
		}
		else{
			alert("Username is not a valid email address.");
			return false;
		}
	} else {
		alert("The password lenght must be at least 2 and must contain a lowercase letter and a capital letter or a number");
		return false;
	}


}

function removeFromMySeats(id){

	let index=bookedSeat.indexOf(id)

	bookedSeat.splice(index,1);

	$("#s_"+(id)).remove();


	n_seat--;

	if(n_seat==0)
		$("#buy").attr("disabled", true);

	$("#counter").html(n_seat);

}


function checkSeats(){

	let toBuy=new Array;
	let toBuyValue=new Array;

	/* get all the button element inside matrix that are yellow */
	toBuy=$( ".matrix" ).find( "button" ).filter(function(){
		let color = $(this).css("background-color").toLowerCase();
		return color === "#ffff00" || color === "rgb(255, 255, 0)" ;
	});

	/* get the value of the result set */
	toBuy.each(function() {
		toBuyValue.push($( this ).attr('id'));
	});

	jsonString=JSON.stringify(toBuyValue);

	console.log(jsonString);

	$.ajax({
		type: "POST",
		url:  "./php/function/checkSeats.php",
		data: {bookings:jsonString},
		success: function(result){
			var data=JSON.parse(result);
			if(data['status']=='timeout'){

				alert(data['message']);
				window.location.href='logout.php';

			}else{

				location.reload(true);

			}
		}
	});



}

function reserveSeat(id){

	let res_id=id.split('-');

	/* if the seat is yellow, delete my booking but first check if it has been stolen
	 * by someone else otherwise you will delete someone else booking */
	if($("#"+id).css('background-color').toLowerCase()=='rgb(255, 255, 0)'){

		$.ajax({
			type: "POST",
			url:  "./php/function/deleteBooking.php",
			data: {row:res_id[0],col:res_id[1]},
			success: function(result){

				let data=JSON.parse(result);

				if( data['status'] == 'error1' ) {

					alert(data['message']);
					$("#"+id).css('background-color','orange');

					removeFromMySeats(id);

				} else if( data['status'] == 'error2' ) {

					alert(data['message']);
					$("#"+id).css('background-color','red');
					$("#"+id).attr("disabled", true);

					removeFromMySeats(id);

				} else if(data['status']=='timeout'){
					alert(data['message']);
					window.location.href='logout.php';
				}
				else if(data['status']=='success'||data['status']=='success2'){
					alert(data['message']);
					$("#"+id).css('background-color','green');

					let old=$('#available').text();
					let update=+old+1;
					$('#available').html(update);


					removeFromMySeats(id);

					old=$('#booked').text();
					update=+old-1;
					$('#booked').html(update);

				}else if(data['status']=='Internal-Error'){

					alert(data['message']);

				}
			}
		});


	}
	/* if the seat is green book the seat */
	else{
		$.ajax({
			type: "POST",
			url:  "./php/function/insertBooking.php",
			data: {row:res_id[0],col:res_id[1]},
			success: function(result){
				console.log(result);
				var data=JSON.parse(result);

				if( data['status'] =='error2' ) {

					console.log(result);
					alert(data['message']);
					$("#"+id).css('background-color','red');
					$("#"+id).attr("disabled", true);

				}
				else if(data['status']=='timeout'){

					alert(data['message']);
					window.location.href='logout.php';
				}
				else if(data['status']=='success'){

					alert(data['message']);
					bookedSeat.push(id);
					n_seat++;

					var old=$('#available').text();
					var update=+old-1;
					$('#available').html(update);


					old=$('#booked').text();
					update=+old+1;
					$('#booked').html(update);


					$("#selected-seats").append("<li id=s_"+id+"><i class='fas fa-chair' aria-hidden='true' style='color:black'></i>&nbsp;"+id+"</li>");
					$("#"+id).css('background-color','yellow');
					$("#counter").html(n_seat);
					$("#buy").removeAttr("disabled")

					console.log(bookedSeat);

				}else if(data['status']=='Internal-Error'){

					alert(data['message']);

				}
			}
		});

	}

}

function buySeats(){


	let toBuy=new Array;
	let toBuyValue=new Array;

	/* get all the button element inside matrix that are yellow */
	toBuy=$( ".matrix" ).find( "button" ).filter(function(){
		let color = $(this).css("background-color").toLowerCase();
		return color === "#ffff00" || color === "rgb(255, 255, 0)" ;
	});

	/* get the value of the result set */
	toBuy.each(function() {
		toBuyValue.push($( this ).attr('id'));
	});

	jsonString=JSON.stringify(toBuyValue);

	$.ajax({
		type: "POST",
		url:  "./php/function/insertSell.php",
		data: {bookings:jsonString},
		success: function(result){
			console.log(result);
			var data=JSON.parse(result);

			if(data['status']=='timeout'){

				alert(data['message']);
				window.location.href='logout.php';

			}else if(data['status']=='success' || data['status']=='error'){

				alert(data['message']);
				location.reload(true);

			}else if(data['status']=='Internal-Error'){

				alert(data['message']);

			}
		}
	});


}





