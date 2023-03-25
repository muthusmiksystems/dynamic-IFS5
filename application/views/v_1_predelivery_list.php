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
                           <h3><i class="icon-map-marker"></i> Pre Deliveries</h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                  <?php
                  if($this->session->flashdata('warning'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-warning fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                           </button>
                           <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }                                            if($this->session->flashdata('error'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-block alert-danger fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                           <i class="icon-remove"></i>
                           </button>
                           <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }
                  if($this->session->flashdata('success'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
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
                     </header>
                  </section>
                  <?php
                  }
                  ?>
                  </div>
               </div>
                <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Pre Deliveries
                          </header>
                          <div class="panel-body">
                              <table class="table table-striped border-top" id="sample_1">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Date</th>
                                  <th>Pre Delivery No</th>
                                  <th>Customer</th>
                                  <th>Items</th>
                                  <th>Shade Name</th>
                                  <th>Shade Code</th>
                                  <th>Selected Boxes</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $sno = 1;
                                foreach ($pre_deliveries as $row) {
                                  $boxes_array = array();
                                  $p_delivery_boxes = explode(",", $row['p_delivery_boxes']);
                                  $box_ids = $p_delivery_boxes;
                                  // $selected_boxes = $this->m_delivery->getBoxesArrayItems('box_id', $p_delivery_boxes);
                                  $boxes = $this->m_delivery->get_yt_predelivery_items($box_ids);

                                  /*echo "<pre>";
                                  print_r($boxes);
                                  echo "</pre>";*/

                                  $item_names = array();
                                  $shade_names = array();
                                  $shade_codes = array();
                                  if(sizeof($boxes) > 0)
                                  {
                                    foreach ($boxes as $box) {
                                      $boxes_array[] = $box->box_prefix.$box->box_no;
                                      $item_names[$box->item_id] = $box->item_name;
                                      $shade_names[$box->shade_no] = $box->shade_name;
                                      $shade_codes[$box->shade_no] = $box->shade_code;
                                    }
                                  }
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['p_delivery_date']; ?></td>
                                    <td><?=$row['p_delivery_id']; ?></td>
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $row['p_delivery_cust'], 'cust_name');?>
                                    </td>
                                    <td><?=implode(",", $item_names); ?></td>
                                    <td><?=implode(",", $boxes_array); ?></td>
                                    <td><?=implode(",", $shade_names); ?></td>
                                    <td><?=implode(",", $shade_codes); ?></td>
                                    <td>
                                      <a href="<?=base_url(); ?>delivery/predelivery_1_edit/<?=$row['p_delivery_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                      <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updatePDCId(<?=$row['p_delivery_id']?>)">Delete
                                      </button><!--ER-09-18#-58-->
                                      <a href="<?=base_url(); ?>delivery/predelivery_print/<?=$row['p_delivery_id']; ?>" class="btn btn-success btn-xs">Print</a>
                                    </td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>
                              </tbody>
                              </table>
                          </div>
                      </section>
                   </div>
                </div>
               <div class="pageloader"></div>                          <!-- page end-->
            </section>
         </section>
         <!--main content end-->
         <!--ER-09-18#-58-->
         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete Delivery</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" id="pDeliveryId" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="custChanged" value="Customer is Changed">Customer is Changed</label>
            </div>           <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="WrongQty" value="Qty is != PO Qty">Qty is != PO Qty</label>
            </div>
            <div class="radio">
              <label><input type="radio" name="remarks" id='others' value="others">Others</label>
            </div>
            <div class="form-group" id="otherRemarks">
              <label for="comment">Comment:</label>
              <textarea class="form-control" rows="5" name="others" id="otherRemarkValue"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deletedc()">Delete</button>
          </div>
        </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    </script>
      <!--ER-09-18#-58-->
      <script>
        $('#otherRemarks').hide();
      $('#others').click(function(event) {
      if(this.checked) { // check select status
        $('#otherRemarks').show();
      }
      else
      {
        $('#otherRemarks').hide();
      }
      });
      $('.remarks').click(function(event) {
      $('#otherRemarks').hide();
      });
      function updatePDCId(pdc_id){
        $('#pDeliveryId').val(pdc_id);
      }
      function deletedc(){
        var remarks = $( "input:checked" ).val();
        if(remarks=="others")
        {
          remarks=$('#otherRemarkValue').val();
        }
        var p_delivery_id=$('#pDeliveryId').val();
        var url = "<?php echo base_url('delivery/predelivery_1_delete')?>";
        $.ajax({
            type: "POST",
            url: url,
            data:  {
            "p_delivery_id": p_delivery_id,
            "remarks": remarks
            },
            success: function(result)
            {
              alert(result);
              location.reload(true);
            }
          });
      }
      </script>
   </body>
</html>
