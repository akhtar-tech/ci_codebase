<div class="row">
    <div class="col-md-12">
        <!-- Error viewer -->
        <?php $this->load->view('notification/error'); ?>
        <!-- message viewer -->
        <?php $this->load->view('notification/message', ['key' => $infoKey]); ?>
        <!-- Basic layout-->
		
		<?php echo form_open_multipart($link . $controller.'create/' . $id, ['class' => 'form-horizontal']); ?>
        <div class="panel panel-flat">
			
            <div class="panel-heading">
                <h5 class="panel-title"><?php echo $data['header']; ?></h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li class="label label-primary"><a  href="<?php echo base_url() . $link . $controller.'list'; ?>">List</a></li>
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
					<label class="col-lg-3 control-label">Mobile No.:</label>
					<div class="col-lg-9">
						<input value="<?php echo @$form_data['mobile']; ?>" name="mobile" type="text" class="form-control" placeholder="Mobile No" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Image:</label>
					
					<div class="col-lg-9">
						
						<div class="row">
							
							<div class="col-md-12">
								<?php if (!empty(@$form_data['image'])) { ?>
									<img onclick="window.open('<?php echo media_url(); ?>data/<?= $path ?>profile/<?php echo $form_data['image']; ?>')"
									style="width:100px;height:100px" class="img img-thumbnail"
									src="<?php echo media_url(); ?>data/<?= $path ?>profile/<?php echo $form_data['image']; ?>">
									<br/>
									<br/>
								<?php } ?>
								<input name="img1" type="file" class="file-styled">
								
							</div>
							
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Driving Licence:</label>
					<div class="col-lg-9">
						<input value="<?php echo @$form_data['dl_no']; ?>" name="dl_no" type="text" class="form-control" placeholder="Driving Licence" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-3 control-label">Userkey:</label>
					<div class="col-lg-9">
						<input disabled value="<?php echo @$form_data['userkey']; ?>" name="userkey" class="form-control" placeholder="Userkey" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">UserID:</label>
					<div class="col-lg-9">
						<input disabled value="<?php echo @$form_data['user_id']; ?>" name="user_id" class="form-control" placeholder="UserID" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">User Referral Key:</label>
					<div class="col-lg-9">
						<input disabled value="<?php echo @$form_data['user_referral_key']; ?>" name="user_referral_key" class="form-control" placeholder="User Referral Key" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-3 control-label">Active:</label>
					<div class="col-lg-9">
						<label class="radio-inline">
							<input <?php checked(@$form_data['is_active'], '1'); if(!isset($form_data['is_active'])){ echo 'checked'; } ?> value="1" type="radio" class="styled" name="is_active">
							Active
						</label>
						<label class="radio-inline">
							<input <?php checked(@$form_data['is_active'], '0');  ?>   value="0" type="radio" class="styled" name="is_active">
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


