<!-- Core JS files -->
<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>

<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/notifications/noty.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>

<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

<script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>
<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

<?php if ($page_code == "DASHBOARD") { ?>
	<!-- <script type="text/javascript" src="assets/js/pages/dashboard.js"></script> -->
<?php } ?>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script type="text/javascript" src="assets/js/pages/components_notifications_other.js"></script>
<script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
<!-- /theme JS files -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/print.min.js"></script>
<script type="text/javascript" src="assets/js/sweetalert.min.js"></script>

<?php load_script($this->router->fetch_class(), $this->router->fetch_method(), @$js_obj); ?>

<script type="text/javascript" src="assets/js/spinner.js"></script>
<div class="loading">Loading&#8230;</div>