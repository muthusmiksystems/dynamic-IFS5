<?php include APPPATH.'views/html/header.php'; ?>
<style type="text/css">
    @media print{
        @page{
            margin: 3mm;
        }
    }

    .button-group {
    display: flex;
    gap: 10px; /* Adjust the gap between buttons as desired */
    }

</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                       <h3 style="font-size:24px"> Create New Lot of Raw Material Inward Entry </h3>
                    </header>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('directpack/lot_save/'.$lot_id); ?>">
                            <!-- <div class="row">
                                <div class="form-group col-lg-3">
                                    Receipt No <label class="label label-danger" style="font-size:14px;">SHOP - <span id="receipt_no">1</span></label>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Select Machine</label>
                                    <select class="select2 form-control" name="machine_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($machines) > 0): ?>
                                            <?php foreach($machines as $row): ?>
                                                <option value="<?php echo $row->machine_id; ?>"><?php echo $row->machine_prefix; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Item Name</label>
                                    <select class="select2 item-select form-control" name="item_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($items) > 0): ?>
                                            <?php foreach($items as $row): ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Item Code</label>
                                    <select class="select2 item-select form-control">
                                        <option value="">Select</option>
                                        <?php if(sizeof($items) > 0): ?>
                                            <?php foreach($items as $row): ?>
                                                <option value="<?php echo $row->item_id; ?>"><?php echo $row->item_id; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Color Name</label>
                                    <select class="select2 shade-select form-control" name="shade_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($shades) > 0): ?>
                                            <?php foreach($shades as $row): ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Color Code</label>
                                    <select class="select2 shade-select form-control">
                                        <option value="">Select</option>
                                        <?php if(sizeof($shades) > 0): ?>
                                            <?php foreach($shades as $row): ?>
                                                <option value="<?php echo $row->shade_id; ?>"><?php echo $row->shade_code; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Oil Gain %</label>
                                    <input type="text" name="oil_required" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label># Units</label>
                                    <input type="text" name="no_springs" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Lot Qty</label>
                                    <input type="text" name="lot_qty" class="form-control">
                                </div> 
                                <div class="form-group col-md-3">
                                    <label>Lot Rate</label>
                                    <input type="text" name="lot_rate" class="form-control">
                                </div>                                  
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" value="submit" class="ajax-submit btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Direct Lot Entry List
                    </header>
                    <div class="panel-body" id="lot_list_data">
                        
                    </div>
                </section>
            </div>
        </div>

    </section>
    <div class="modal fade" id="modal_ajax">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"> Raw Material Update Item & Color</h4>
        </div>

        <div class="modal-body" style="height:250px; overflow:auto;">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <h5 style="text-align:right;font-size:5px;margin-right:20px">application\modules\directpack\views\lot-form.php</h5>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">   
    load_lot_list();
    $("#ajaxForm").submit(function(e) {
        var url = $(this).attr('action');
        // alert(url);
        $.ajax({
            type: "POST",
            url: url,
            data: $("#ajaxForm").serialize(),
            beforeSend: function(response)
            {
                $(".ajax-loader").css('display', 'block');
            },
            success: function(response)
            {
                // console.log(response);
                var response = $.parseJSON(response);
                $.each(response, function(k, v) {
                    if(k=='error')
                    {
                        $("#formResponse").html('<div class="alert alert-danger">'+v+'</div>');
                    }
                    if(k == 'success')
                    {
                        $("#formResponse").html('<div class="alert alert-success">'+v+'</div>');
                        load_lot_list();
                    }
                });
            }
        });

        e.preventDefault();
    });

    $('.item-select').change(function() {
        $(".item-select").select2('val', $(this).val());
    });
    $('.shade-select').change(function() {
        $(".shade-select").select2('val', $(this).val());
    });

    function load_lot_list() {
        $.ajax({
            url: "<?php echo base_url('directpack/lot_list_data'); ?>",
            dataType:"html",
            success: function(response)
            {
                jQuery('#lot_list_data').html(response);
                oTable01 = $('.datatables').dataTable({
                    "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page",
                        "oPaginate": {
                            "sPrevious": "Prev",
                            "sNext": "Next"
                        }
                    }
                });
                jQuery('.dataTables_filter input').addClass("form-control");
                jQuery('.dataTables_length select').addClass("form-control");
            }
        });
    }

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
</script>
</body>
</html>