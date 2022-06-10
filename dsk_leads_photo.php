<?php
    include('header.php');
    include('sidebar.php');
    if($_GET['action']=='delete')
    {
        $id=$_GET['id'];
        $objAdmin->deleteLeadById($id);
        header("location:dskleads.php");
        
    }

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

    $arrQuery=$objAdmin->getALLDskLeadsPhoto();
    
?>
<script type="text/javascript">
  $(document).ready(function(){
$("#example1 #checkall").click(function () {
        if ($("#example1 #checkall").is(':checked')) {
            $("#example1 input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#example1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    
    $("[data-toggle=tooltip]").tooltip();
});
</script>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
              Photo Received Leads Detail
          </h1>
          <div id="status"></div>
          
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> DSK EVENT</a></li>
            <li class="active">photo received List</li>
          </ol>
        </section>
        <section class="col-md-6" style="margin-top: 10px;margin-bottom: 10px;">
          <div class="col-md-2">
        <!--  <select class="form-control" id="massAction">
          <option>Action</option>
          <option value="delete">Delete All</option>
           <optgroup label="Move To">
           <option value="move">Photo Received</option>
           <option value="second_payment">2nd payment</option>
           <option value="cancelled">Cancelled</option>
         </optgroup>
         </select> -->
        
          <div class="dropdown">
            <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#">
                Action <span class="caret"></span>
            </a>
        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li><a href="#" onclick="DeleteAll();">Delete All</a></li>
              <li class="divider"></li>
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#"><strong>Move To</strong></a>
                <ul class="dropdown-menu">
                  <li><a tabindex="-1" href="#" onclick="Leads();">Leads</a></li> <li class="divider"></li>               
                  <li><a href="#" onclick="paymentReceived();">2nd Payment</a></li>
                </ul>
              </li>
              <li class="divider"></li>
              <li><a href="#" onclick="SendEmail();">Send Bulk Email</a></li>
              <li class="divider"></li>
              <li><a href="#" onclick="ChangeMassColor();">Change Color</a></li>
            </ul>
        </div>
        </div>

        <div class="col-md-2">
          <a href="dskleads_new.php" class="btn btn-info" role="button"><i class="fa fa-plus"></i> Import leads</a>
        </div>
        <div class="col-md-2">
          <div class="form-group">
              <button onclick="Export()" style="margin-left: 40px;" class="btn btn-primary">ExportData</button>
          </div>
        </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box">
                <div class="box-body table-responsive">
                  <form id="massActionFrom">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 80px;"><input type="checkbox" id="checkall" />Select All</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Whatsapp No</th>
                        <th>Alternative No</th>
                        <th>Created At</th>
                        <th style="width: 70px;">Action</th>
                        <!--<th>Workout</th>-->
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $count=1;
                    
                    foreach($arrQuery as $key=>$val)
                    {
                    ?>
                       <tr style="<?php if ($val['color_code'] !='' && $val['color_code'] != '#ffffff') { echo 'background-color: '.$val['color_code']; } ?>">
                        <td><input type="checkbox"  id="agree" name="selectAll[]" value="<?php echo $val['id']; ?>"></td>
                        <td><?php echo $val['id'];?></td>
                        <td><?php echo $val['name'];?></td>
                        <td><?php echo $val['email'];?></td>
                        <td><?php echo $val['mobile_no'];?></td>
                        <td><?php echo $val['alternative_no'];?></td>
                        <td><?php echo $val['created_at'];?></td>
                      <td>
                        <div class="btn-group btn-group-xs">
                        <a href="?action=delete&id=<?php echo $val['id'];?>" onclick="return areyousure();" class="btn btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>
                        <a type="button" class="btn btn-primary" class="btn btn-info" onclick="sendMail('<?php echo $val['id'] ?>')" title="Send mail" data-toggle="tooltip"><i class="fa fa-envelope"></i></a>
                        <a type="button" class="btn btn-primary" class="btn btn-info" onclick="moveData('<?php echo $val['id'] ?>')" title="Move" data-toggle="tooltip"><i class="fa fa-arrows"></i></a>
                        <a type="button" class="btn btn-primary" class="btn btn-info" onclick="cancelData('<?php echo $val['id'] ?>')" title="cancel" data-toggle="tooltip"><i class="fa fa-close"></i></a>
                         <a type="button" class="btn btn-primary" class="btn btn-info" onclick="Color('<?php echo $val['id'] ?>')" title="Change Color" data-toggle="tooltip"><i class="fa fa-adjust"></i></a>
                        </div>
                      </td>
                      </tr>
                
                   <?php
                     }
                   ?>

                  </table>
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
<div id="qDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Enter Message</h4>
      </div>
       <form role="form" id="bulkattach" method="post" role="form" enctype="multipart/form-data">
      <div class="modal-body" id="mdetail">
        <div class="form-group">
        <label for="comment">Email Content:</label>
        <textarea class="form-control" rows="5" id="comment"></textarea>
        </div>
        <div class="form-group">
          <label for="attachment">Attachment:</label>
          <input type="file" class="form-control" name="bulkattachment">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="Send();">Send</button>
      </div>
    </form>
    </div>

  </div>
</div>
<div id="mDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Move to</h4>
      </div>
      <div class="modal-body" id="mdetail">
        <div class="form-group">
        <input type="hidden" name="id" id="id">
        <select class="form-control" id="moveoption">
          <option>Action</option>
          <option value="leads">Leads</option>
          <option value="second_payment">2nd Payment Detail</option>
        </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="Move();">Move</button>
      </div>
    </div>
  </div>
</div> 
<div id="cancelDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Enter Cancelation Reason</h4>
      </div>
      <div class="modal-body" id="canceldetail">
        <div class="form-group">
        <input type="hidden" name="id" id="cid">
        <label for="comment">Reason:</label>
        <textarea class="form-control" rows="5" id="cancelReason"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="Cancel();">Cancel</button>
      </div>
    </div>

  </div>
</div>
<div id="mailDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Email Message</h4>
      </div>
      <form role="form" id="attach" method="post" role="form" enctype="multipart/form-data">
      <div class="modal-body" id="canceldetail">
        <div class="form-group">
        <input type="hidden" name="id" id="mailid">
        <label for="comment">Message:</label>
        <textarea class="form-control" rows="5" id="mail"></textarea>
        </div>
        <div class="form-group">
          <label for="attachment">Attachment:</label>
          <input type="file" class="form-control" name="attachment">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="Mail();">Send Mail</button>
      </div>
    </form>
    </div>

  </div>
</div>
<div id="colorDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Email Message</h4>
      </div>
      <form role="form" id="attach" method="post" role="form" enctype="multipart/form-data">
      <div class="modal-body" id="colordetail">
        <div class="form-group">
        <input type="hidden" name="id" id="colorid">
          <label for="color">Select Color:</label>
          <input type="color" class="form-control" id="color" name="color">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="changeColor();">Change Color</button>
      </div>
    </div>
    </form>
    </div>

  </div>
</div>
<div id="masscolorDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: #FFF;background: #4357ca;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalHead">Email Message</h4>
      </div>
      <form role="form" id="attach" method="post" role="form" enctype="multipart/form-data">
      <div class="modal-body" id="masscolordetail">
        <div class="form-group">
          <label for="color">Select Color:</label>
          <input type="color" class="form-control" id="masscolor" name="color">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="changeBulkColor();">Change Color</button>
      </div>
    </div>
    </form>
    </div>

  </div>
</div>
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
        
      });
    
     </script>
     <?php include('footer.php');?>
     <script type="text/javascript">
         function sendMail(id){
          $("#mailid").val(id);
          $("#mailDetail").modal();
      }

    function Mail() {
        var msg = $("#mail").val();
        var formData = new FormData($('#attach')[0]);
        formData.append('attachment', $('input[type=file]')[0].files[0]);
        formData.append('email',msgddd);
        $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=Mail',
              data:formData,
              contentType: false,
              processData: false,
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, Cant Send Email Right Now, Please try Again</div>');     
              }
            }
        });
    }

    function DeleteAll() {
      var confirm = areyousure();
      if (confirm == false) {
        return false;
        }else{
            var ids =   $("#massActionFrom").serializeArray();
            $.ajax({
            type:'post',
            url: '_ajax_dsk_lead_massaction.php?action=massDelete',
            data:{leadid:ids},
            success:function(result) {
            if(result == '1')
            {
              window.location.href='dsk_leads_photo.php';
            }
            else if (result == '0')
            {
              $("#status").show().html('<div class="alert alert-danger">Sorry, Some Record are not deleted Please try Again</div>');     
            }
          }
        });
      }
    }

    function Leads() {
      var confirm = areyousure();
      if (confirm == false) {
        return false;
        }else{
             var ids =   $("#massActionFrom").serializeArray();
              $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=massLeads',
              data:{leadid:ids},
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, Some Record are not Moved Please try Again</div>');     
              }
            }
          });
        }
    }

    function paymentReceived() {
      var confirm = areyousure();
      if (confirm == false) {
        return false;
        }else{
             var ids =   $("#massActionFrom").serializeArray();
              $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=massMovePayment',
              data:{leadid:ids},
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, Some Record are not Moved Please try Again</div>');     
              }
            }
          });
        }
    }

    function SendEmail() {
       $("#qDetail").modal();
    }

    function Send() {
        var ids =   $("#massActionFrom").serializeArray();
        var data = JSON.stringify(ids)
        var content = $("#comment").val();
        var formData = new FormData($('#bulkattach')[0]);
        formData.append('bulkattachment', $('input[type=file]')[0].files[0]);
        formData.append('content',content);
        formData.append('ids',data);
        $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=massEmail',
              data:formData,
              contentType: false,
              processData: false,
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, Some Email are not Sent Please try Again</div>');     
              }
            }
          });
    }

    function moveData(id) {
        $("#id").val(id);
        $("#mDetail").modal();
    }

    function Move() {
        var id = $("#id").val();
        var moveto = $("#moveoption").val();
        if (moveto == 'leads') {
            $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=movetoleads',
              data:{leadid:id},
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, can not Move Please try Again</div>');     
              }
            }
          });
        }else if (moveto == 'second_payment') {
             $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=movetosecond',
              data:{leadid:id},
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, can not Move Please try Again</div>');     
              }
            }
          });
        } 
    }

    function cancelData(id) {
        $("#cid").val(id);
        $("#cancelDetail").modal();
    }

    function Cancel() {
       var id = $("#cid").val();
       var reason = $("#cancelReason").val();
       $.ajax({
              type:'post',
              url: '_ajax_dsk_lead_massaction.php?action=cancelData',
              data:{leadid:id,creason:reason},
              success:function(result) {
              if(result == '1')
              {
                window.location.href='dsk_leads_photo.php';
              }
              else if (result == '0')
              {
                $("#status").show().html('<div class="alert alert-danger">Sorry, can not Move Please try Again</div>');     
              }
          }
      });
    }

    function Export() {
      var conf = confirm("Export Leads to CSV?");
        if(conf == true)
        {
          window.open("exportleads.php?action=exportphoto", '_blank');
        }
    }

    function areyousure()
    {
      if(confirm('Are you sure.'))
    {
      return true
      
    }else {
      
      return false;
    }
  }

  function Color(id) {
      $("#colorid").val(id);
      $("#colorDetail").modal();
  }

  function changeColor() {
      var id = $("#colorid").val();
      var color_code = $("#color").val();
      $.ajax({
        type:'post',
        url: '_ajax_dsk_lead_massaction.php?action=changeRowColor',
        data:{leadid:id,code:color_code},
        success:function(result) {
          if(result == '1')
            {
              window.location.href='dsk_leads_photo.php';
            }
            else if (result == '0')
            {
              $("#status").show().html('<div class="alert alert-danger">Sorry, can not Move Please try Again</div>');     
            }
        }
      });
  }

  function ChangeMassColor() {
    $("#masscolorDetail").modal();
  }

  function changeBulkColor(argument) {
    var ids =   $("#massActionFrom").serializeArray();
    var color_code = $("#masscolor").val();
    $.ajax({
        type:'post',
        url: '_ajax_dsk_lead_massaction.php?action=changeBulkColor',
        data:{leadsid:ids,code:color_code},
        success:function(result) {
        if(result == '1')
        {
          window.location.href='dsk_leads_photo.php';
        }
        else if (result == '0')
        {
          $("#status").show().html('<div class="alert alert-danger">Sorry, Some Email are not Sent Please try Again</div>');     
        }
      }
    });
  }

</script>


