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
                                <h3><i class="icon-book"></i> New Quotation</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
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
                            </header>
                        </section>
                    </div>
                </div>
                <?php
                foreach ($quotations as $quotation) {
                    $quote_enq_id = $quotation['quote_enq_id'];
                    $quote_category = $quotation['quote_category'];
                    $quote_customer = $quotation['quote_customer'];
                    $quote_marketing_staff = $quotation['quote_marketing_staff'];
                    $quote_remarks = $quotation['quote_remarks'];

                    $quote_customer_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_category', $quotation['quote_customer'], 'cust_name');
                }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>productions/savejobinward">
                        <input type="hidden" name="job_enq_id" value="<?=$quote_enq_id; ?>">
                        <input type="hidden" name="job_category" value="<?=$quote_category; ?>">
                        <section class="panel">                                                <header class="panel-heading">
                                Jobinward Details
                            </header>                                                <div class="panel-body">
                              <div class="form-group col-lg-4">
                                <label for="job_date">Date</label>
                                <input class="form-control dateplugin" id="job_date" name="job_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_customer_name">Customer Name</label>
                                <input type="hidden" name="job_customer" value="<?=$quote_customer; ?>">
                                <input class="form-control" id="job_customer_name" name="job_customer_name" value="<?=$quote_customer_name; ?>" required>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_customer_po_no">Customer PO No</label>
                                <input class="form-control" id="job_customer_po_no" name="job_customer_po_no" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_purpose">Purpose</label>
                                <input class="form-control" id="job_purpose" name="job_purpose" type="text">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="job_marketing_staff">Marketing Staff</label>
                                <input class="form-control" id="job_marketing_staff" name="job_marketing_staff" value="<?=$quote_marketing_staff; ?>" type="text">
                              </div>                                                  </div>
                        </section>
                                        <!-- Start Item List -->
                        <section class="panel">
                            <header class="panel-heading">
                                Items
                            </header>
                            <div class="panel-body">
                              <table class="table table-striped table-hover" id="cartdata">                                                        <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Group</th>
                                    <th class="hidden-phone">Item Name</th>
                                    <th class="">Shade No</th>
                                    <th class="">Lot No</th>
                                    <th class="">Uom</th>
                                    <th class="">Quantity</th>
                                    <th class="">Rate</th>
                                    <th class=""></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sno = 1;
                                foreach ($items as $item) {
                                  ?>
                                  <tr>
                                      <td><?=$sno; ?></td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_itemgroups', 'group_id', $item['enq_itemgroup'], 'group_name'); ?>
                                      </td>
                                      <td>
                                        <?=$this->m_masters->getmasterIDvalue('bud_items', 'item_id', $item['enq_item'], 'item_name'); ?>
                                      </td>
                                      <td class="">
                                        <?=$this->m_masters->getmasterIDvalue('bud_shades', 'shade_id', $item['enq_itemcolor'], 'shade_name'); ?>
                                      </td>
                                      <td class="">
                                        <select class="form-control" name="item_lot_no[<?=$item['enq_item_id']; ?>]">
                                        <?php
                                        $lots = $this->m_masters->getactiveCdatas('bud_lots', 'lot_status', 'category', $quote_category);
                                        foreach ($lots as $lot) {
                                          ?>
                                          <option value="<?=$lot['lot_id']; ?>" ><?=$lot['lot_no']; ?></option>
                                          <?php
                                        }
                                        ?>
                                        </select>
                                      </td>
                                      <td class="">
                                        <?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item['enq_itemuom'], 'uom_name'); ?>
                                      </td>
                                      <td><?=$item['enq_required_qty']; ?></td>
                                      <td>
                                          <?=$item['enq_item_rate']; ?>
                                      </td>
                                      <td>
                                        <a href="#" id="<?=$item['enq_item_id']; ?>" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
                                      </td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>                                                      </tbody>
                              </table>
                            </div>
                        </section>
                        <!-- End Item List -->

                        <!-- Start Remarks -->
                        <section class="panel">                                                <header class="panel-heading">
                                Other Details
                            </header>                                              <div class="panel-body">
                              <div class="form-group col-lg-12">
                                <label for="job_remarks">Remarks</label>
                                <textarea class="form-control" name="job_remarks" id="job_remarks"><?=$quote_remarks; ?></textarea>
                              </div> 
                            </div>
                        </section>
                        <!-- End Remarks -->
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
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
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      /*$(function(){
        $( "a.removecart" ).live( "click", function() {
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>purchase/deleteenquiryItem/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#cartdata').fadeOut('slow').load('<?=base_url();?>purchase/enquiry_items').fadeIn("slow");                           }
            });
            return false;
        });
      });*/

  </script>

  </body>
</html>
