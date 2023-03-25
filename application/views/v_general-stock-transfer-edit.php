<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?=$page_title; ?> | INDOFILA SYNTHETICS</title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
      <?php
    }
    ?>
    


  
  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <?php $this->load->view('html/v_header.php'); ?>
      <!--header end-->
      <!--sidebar start-->
      <?php $this->load->view('html/v_sidebar.php'); ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <h3><i class="icon-truck"></i> Stock Transfer</h3>
                            </header>
                            <div class="panel-body" id="sample-box">
                            <!-- Item Sample -->
                            </div>
                            <?php
                            if($this->session->flashdata('warning'))
                            {
                              ?>
                              <div class="alert alert-warning fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="icon-remove"></i>
                                </button>
                                <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                              </div>
                              <?php
                            }                                                      if($this->session->flashdata('error'))
                            {
                              ?>
                              <div class="alert alert-block alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="icon-remove"></i>
                                </button>
                                <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                            </div>
                              <?php
                            }
                            if($this->session->flashdata('success'))
                            {
                              ?>
                              <div class="alert alert-success alert-block fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                                  <h4>
                                      <i class="icon-ok-sign"></i>
                                      Success!
                                  </h4>
                                  <p><?=$this->session->flashdata('success'); ?></p>
                              </div>
                              <?php
                            }
                            ?>
                        </section>
                    </div>
                </div>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>general/generalStockTransSave">
                <div class="row">
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                                Transfer From
                            </header>                                                <div class="panel-body">                                                        <div class="form-group col-lg-6">
                                   <label for="item_name">Item Name</label>
                                   <select class="item-select form-control select2" id="item_name" name="item_name" required>
                                   <option value="">Select Item</option>
                                   <?php
                                   foreach ($items as $row) {
                                     ?>
                                     <option value="<?=$row['item_id']; ?>"><?=$row['item_name']; ?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>
                                <div class="form-group col-lg-6">
                                   <label for="item_code">Item Code</label>
                                   <select class="item-select form-control select2" id="item_code" name="item_code" required>
                                   <option value="">Select Code</option>
                                   <?php
                                   foreach ($items as $row) {
                                     ?>
                                     <option value="<?=$row['item_id']; ?>"><?=$row['item_id']; ?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>
                                <div class="form-group col-lg-6">
                                   <label for="concern_id">From Concern</label>
                                   <select class="form-control select2" id="concern_id" name="concern_id" required>
                                   <option value="">Select Concern</option>
                                   <?php
                                   foreach ($concerns as $row) {
                                     ?>
                                     <option value="<?=$row['concern_id']; ?>"><?=$row['concern_name']; ?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>
                                <div class="form-group col-lg-6">
                                   <label for="stockroom_id">From Stock Room</label>
                                   <select class="form-control select2" id="stockroom_id" name="stockroom_id" required>
                                   <option value="">Select</option>
                                   <?php
                                   foreach ($stockrooms as $row) {
                                     ?>
                                     <option value="<?=$row['stock_room_id']; ?>"><?=$row['stock_room_name']; ?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="current_stock">Current Stock</label>
                                   <input type="text" style="padding: 6px 3px;" class="form-control" id="current_stock" name="current_stock" readonly="readonly" value="0">
                                </div>
                                <div class="form-group col-lg-4">
                                   <label for="item_qty">Qty</label>
                                   <input type="text" style="padding: 6px 3px;" class="form-control" id="item_qty" name="item_qty" required>                                                           </div>
                                <div class="form-group col-lg-4">
                                   <label for="item_uom">Uom</label>
                                   <select class="form-control select2" id="item_uom" name="item_uom" required>
                                   <option value="">Select</option>
                                   <?php
                                   foreach ($uoms as $row) {
                                     ?>
                                     <option value="<?=$row['uom_id']; ?>"><?=$row['uom_name']; ?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>
                                <div class="form-group col-lg-11">
                                  <label for="dc_sent_through">Sent Through</label>
                                  <textarea class="form-control" name="dc_sent_through" id="dc_sent_through"></textarea>
                                </div>
                            </div>
                        </section>
                  </div>
                  <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Transfer To
                        </header>                                            <div class="panel-body">
                          <div class="form-group col-lg-6">
                             <label for="dc_to">To</label>
                             <select class="form-control select2" id="dc_to" name="dc_to" required>
                             <option value="">Select</option>
                             <?php
                             foreach ($concerns as $row) {
                               ?>
                               <option value="<?=$row['concern_id']; ?>"><?=$row['concern_name']; ?></option>
                               <?php
                             }
                             ?>
                             </select>
                          </div>
                          <div class="form-group col-lg-6">
                             <label for="staff_name">Staff</label>
                             <select class="form-control select2" id="staff_name" name="staff_name" required>
                             <option value="">Select</option>
                             <?php
                             foreach ($staffs as $row) {
                               ?>
                               <option value="<?=$row['ID']; ?>"><?=$row['user_login']; ?></option>
                               <?php
                             }
                             ?>
                             </select>
                          </div>
                          <div class="form-group col-lg-6">
                             <label for="gross_weights">Gross Weight</label>
                             <input class="form-control" id="gross_weights" name="gross_weights" type="text">
                          </div>
                          <div class="form-group col-lg-6">
                             <label for="net_weights">Net Weight</label>
                             <input class="form-control" id="net_weights" name="net_weights" type="text">
                          </div>
                          <div class="form-group col-lg-6">
                             <label for="attn_to">Attn.To</label>
                             <input class="form-control" id="attn_to" name="attn_to" type="text">
                          </div>
                          <div class="form-group col-lg-6">
                             <label for="dc_total_bundels">Total Bundel</label>
                             <input class="form-control" id="dc_total_bundels" name="dc_total_bundels" type="text">
                          </div>
                          <div class="form-group col-lg-11">
                            <label for="dc_remarks">Remarks</label>
                            <textarea class="form-control" name="dc_remarks" id="dc_remarks"></textarea>
                          </div>
                        </div>
                    </section>
                  </div>
                  <!-- Loading -->
                  <div class="pageloader"></div>
                  <!-- End Loading -->
                  <section class="panel">
                      <header class="panel-heading">
                          <button class="btn btn-danger" type="submit">Save</button>
                      </header>
                  </section>
                </div>
                </form>  

                <div class="row">
                    <div class="col-lg-12">
                    <section class="panel">
                      <header class="panel-heading">
                          Delivery details 
                      </header>
                      <div class="panel-body">
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Dc No</th>
                                <th>From</th>
                                <th>From Staff</th>
                                <th>To</th>
                                <th>To Staff</th>
                                <th>Transfer Date</th>
                                <th>Accepted Date</th>
                                <th></th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($peding_dc as $row) {
                              $transfer_id = $row['transfer_id'];
                              $status = $row['status'];
                              $staff_name = $row['staff_name'];
                              if($transfer_id != '')
                              {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$transfer_id; ?></td>
                                    <td><?=$row['from_concern']; ?></td>                                                             <td><?=$row['from_staff_name']; ?></td>                                                             <td><?=$row['to_concern']; ?></td>                                                             <td><?=$row['to_staff_name']; ?></td> 
                                    <td><?=$row['transfer_date']; ?></td>
                                    <td><?=$row['accepted_date']; ?></td>
                                    <td>
                                      <?php
                                      if($staff_name == $this->session->userdata('user_id'))
                                      {
                                        if($status == 1)
                                        {
                                          ?>
                                          <a href="<?=base_url(); ?>general/generalDcAcceptance/<?=$transfer_id; ?>" class="label label-danger">View &amp; Accept</a>
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                          <a href="<?=base_url(); ?>general/generalStockTransDc/<?=$transfer_id; ?>" class="<?=($status==0)?'label label-success':'label label-danger'; ?>">View</a>
                                          <?php
                                        }
                                        ?>
                                        <?php
                                      }
                                      else
                                      {
                                        ?>
                                        <a href="<?=base_url(); ?>general/generalStockTransDc/<?=$transfer_id; ?>" class="<?=($status==0)?'label label-success':'label label-danger'; ?>">View</a>
                                        <?php
                                      }
                                      ?>
                                    </td>
                                </tr>
                                <?php                                                      }
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </section>
                    <!-- Loading -->
                    <div class="pageloader"></div>
                    <!-- End Loading -->
                </div>
              </div>  
                <!-- page end-->
            </section>
      </section>
      <!--main content end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <?php
    foreach ($js as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>    

    <!--common script for all pages-->
    <?php
    foreach ($js_common as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

    <!--script for this page-->
    <?php
    foreach ($js_thispage as $path) {
      ?>
      <script src="<?=base_url().'themes/default/'.$path; ?>"></script>
      <?php
    }
    ?>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });
      $("#add").click(function () {
        var $tableBody = $('#tbl').find("tbody"),
        $trFirst = $tableBody.find("tr:first"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trFirst.clone(true);
        $trLast.after($trNew);
        $trNew.find("input").val("");
        return false;
      });
    $('.remove-row').live('click', function(){
        $(this).closest('tr').remove();
    });

    $(".item-select").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());
        var item_code = $(this).val();
        var url = "<?=base_url()?>general/getItemImage/"+item_code;
        var postData = 'item_code='+item_code;
        $.ajax({
          type: "POST",
          url: url,
          // data: postData,
          success: function(result)
          {                if(result != '')
            {
              $("#sample-box").html('<img src="<?=base_url(); ?>uploads/itemsamples/general/'+result+'" style="width:auto;height:70px;max-width:100%;">');                  }
            else
            {
              $("#sample-box").html('');
            }
          }
        });
        return false;
    });

    $(function(){
      $("#stockroom_id").change(function() {
          var stockroom_id = $("#stockroom_id").val();
          var concern_id = $("#concern_id").val();
          var item_name = $("#item_name").val();
          var url = "<?=base_url()?>general/getGeneralStock";
          var postData = 'item_id='+item_name+'&concern_id='+concern_id+'&stockroom_id='+stockroom_id;
          // alert(postData);
          $.ajax({
              type: "POST",
              url: url,
              data: postData,
              success: function(result)
              {
                $("#current_stock").val(result);
              }
          });
          return false;
      });
    });
  </script>

  </body>
</html>
