<div class="row">
	<div class="col-md-12">
		<!-- Error viewer -->
		<?php $this->load->view('notification/error'); ?>
		<!-- message viewer -->
		<?php $this->load->view('notification/message', ['key' => $infoKey]); ?>
		<!-- Basic layout-->

		<?php echo form_open_multipart($link . $controller . 'edit/' . $id, ['class' => 'form-horizontal']); ?>
		<div class="panel panel-flat">

			<div class="panel-heading">
				<h5 class="panel-title"><?php echo $data['header']; ?></h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li class="label label-warning"><a href="<?php echo base_url() . $link . $controller . 'create'; ?>">Create</a></li>
						<li class="label label-primary"><a href="<?php echo base_url() . $link . $controller . 'list'; ?>">List</a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">


				<div class="form-group">
					<label class="col-lg-3 control-label">Name:</label>
					<div class="col-lg-9">
						<input value="<?php echo @$form_data['name']; ?>" name="name" type="text" class="form-control" placeholder="Name" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Message:</label>
					<div class="col-lg-9">
						<textarea name="msg" type="text" class="form-control" placeholder="Message" required><?php echo @$form_data['msg']; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">File:</label>
					<div class="col-lg-9">
						<?php if (!empty($form_data['file'])) { ?>
							<img onclick="window.open('<?php echo base_url(); ?>data/user/<?php echo $form_data['file']; ?>')" style="width:100px;height:100px" class="img img-thumbnail" src="<?php echo base_url(); ?>data/user/<?php echo $form_data['file']; ?>">
							<br />
							<br />
						<?php } ?>
						<input name="file" type="file" class="file-styled">
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Active:</label>
					<div class="col-lg-9">
						<label class="radio-inline">
							<input <?php checked(@$form_data['is_active'], '1');
									if (!isset($form_data['is_active'])) {
										echo 'checked';
									} ?> value="1" type="radio" class="styled" name="is_active">
							Active
						</label>
						<label class="radio-inline">
							<input <?php checked(@$form_data['is_active'], '0');  ?> value="0" type="radio" class="styled" name="is_active">
							In-Active
						</label>
					</div>
				</div>

				<div class="text-right">

					<button type="submit" class="btn btn-xs btn-warning">Update <i class="icon-arrow-right14 position-right"></i></button>
				</div>
			</div>

		</div>
		<?php echo form_close(); ?>
		<!-- /basic layout -->

	</div>
</div>