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
                                <h3><i class="icon-truck"></i> Print Stock Transfer</h3>
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
                        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>general/genStockTranDc_print">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">                                                <div class="panel-body">                                                        <div class="form-group col-lg-6">
                                   <label for="from_concern">From Concern</label>
                                   <select class="item-select form-control select2" id="from_concern" name="from_concern" required>
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
                                   <label for="to_concern">To Concern</label>
                                   <select class="item-select form-control select2" id="to_concern" name="to_concern" required>
                                   <option value="">Select Concern</option>
                                   <?php
                                   foreach ($concerns as $row) {
                                     ?>
                                     <option value="<?=$row['concern_id']; ?>"><?=$row['concern_name']; ?></option>
                                     <?php
                                   }
                                   ?>
                                   </select>
                                </div>                                                    </div>
                        </section>
                  </div>                            <!-- Loading -->
                  <div class="pageloader"></div>
                  <!-- End Loading -->
                  <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit" name="search">Search</button>
                        </header>
                  </section>                          </div>
                </form>  
                <?php
                /*echo "<pre>";
                print_r($stock_trans_dc);
                echo "</pre>";*/
                ?>
                <form class="cmxform form-horizontal tasi-form" role="form" method="post" action="<?=base_url();?>general/stockTranDc_print_view">
                <input type="hidden" name="from_concern" value="<?=$from_concern; ?>">
                <input type="hidden" name="to_concern" value="<?=$to_concern; ?>">
                <div class="row">
                    <div class="col-lg-12">
                    <section class="panel">
                      <header class="panel-heading">
                          Search Result
                      </header>
                      <div class="panel-body">
                        <table class="table table-striped border-top">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Dc No</th>
                                <th>From Concern</th>
                                <th>From Staff</th>
                                <th>Particulars</th>
                                <th>Qty</th>
                                <th>To Concern</th>
                                <th>To Staff</th>
                                <th>Transfer Date</th>
                                <th>
                                  <label class="checkbox-inline">
                                  <input type="checkbox" id="selecctall">
                                  <b>Select All</b>
                                  </label>
                                </th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            if(sizeof($stock_trans_dc) > 0)
                            {
                              foreach ($stock_trans_dc as $row) {
                                $transfer_id = $row['transfer_id'];
                                $status = $row['status'];
                                $staff_name = $row['staff_name'];
                                if($transfer_id != '')
                                {
                                  ?>
                                  <tr class="odd gradeX">
                                      <td><?=$sno; ?></td>
                                      <td><?=$transfer_id; ?></td>
                                      <td><?=$row['from_concern']; ?></td>                                                               <td><?=$row['from_staff_name']; ?></td>                                                               <td><?=$row['item_name']; ?></td>                                                               <td><?=$row['item_qty']; ?> <?=$row['uom_name']; ?></td>                                                               <td><?=$row['to_concern']; ?></td>                                                               <td><?=$row['to_staff_name']; ?></td> 
                                      <td><?=$row['transfer_date']; ?></td>
                                      <td>
                                        <input type="checkbox" name="selected_dc[]" class="checkbox" value="<?=$transfer_id; ?>">
                                      </td>                                                              </tr>
                                  <?php                                                        }
                                $sno++;
                              }
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
               <button class="btn btn-danger" type="submit" name="print">Print</button>
              </form> 
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
          {                $("#concern_id").select2("val", '');
            $("#stockroom_id").select2("val", '');
            $("#current_stock").val(0);
            if(result != '')
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
    $("#concern_id").change(function() {
      $("#stockroom_id").select2("val", '');
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
                // console.log(result);
              }
          });
          return false;
      });
    });

    $('#selecctall').click(function(event) {  //on click
          var no_boxes = 0;
          var net_weight = 0;
          var total_meters = 0;
          if(this.checked) { // check select status
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = true;
              });
          }else{
              $('.checkbox').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"                           });           }
      });
  </script>

  </body>
</html>
