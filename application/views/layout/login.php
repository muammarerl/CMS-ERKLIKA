<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Erlangga Video Application CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url()?>assets/srtdash/assets/images/icon/favicon.ico">
    
    <link rel="stylesheet" href="assets/srtdash/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/srtdash/assets/css/typography.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/default-css.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/styles.css">
    <link rel="stylesheet" href="assets/srtdash/assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<style>
  /* Your existing styles */
  .login-form-head {
    background: linear-gradient(135deg, #ffffff, #6dd5fa, #2980b9);
  }
  .card {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  }

  /* New background image rule with overlay */
  .login-area {
    position: relative;
    background-image: url('<?php echo base_url()?>assets/img/bg-erl.png');
    background-size: cover;
    background-position: center;
  }

  .login-area::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 255, 0.3);
  }
</style>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" class="register-form" id="login-form" action="<?php echo base_url()?>login/cek_login">
                  <div class="card">    
                    <div class="login-form-head">
                        <img src="<?php echo base_url()?>assets/img/Logo.png" width="50%">
                            <!-- <h4>Sign In</h4>
                            <p>Hello there, Sign in and start managing your Admin Template</p> -->
                        </div>
                        <div class="login-form-body">
                            <div class="form-gp">
                                <label for="your_name">Email address</label>
                                <input type="text" name="username" id="your_name">
                                <i class="ti-email"></i>
                                <div class="text-danger"></div>
                            </div>
                            <div class="form-gp">
                                <label for="your_pass">Password</label>
                                <input type="password" name="password" id="your_pass">
                                <i class="ti-lock"></i>
                                <div class="text-danger"></div>
                            </div>
                            <div class="row mb-4 rmber-area">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                        <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-btn-area">
                                <button name="signin" id="signin" class="form-submit" value="Log in">Submit <i class="ti-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/popper.min.js"></script>
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/plugins.js"></script>
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/scripts.js"></script>
</body>

</html>