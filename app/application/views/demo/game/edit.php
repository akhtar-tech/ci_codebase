<div class="row">
    <div class="col-md-12">
        <!-- Error viewer -->
        <?php $this->load->view('notification/error'); ?>
        <!-- message viewer -->
        <?php $this->load->view('notification/message', ['key' => $infoKey]); ?>
        <!-- Basic layout-->
		
		
        <div class="panel panel-flat">
            <?php echo form_open_multipart($link . $controller . 'edit/' . $id, ['class' => 'form-horizontal']); ?>
            <div class="panel-heading">
                <h5 class="panel-title"><?php echo $data['header']; ?></h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li class="label label-primary"><a
							href="<?php echo base_url() . $config['sub_directory']['dir_1']['link'] . $controller . 'list'; ?>">List</a>
						</li>
					</ul>
				</div>
			</div>
			
            <div class="panel-body">
				
                <div class="form-group">
                    <label class="col-lg-3 control-label">Game Type:</label>
                    <div class="col-lg-9">
						
                        
						<select disabled class="select" name="type" required>
							<option value="">Select Game Type</option>
							<?php if(count($game_type_list)){ 
								foreach($game_type_list as $game_type){
								?>
								<option <?php selected(@$form_data['type'], $game_type['id']); ?> value="<?php echo $game_type['id']; ?>"><?php echo $game_type['name']; ?></option>
							<?php } } ?>
						</select>
					</div>
				</div>
                <?php echo $main_form; ?>
                <?php echo $rating_content_form; ?>
                <?php
					if (count($sub_game) && $form_data['type'] == 1) {
						foreach ($sub_game as $subgame) {
						?>
                        <div>
                            <hr/>
							
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Image:</label>
								
                                <div class="col-lg-9">
									
                                    <div class="row">
										
                                        <div class="col-md-6">
                                            <?php if (!empty($subgame['image1'])) { ?>
                                                <img onclick="window.open('<?= media_url(); ?>data/<?= $path ?>game/<?php echo $subgame['image1']; ?>')"
												style="width:100px;height:100px" class="img img-thumbnail"
												src="<?= media_url(); ?>data/<?= $path ?>game/<?php echo $subgame['image1']; ?>">
                                                <br/>
                                                <br/>
											<?php } ?>
                                            <input name="img1[]" type="file" class="file-styled">
											
										</div>
                                        <div class="col-md-6">
                                            <?php if (!empty($subgame['image2'])) { ?>
                                                <img onclick="window.open('<?php echo media_url(); ?>data/<?= $path ?>game/<?php echo $subgame['image2']; ?>')"
												style="width:100px;height:100px" class="img img-thumbnail"
												src="<?php echo media_url(); ?>data/<?= $path ?>game/<?php echo $subgame['image2']; ?>">
                                                <br/>
                                                <br/>
											<?php } ?>
                                            <input name="img2[]" type="file" class="file-styled">
											
										</div>
									</div>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Content:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-md-6">
											
                                            <input value="<?php echo $subgame['content1']; ?>" name="content1[]"
											type="text" class="form-control" placeholder="Content 1">
										</div>
                                        <div class="col-md-6">
											
                                            <input value="<?php echo $subgame['content2']; ?>" name="content2[]"
											type="text" class="form-control" placeholder="Content 2">
										</div>
									</div>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-3 control-label">Answer:</label>
								<div class="col-lg-9">
								<select class="form-control" name="answer[]" required>
								<option value="">Select Answer</option>
								<option <?php selected($subgame['answer'], '1'); ?> value="1">Content 1</option>
								<option <?php selected($subgame['answer'], '2'); ?> value="2">Content 2</option>
								</select>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript:{}"
											onclick="remove_box(this, null, '<?php echo $subgame['id']; ?>')"
											title="Remove" class="btn-xs btn bg-indigo-300 pull-right"><i
											class="icon-trash"></i> Delete</a>
										</div>
										
									</div>
								</div>
							</div>
                            <input type="hidden" name="item_id[]" value="<?php echo $subgame['id']; ?>">
						</div>
                        <?php
						}
					}
				?>
				
                <?php
					if (count($sub_game) && $form_data['type'] == 2) {
						foreach ($sub_game as $subgame) {
						?>
                        <div>
                            <hr/>
							
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Image:</label>
								
                                <div class="col-lg-9">
									
                                    <div class="row">
										
                                        <div class="col-md-12">
                                            <?php if (!empty($subgame['image1'])) { ?>
                                                <img onclick="window.open('<?php echo media_url(); ?>data/<?= $path ?>game/<?php echo $subgame['image1']; ?>')"
												style="width:100px;height:100px" class="img img-thumbnail"
												src="<?php echo media_url(); ?>data/<?= $path ?>game/<?php echo $subgame['image1']; ?>">
                                                <br/>
                                                <br/>
											<?php } ?>
                                            <input name="img1[]" type="file" class="file-styled">
											
										</div>
										
									</div>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Content:</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-md-12">
											
                                            <input value="<?php echo $subgame['content1']; ?>" name="content1[]"
											type="text" class="form-control" placeholder="Content 1">
										</div>
										
									</div>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-3 control-label">Answer:</label>
								<div class="col-lg-9">
								<select class="form-control" name="answer[]" required>
								<option value="">Select Answer</option>
								<option <?php selected($subgame['answer'], '1'); ?> value="1">Content 1</option>
								<option <?php selected($subgame['answer'], '2'); ?> value="2">Content 2</option>
								</select>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript:{}"
											onclick="remove_box(this, null, '<?php echo $subgame['id']; ?>')"
											title="Remove" class="btn-xs btn bg-indigo-300 pull-right"><i
											class="icon-trash"></i> Delete</a>
										</div>
										
									</div>
								</div>
							</div>
                            <input type="hidden" name="item_id[]" value="<?php echo $subgame['id']; ?>">
						</div>
                        <?php
						}
					}
				?>
                <div id="game_form"></div>
                <hr/>
                <div class="text-right">
                    <button onclick="game_form('<?php echo $form_data['type']; ?>')" type="button"
					class="btn btn-xs btn-success">Add Game Data
					</button>
                    <button name="update_user" type="submit" class="btn btn-xs btn-warning">Update <i
					class="icon-arrow-right14 position-right"></i></button>
				</div>
			</div>
			
            <?php echo form_close(); ?>
		</div>
		
        <!-- /basic layout -->
		
	</div>
</div>


