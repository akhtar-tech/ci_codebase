<html lang="en">
    <head>
        <base href="<?= base_url(); ?>assets/<?= $path; ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title; ?></title>
		
        <?php echo $css; ?>
        <?php echo $script; ?>
		
	</head>
	
    <body>
		
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><strong><?php echo $config['site_name']; ?></strong></a>
				
                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
				</ul>
			</div>
			
            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
					
                    <!-- <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-git-compare"></i>
						<span class="visible-xs-inline-block position-right">Git updates</span>
						<span class="badge bg-warning-400">9</span>
						</a>
						
						<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
						Git updates
						<ul class="icons-list">
						<li><a href="#"><i class="icon-sync"></i></a></li>
						</ul>
						</div>
						
						<ul class="media-list dropdown-content-body width-350">
						<li class="media">
						<div class="media-left">
						<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
						</div>
						
						<div class="media-body">
						Drop the IE <a href="#">specific hacks</a> for temporal inputs
						<div class="media-annotation">4 minutes ago</div>
						</div>
						</li>
						
						
						</ul>
						
						<div class="dropdown-content-footer">
						<a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
						</div>
						</div>
					</li> -->
				</ul>
				
				<!-- <p class="navbar-text"><span class="label bg-success-400">Online</span></p> -->
				
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li class="dropdown language-switch">
						<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/flags/gb.png" class="position-left" alt="">
						English
						<span class="caret"></span>
						</a>
						
						<ul class="dropdown-menu">
						<li><a class="deutsch"><img src="assets/images/flags/de.png" alt=""> Deutsch</a></li>
						<li><a class="ukrainian"><img src="assets/images/flags/ua.png" alt=""> ??????????</a></li>
						<li><a class="english"><img src="assets/images/flags/gb.png" alt=""> English</a></li>
						<li><a class="espana"><img src="assets/images/flags/es.png" alt=""> Espa�a</a></li>
						<li><a class="russian"><img src="assets/images/flags/ru.png" alt=""> ???????</a></li>
						</ul>
					</li> -->
					
                    <!-- <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-bubbles4"></i>
						<span class="visible-xs-inline-block position-right">Messages</span>
						<span class="badge bg-warning-400">2</span>
						</a>
						
						<div class="dropdown-menu dropdown-content width-350">
						<div class="dropdown-content-heading">
						Messages
						<ul class="icons-list">
						<li><a href="#"><i class="icon-compose"></i></a></li>
						</ul>
						</div>
						
						<ul class="media-list dropdown-content-body">
						<li class="media">
						<div class="media-left">
						<img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
						<span class="badge bg-danger-400 media-badge">5</span>
						</div>
						
						<div class="media-body">
						<a href="#" class="media-heading">
						<span class="text-semibold">James Alexander</span>
						<span class="media-annotation pull-right">04:58</span>
						</a>
						
						<span class="text-muted">who knows, maybe that would be the best thing for me...</span>
						</div>
						</li>
						
						<li class="media">
						<div class="media-left">
						<img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
						<span class="badge bg-danger-400 media-badge">4</span>
						</div>
						
						<div class="media-body">
						<a href="#" class="media-heading">
						<span class="text-semibold">Margo Baker</span>
						<span class="media-annotation pull-right">12:16</span>
						</a>
						
						<span class="text-muted">That was something he was unable to do because...</span>
						</div>
						</li>
						
						
						</ul>
						
						<div class="dropdown-content-footer">
						<a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
						</div>
						</div>
					</li> -->
					<li class="dropdown language-switch">
						<a href="<?php echo base_url() . $config['sub_directory']['dir_1']['link']; ?>auth/logout"><i class="icon-switch2"></i> Logout</a>
					</li> 
					<!--  <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php // echo base_url(); ?>data/users/image/<?php //echo $user['image']; ?>" alt="...">
						<span><?php //echo $user['name']; ?>&nbsp;</span>
						<i class="caret"></i>
						</a>
						
						<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
						<li><a href="#"><i class="icon-coins"></i> My balance</a></li>
						<li><a href="#"><span class="badge bg-teal-400 pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
						<li class="divider"></li> 
						<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
						<li><a href="<?php //echo base_url() . $config['sub_directory']['dir_1']['link']; ?>auth/logout"><i class="icon-switch2"></i> Logout</a></li>
						</ul> 
					</li> -->
				</ul>
			</div>
		</div>
        <!-- /main navbar -->
		
		
        <!-- Page container -->
        <div class="page-container">
			
            <!-- Page content -->
            <div class="page-content">
				
                <!-- Main sidebar -->
                <?php echo @$sidebar; ?>
                <!-- /main sidebar -->
				
				
                <!-- Main content -->
                <div class="content-wrapper">
					
                    <!-- Page header -->
                    <div class="page-header">
                        <div class="page-header-content">
                            <!-- <div class="page-title">
								<h4><i style="cursor:pointer;" onclick="window.history.back()" class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> <?php echo ($data['header']) ? ' - ' . $data['header'] : ''; ?></h4>
							</div> -->
							
                            <!-- <div class="heading-elements">
								<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
								</div>
							</div> -->
						</div>
						
                        <div class="breadcrumb-line">
                            <ul class="breadcrumb">
                                <li>
                                    <i style="cursor:pointer;" onclick="window.history.back()" class="icon-arrow-left52 position-left"></i>
								<a href="<?php echo base_url() . $config['sub_directory']['dir_1']['link']; ?>">Home</a></li>
                                <li class="active"><?php echo ($data['header']) ? humanize($data['header']) : ''; ?></li>
							</ul>
							
                            <ul class="breadcrumb-elements">
								 <!--<li><a href="<?php echo base_url() . $config['sub_directory']['dir_1']['link'] . $controller.'create'; ?>"><i class="icon-pencil3 position-left"></i> Create</a></li>
								 <li><a href="#"><i class="icon-file-excel position-left"></i> Excel</a></li>
								<li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
								 <li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="icon-gear position-left"></i>
										Settings
										<span class="caret"></span>
									</a>
									
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
										<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
										<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
										<li class="divider"></li>
										<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
									</ul>
								</li> -->
							</ul> 
						</div>
					</div>
                    <!-- /page header -->
					
					
                    <!-- Content area -->
                    <div class="content">
						
										