<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= base_url(); ?>assets/<?= $path; ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Theme JS files -->
    <!-- <script type="text/javascript" src="assets/js/core/app.js"></script> -->
    <!-- /theme JS files -->
    <style>
        .error-help {
            color: #f00 !important;
        }
    </style>
    <link href="assets/css/spinner.css" rel="stylesheet" type="text/css">
    <!-- <div class="loading">Loading&#8230;</div> -->
    <script>
        // $('html').hide();
        // $(document).ready(function() {
        //     setTimeout(() => {
        //         $('.loading').hide();
        //         $('html').fadeIn();
        //     }, 200);
        // });
    </script>
</head>

<body>
    
    <!-- Main navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo $config['base_url']; ?>"><strong><?php echo $config['site_name']; ?></strong></a>

            <ul class="nav navbar-nav pull-right visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <!-- <ul class="nav navbar-nav navbar-right">
                    <li>
                    <a href="#">
                    <i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span>
                    </a>
                    </li>
                    
                    <li>
                    <a href="#">
                    <i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span>
                    </a>
                    </li>
                    
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-cog3"></i>
                    <span class="visible-xs-inline-block position-right"> Options</span>
                    </a>
                    </li>
            </ul> -->
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container login-container">

        <!-- Page content -->
        <div class="page-content" >

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content" style="margin-top: 60px;">

                    <!-- Simple login form -->

                    <?php echo form_open_multipart($config['sub_directory']['dir_1']['link'] . 'auth/login'); ?>

                    <input type="hidden" name="referer" value="<?php echo $referer; ?>">
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
                        </div>
                        <?php $this->load->view('notification/message', ['key' => $infoKey]); ?>
                        <div class="form-group has-feedback has-feedback-left">
                            <input autofocus autocomplete="off" value="<?php echo @$form_data['email']; ?>" name="email" type="text" class="form-control" placeholder="Username">
                            <span class="error-help"><?php echo @$form_error['email']; ?></span>
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input autocomplete="off" value="<?php echo @$form_data['password']; ?>" name="password" type="password" class="form-control" placeholder="Password">
                            <span class="error-help"><?php echo @$form_error['password']; ?></span>
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                        </div>

                        <div class="text-center">
                            <a href="login_password_recover.html">Forgot password?</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <!-- /simple login form -->


                    <!-- Footer -->
                    <div class="footer text-muted">
                        &copy; 2018. <a href="<?= base_url(); ?>"><?php echo $config['site_name']; ?></a> by <a href="<?php echo $config['footer_link']; ?>" target="_blank"><?php echo $config['footer_name']; ?></a>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->


</body>

</html>