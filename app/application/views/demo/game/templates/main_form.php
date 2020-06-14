<div class="form-group">
	<label class="col-lg-3 control-label">Name:</label>
	<div class="col-lg-9">
		<input value="<?php echo @$form_data['name']; ?>" name="name" type="text" class="form-control" placeholder="Name" required>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">Description:</label>
	<div class="col-lg-9">
		<textarea name="desp" type="text" class="form-control" placeholder="Description" required><?php echo @$form_data['desp']; ?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">Help Content:</label>
	<div class="col-lg-9">
		<textarea name="content_help" type="text" class="form-control" placeholder="Help Content" required><?php echo @$form_data['content_help']; ?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">Game Index:</label>
	<div class="col-lg-9">
		<input readonly value="<?php echo @$form_data['game_index']; ?>" name="game_index" type="number" class="form-control" placeholder="Game Index" required>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">Caption:</label>
	<div class="col-lg-9">
		<input value="<?php echo @$form_data['caption']; ?>" name="caption" type="text" class="form-control" placeholder="Caption" required>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">Max Points/Activity:</label>
	<div class="col-lg-9">
		<input value="<?php echo @$form_data['points']; ?>" name="points" type="text" class="form-control" placeholder="Points" required>
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