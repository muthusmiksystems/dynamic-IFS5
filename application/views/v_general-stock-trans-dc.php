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
    foreach ($print_css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet" media="print">
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
                                <h3><i class="icon-truck"></i> Stock Transfer Dc</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                                            <!-- Loading -->
                            <div class="pageloader"></div>
                              <!-- End Loading -->
                            <!-- Start Item List -->
                            <section class="panel">
                                <header class="panel-heading">
                                    Delivery details 
                                </header>
                                <div class="panel-body">
                                  <?php
                                  foreach ($transfer_details as $row) {
                                    $transfer_id = $row['transfer_id'];
                                    $transfer_date = $row['transfer_date'];
                                    $transfer_from = $row['transfer_from'];
                                    $transfer_by = $row['transfer_by'];
                                    $transfer_to = $row['transfer_to'];                                                              $staff_name = $row['staff_name'];                                                              $attn_to = $row['attn_to'];                                                              $dc_total_bundels = $row['dc_total_bundels'];                                                              $dc_sent_through = $row['dc_sent_through'];                                                              $dc_remarks = $row['dc_remarks'];                                                            }
                                  $date = explode(" ", $transfer_date);
                                  $ed = explode("-", $date[0]);
                                  $dc_date = $ed[2].'-'.$ed[1].'-'.$ed[0];

                                  // $dc_from = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $transfer_from, 'concern_name');
                                  // $dc_to = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $transfer_to, 'concern_name');
                                  $from_concern = $this->m_masters->get_concern($transfer_from);
                                  $to_concern = $this->m_masters->get_concern($transfer_to);
                                  $from_staff = $this->m_masters->getmasterIDvalue('bud_users', 'ID', $transfer_by, 'user_login');
                                  $to_staff = $this->m_masters->getmasterIDvalue('bud_users', 'ID', $staff_name, 'user_login');
                                  ?>                                                            <!-- Start Item List -->
                                  <table class="table table-bordered table-striped table-condensed">
                                    <tbody>
                                    <tr>
                                      <td colspan="8" align="center"><h3>General Delivery (Stock Transfer)</h3></td>
                                    </tr>
                                    <tr>
                                      <td colspan="4">
                                        <strong>FROM:</strong><br>
                                        <?php if($from_concern): ?>
                                          <strong><?php echo $from_concern->concern_name; ?></strong><br>
                                          <strong><?php echo $from_concern->concern_address; ?></strong><br>                                                                            <strong>GST : <?php echo $from_concern->concern_gst; ?></strong><br>
                                        <?php endif; ?>
                                        Staff Name : <?=$from_staff; ?>
                                      </td>
                                      <td colspan="4">
                                        <strong>TO:</strong><br>
                                        <?php if($to_concern): ?>
                                          <strong><?php echo $to_concern->concern_name; ?></strong><br>
                                          <strong><?php echo $to_concern->concern_address; ?></strong><br>                                                                           <strong> GST : <?php echo $to_concern->concern_gst; ?></strong><br>
                                        <?php endif; ?>
                                        Staff Name : <?=$to_staff; ?>                                                                    </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">DC.No</td>
                                      <td colspan="2"><strong style="font-size:20px;"><?=$transfer_id; ?></strong></td>
                                      <td colspan="2">Date </td>
                                      <td colspan="2"><?=$dc_date; ?> <?=$date[1]; ?></td>
                                    </tr>
                                    <tr>
                                      <td width="10%">#</td>
                                      <td width="10%">Item Code</td>
                                      <td width="30%">Item Name</td>
                                      <td width="10%">HSN Code</td>                                                                    <td width="10%">Quantity</td>
                                      <td width="10%">Uom</td>
                                      <td width="10%">Gross Weight</td>
                                      <td width="10%">Net Weight</td>
                                    </tr>
                                    <?php
                                    $items = $this->m_masters->getmasterdetails('bud_general_transfer_items', 'transfer_id', $transfer_id);
                                    $sno = 1;
                                    foreach ($items as $row) {
                                      $dc_supplier = $row['dc_supplier'];
                                      $item_id = $row['item_id'];
                                      $item_description = $row['item_description'];
                                      $item_qty = $row['item_qty'];
                                      $item_uom = $row['item_uom'];
                                      $item_rate = $row['item_rate'];
                                      $gross_weight = $row['gross_weight'];
                                      $gross_wt_received = $row['gross_wt_received'];
                                      $net_weight = $row['net_weight'];
                                      ?>
                                      <tr>
                                        <td><?=$sno; ?></td>
                                        <td><?=$item_id; ?></td>
                                        <td>
                                          <?=$this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_id, 'item_name'); ?><br>
                                          <?=$item_description; ?>
                                        </td>
                                        <td>
                                         <?=$this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_id, 'hsn_code'); ?>
                                        </td>
                                        <td><?=$item_qty; ?></td>
                                        <td><?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item_uom, 'uom_name'); ?></td>
                                        <td><?=$gross_weight; ?></td>
                                        <td><?=$net_weight; ?></td>
                                      </tr>
                                      <?php
                                      $sno++;
                                    }
                                    ?>
                                    <tr>
                                      <td colspan="8">
                                        <strong>Total Bundels: </strong> <?=$dc_total_bundels; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="4">
                                        <strong>Sent Through: </strong>
                                        <?=$dc_sent_through; ?>
                                      </td>
                                      <td colspan="4">
                                        <strong>Remarks: </strong>
                                        <?=$dc_remarks; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="8">
                                        <div class="print-div col-lg-4">
                                            <strong>Received By</strong>
                                            <br/>
                                            <br/>
                                         </div>
                                         <div class="print-div col-lg-4">
                                            <strong>Prepared By</strong>
                                            <br/>
                                            <br/>
                                            <?=$this->m_masters->getmasterIDvalue('bud_users', 'ID', $this->session->userdata('user_id'), 'user_login'); ?><br>
                                         </div>
                                         <div class="col-lg-4" style="float:right;text-align:right;">
                                            Authorized Signature
                                            <br/>
                                            <br/>
                                         </div>
                                      </td>
                                    </tr>                                                                                           </tbody>
                                  </table>
                                </div>
                            </section>
                            <section class="panel">
                                <header class="panel-heading">
                                    <button class="btn btn-danger" onclick="window.print()" type="button">Print</button>
                                </header>
                            </section>
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
