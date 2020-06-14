				<!-- Footer -->
<div class="footer text-muted" style="width:77%">
	<div class="row">
	<div class="col-md-6">
	&copy; 2018. <a href="<?= base_url(); ?>"><?php echo $config['site_name']; ?></a> by <a href="<?php echo $config['footer_link']; ?>" target="_blank"><?php echo $config['footer_name']; ?></a>
	</div>
		<div class="col-md-6">
	<div style="float:right">Page rendered in <strong>{elapsed_time}</strong> seconds. Memory uses <strong>{memory_usage}</strong>. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></div>
	</div>
	</div>
	
	
</div>

<!-- /footer -->

</div>
<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>