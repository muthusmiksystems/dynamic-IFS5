<?php include APPPATH.'views/html/header.php'; ?>
<style type="text/css">
    @media print{
        @page{
            margin: 3mm;
        }
    }
    .datepicker {
      z-index: 10000;
    }
</style>
<section id="main-content">
    <section class="wrapper">
    <a class="btn btn-md btn-primary" href="<?= base_url(); ?>directpack/lot_form/">Back to Direct Lot Form</a>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                       <h3 style="font-size:24px"> Add Qty in Old Lot: </h3>
                    </header>
                    <table class="table table-bordered datatables">
    <thead>
        <tr>
            <th>#</th>
            <th>Lot No</th>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>Create Date</th>
            <th>Item Name</th>
            <th>Color Name/Id</th>
            <th>Color Code</th>
            <th>Oil Required</th>
            <th># Units</th>
            <th>Lot Qty</th>
            <th>Rate</th>
            <th>Quality</th>
            <th>Remarks</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sno = 1;
        ?>
        <?php if(sizeof($lot_list_details) > 0): ?>
            <?php foreach($lot_list_details as $row): ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $row->lot_no; ?></td>  
                    <td><?php echo $row->lot_invoice_no; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row->inward_date)); ?></td>
                    <td><?php echo date("d-m-Y g:i A", strtotime($row->lot_created_date)); ?></td>
                    <td><?php echo $row->item_name; ?>/<?php echo $row->lot_item_id; ?></td>
                    <td><?php echo $row->shade_name; ?>/<?php echo $row->lot_shade_no; ?></td>
                    <td><?php echo $row->shade_code; ?></td>
                    <td><?php echo $row->lot_oil_required; ?></td>
                    <td><?php echo $row->no_springs; ?></td>
                    <td><?php echo $row->lot_qty; ?></td>
                    <td><?php echo $row->lot_rate; ?></td>
                    <td><?php echo $row->lot_quality; ?></td>
                    <td><?php echo $row->lot_remark; ?></td>
                    <!-- <td>
                    <a class="btn btn-xs btn-primary" onclick="get_detail(<?= $row->lot_no; ?>)">Add Lot Qty</a>
            </td> -->
            <td>
				
                    <!-- <button class="btn btn-xs btn-success" onclick="showAjaxModal('<?php echo base_url('directpack/direct_lot_inwd_addqty?lot_no=' . $row->lot_no . '?lot_id=' . $row->lot_id); ?>')">Add Lot Qty</button> -->
                    <button class="btn btn-xs btn-success" onclick="showAjaxModal('<?php echo base_url('directpack/direct_lot_inwd_addqty?lot_no=' . urlencode($row->lot_no) . '&lot_id=' . $row->lot_id); ?>')">Add Lot Qty</button>

                   
                    <!-- <form action="<?= base_url(); ?>directpack/lot_list_details" method="post">
                            <input type="hidden" name="lot_no" value="<?= htmlspecialchars($row->lot_no); ?>">
                            <button class="btn btn-xs btn-success" type="submit">Lot Qty Detail</button>
                    </form> -->

                    
               

                </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
                    
                </section>
            </div>
        </div>


    </section>
    <h5 style="text-align:right;font-size:5px;margin-right:20px">application\modules\directpack\views\lot-form-details.php</h5>
</section>
  <!-- Modal -->
  <!-- (Ajax Modal)-->
  <div class="modal fade" id="modal_ajax">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Direct Lot & Raw Material Update Qty</h4>
        </div>

        <div class="modal-body" style="height:500px; overflow:auto;">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->

  <!-- js placed at the end of the document so the pages load faster -->
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">   
    function showAjaxModal(url) {
      // SHOWING AJAX PRELOADER IMAGE
      jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url('themes/admin/img/preloader.gif') ?>" /></div>');

      // LOADING THE AJAX MODAL
      jQuery('#modal_ajax').modal('show', {
        backdrop: 'true'
      });

      // SHOW AJAX RESPONSE ON REQUEST SUCCESS
      $.ajax({
        url: url,
        success: function(response) {
          jQuery('#modal_ajax .modal-body').html(response);

          /*$(function(){
              $('.dateplugin').datepicker({
                  format: 'dd-mm-yyyy',
                  autoclose: true
              });
          });*/
          $('.dateplugin').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
          });
        }
      });
    }
    // $(document).ready(function() {
    //   $("#owl-demo").owlCarousel({
    //     navigation: true,
    //     slideSpeed: 300,
    //     paginationSpeed: 400,
    //     singleItem: true

    //   });
  
    $(document).ajaxStart(function() {
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });

</script>
</body>
</html>