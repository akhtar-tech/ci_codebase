<?php
	$notification_message = get_info($key);
	//$notification_message = NULL;
	if ($notification_message) {
	$noti_type = ($notification_message['type'] == 'danger') ? 'error' : $notification_message['type'];
	?>
    <!-- <div class="alert alert-<?php echo $notification_message['type']; ?> alert-bordered">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <?php echo $notification_message['msg']; ?>
	</div> -->
	<script>swal("Alert", "<?php echo $notification_message['msg']; ?>", "<?php echo $noti_type; ?>");</script>
<?php } ?>