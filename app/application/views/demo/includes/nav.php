<div class="sidebar sidebar-main">
	<div class="sidebar-content">
		
		<!-- User menu -->
		<div class="sidebar-user">
			<div class="category-content">
				<div class="media">
					<a href="#" class="media-left"><img src="<?php echo base_url(); ?>data/<?= $path ?>users/image/<?php echo $user['image']; ?>" class="img-circle img-sm" alt=""></a>
					<div class="media-body">
						<span class="media-heading text-semibold"><?php echo $user['name']; ?>&nbsp;</span>
						<div class="text-size-mini text-muted">
							<?php echo $user['email']; ?> 
						</div>
					</div>
					
					<div class="media-right media-middle">
						<!-- <ul class="icons-list">
							<li>
								<a href="#"><i class="icon-cog3"></i></a>
							</li>
						</ul> -->
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->
		
		
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					
					<!-- Main -->
					<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
					<li class=""><a href="<?php echo base_url().$config['sub_directory']['dir_1']['link']; ?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
					
					<li>
						<a href="#"><i class="icon-three-bars"></i> <span>Manage Games</span></a>
						<ul>
							<li><a href="<?php echo base_url() . $config['sub_directory']['dir_1']['link'] . 'game/list'; ?>"><i class="icon-three-bars"></i> Game List</a></li>
							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-three-bars"></i> <span>Users</span></a>
						<ul>
							<li><a href="<?php echo base_url().$config['sub_directory']['dir_1']['link'].'user/create'; ?>"><i class="icon-three-bars"></i> Create User</a></li>
							<li><a href="<?php echo base_url().$config['sub_directory']['dir_1']['link'].'user/list'; ?>"><i class="icon-three-bars"></i> User List</a></li>
						</ul>
					</li>
					
					<!--	<li>
						<a href="#"><i class="icon-three-bars"></i> <span>Menu levels</span></a>
						<ul>
						<li><a href="#"><i class="icon-three-bars"></i> Second level</a></li>
						<li>
						<a href="#"><i class="icon-three-bars"></i> Second level with child</a>
						<ul>
						<li><a href="#"><i class="icon-three-bars"></i> Third level</a></li>
						<li>
						<a href="#"><i class="icon-three-bars"></i> Third level with child</a>
						<ul>
						<li><a href="#"><i class="icon-three-bars"></i> Fourth level</a></li>
						<li><a href="#"><i class="icon-three-bars"></i> Fourth level</a></li>
						</ul>
						</li>
						<li><a href="#"><i class="icon-three-bars"></i> Third level</a></li>
						</ul>
						</li>
						<li><a href="#"><i class="icon-three-bars"></i> Second level</a></li>
						</ul>
					</li> -->
					<!-- /layout -->
					
					
					
					
					
				</ul>
			</div>
		</div>
		
		<!-- /main navigation -->
		
		
		
	</div>
</div>
