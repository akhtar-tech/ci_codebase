function deleteItem(link, ref) {
	swal({
		title: "Warning",
		text: "Are you sure you want to perform delete action ?",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				type: 'post',
				data: {},
				url: link,
				success: function (response) {
					//console.log(response);
					window.location = ref;
				},
				error:function(data){
					console.log(data);
				}
			});
			} else {
			swal({
				title: "Success",
				text: "Your data is safe!",
			icon: "success"});
		}
	});
	
}

function resend_otp(type,phone){
	$('#loading_p').show();
	$.ajax({
		type:'post',
		data:{},
		url:js_obj.base_url+'auth/resend_otp_auth/'+type+'/'+phone,
		success:function(data){
			$('#loading_p').hide();
			if(data.trim() == true){ 
				$('#otp_error_msg').hide();
				$('#otp_btn').show();
				
				swal({
					title: "Success",
					text: "OTP sent to your mobile number",
					icon: "success"
				});
			}
			if(data.trim() == false){ 
				$('#otp_btn').hide();
				$('#otp_error_msg').show();
			}
			console.log(data);
		},
		error: function (data) {
			$('#loading_p').hide();
			console.log(data);
		}
	});
}
