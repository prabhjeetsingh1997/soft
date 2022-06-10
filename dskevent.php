<?php
    include('header.php');
    include('sidebar.php');
    // if($_GET['action']=='delete')
    // {
    //     $id=$_GET['id'];
    //     $objAdmin->deleteMrsCapitalLeadById($id);
    //     header("location:dskevent.php");
        
    // }

    function url()
    {
      return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
      );
    }

  
    //print_r($_SESSION);
    //Array ( [admin_Id] => 104 [user_type] => Employee [employee_type] => 0 [employee_Id] => LiDE0104 [admin_Email] => LiDE0104 ) asdfasldfklasdhfsadhkfhkasdfhlsahdflsahdfdashfhasdha::::104::::Employee::::0:::1SELECT * FROM query WHERE employeeId = 104 AND query_type = 1 ORDER BY id DESC


    //Array ( [admin_Id] => 136 [user_type] => Employee [employee_type] => 0 [admin_Email] => LiDE0136 )
    //Array ( [admin_Id] => 136 [user_type] => Employee [admin_Email] => LiDE0136 )
    //Array ( [admin_Id] => 73 [user_type] => admin [employee_type] => 1 [admin_Email] => admin@gmail.com )
    
    $userType = $_SESSION['user_type'];
    $empType = $queryType = $_SESSION['employee_type'];

    $arrQuery=$objAdmin->getALLmrsCapitalEvent();
    
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             	REGISTRATION DETAIL
          </h1>
          <div id="status"></div>
          
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Query List</li>
          </ol>
        </section>
        <div class="addNew">
        	<a href="dskevent_new.php" class="btn btn-info" role="button"><i class="fa fa-plus"></i> Add New</a>
        </div>
