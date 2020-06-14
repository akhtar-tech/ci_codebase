<div class="row">
    <div class="col-md-12">
        <!-- Error viewer -->
        <?php $this->load->view('notification/error'); ?>
        <!-- message viewer -->
        <?php $this->load->view('notification/message', ['key' => $infoKey]); ?>
        <!-- Basic layout-->
		
		<?php echo form_open_multipart($link . $controller.'upload', ['class' => 'form-horizontal']); ?>
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
					<label class="col-lg-3 control-label">Choose Excel:</label>
					
					<div class="col-lg-9">
						
						<div class="row">
							
							<div class="col-md-12">
								
								<input name="file1" type="file" class="file-styled">
								
							</div>
							
						</div>
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
					
                    <button type="submit" class="btn btn-xs btn-success">Upload <i class=" icon-file-upload position-right"></i></button>
				</div>
			</div>
           
		</div>
         <?php echo form_close(); ?>
        <!-- /basic layout -->
		
	</div>
</div>


