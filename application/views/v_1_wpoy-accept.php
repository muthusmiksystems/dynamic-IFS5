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
                                <h3><i class="icon-user"></i> POY Acceptance</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Talbe List  --> 
                      <?php
                      /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
                      ?>                                     <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Issue To</th>
                                <th>Supplier Group</th>
                                <th>Supplier</th>
                                <th>POY Denier</th>
                                <th>POY Lot</th>
                                <th>Qty</th>
                                <th>Uom</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($poy_issue as $row) {
                              $id = $row['id'];
                              $is_accepted = $row['is_accepted'];
                              if($id != '')
                              {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['item_name']; ?></td>                                                             <td><?=$row['item_id']; ?></td>                                                             <td><?=$row['dept_name']; ?></td>                                                             <td><?=$row['group_name']; ?></td>                                                             <td><?=$row['sup_name']; ?></td>
                                    <td><?=$row['denier_name']; ?></td>
                                    <td><?=$row['poy_lot_name']; ?></td>
                                    <td><?=$row['qty']; ?></td>
                                    <td><?=$row['uom_name']; ?></td>
                                    <td><?=$row['issue_datetime']; ?></td>
                                    <td>
                                      <?php
                                      if($is_accepted == 1)
                                      {
                                        ?>
                                        <span class="<?=($is_accepted==1)?'label label-success':'label label-danger'; ?>"><?=($is_accepted==1)?'Accepted':'Not Accepted'; ?></span>
                                        <?php
                                      }
                                      else
                                      {
                                      ?>
                                      <a href="#<?=$row['id']; ?>" data-toggle="modal" data-placement="top" data-original-title="Click to Accept" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Accept</a>
                                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?=$row['id']; ?>" class="modal fade">
                                         <div class="modal-dialog">
                                            <div class="modal-content">
                                               <div class="modal-header">
                                                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                  <h4 class="modal-title">Enter Your Password</h4>
                                               </div>
                                               <div class="modal-body">
                                                  <form role="form" method="post" action="<?=base_url(); ?>deliveryaccept/poy_accept_update">
                                                     <input type="hidden" name="id" value="<?=$row['id']; ?>">
                                                     <div class="form-group" style="margin-bottom: 15px;">
                                                     <label>Password</label>
                                                     <input type="text" class="form-control" name="password" required placeholder="Your Password">
                                                     </div>
                                                     <div style="clear:both;"></div>
                                                     <button type="submit" class="btn btn-default" name="print">Accept</button>
                                                  </form>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
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
                    </section>
                    <!-- End Talbe List  -->                               </div>
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
      $('#po_cartitems').load('<?=base_url();?>poy/poyInw_cartItems');
      $(".itemsselects").change(function(){
        $(".itemsselects").select2("val", $(this).val());
      }); 
      $(function(){
        $("#sup_group_id").change(function () {
            var sup_group_id = $('#sup_group_id').val();
            var url = "<?=base_url()?>poy/getsuppliers/"+sup_group_id;
            var postData = 'sup_group_id='+sup_group_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#supplier_id").html('<option value="">Select</option>');
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_denier").html('<option value="">Select</option>');
                  $("#supplier_id").select2("val", '');
                  $("#poy_lot").select2("val", '');
                  $("#poy_denier").select2("val", '');
                  $("#supplier_id").html(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#supplier_id").change(function () {
            var supplier_id = $('#supplier_id').val();
            var url = "<?=base_url()?>poy/getsupplierDeniers/"+supplier_id;
            var postData = 'supplier_id='+supplier_id;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#poy_denier").html('<option value="">Select</option>');
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_denier").select2("val", '');
                  $("#poy_lot").select2("val", '');
                  $("#poy_denier").html(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#poy_denier").change(function () {
            var poy_denier = $('#poy_denier').val();
            var url = "<?=base_url()?>poy/getpoylots/"+poy_denier;
            var postData = 'poy_denier='+poy_denier;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(result)
                {
                  $("#poy_lot").html('<option value="">Select</option>');
                  $("#poy_lot").select2("val", '');
                  $("#poy_lot").html(result);
                }
            });
            return false;
        });
      });
      $(function(){
        $("#addtocart").click(function () {
            var item_id = $('#item_id').val();
            var supplier_id = $('#supplier_id').val();
            var poy_denier = $('#poy_denier').val();
            var poy_lot = $('#poy_lot').val();
            var po_qty = $('#po_qty').val();
            var item_uom = $('#item_uom').val();
            var url = "<?=base_url()?>poy/poyInw_addtocart";
            var postData = 'item_id='+item_id+'&supplier_id='+supplier_id+"&poy_denier="+poy_denier+"&poy_lot="+poy_lot+"&po_qty="+po_qty+"&item_uom="+item_uom;
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function(result)
                {
                  $('#po_cartitems').load('<?=base_url();?>poy/poyInw_cartItems');
                }
            });
            return false;
        });
      });
      $(function(){
        $( "a.removetocart" ).live( "click", function() {
            // alert('hi');
            var row_id = $(this).attr('id');
            var url = "<?=base_url()?>poy/poyInw_removetocart/"+row_id;
            var postData = 'row_id='+row_id;
            $.ajax({
                type: "POST",
                url: url,
                success: function(msg)
                {
                   $('#po_cartitems').load('<?=base_url();?>poy/poyInw_cartItems');
                }
            });
            return false;
        });
      });
  </script>

  </body>
</html>
