<?php 
$pageName = basename($_SERVER['PHP_SELF']);
if($pageName == 'view_hotel_detail.php' || $pageName == 'view_package_detail.php')
{
	//do nothing
	define(@APP_URL, 'https://lid.lidtravel.com/');
}
else
{
	include('adminConfig/init.php');
}

if(!$_SESSION['admin_Email']){
	if($pageName == 'view_hotel_detail.php' || $pageName == 'view_package_detail.php')
	{
	}
	else
	{
		header('location:index.php');
	}
}
$user_type=$_SESSION['user_type'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Travel CRM| Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/bootstrap/css/custom.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/bootstrap/css/bootstrap.min.css">
    <?php 
	if($pageName == 'hotel.php')
{
	echo '<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
}
else
{
	?>
	
	<link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/plugins/datepicker/datepicker3.css">
<?php 
	}
	?>
	
	
	 <!-- DataTables -->
<link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/plugins/datatables/dataTables.bootstrap.css"> 

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Bootstrap 3.3.5 -->
   
	 <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/plugins/select2/select2.min.css">
   <!--Date picker CSS-->

   
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/dist/css/skins/_all-skins.min.css">
	
	<link rel="stylesheet" href="<?php echo APP_URL; ?>soft/asset/dist/css/custom_responsive.css">
	
	<!--Superbox CSS-->
		<!--<link href="asset/plugins/jquery-superbox/css/style.css" rel="stylesheet" type="text/css" media="screen"/>-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	  <!-- jQuery 2.1.4 -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	
	<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo APP_URL; ?>soft/asset/bootstrap/js/bootstrap.min.js"></script>
	<!-- Select2 -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/select2/select2.full.min.js"></script>
	<!-- InputMask -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/input-mask/jquery.inputmask.js"></script>
	<script src="<?php echo APP_URL; ?>soft/asset/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?php echo APP_URL; ?>soft/asset/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	
	
    <!-- bootstrap time picker -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/iCheck/icheck.min.js"></script>
	<!-- FastClick -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/fastclick/fastclick.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo APP_URL; ?>soft/asset/dist/js/demo.js"></script>
	<script src="<?php echo APP_URL; ?>soft/jquery-validation/dist/jquery.validate.js"></script>
	<script src="<?php echo APP_URL; ?>soft/jquery-validation/dist/additional-methods.js"></script>
	 <!-- DataTables -->
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo APP_URL; ?>soft/asset/plugins/datatables/dataTables.bootstrap.min.js"></script>

  </head>
  <body class="skin-blue">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="dashboard.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>PS</b>App</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Travel</b>CRM</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo APP_URL;?>soft/asset/dist/img/user.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo @$_SESSION['admin_Email'];?></span>
                </a>
                <ul class="dropdown-menu">                                  
					<!-- Menu Footer-->
					 <li><a href="resetpassword.php">Reset Password</a></li>
					<li>
						<a href="logout.php" >Sign out</a>
					</li>
                </ul>
              </li>
             
            </ul>
          </div>

        </nav>
      </header>
	 
      