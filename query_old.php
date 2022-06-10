<?php
include('header.php');
include('sidebar.php');


if($_GET['action']=='edit')
{
	$editUserId=$_GET['id'];
	$usrData = $objAdmin->getUsrById($editUserId);

	//print_r($usrData);
}
?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add User Form
            <small>Preview</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Add User</li>
          </ol>
        </section>
		
		<!-- Main content -->
        <section class="content">
			<!-- SELECT2 EXAMPLE -->
			<div class="box box-default">
				<div class="box-header with-border">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#home"> <h3 class="box-title"><b>CLIENT DETAILS</b></h3></a></li>
				  <li><a data-toggle="tab" href="#menu1"><h3 class="box-title"><b>QUERY DETAILS</b></h3> </a></li>
				  <li><a data-toggle="tab" href="#menu2"><h3 class="box-title"><b>STATUS</b></h3> </a></li>
				</ul>
				 
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div id="status"></div>
				<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
				<form role="form" method="POST" name="add_User" id="add_User">
					<input type="hidden" id="item_count" name="item_count" value="1"> 
					<input type="hidden" id="item_count1" name="item_count1" value="1"> 
					<input type="hidden" id="item_count2" name="item_count2" value="1"> 
					<input type="hidden" id="item_count3" name="item_count3" value="1"> 
					<input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<div class="box-body">
						<div class="row">
							
							<!-- Frist Line -->
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Query No </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="query_no">Query No</label>
									<input type="text" class="form-control" name="query_no" id="query_no"  value="LiDQ00001"/>
								</div>
							</div><!-- /.form-group -->
							
							<!-- /.first line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b >	Query Date</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
									<label for="query_no">Query Date</label>
									<div class='input-group date' >
									<input type='text' class="form-control"  id="depData"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Person Name </b></h4>
								</div>
							</div>
						
							<div class="col-md-10">
								<div class="form-group">
									<label for="search">Name</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Name" value=""/>
								</div>
							<div id="result"></div>
							</div>
							
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Organization </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="query_no">Organization</label>
									<input type="text" class="form-control" name="Organization" id="Organization"  value="LiD"/>
								</div>
							</div>
							<!-- /.third line -->
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Email </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Email</label>
									<input type="email" class="form-control" name="userPhone" id="userPhone" placeholder="Email" value=""/>
								</div>
							</div>
						   <!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Contact Number</b></h4>
								</div>
							</div>
						
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Number</label>
									<input type="number" class="form-control" name="userPhone" id="userPhone" placeholder="contact Number" value=""/>
								</div>
							</div>					
							<!-- forth Line -->
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Reference </b></h4>
								</div>
							</div>
						
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Reference</label>
									<input type="Reference" class="form-control" name="Reference" id="Reference" placeholder="Reference" value=""/>
								</div>
							</div>					
							<!-- forth Line -->
							
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
					</div>
				</form>
			</div>
				<div id="menu1" class="tab-pane fade">
				<form role="form" method="POST" name="add_User" id="add_User">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Query type</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Query type</label>
									<select class="form-control">
									<option>Hotel</option>
									<option>Resort</option>
									<option> Motel</option>
									<option>BnB</option>
									<option>Homestay</option>
									<option>Tent</option>
									<option>Service Apartment</option>
									<option>Bungalow</option>
									<option>Lodge</option>
									<option>Guest House</option>
									<option>Hostel</option>
									<option>Cottage</option>
									<option>Houseboat</option>
									<option> Villa</option>
									<option>Palace</option>
									<option>Beach Hut</option>
									<option> Farm</option>
									</select>
								</div>
							</div><!-- /.form-group -->
							
							<!-- /.first line -->
							
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Origin</b></h4>
								</div>
							</div>
						
							<div class="col-md-10">
								<div class="form-group">
									<label for="search">Origin</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Name" value="Delhi"/>
								</div>
							
							</div>
							
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Destination </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="query_no">Destination</label>
									<input type="text" class="form-control" name="Organization" id="Organization"  value="Goa"/>
								</div>
							</div>
							<!-- /.third line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Starting Date </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
									<div class='input-group date' >
									<input type='text' class="form-control"  id="startdate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">End Date </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<div class="form-group">
									<div class='input-group date' >
									<input type='text' class="form-control"  id="enddate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									</div>
								</div>
								</div>
							</div>
						
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Stay Duration</b></h4>
								</div>
							</div>
							
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Stay Duration</label>
									<select class="form-control">
									<option>1</option>
									<option>2</option>
									<option> 3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
									<option>7</option>
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>11</option>
									<option>12</option>
									<option>13</option>
									<option>14</option>
									<option>15</option>
									<option>16</option>
									<option>17</option>
									</select>
								</div>
							</div>
							
							
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">No. of Pax</b></h4>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label for="userPhone">Adults</label>
									<select class="form-control">
									<option>(DD)</option>
									<option>1</option>
									<option>2</option>
									<option> 3</option>
									<option>4</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="userPhone">C(5-12)</label>
									<select class="form-control">
									<option>(DD)</option>
									<option>1</option>
									<option>2</option>
									<option> 3</option>
									<option>4</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="userPhone">C(2-5)</label>
									<select class="form-control">
									<option>(DD)</option>
									<option>1</option>
									<option>2</option>
									<option> 3</option>
									<option>4</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="userPhone">C(0-2)</label>
									<select class="form-control">
									<option>(DD)</option>
									<option>1</option>
									<option>2</option>
									<option> 3</option>
									<option>4</option>
									</select>
								</div>
							</div>
							
							
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">No. of Rooms</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">No. of Rooms</label>
									<input type="text" class="form-control" name="userPhone" id="userPhone" placeholder="No. of Rooms" value=""/>
								</div>
							</div>
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	No. of Extra Beds</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">No. of Extra Beds</label>
									<input type="text" class="form-control" name="userPhone" id="userPhone" placeholder="No. of Extra Beds" value=""/>
								</div>
							</div>
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Child Without Bed </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Child Without Bed</label>
									<input type="text" class="form-control" name="userPhone" id="userPhone" placeholder="Child Without Bed" value=""/>
								</div>
							</div>
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">	Child With Bed </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Child With Bed</label>
									<input type="text" class="form-control" name="userPhone" id="userPhone" placeholder="Child With Bed" value=""/>
								</div>
							</div>
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Hotel Name</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Hotel Name</label>
									<input type="text" class="form-control" name="userPhone" id="userPhone" placeholder="Hotel Name" value=""/>
								</div>
							</div>
						   <!-- /.second line -->
						   <div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Itinerary </b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Itinerary</label>
									<select class="form-control">
									<option></option>
									<option></option>
									<option></option>
									<option></option>
									<option></option>
									<option></option>
									<option></option>
								
									</select>
								</div>
							</div>					
							<!-- forth Line -->
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Note</b></h4>
								</div>
							</div>
						
							<div class="col-md-10">
								<div class="form-group">
									<label for="userPhone">Note</label>
									<input type="text" class="form-control" name="Reference" id="Reference" placeholder="Note" value=""/>
								</div>
							</div>					
							<!-- forth Line -->
							
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
					</div>
				</form>
			  </div>
				<div id="menu2" class="tab-pane fade">
				<form role="form" method="POST" name="add_User" id="add_User">
				 <input type="hidden" id="item_count" name="item_count" value="1"> 
				 <input type="hidden" id="item_count1" name="item_count1" value="1"> 
				 <input type="hidden" id="item_count2" name="item_count2" value="1"> 
				 <input type="hidden" id="item_count3" name="item_count3" value="1"> 
				 <input type="hidden" id="item_count4" name="item_count4" value="1"> 
					<input type="hidden" name="userId" value="<?php echo $usrData['admin_id']; ?>" />
					<div class="box-body">
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Handled By</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="search">Handled By</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Auto" value="Auto"/>
								</div>
							</div><!-- /.form-group -->
							
							<!-- /.first line -->
							
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Replied On</b></h4>
								</div>
							</div>
						
							<div class="col-md-5">
								<div class="form-group">
									<label for="search">Date</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Name" value="Date"/>
								</div>
							
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label for="search">Time</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Name" value="Time"/>
								</div>
							
							</div>
							
							<!-- /.second line -->
							<div class="col-md-2">
								<div class="form-group">
								<h4  class="box-title"><b style="font-size: 17px;">Client Feedback</b></h4>
								</div>
							</div>
							<div class="col-md-10">
								<div class="form-group">
									<label for="query_no">Client Feedback</label>
									<textarea type="text" class="form-control" name="Organization" id="Organization"  value=""></textarea>
								</div>
							</div>
							<!-- /.third line -->
							<div class="col-md-2">
								<div class="form-group">
							<h4  class="box-title"><b style="font-size: 17px;">Replied On</b></h4>
								</div>
							</div>
						
							<div class="col-md-5">
								<div class="form-group">
									<label for="search">Date</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Name" value="Date"/>
								</div>
							
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label for="search">Time</label>
									<input type="text" class="form-control " name="searchid" id="searchid" placeholder="Name" value="Time"/>
								</div>							
							</div>
						</div>
						</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
					</div>
				</form>
			
			</div>
		
				</div>
			</div>
		</section>
	<script>
	
		$(document).ready(function(){
			$('#startdate').datepicker({
			format: "dd MM yyyy"
		});
			$( "#enddate" ).datepicker({			
			format: "dd MM yyyy"
		});
		
		
		});
		</script>
		<script src="asset/bootstrap-datepicker.js"></script>
<?php  include('footer.php');?> 