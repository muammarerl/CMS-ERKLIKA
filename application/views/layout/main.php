    <!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Erlangga Video Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url()?>assets/srtdash/assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="<?php echo base_url()?>assets/amcharts5/js/amcharts.js"></script>
    <script src="<?php echo base_url()?>assets/amcharts5/js/serial.js"></script>
    <script src="https://cdn.amcharts.com/lib/version/5.5.7/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/version/5.5.7/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/version/5.5.7/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/version/5.5.7/locales/de_DE.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js">
    
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/srtdash/assets/css/responsive.css">
    <link type="text/css" href="<?php echo base_url();?>assets/flexigrid/css/flexigrid.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/datepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- modernizr css -->
    
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- jquery latest version -->
    <script src="<?php echo base_url()?>assets/srtdash/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="<?php echo base_url('assets')?>/ace/js/date-time/bootstrap-datepicker.js"></script>
    <style>
        
    #modalse{
     min-width:80%!important;
    }
    </style>
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>assets/img/Logo.png" alt="logo"></a>
                </div><p style="color: white; text-align:right;">Beta</p>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            
                        <?php
                            $act="";
                            $menu=$this->uri->segment(1);
                            $webmaster_grup=$this->session->userdata('webmaster_grup');
                            $q=GetAll('menu',array('id_parents'=>'where/0','sort'=>'order/ASC','is_active'=>'where/Active'));
                            if($q->num_rows()>0){
                             foreach($q->result() as $hasil){
                                 $parent=GetValue('id_parents','menu',array('filez'=>'where/'.$menu));
                                 if($parent==$hasil->id)$act='class="active"';
                                 else $act='';
                        	if($webmaster_grup=='2706' || $webmaster_grup=='1'){
                                    $allow=1;
                                }
                                else{
                                    
                                    $allow=GetValue('view','users_permission_sf',array('menu_id'=>'where/'.$hasil->id,'user_id'=>'where/'.$webmaster_grup));
				}
                                    if($allow==1){
					if($hasil->icon==NULL){$hasil->icon='fa fa-cog';}
                                            if($hasil->img==''){
                                                $hasil->icon=$hasil->icon;
                                            }else{
                                                $hasil->icon='';
                                            }
								?>
                            <li id="menuutama<?php echo $hasil->id?>" <?php echo $act?>>
				<a href="<?php echo base_url().$hasil->filez?>">
                                    <i class="menu-icon <?php echo $hasil->icon;?>" ><?php if($hasil->img!=NULL){ ?><img src="<?php echo base_url()?>assets/icons/<?php echo $hasil->img;?>" width="24px" height="24px"><?php } ?></i>
                                    <span class="menu-text" > <?php echo $hasil->title;?> - beta</span></a>
                                    <ul class="collapse">
                                        <?php 
                                        $qm=GetAll('menu',array('id_parents'=>'where/'.$hasil->id,'sort'=>'order/ASC','is_active'=>'where/Active'));
                            if($qm->num_rows()>0){
                             foreach($qm->result() as $hasils){
                                 
                                 $parents=GetValue('id','menu',array('filez'=>'where/'.$menu));
                                 if($parents==$hasil->id)$acts='class="active"';
                                 else $acts='';
                                 
                        	if($webmaster_grup=='2706' || $webmaster_grup=='1'){
                                    $allows=1;
                                }
                                else{
                                    $allows=GetValue('view','users_permission_sf',array('menu_id'=>'where/'.$hasils->id,'user_id'=>'where/'.$webmaster_grup));
				}
                                    if($allows==1){
					if($hasils->icon==NULL){$hasils->icon='fa fa-cog';}
                                            if($hasils->img==''){
                                                $hasils->icon=$hasils->icon;
                                            }else{
                                                $hasils->icon='';
                                            }
								?>
                            <li id="submenu<?php echo $hasils->id?>" <?php echo $acts?>>
				<a href="<?php echo base_url().$hasils->filez?>">
                                    <i class="menu-icon <?php echo $hasils->icon;?>" ><?php if($hasils->img!=NULL){ ?><img src="<?php echo base_url()?>assets/icons/<?php echo $hasils->img;?>" width="24px" height="24px"><?php } ?></i>
                                    <span class="menu-text" > <?php echo $hasils->title;?></span></a>
                                    
                             </li>
								<?php } 
							}
						}?>
                                    </ul>
                             </li>
								<?php } 
							}
						}?>
                        
                            
                            <?php if($this->session->userdata('user_type')=='superuser'||$this->session->userdata('webmaster_grup')==1){?>
                        <li>
                            <a href="<?php echo base_url()?>#"><i class="ti-user"></i><span class="menu-text"> Super User Menu</span></a>
                            <ul class="collapse">
                                <li><a href="<?php echo base_url()?>menu"><i class="glyphicon glyphicon-list"></i> Menu</a></li>
                                <li><a href="<?php echo base_url()?>admin"><i class="glyphicon glyphicon-user"></i> User Management</a></li>
                                <li><a href="<?php echo base_url()?>admin_grup"><i class="glyphicon glyphicon-user"></i> User Grup</a></li>
                           </ul>
							
                        </li>
                            <?php }?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"><i class="<?php echo GetValue('icon','sv_menu',array('filez'=>'where/'.$this->utama))?>"></i> <?php echo $this->title;?></h4>
                            <ul class="breadcrumbs pull-left">
                                <li>
                                    <a href="<?php echo base_url($this->utama)?>"><?php echo ucwords(str_replace('_',' ',$this->utama))?></a>
                                </li>
                                <li>
                                    <?php echo $type?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="<?php echo base_url('assets')?>/ace/avatars/<?php echo GetValue('avatar','admin_profile',array('id'=>'where/'.$this->session->userdata('webmaster_id')))?>" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo ucfirst(GetValue('name','admin_profile',array('id'=>'where/'.$this->session->userdata('webmaster_id'))));?><i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo base_url('admin').'/form/'.$this->session->userdata('webmaster_id')?>">Change Password</a>
                                <a class="dropdown-item" href="<?php echo base_url('admin').'/profile/'.$this->session->userdata('webmaster_id')?>">Settings</a>
                                <a class="dropdown-item" href="<?php echo base_url()?>login/logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <?php $this->load->view($content); ?>
            </div>
        </div>
        <!-- main content area end -->
        
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Penerbit Erlangga <?php echo date('Y')?>. All right reserved.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    
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
    <script type="text/javascript" src="<?php echo base_url();?>assets/flexigrid/js/flexigrid.pack.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        <?php if($this->session->flashdata('munculnotif')){?>
    $(document).ready(function(e){
        $('#notification').modal('show');
    })
                            <?php }?>
    $(document).ready(function() {
        $('.select2').select2();
    });
    function shownotif(){
        $('#notification').modal('show');
    };
    </script>
</body>

</html>
