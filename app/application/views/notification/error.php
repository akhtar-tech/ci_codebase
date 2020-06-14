<?php if (validation_errors()) { ?>
	<div class="alert alert-danger alert-bordered">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
		<?php echo validation_errors(); ?>
	</div>
<?php } ?>