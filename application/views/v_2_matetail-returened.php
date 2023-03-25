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
               <div class="row screen-only">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i> Material Returened Back Form</h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row screen-only">
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
               <?php
               $items = $this->m_masters->getactivemaster('bud_te_items', 'item_status');
               $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
               $uoms = $this->m_masters->getactivemaster('bud_uoms', 'uom_status');
               $item_name = null;
               if(isset($return_id))
               {
                  $result = $this->m_masters->getmasterdetails('bud_te_material_returns', 'id', $return_id);
                  foreach ($result as $row) {
                     $id = $row['id'];
                     $customer_id = $row['customer_id'];
                     $item_name = $row['item_name'];
                     $no_of_bags = $row['no_of_bags'];
                     $total_gr_weight = $row['total_gr_weight'];
                     $total_net_weight = $row['total_net_weight'];
                     $total_qty = $row['total_qty'];
                     $item_uom = $row['item_uom'];
                     $remarks = $row['remarks'];
                     $status = $row['status'];
                  }
               }
               else
               {
                  $id = '';
                  $return_id = '';
                  $customer_id = '';
                  $item_name = '';
                  $no_of_bags = '';
                  $total_gr_weight = '';
                  $total_net_weight = '';
                  $total_qty = '';
                  $item_uom = '';
                  $remarks = '';
                  $status = '';
               }
               ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>packing/saveMatetailReturn">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                                               <header class="panel-heading">
                              MRR.No:
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="customer_id">Customer</label>
                                 <select class="form-control select2" id="customer_id" name="customer_id" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($customers as $row) {
                                      ?>
                                      <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?>><?=$row['cust_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_item_detail form-control select2" id="item_name" name="item_name" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_name)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_code">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="item_code" name="item_code" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_name)?'selected="selected"':''; ?>><?=$row['item_id']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="no_of_bags">No Of Bags</label>
                                 <input type="text" class="form-control" value="<?=$no_of_bags; ?>" id="no_of_bags" name="no_of_bags">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="total_gr_weight">Total Gr.Weight</label>
                                 <input type="text" class="form-control" id="total_gr_weight" name="total_gr_weight">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="total_net_weight">Total Net Weight</label>
                                 <input type="text" class="form-control" id="total_net_weight" name="total_net_weight">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="total_qty">Total Qty</label>
                                 <input type="text" class="form-control" id="total_qty" name="total_qty">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_uom">Item Uom</label>
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
                              <div class="form-group col-lg-6">
                                 <label for="remarks">Remarks</label>
                                 <textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
                              </div>                                                    <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-danger" type="submit" name="save"><?=($return_id != '')?'Update':'Save'; ?></button>
                              </div>                                                </div>
                        </section>
                     </div> 
                  </div>
                </form>

               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                                  <section class="panel">
                    <header class="panel-heading">
                        Summery
                    </header>
                    <table class="table table-striped border-top" id="itemlist">
                      <thead>
                        <tr>
                           <th>#</th>                                            <th>MRR.No</th>
                           <th>Customer</th>
                           <th>Item Name</th>
                           <th>Item Code</th>
                           <th># of Bags</th>
                           <th>Gr.Weight</th>
                           <th>Nt. Weight</th>
                           <th>Qty</th>
                           <th>UOM</th>
                           <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sno = 1;
                        foreach ($material_returns as $row) {
                           $id = $row['id'];
                           $customer_id = $row['customer_id'];
                           $item_name = $row['item_name'];
                           $no_of_bags = $row['no_of_bags'];
                           $total_gr_weight = $row['total_gr_weight'];
                           $total_net_weight = $row['total_net_weight'];
                           $total_qty = $row['total_qty'];
                           $item_uom = $row['item_uom'];
                           ?>
                           <tr>
                              <td><?=$sno; ?></td>
                              <td><?=$id; ?></td>
                              <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_name'); ?></td>
                              <td><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $item_name, 'item_name'); ?></td>
                              <td><?=$item_name; ?></td>
                              <td><?=$no_of_bags; ?></td>
                              <td><?=$total_gr_weight; ?></td>
                              <td><?=$total_net_weight; ?></td>
                              <td><?=$total_qty; ?></td>
                              <td><?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $item_uom, 'uom_name'); ?></td>
                              <td>
                                 <a href="<?=base_url();?>packing/matetailReturened/<?=$id; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                 <a href="<?=base_url();?>masters/deletemaster/bud_te_material_returns/id/<?=$id; ?>/packing/matetailReturened" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                              </td>
                           </tr>
                           <?php
                           $sno++;
                        }
                        ?>
                        </tbody>
                     </table>
                  </section>
                  <!-- End Talbe List  -->
               </div>
            </div>
               <div class="pageloader"></div>                          <!-- page end-->
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

      $(".get_item_detail").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_code").select2("val", $(this).val());       return false;
      });
      $('#selectall').click(function() {
         var c = this.checked;
         $('.checkbox').prop('checked',c);
      });
      </script>
   </body>
</html>
