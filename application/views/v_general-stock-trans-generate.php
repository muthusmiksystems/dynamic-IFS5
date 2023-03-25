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
                                <h3><i class="icon-truck"></i> General Delivery</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                                            <!-- Loading -->
                            <div class="pageloader"></div>
                              <!-- End Loading -->
                            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>general/generalStockTransSave">
                            <!-- Start Item List -->
                            <section class="panel">
                                <header class="panel-heading">
                                    DC No : 
                                </header>
                                <div class="panel-body">
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
                                  }                                                            if($this->session->flashdata('error'))
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
                                  <div class="form-group col-lg-3">
                                     <label for="dc_from">From</label>
                                     <select class="form-control select2" id="dc_from" name="dc_from" required>
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
                                  <div class="form-group col-lg-3">
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
                                  <div class="form-group col-lg-3">
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
                                  <div class="form-group col-lg-3">
                                     <label for="dc_date">Date</label>
                                     <input class="form-control" value="<?=date("d-m-Y H:i:s"); ?>" id="dc_date" name="dc_date" required type="text" disabled="disabled">
                                  </div>
                                  <div class="form-group col-lg-6">
                                     <label for="attn_to">Attn.To</label>
                                     <input class="form-control" id="attn_to" name="attn_to" type="text">
                                  </div>
                                  <!-- Start Item List -->
                                  <table class="table table-bordered table-striped table-condensed">                                                           <thead>
                                      <tr>
                                          <th width="5%">#</th>
                                          <th width="10%">Item Code</th>
                                          <th width="25%">Item Name</th>
                                          <th width="20%">Supplier</th>
                                          <th width="5%">Quantity</th>
                                          <th width="5%">Uom</th>
                                          <th width="10%">Rate</th>
                                          <th width="10%">Gross Weight</th>
                                          <th width="10%">Net Weight</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                      // print_r($this->cart->contents());
                                      $sno = 1;
                                      foreach ($this->cart->contents() as $items) {
                                        ?>
                                        <tr>
                                            <td><?=$sno; ?></td>
                                            <td><?=$items['id']; ?></td>
                                            <td>
                                              <?=$this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $items['id'], 'item_name'); ?><br>
                                              <textarea name="item_descriptions[<?=$items['id']; ?>]"></textarea>
                                            </td>
                                            <td>
                                              <?=$this->m_masters->getmasterIDvalue('bud_general_customers', 'company_id', $items['supplier'], 'company_name'); ?>
                                            </td>
                                            <td><?=$items['qty']?></td>
                                            <td>
                                              <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $items['item_uom'], 'uom_name'); ?>
                                            </td>
                                            <td><?=$items['price']; ?></td>
                                            <td>
                                              <input type="text" style="width:100%;" name="gross_weights[<?=$items['id']; ?>]" required>
                                            </td>
                                            <td>
                                              <input type="text" style="width:100%;" name="net_weights[<?=$items['id']; ?>]" required>
                                            </td>
                                        </tr>
                                        <?php
                                        $sno++;
                                      }
                                      ?>
                                      <tr>
                                        <td colspan="9">
                                          Total Bundels <input type="text" size="10" name="dc_total_bundels" required>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="4">
                                          Sent Through
                                          <textarea class="form-control" name="dc_sent_through"></textarea>
                                        </td>
                                        <td colspan="5">
                                          Remarks
                                          <textarea class="form-control" name="dc_remarks"></textarea>
                                        </td>
                                      </tr>                                                            </tbody>
                                  </table>
                                </div>
                            </section>
                            <section class="panel">
                                <header class="panel-heading">
                                    <button class="btn btn-danger" type="submit">Save</button>
                                </header>
                            </section>
                            <!-- End Item List -->
                            </form>
                            <!-- End Talbe List  -->
                      </div>
                </div>             <!-- page end-->
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
    $(function(){
      $( "a.removecart" ).live( "click", function() {
          var row_id = $(this).attr('id');
          var url = "<?=base_url()?>general/removeGeneralDCItem/"+row_id;
          var postData = 'row_id='+row_id;
          $.ajax({
              type: "POST",
              url: url,
              success: function(msg)
              {
                 $('#cartdata').load('<?=base_url();?>general/generalDeliveryItems');
              }
          });
          return false;
      });
    });  
  </script>

  </body>
</html>
