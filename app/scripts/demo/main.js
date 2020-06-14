$(document).ready(function () { 
	$("#search_filter").on('keyup', function(e){
		e = e || window.event;
		if (e.keyCode == 13)
		{
			js_obj.searchFilter($('#search_filter').attr('name'), $('#search_filter').val());
		}
	});
	//document.createElement('<script>'+js_obj.test_function+'x();</script>');
});

function deleteItem(link, ref) {
	swal({
		title: "Warning",
		text: "Are you sure you want to delete this ?",
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

setInterval(function () {
	$('.alert-success').hide();
}, 5000);
setInterval(function () {
	$('.alert-warning').hide();
}, 10000);