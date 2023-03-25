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
                                <h3><i class="icon-map-marker"></i> Edit Production Sheet</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Item Group Details
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
                                }                                                          if($this->session->flashdata('error'))
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
                                if(isset($po_no))
                                {
                                  $result = $this->m_masters->getmasterdetails('bud_lbl_po_received', 'po_no', $po_no);
                                  foreach ($result as $row) {
                                    $po_date = $row['po_date'];
                                    $item_id = $row['item_code'];
                                    $customer_id = $row['customer_id'];
                                    $delivery_form = $row['delivery_form'];
                                    $marketing_by = $row['marketing_by'];
                                    $machine_id = $row['machine_id'];
                                    $po_item_rate = $row['po_item_rate'];
                                    $po_remarks = $row['po_remarks'];
                                  }
                                  $pd = explode("-", $po_date);
                                  $po_date = $pd[2].'-'.$pd[1].'-'.$pd[0];
                                }
                                if(isset($item_id))
                                {
                                  $item_sizes = explode(",", $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $item_id, 'item_sizes'));
                                }
                                else
                                {
                                  $item_id = '';
                                  $item_sizes = array();
                                }

                                $po_items = $this->m_masters->getmasterdetails('bud_lbl_po_items', 'po_no', $po_no);
                                $po_items_qty = array();
                                foreach ($po_items as $item) {
                                  $po_items_qty[$item['po_item_size']] = $item['po_qty'];
                                }
                                ?>                                                     <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>purchase/update_po_received_3">
                                    <input type="hidden" name="po_no" value="<?=$po_no; ?>">
                                    <div class="form-group col-lg-3">
                                       <label for="item_name">Item Name</label>
                                       <input class="form-control" value="<?=$po_date; ?>" id="po_date" name="po_date" type="text" readonly="">
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_name">Item Name</label>
                                       <select class="get_outerboxes form-control select2" id="item_name" name="item_name">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($items as $row) {
                                             ?>
                                             <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="item_code">Item Code</label>
                                       <select class="get_outerboxes form-control select2" id="item_code" name="item_code">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($items as $row) {
                                             ?>
                                             <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="customer_id">Party Code</label>
                                       <select class="selects_customers form-control select2" id="customer_id" name="customer_id">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($customers as $row) {
                                             ?>
                                             <option value="<?=$row['cust_id'];?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_id'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="customer_name">Party Name</label>
                                       <select class="selects_customers form-control select2" id="customer_name" name="customer_name">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($customers as $row) {
                                             ?>
                                             <option value="<?=$row['cust_id'];?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="delivery_form">Delivery In Roll/Cut &amp; Fold/Dye Cut</label>
                                       <select class="form-control select2" id="delivery_form" name="delivery_form">
                                          <option value="Roll Form" <?=($delivery_form == 'Roll Form')?'selected="selected"':''; ?>>Roll Form</option>                                                                            <option value="Cut & Seal" <?=($delivery_form == 'Cut & Seal')?'selected="selected"':''; ?>>Cut &amp; Seal</option>                                                                            <option value="Cut & Fold" <?=($delivery_form == 'Cut & Fold')?'selected="selected"':''; ?>>Cut &amp; Fold</option>                                                                            <option value="Dye Cut" <?=($delivery_form == 'Dye Cut')?'selected="selected"':''; ?>>Dye Cut</option>                                                                         </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="marketing_by">Marketing By</label>
                                       <select class="form-control select2" id="marketing_by" name="marketing_by">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($staffs as $row) {
                                             ?>
                                             <option value="<?=$row['ID'];?>" <?=($row['ID'] == $marketing_by)?'selected="selected"':''; ?>><?=$row['display_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                       <label for="machine_id">Machine</label>
                                       <select class="form-control select2" id="machine_id" name="machine_id">
                                          <option value="">Select Item</option>
                                          <?php
                                          foreach ($machines as $row) {
                                             ?>
                                             <option value="<?=$row['machine_id'];?>" <?=($row['machine_id'] == $machine_id)?'selected="selected"':''; ?>><?=$row['machine_name'];?></option>
                                             <?php
                                          }
                                          ?>
                                       </select>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <?php
                                    if(isset($item_id))
                                    {
                                      $item_sizes = explode(",", $this->m_masters->getmasterIDvalue('bud_lbl_items', 'item_id', $item_id, 'item_sizes'));
                                      ?>
                                      <div class="form-group col-lg-12">
                                        <table id="table" class="table table-bordered table-striped table-condensed">
                                          <thead>
                                            <tr>
                                              <th>Sno</th>
                                              <th>Size</th>
                                              <th>PO Qty</th>
                                              <th>Rate</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                            $sno = 1;
                                            $size_qty = 0;
                                            foreach ($item_sizes as $size) {
                                              if($size != '')
                                              {
                                                $size_qty = (array_key_exists($size,$po_items_qty))?$po_items_qty[$size]:'0';
                                                ?>
                                                <tr>
                                                  <td><?=$sno; ?></td>
                                                  <td><?=$size; ?></td>
                                                  <td><input type="text" name="po_qty[<?=$size; ?>]" value="<?=$size_qty; ?>"></td>
                                                  <td></td>
                                                </tr>
                                                <?php
                                                $sno++;                                                                                      }
                                            }
                                            ?>
                                          </tbody>
                                        </table>
                                      </div>
                                      <div style="clear:both;"></div>
                                      <?php
                                    }
                                    ?>
                                    <div class="form-group col-lg-6">
                                       <label for="po_remarks">Remarks</label>
                                       <textarea class="form-control" id="po_remarks" name="po_remarks"></textarea>
                                    </div>                                                                <div style="clear:both;"></div>
                                    <div class="form-group col-lg-12">
                                        <div>
                                            <button class="btn btn-danger" type="submit">Update</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <section class="panel">
                          <header class="panel-heading">
                              Summery
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <th>#</th>
                                  <th>PO No</th>
                                  <th>Party</th>
                                  <th>Item Name</th>
                                  <th>Item Code</th>
                                  <th>Qty in<br>each size</th>
                                  <th>Production<br>Time(Hrs)</th>
                                  <th>Total Po Qty</th>
                                  <th>Total Production<br> Time(Hrs)</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($purchaseorders as $row) {
                                $po_status = $row['po_status'];
                                $po_items = $this->m_masters->getmasterdetails('bud_lbl_po_items', 'po_no', $row['po_no']);
                                $po_items_qty = array();
                                $total_po_qty = 0;
                                foreach ($po_items as $item) {
                                  $po_items_qty[] = $item['po_item_size'].'-'.$item['po_qty'];
                                  $total_po_qty += $item['po_qty'];
                                }
                                ?>
                                <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['po_no']; ?></td>
                                    <td><?=$row['cust_name']; ?></td>
                                    <td><?=$row['item_name']; ?></td>
                                    <td><?=$row['item_code']; ?></td>
                                    <td><?=implode("<br>", $po_items_qty); ?></td>
                                    <td></td>
                                    <td><?=$total_po_qty; ?></td>
                                    <td></td>
                                    <td>
                                      <?php
                                      if($po_status == 1)
                                      {
                                        ?>
                                        <a href="#" class="btn btn-primary btn-xs">P.S Pending</a>
                                        <a href="<?=base_url(); ?>production/print_ps_3/<?=$row['po_no']; ?>" class="btn btn-success btn-xs">Print</a>
                                        <?php 
                                      }
                                      else
                                      {
                                        ?>
                                        <a href="#" class="btn btn-success btn-xs">P.S. Issued</a>
                                        <a href="<?=base_url(); ?>production/print_ps_3/<?=$row['po_no']; ?>" class="btn btn-success btn-xs">Print</a>
                                        <?php
                                      }
                                      $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
                                      if($is_admin)
                                      {
                                        ?>
                                        <a href="<?=base_url(); ?>purchase/po_edit_3/<?=$row['po_no']; ?>" class="btn btn-danger btn-xs">Edit</a>
                                        <?php
                                      }
                                      ?>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
                          </table>
                      </section>
                      <!-- End Talbe List  -->                                 </div>
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

      $(".get_outerboxes").change(function(){
        window.location = "<?=base_url(); ?>purchase/po_received_3/"+$(this).val();
      });
      $(".selects_customers").change(function(){
          $("#customer_name").select2("val", $(this).val());
          $("#customer_id").select2("val", $(this).val());
      });     

  </script>

  </body>
</html>
