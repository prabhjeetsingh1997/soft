<?php
include('header.php');
include('sidebar.php');
if($_GET['action'] == 'listView')
{
	$id=$_GET['id'];
	$usrData = $objAdmin->getUsrById($id);
	$usrAddress=$objAdmin->getAllAddressById($id,'Employee');
	$usrPhone=$objAdmin->getAllPhoneNumberById($id);
	//print_r($usrAddress);
}
?>
<style>
.add_action {
    float: right;
    position: absolute;
    right: 0px;
    top: 0px;
    margin-right: 20px;
    z-index: 1;
}
.add_action > span {
    font-size: 18px;
    margin-left: 10px;
    cursor: pointer;
}
#checked_7{
	top: 1px;
    left: 11px;
    float: left;
    height: 32px;
    width: 32px;
    display: none;
}
* {
    border-radius: 0 !important;
}
.servive-block
{
	padding: 20px;
    cursor: pointer;
    position: relative;
}
.servive-block-light, .servive-block-default {
    background: #fafafa;
    border: solid 1px #eee;
}
i.icon-custom {
    color: #555;
    width: 40px;
    height: 40px;
    font-size: 20px;
    line-height: 40px;
    margin-bottom: 5px;
    text-align: center;
    display: inline-block;
    border: solid 1px #555;
}
.rounded-x {
    border-radius: 50% !important;
}
.heading-md{
	border-bottom: 1px solid #ccc;
    text-align: left;
    padding-left: 0;
}
p{
	text-align: left;
    border-bottom: 1px solid #ccc;
}
.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    /* transform: translate(0, 0); */
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		 <h1>Address</h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">User List</a></li>
			<li class="active">Address</li>
		  </ol>
	</section>
	
	<!-- Main content -->
    <section class="content">
		<div class="box box-default">
			<div class="row">
				<?php
					foreach($usrAddress as $key=>$val){
				?>
				<div class="col-md-6 col-sm-6 add_sel" id="add_sel_7" rel="7">
					<!--<div class="add_action"><span title="Edit" rel="7"><i class="fa fa-pencil-square-o"></i></span><span title="Delete" rel="7"><i class="fa fa-times-circle"></i></span></div>-->
					<div>
					<h2 class="heading-md"><?php echo ucfirst($val['address_type']." Address");?></h2>
					</div>
					<div id="checked_7" style="top: 1px; left: 11px; float: left; height: 32px; width: 32px; display:none;" class="add_action checked">&nbsp;</div>
					
					<div class="servive-block servive-block-default" id="add_box_7" style="padding:20px; cursor:pointer; position:relative;" href="#changeAdd" data-parent="#accordion-1" data-toggle="collapse" onclick="select(7)">
						<i class="icon-custom icon-color-dark rounded-x fa fa-home"></i>
						<h4 class="heading-md" style="border-bottom: 1px solid #ccc; text-align:left; padding-left:0;"><?php echo '<b>'.$usrData['first_name']." ".$usrData['middle_name']." ".$usrData['last_name'].'</b>';?></h4>
						<p style="text-align: left; border-bottom: 1px solid #ccc;"><?php echo $val['address1'].", ".$val['address2'].", ".$val['state'].", ".$val['city'].", ".$val['country']."-".$val['pin_code'];?></p>
						<?php
							foreach($usrPhone as $k=>$value){
						?>
							<p style="text-align: left; border-bottom: 1px solid #ccc; margin-bottom:20px;"><?php echo ucfirst($value['type']." ".$value['code']." number: ").$value['contact_no'];?></p>   
						<?php
							}
						?>
					</div>
				</div>
				<?php
					}
				?>
				
			</div>
		</div>
	</section>
	<!--End Main content -->
</div>
</div>
<?php
	include('footer.php');
?>