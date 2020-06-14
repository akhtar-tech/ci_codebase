function remove_box(el, index, id){
	swal({
		title: "Warning",
		text: "Are you sure you want to delete this ?",
		icon: "warning",
		buttons: true,
		dangerMode: true,
		}).then((willDelete) => {
		if (willDelete) {
			if(!js_obj.isEmpty(id)){
				$(el).parent().parent().parent().parent().parent().remove();
		$.ajax({
			type:'post',
			data:{
				id:id
			},
			url:js_obj.base_url+'ajax/remove_box',
			success:function(data){
				console.log(data);
			},
			error: function (data) {
				console.log(data);
			}
		});
		
	}
	else{
		$(el).parent().parent().parent().parent().parent().remove();
	}
			} else {
			swal({
				title: "Success",
				text: "Your data is safe!",
			icon: "success"});
		}
	});
	
}

function game_form(type) {

    $.ajax({
        type: 'post',
        data: {
            type: type
        },
        url: js_obj.base_url + 'ajax/game/game_form',
        success: function (data, textStatus, response) {
            //console.log(response.status);
            // console.log(response.getResponseHeader('some_header'));
            //console.log(response.getAllResponseHeaders());
            $('#game_form').append(data);
            $(".file-styled").uniform({
                fileButtonHtml: '<i class="icon-googleplus5"></i>',
                wrapperClass: 'bg-warning'
            });
            $(".styled").uniform({radioClass: 'choice'});
        },
		error: function (data) {
            console.log(data);
		}
    });
}
