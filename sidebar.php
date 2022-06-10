<?php
 $searchUser = $_GET['ut'];
?>
<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel" style="display:none;">
            <div class="pull-left image">
              <img src="asset/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info" >
              <p>Lid Admin</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <form action="#" method="get" class="sidebar-form" style="display:none;">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <ul class="sidebar-menu">
		  <?php 
			if($user_type == 'admin' || $searchUser == 'a')
			{
		  ?>
	        <!--<li class="treeview" id="PartnerPanel">-->
         <!--     <a href="#">-->
         <!--       <i class="fa fa-building"></i> <span>Partner Panel</span>-->
         <!--       <i class="fa fa-angle-left pull-right"></i>-->
         <!--     </a>-->
         <!--     <ul class="treeview-menu">-->
         <!--       <li class="partnerli1"><a href="partner_register.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Partner</a></li>-->
         <!--       <li class="partnerli2"><a href="partner_list.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Partner List</a></li>-->
         <!--     </ul>-->
         <!--   </li>-->


			<!--<li class="treeview" id="MasterData">-->
			<!--	<a href="#">-->
			<!--		<i class="fa fa-empire"></i> <span>Manage Master Data</span>-->
			<!--		<i class="fa fa-angle-left pull-right"></i>-->
			<!--	</a>-->
			<!--	<ul class="treeview-menu">-->
			<!--		<li class="masterli1"><a href="countries.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Countries</a></li>-->
			<!--		<li class="masterli2"><a href="add_city.php"><i class="fa fa-plus" aria-hidden="true"></i> Add City & State</a></li>-->
			<!--		<li class="masterli3"><a href="viewstate.php"><i class="fa fa-list-ul" aria-hidden="true"></i> View State</a></li>-->
			<!--		<li class="masterli4"><a href="viewcity.php"><i class="fa fa-list-ul" aria-hidden="true"></i> View City</a></li>-->
			<!--	</ul>-->
   <!--         </li>-->
    <!--        <li class="treeview" id="EmployeePanel">-->
				<!--<a href="#">-->
				<!--	<i class="fa fa-user"></i> <span>Employee Panel</span>-->
				<!--	<i class="fa fa-angle-left pull-right"></i>-->
				<!--</a>-->
				<!--<ul class="treeview-menu">-->
				<!--	<li class="employeeli1"><a href="addUser.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Employee</a></li>-->
				<!--	<li class="employeeli2"><a href="userlist.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Employee List</a></li>-->
				<!--</ul>-->
    <!--        </li>-->
			<!--<li class="treeview" id="ClientPanel">-->
			<!--	<a href="#">-->
			<!--		<i class="fa fa-user-plus"></i> <span>Client Panel</span>-->
			<!--		<i class="fa fa-angle-left pull-right"></i>-->
			<!--	</a>-->
			<!--	<ul class="treeview-menu">-->
			<!--		<li class="clientli1"><a href="client.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Client</a></li>-->
			<!--		<li class="clientli2"><a href="clientlist.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Client List</a></li>-->

			<!--	</ul>-->
   <!--         </li>-->
			<!--<li class="treeview" id="HotelPanel">-->
			<!--	<a href="#">-->
			<!--		<i class="fa fa-bed"></i> <span>Hotel Panel</span>-->
			<!--		<i class="fa fa-angle-left pull-right"></i>-->
			<!--	</a>-->
			<!--	<ul class="treeview-menu">-->
			<!--		<li class="hotelli1"><a href="hotel.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Hotel</a></li>-->
			<!--		<li class="hotelli2"><a href="hotel_list.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Hotel List</a></li>-->
			<!--	</ul>-->
   <!--         </li>-->
            
    <!--        <li class="treeview" id="VendorPanel">-->
				<!--<a href="#">-->
				<!--	<i class="fa fa-user-plus"></i> <span>Vendor Management</span>-->
				<!--	<i class="fa fa-angle-left pull-right"></i>-->
				<!--</a>-->
    <!--		    <ul class="treeview-menu">-->
    <!--				<li class="travelAgentli1"><a href="travel_Agent.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Vendor</a></li>-->
    <!--				<li class="travelAgentli2"><a href="travel_Agent_list.php"><i class="fa fa-list-ul" aria-hidden="true"></i>Vendor List</a></li>-->
    <!--		    </ul>-->
    <!--        </li>-->
			<!--<li class="workoutli"><a href="query.php"><i class="fa fa-cog"></i> Workout Panel</a></li>-->
			<?php
			}
			?>	
     
			<?php 
			if($user_type == 'admin')

			{
		  ?>
          
     <!--           <li class="treeview" id="ItineraryPanel">-->
				 <!--  <a href="#">-->
					<!--<i class="fa fa-outdent"></i> <span>Itinerary Management </span>-->
					<!--<i class="fa fa-angle-left pull-right"></i>-->
				 <!--  </a>-->
				 <!--  <ul class="treeview-menu">-->
					<!--<li class="itienaryli1"><a href="itienary.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Itinerary</a></li>-->
					<!--<li class="itienaryli2"><a href="itienarylist.php"><i class="fa fa-list-ul" aria-hidden="true"></i> Itinerary List</a></li>-->
				
					<!--<li><a href="#">VAN List</a></li>-->
			  <!--     </ul>-->
     <!--           </li>-->
				<!--<li class="treeview" id="DSKPanel">-->
				<!--  <a href="#">-->
				<!--	<i class="fa fa-outdent"></i> <span>DSK Event </span>-->
				<!--	<i class="fa fa-angle-left pull-right"></i>-->
				<!--  </a>-->
				<!--  <ul class="treeview-menu">-->
				<!--	<li class="dsk1"><a href="dskevent.php"><i class="fa fa-calendar"></i> DSK EVENT DETAIL</a></li>-->
				<!--	<li class="dsk2"><a href="dskleads.php"><i class="fa fa-tasks"></i> Leads</a></li>-->
				<!--	<li class="dsk3"><a href="dsk_leads_photo.php"><i class="fa fa-image"></i> Photo Received</a></li>-->
				<!--	<li class="dsk4"><a href="dsk_first_payment.php"><i class="fa fa-money"></i> 1st payment received </a></li>-->
				<!--	<li class="dsk5"><a href="dsk_second_payment.php"><i class="fa fa-money"></i> 2nd payment received</a></li>-->
				<!--	<li class="dsk6"><a href="dsk_leads_cancelled.php"><i class="fa fa-ban"></i> Cancelled</a></li>-->

				<!--  </ul>-->
			 <!--  </li>-->
			   <li class="treeview" id="mrsCapital">
				<a href="#">
					<i class="fa fa-outdent"></i> <span>MRS Capital </span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="dsk1"><a href="dskevent.php"><i class="fa fa-calendar"></i> All Leads</a></li>
					<!--<li class="dsk2"><a href="#"><i class="fa fa-tasks"></i> Leads</a></li>-->
					<!--<li class="dsk3"><a href="#"><i class="fa fa-image"></i> Photo Received</a></li>-->
					<!--<li class="dsk4"><a href="dsk_first_payment.php"><i class="fa fa-money"></i> 1st payment received </a></li>-->
					<!--<li class="dsk5"><a href="dsk_second_payment.php"><i class="fa fa-money"></i> 2nd payment received</a></li>-->
					<!--<li class="dsk6"><a href="dsk_leads_cancelled.php"><i class="fa fa-ban"></i> Cancelled</a></li>-->
					<li class="dsk4"><a href="dsk_first_payment.php"><i class="fa fa-money"></i> Success Payments</a></li>
					<li class="dsk5"><a href="mrscapital_failed_payment.php"><i class="fa fa-money"></i> Failed Payments</a></li>
					<li class="dsk6"><a href="Mrscapital_other_Leads.php"><i class="fa fa-calendar"></i> Others</a></li>

				</ul>
			   </li>			   
            </li>
			<!--<li class="tourcardli1"><a href="tour_card.php"><i class="fa fa-credit-card" aria-hidden="true"></i> Tour Card </a></li>-->
            <!--  <li class="tourcardli2"><a href="other_tour_card.php"><i class="fa fa-credit-card" aria-hidden="true"></i> Other Tour Card </a></li> -->
            <!--<li class="hotelConf"><a href="hotel_confirmation.php"><i class="fa fa-envelope" aria-hidden="true"></i>Hotel Confirmation </a></li>-->
			<?php
			}
			?>
          

            <?php 
				if($user_type == 'Employee'){ ?>
					<ul class="sidebar-menu">
					<!--<li class="queryli1"><a href="add_query.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Query</a></li>-->
					<!--<li class="queryli2"><a href="view_query.php"><i class="fa fa-list-ul" aria-hidden="true"></i> View Query</a></li>-->
					<!--<li class="queryli3">-->
					<!--	<a href="query_in_hand.php"><i class="fa fa-hand-paper-o" aria-hidden="true"></i> Query in hand</a></li>-->

					<!--<li class="queryli4"><a href="confirmed_queries.php"><i class="fa fa-check-circle" aria-hidden="true"></i> Confirmed Queries</a></li>-->

					<!--<li class="queryli5"><a href="cancelled_queries.php"><i class="fa fa-close" aria-hidden="true"></i> Cancelled Queries</a></li>-->
					</ul>
				<?php
					} ?>
        </section>
        <!-- /.sidebar -->
      </aside>



  <style>
.skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
color: #fff;
background: #3c8dbc;
border-left-color: #3c8dbc;
</style>

<style type="text/css">
  
  li.partnerli1.selected a, li.partnerli2.selected a{
    color: #fff;
}
   li.masterli1.selected a, li.masterli2.selected a, li.masterli3.selected a, li.masterli4.selected a{
  	color: #fff;
}
 li.employeeli1.selected a, li.employeeli2.selected a{
  	color: #fff;
}

li.clientli1.selected a, li.clientli2.selected a{
  	color: #fff;
}

li.hotelli1.selected a, li.hotelli2.selected a{
  	color: #fff;
}

li.travelAgentli1.selected a, li.travelAgentli2.selected a{
  	color: #fff;
}
 li.itienaryli1.selected a, li.itienaryli2.selected a{
  	color: #fff;
}

li.dsk1.selected a, li.dsk2.selected a, li.dsk3.selected a, li.dsk4.selected a, li.dsk5.selected a, li.dsk6.selected a{
  	color: #fff;
}

</style>

 <script type="text/javascript">
/*ative class code here*/  
$(function() {
  var loc = window.location.pathname; // returns the full URL
 
 if(/partner_register/.test(loc)) {
  $('#PartnerPanel').addClass('active');
  $('.partnerli1').addClass("selected");  
}
  if(/partner_list/.test(loc)) {
  $('#PartnerPanel').addClass('active');
  $('.partnerli1').removeClass("selected");
  $('.partnerli2').addClass("selected");
}

 
  if(/countries/.test(loc)) {
  $('#MasterData').addClass('active');
  $('.masterli1').addClass("selected");  
}
  if(/add_city/.test(loc)) {                                    
  $('#MasterData').addClass('active');
  $('.masterli1').removeClass("selected");
  $('.masterli2').addClass("selected");
}
  if(/viewstate/.test(loc)) {                                    
  $('#MasterData').addClass('active');
  $('.masterli2').removeClass("selected");
  $('.masterli3').addClass("selected");
}

  if(/viewcity/.test(loc)) {                                    
  $('#MasterData').addClass('active');
  $('.masterli3').removeClass("selected");
  $('.masterli4').addClass("selected");
}

  
  if(/addUser/.test(loc)) {
  $('#EmployeePanel').addClass('active');
  $('.employeeli1').addClass("selected");  
}
  if(/userlist/.test(loc)) {
  $('#EmployeePanel').addClass('active');
  $('.employeeli1').removeClass("selected");
  $('.employeeli2').addClass("selected");
}


  if(/client/.test(loc)) {
  $('#ClientPanel').addClass('active');
  $('.clientli1').addClass("selected");  
}
  if(/clientlist/.test(loc)) {
  $('#ClientPanel').addClass('active');
  $('.clientli1').removeClass("selected");
  $('.clientli2').addClass("selected");
}


  if(/hotel/.test(loc)) {
  $('#HotelPanel').addClass('active');
  $('.hotelli1').addClass("selected");  
}
  if(/hotel_list/.test(loc)) {
  $('#HotelPanel').addClass('active');
  $('.hotelli1').removeClass("selected");
  $('.hotelli2').addClass("selected");
}


 if(/travel_Agent/.test(loc)) {
  $('#VendorPanel').addClass('active');
  $('.travelAgentli1').addClass("selected");  
}
  if(/travel_Agent_list/.test(loc)) {
  $('#VendorPanel').addClass('active');
  $('.travelAgentli1').removeClass("selected");
  $('.travelAgentli2').addClass("selected");
}



  if(/query/.test(loc)) {
  $('.workoutli').addClass('active'); 
}



 if(/itienary/.test(loc)) {
  $('#ItineraryPanel').addClass('active');
  $('.itienaryli1').addClass("selected");  
}
  if(/itienarylist/.test(loc)) {
  $('#ItineraryPanel').addClass('active');
  $('.itienaryli1').removeClass("selected");
  $('.itienaryli2').addClass("selected");
}


  if(/dskevent/.test(loc)) {
  $('#DSKPanel').addClass('active');
  $('.dsk1').addClass("selected");  
}
  if(/dskleads/.test(loc)) {
  $('#DSKPanel').addClass('active');
  $('.dsk1').removeClass("selected");
  $('.dsk2').addClass("selected");
  
}

  if(/dsk_leads_photo/.test(loc)) {
  $('#DSKPanel').addClass('active');
  $('.dsk2').removeClass("selected");
  $('.dsk3').addClass("selected");
  
}
  if(/dsk_first_payment/.test(loc)) {
  $('#DSKPanel').addClass('active');
  $('.dsk3').removeClass("selected");
  $('.dsk4').addClass("selected");
  
}

  if(/dsk_second_payment/.test(loc)) {
  $('#DSKPanel').addClass('active');
  $('.dsk4').removeClass("selected");
  $('.dsk5').addClass("selected");
  
}

 if(/dsk_leads_cancelled/.test(loc)) {
  $('#DSKPanel').addClass('active');
  $('.dsk5').removeClass("selected");
  $('.dsk6').addClass("selected");
  
}


  if(/tour_card/.test(loc)) {
  $('.tourcardli1').addClass('active'); 
  
}
  
  if(/other_tour_card/.test(loc)) {
  $('.tourcardli1').removeClass('active');
  $('.tourcardli2').addClass('active'); 
  

}
 if(/hotel_confirmation/.test(loc)) {
 $('#HotelPanel').removeClass('active');
  $('.hotelConf').addClass('active'); 
  
}


   if(/add_query/.test(loc)) {
  $('.queryli1').addClass('active'); 
}

   if(/view_query/.test(loc)) {
  $('.queryli2').addClass('active'); 
}

   if(/query_in_hand/.test(loc)) {
  $('.queryli3').addClass('active'); 
}

   if(/confirmed_queries/.test(loc)) {
  $('.queryli4').addClass('active'); 
}

   if(/cancelled_queries/.test(loc)) {
  $('.queryli5').addClass('active'); 
}

  


});
</script>

     