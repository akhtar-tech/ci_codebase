<?php $this->load->view('notification/message', ['key' => $infoKey]); ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"><?php echo $data['header']; ?></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <!-- <li><a data-action="collapse"></a></li>
				<li><a data-action="close"></a></li> -->
				<?php $q = ($this->input->server('QUERY_STRING')) ? '?'.$this->input->server('QUERY_STRING') : ''; ?>
				<!-- <li class="label label-primary"><a  href="<?php echo base_url() . $link . $controller.'create'; ?>">Create</a></li>
				<li class="label label-success"><a  href="<?php echo base_url() . $link . $controller . 'get_excel'.$q; ?>">Excel</a></li> -->
				<li class="label label-default"><a title="Click to load default page" href="<?php echo base_url() . $link . $controller.'list'; ?>">Clear</a></li>
			</ul>
		</div>
	</div>
	<div style="padding-top: 12px;overflow: hidden;padding-left: 21px;padding-right:21px;border-top: solid 1px #e8e8e8;">
        <div class="row">
			<div class="col-md-3">
                <div style="width:100%">
                    <div style="margin-bottom:12px;width:80%;float:left;padding-right:0;">
                        <input style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" class="form-control" value="<?php echo $this->input->get('q'); ?>" autocomplete="off" id="search_filter" name="q" class="" placeholder="Type to filter...">
					</div>
                    <div style="width:20%;float:left;">
                        <button style="margin-bottom:12px;border-top-left-radius: 0;border-bottom-left-radius: 0;" onclick="js_obj.searchFilter($('#search_filter').attr('name'), $('#search_filter').val())" class="btn-block btn bg-teal btn-md"><i class="icon-search4"></i></button>
					</div>        
				</div> 
			</div>
			<div class="col-md-3">
                <div style="width:100%">
                    <div style="width:100%;float:left;margin-bottom: 12px;">
                        <input onchange="js_obj.searchFilter(this.name, this.value)" title="From" type="date" class="form-control" value="<?php echo $this->input->get('from'); ?>" autocomplete="off" id="search_filter" name="from" class="" placeholder="Type to filter...">
					</div>
					
				</div> 
			</div>
			<div class="col-md-3">
                <div style="width:100%">
                    <div style="width:100%;float:left;margin-bottom: 12px;">
                        <input onchange="js_obj.searchFilter(this.name, this.value)" title="To" type="date" class="form-control" value="<?php echo $this->input->get('to'); ?>" autocomplete="off" id="search_filter" name="to" class="" placeholder="Type to filter...">
					</div>
				</div> 
			</div>
		</div>
	</div>
    
    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Branch ID</th>
                <th>Active Status</th>
                <th class="text-right">Actions</th>
			</tr>
		</thead>
        <tbody>
            <?php
				if (count($rows)) {
					
					$x = $offset;
					foreach ($rows as $row) {
					?>
                    <tr>
						
                        <td><?php echo ($x + 1); ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['id']; ?></td>
						<td><?php echo ($row['is_active']) ? 'Active' : 'Inactive'; ?></td>
						<td class="text-right">
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <button class="btn bg-success btn-xs" type="button">Option</button>
									</a>
									
                                    <ul class="dropdown-menu dropdown-menu-right">
										
                                        <li><a href="<?php echo base_url() . $link . $controller.'edit/' . $row['id']; ?>"><i class="icon-pencil5"></i> Edit</a></li>
                                        <li><a onclick="deleteItem('<?php echo base_url() . $link . $controller.'delete/' . $row['id']; ?>', '<?php echo $this->input->server('REQUEST_URI'); ?>')" href="javascript:{}"><i class="icon-trash"></i> Delete</a></li> 
									</ul>
								</li>
							</ul>
						</td>
					</tr>
                    <?php
						$x++;
					}
				}
			?>
			
		</tbody>
	</table>
    <?php if (isset($this->pagination)) { ?>
        <div class="row" style="padding: 16px;">
            <div class="col-md-4">
                <div style="padding-top: 10px;padding-bottom: 10px;">Showing <?php echo ($offset + 1); ?> to <?php echo $current_rows ?> of <?php echo ($total_rows); ?> entries</div> 
			</div>
            <div class="col-md-8" style="text-align: right;">
                <?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
	<?php } ?>
</div>



