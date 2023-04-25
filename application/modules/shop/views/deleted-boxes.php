<?php include APPPATH.'views/html/header.php'; ?>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading text-center">
                            <strong>Final Delete</strong>
                        </header>
                        <div class="panel-body" id="transfer_list">
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
                            }                                  
                            if($this->session->flashdata('error'))
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
                            <div class="table-responsive">
                                <script>
                                    var data = [];
                                </script>
                                <table class="table table-bordered dataTables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Box no</th>
                                            <th>Supplier</th>
                                            <th>Sup.DC.no</th>
                                            <th>Item name/code</th>
                                            <th>Shade name/code</th>
                                            <th>Shade number</th>
                                            <th>Lot no</th>
                                            <th>#Boxes</th>
                                            <th>#Cones</th>
                                            <th>Gr.Wt</th>
                                            <th>Nt.Wt</th>
                                            <th>Total lot wise Qty</th>
                                            <th>Remarks</th>
                                            <th>Deleted by</th>
                                            <th>Date</th>
                                            <th>
                                                <label>
                                                    <input type="checkbox" id="select_all">
                                                    Select All
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                        <?php
                                        $sno = 1;
                                        ?>
                                        <?php if(sizeof($boxes) > 0): ?>
                                            <?php foreach($boxes as $box): ?>
                                                
                                                <script>
                                                    data.push( [ '<?=$sno++; ?>', '<?=$box->box_prefix; ?><?=$box->box_no; ?>', '<?=$box->sup_name; ?>', '<?=$box->supplier_dc_no; ?>', '<?=$box->item_name; ?>/<?=$box->item_id; ?>', '<?=$box->shade_name; ?>/<?=$box->shade_id; ?>', '<?=$box->shade_code; ?>', '<?=$box->lot_no; ?>', '<?=$box->no_boxes; ?>', '<?=$box->no_cones; ?>', '<?=$box->gr_weight; ?>', '<?=$box->nt_weight; ?>', '<?=$box->nt_weight; ?>', '<?=$box->deleted_remarks; ?>', '<?=$box->deleted_by; ?>', '<?=date("d-m-Y H:i:s", strtotime($box->deleted_on)); ?>', '<input type="checkbox" class="chkBoxId" value="<?=$box->box_id; ?>">' ] );
                                                </script>

                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    
                                </table>
                                <form class="form" method="post" action="<?php echo base_url('shop/packing/final_delete'); ?>">
                                    <input type="hidden" name="selected_boxes" id="selected_boxes">
                                    <button type="submit" class="btn btn-danger" name="submit" value="submit">Final Delete</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>

<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">

    $(document).ready(function() {
        $('.dataTables').DataTable( {
            'data': data,
            'deferRender': true,
            'processing': true,
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading...'
            },
            "order": [[ 0, "desc" ]]
        } );
        jQuery('.dataTables_filter input').addClass("form-control");
        jQuery('.dataTables_filter').parent().addClass('col-sm-6');
        jQuery('.dataTables_length select').addClass("form-control");
        jQuery('.dataTables_length').parent().addClass('col-sm-6');

    });


    $(document).on('click', '#select_all', function(e){
        if(this.checked){
            $('tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
            $('tbody input[type="checkbox"]:checked').trigger('click');
        }
        e.stopPropagation();
    });

    $(document).on('click', "input[type='checkbox']", function(){
        var matches = [];
        var checkedcollection = oTable01.$(".chkBoxId:checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
        });
        $("#selected_boxes").val(matches);
        // alert(matches);
    });
</script>
</body>
</html>