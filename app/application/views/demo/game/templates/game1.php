<div>
<hr/>

<div class="form-group">
    <label class="col-lg-3 control-label">Image:</label>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-md-6">
                <input name="img1[]" type="file" class="file-styled" required>
			</div>
            <div class="col-md-6">
                <input name="img2[]" type="file" class="file-styled" required>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Content:</label>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-md-6">
                <input value="" name="content1[]" type="text" class="form-control" placeholder="Content 1" >
			</div>
            <div class="col-md-6">
                <input value="" name="content2[]" type="text" class="form-control" placeholder="Content 2" >
			</div>
		</div>
	</div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Answer:</label>
    <div class="col-lg-9">
        <select class="form-control" name="answer[]" required>
            <option value="">Select Answer</option>
            <option value="1">Content 1</option>
            <option value="2">Content 2</option>
		</select>
	</div>
	
</div>
<div class="form-group">
    <label class="col-lg-3 control-label"></label>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-md-12">
                <a href="javascript:{}" onclick="remove_box(this)" title="Remove" class="btn-xs btn bg-indigo-300 pull-right" ><i class="icon-trash"></i> Delete</a>
			</div>
            
		</div>
	</div>
</div>
<input type="hidden" name="item_id[]" value=""> 
</div>