<div class="addNew">
          <div class="form-group">
              <button onclick="Export()" style="margin-left: 40px;" class="btn btn-primary">ExportData</button>
          </div>
        </div>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box">
                <div class="box-body table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Date & Time</th>
                        <th>Full Name</th>
                        <th>Mobile No</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Payment Status</th>
                        <th>Amount</th>
                        <th>Refrence Id</th>
                        <th>Detail</th>
                        <th style="width: 55px;">Action</th>
                        <!--<th>Workout</th>-->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $count=1;
                    
                    foreach($arrQuery as $key=>$val)
                    {
                    ?>
                      <tr>
                        <td><?php echo date('d F Y, h:i A', strtotime($val['date_time']));?></td>
                        <td><?php echo $val['first_name'].' '.$val['last_name'];?></td>
                        <td><?php echo $val['contact'];?></td> 
                        <td><?php echo $val['email'];?></td> 
                        <td><?php echo $val['age'];?></td>
                        <td><?php echo $val['payment_status'];?></td>
                        <td><?php echo $val['amount'];?></td>
                        <td><?php echo $val['reference_id'];?></td>
                        <td>
                            <div id="detal_<?php echo $val['id'];?>" style="display:none; text-align: justify;">
                              <div><strong>ID : </strong><span><?php echo $val['id'];?></span></div>
                              <div><strong>Full Name : </strong><span><?php echo $val['first_name'].' '.$val['last_name'];?></span></div>
                              <div><strong>Email : </strong><span><?php echo $val['email'];?></span></div>
                              <div><strong>Mobile No : </strong><span><?php echo $val['contact'];?></span></div>
                              <div><strong>Maritial Status : </strong><span><?php echo $val['maritial_status'];?></span></div>
                              <div><strong>Address : </strong><span><?php echo $val['address_line_1'].", ".$val['address_line_2'].', '.$val['city'].", ".$val['state'].", ".$val['postal_code'];?></span></div>
                              <!--<div><strong>Child Name : </strong><span><?php //echo $val['child_fname'];?></span></div>-->
                              <div><strong>Age : </strong><span><?php echo $val['age'];?></span></div>
                              <div><strong>Body Measurements : </strong><span><?php echo "Hight: ".$val['height'].' Weight: '.$val['weight'].' Bust: '.$val['bust'].' Waist: '.$val['waist'].' Hips: '.$val['hips'];?></span></div>
                              <!-- <div style="position: absolute; top: 20px; right: 20px;"><span><a href="<?php //echo url().$val['photo']; ?>" download><img src="<?php //echo url().$val['photo']; ?>" height="120px" width="120px" ></a></span></div> -->
                            </div>
                            <a href="mrsCapitalLeadDetail.php?action=view&id=<?php echo $val['id'];?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                              <!--<button type="button" rel="<?php //echo $val['id'];?>" class="btn btn-info btn-sm viewDetail"><i class="fa fa-eye"></i></button>-->
                            
                      </td>

                      <td>
                        <div class="btn-group btn-group-xs">
                            <?php if($val['payment_status'] == "") {?>
                        <a type="button" onclick="areyousure('<?php echo $val['id']?>')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        <!--<a href="?action=delete&id=<?php //echo $val['id'];?>" onclick="return areyousure(<?php //echo $val['id']?>);" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>-->
                        <?php } if($val['payment_status'] == "failure") {?>
                        <a type="button" onclick="areyousure('<?php echo $val['id']?>')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                        <?php if($val['payment_status'] == "success") {?>
                        <a type="button" class="btn btn-primary" class="btn btn-info" onclick="sendMail('<?php echo $val['id'] ?>')"><i class="fa fa-envelope"></i></a> 
                        <?php }?>
                        </div>
                      </td>
                      </tr>
                
                   <?php
                     $i++;
                     }
                   ?>

                  </table>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
        </div><!-- /.content-wrapper --> 
        <!--<div id="qDetail" class="modal fade" role="dialog">-->
        <!--    <div class="modal-dialog">-->
              <!-- Modal content-->
        <!--      <div class="modal-content">-->
        <!--        <div class="modal-header" style="color: #FFF;background: #4357ca;">-->
        <!--          <button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <!--          <h4 class="modal-title" id="modalHead">EVENT DETAIL</h4>-->
        <!--        </div>-->
        <!--        <div class="modal-body" id="mdetail">-->
        <!--        </div>-->
        <!--        <div class="modal-footer">-->
        <!--          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <!--        </div>-->
        <!--      </div>-->

        <!--    </div>-->
        <!--</div> -->
        
        <!--<div id="deleteConf" class="modal fade" role="dialog">-->
        <!--    <div class="modal-dialog">-->
        <!--       Modal content-->
        <!--      <div class="modal-content">-->
                <!--<div class="modal-header" style="color: #FFF;background: #4357ca;">-->
                <!--  <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--  <h4 class="modal-title" id="modalHead">EVENT DETAIL</h4>-->
                <!--</div>-->
        <!--        <div class="modal-body" id="">-->
        <!--            <h3>Are You Sure ?</h3>-->
        <!--        </div>-->
        <!--        <div class="modal-footer">-->
        <!--          <button type="button" class="btn btn-danger" id="confYes" value="yes">Yes</button>-->
        <!--          <button type="button" class="btn btn-warning" id="confNo" data-dismiss="modal" value="no">No</button>-->
        <!--        </div>-->
        <!--      </div>-->

        <!--    </div>-->
        <!--</div> -->
      <script>
      $(function () {
        $('#example1').DataTable({
          "paging"      : true,
          "lengthChange": true,
          "searching"   : true,
          "info"        : true,
          "autoWidth"   : false,
          "bSort"       : false,
          
        });

        //   $(document).on('click',".viewDetail",function(){
        //   $("#qDetail").modal();
        //   var qn = $(this).attr('rel');
        //   $("#modalHead").html('EVENT DETAIL: <strong>'+qn+'</strong>');
        //   $("#mdetail").html($("#detal_"+qn).html());
      
        // });
        
      });
    
     </script>
     <?php include('footer.php');?>
     <script type="text/javascript">
        function sendMail(id){
        var id=id;
          $.ajax({
            type: 'POST',  
            url: '_ajax_sendmail_request.php',
            data: {id : id},
            beforeSend:function() {
            },
            success:function(result) {
                if(result == '1')
                {
                   $("#status").show().html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>mail has been sent</div>');
                
                }
                else if (result == '0' || result == '2' || result == '3')
                {
                    $("#status").show().html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong>Sorry, Fail to send mail.</div>');     
                }
            }
        });
    }
    
    function areyousure(id){
        //$("#deleteConf").modal();
        var id = id;
        var sure = confirm("Are You Sure ?");
        
        //$("#confYes").click(function(){
        if(sure == true){
    
            $.ajax({
            type: 'POST',  
            url: 'ajax_deleteMrsCapitalLead.php?action=delete',
            data: {id : id},
            beforeSend:function() {
            },
            success:function(result) {
                //$("#deleteConf").modal('hide');
                if(result == '1')
                {
                    location.reload(true);
                   $("#status").show().html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success! </strong>query has been deleted</div>');
                
                }
                else
                {
                    $("#status").show().html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed! </strong>Sorry, Fail to delete query at the moment.</div>');     
                }
            }
           });
        //})
        }
      
    }

function Export() {
      var conf = confirm("Export Dsk Events to CSV?");
        if(conf == true)
        {
          window.open("dsk_event_export.php?action=dsk_event_export", '_blank');
        }
    }
</script>


