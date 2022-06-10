<?php
include('header.php');
include('sidebar.php');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-calendar" aria-hidden="true"></i></i> DSK Leads MANAGEMENT
        <small>Import New leads</small>
      </h1>
       <div id="status"></div>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> DSK EVENT</a></li>
        <li>Leads List</li>
        <li class="active">Import Leads</li>
      </ol>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                    <form role="form" id="add" method="post" role="form" enctype="multipart/form-data">
                    <div class="box-header">
                    <h3 class="box-title"><a href="dskcsv/sample/dskeventleads.csv" download>Download Sample CSV File.<i class="fa fa-download" aria-hidden="true"></i></a></h3>
                    </div>
                    <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Choose your CSV File</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">File<span class="addnewrequired">*</span></label>
                                        <input type="file" class="form-control" name="csv" accept=".csv" required="true">
                                    </div> 
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="button" class="btn btn-primary" value="Submit" onclick="AddNew();" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>   
                </div>
                </form>
            </div>
        </div>    
    </section> 
</div>
<?php include('footer.php');?>
<script type="text/javascript">
    function AddNew() {
        var formData = new FormData($('#add')[0]);
        formData.append('csv', $('input[type=file]')[0].files[0]);
        $.ajax({
            type:'post',
            url: '_ajax_import_dsk_leads.php?action=addnew',
            data: formData,
            contentType: false,
            processData: false,
            success:function(result) {
                if(result == '1')
                {
                   $("#status").show().html('<div class="alert alert-success"> New record is inserted</div>');
                   window.location.href='dskleads.php';

                
                }
                else if (result == '0' || result == '2' || result == '3')
                {
                    $("#status").show().html('<div class="alert alert-danger">Sorry, there is something problem please try again later</div>');     
                }
            }
        });
    }
</script>