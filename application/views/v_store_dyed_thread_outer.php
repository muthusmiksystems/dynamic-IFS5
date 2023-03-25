<?php include APPPATH.'views/html/header.php'; ?>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Inner Boxes
                    </header>
                    <div class="panel-body">
                        <div id="packing-list">
                                            </div>
                        <input type="hidden" id="selected_boxes">

                        <div class="row">
                            <div class="form-group col-md-3">
                                <button type="button" class="btn btn-warning btn-sm" onclick="addToCart()">Add to List</button>
                            </div>
                        </div>

                        <hr>

                        <form role="form" method="post" action="<?=base_url('store/dyed_yarn_outer_save'); ?>">
                            <h3>Selecte Boxes</h3>
                            <p>
                                <label >Box No : </label>
                                <span class="label label-danger" style="padding: 0 8px;font-size:16px;">TI<?=$box_no ?></span>
                            </p>
                            <div id="formResponse-2"></div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="po_date" class="gross-weight-lbl">Gross Weight:</label>
                                    <input class="gross-weight form-control" id="gross_weight" name="gross_weight" type="text" required autofocus="">
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="stock_room_id" class="gross-weight-lbl">Stock Room</label>
                                    <select class="form-control select2" id="stock_room_id" name="stock_room_id" required>
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($stock_rooms as $row) {
                                            ?>
                                            <option value="<?php echo $row['stock_room_id']; ?>"><?php echo $row['stock_room_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div id="cart_items">
                                                        </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="pack_by" value="<?=$this->session->userdata('display_name'); ?>">
                                    <button type="submit" class="btn btn-success btn-sm" name="submit" value="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url('store/dyed_yarn_outer_save'); ?>">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="form-group col-lg-12">
                                <label >Box No : </label>
                                <span class="label label-danger" style="padding: 0 1em;font-size:24px;">TI<?=$box_no ?></span>
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="form-group col-lg-4">
                                <label for="po_date" class="gross-weight-lbl">Gross Weight:</label>
                                <input class="gross-weight form-control" id="gross_weight" name="gross_weight" type="text" required autofocus="">
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="stock_room_id" class="gross-weight-lbl">Stock Room</label>
                                <select class="form-control select2" id="stock_room_id" name="stock_room_id" required>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($stock_rooms as $row) {
                                        ?>
                                        <option value="<?=$row['stock_room_id']; ?>"><?=$row['stock_room_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <table class="table table-striped border-top" id="selected_items">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Date</th>
                                        <th>Box No</th>
                                        <th>LOT</th>
                                        <th>Item name/code</th>
                                        <th>Colour name/code</th>                                                                <th>Gross Weight</th>
                                        <th>Net Weight</th>
                                        <th>Packed By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="pack_by" value="<?=$this->session->userdata('display_name'); ?>">
                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit" name="save" value="save">Save</button>
                        </header>
                    </section>
                </form>

                <section class="panel">
                    <header class="panel-heading">
                        Summery
                    </header>
                    <table class="table table-striped border-top" id="sample_1">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Date</th>
                                <th>Box No</th>
                                <th>LOT</th>
                                <th>Item name/code</th>
                                <th>Colour name/code</th>                                                        <th>Gross Weight</th>
                                <th>Net Weight</th>
                                <th>Packed By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 1;
                            foreach ($boxes as $row) {
                                $box_ids = array();
                                $items = array();
                                $shades = array();
                                $inner_boxes = json_decode($row['inner_boxes']);
                                foreach ($inner_boxes as $inner_box_id => $inner_box) {
                                    $box_ids[] = $inner_box_id;
                                }

                                $lots = array();
                                $packed_inner_boxes = $this->ak->get_dyed_thread_inner_boxes($box_ids);
                                foreach ($packed_inner_boxes as $pack_i_box) {
                                    $lots[] = $pack_i_box['lot_no'];
                                    //$items[] = $pack_i_box['item_name'].'/'.$pack_i_box['item_id'];
                                    //$shades[] = $pack_i_box['shade_name'].'/'.$pack_i_box['shade_id'];
                                    $item = $pack_i_box['item_name'];
                                    $shade = $pack_i_box['shade_name'];
                                }
                                $lots = array_unique($lots);
                                ?>
                                <tr class="odd gradeX">                                           <td><?=$sno; ?></td>
                                     <td><?=date('d-m-Y h:i:s', strtotime($row['packed_date'])); ?></td>                                                 <td><?=$row['box_prefix']; ?><?=$row['box_no']; ?></td>                                                             <td><?php echo implode(",", $lots); ?></td>                                          <td><?=$item; ?></td>                                    <td><?=$shade; ?></td>                                                         <td><?=$row['gross_weight']; ?></td>                                      <td><?=$row['net_weight']; ?></td>                                        <td><?=$row['packed_by']; ?></td>
                                    <td>
                                        <a href="<?=base_url(); ?>store/print_thread_with_i/<?=$row['box_id']; ?>" class="btn btn-xs btn-warning" title="Print" target="_blank">Print</a>
                                    </td>
                                </tr>
                                <?php                                                        $sno++;
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </section>
</section>
</section>

<?php include APPPATH.'views/html/footer.php'; ?>
<script>var oTable01 = '';
    load_inner_boxes();
    load_cart_items();
    function load_inner_boxes() {
        $.ajax({
            url: "<?php echo base_url('store/get_dyed_inner_boxes'); ?>",
            success: function(response)
            {
                jQuery('#packing-list').html(response);
                oTable01 = $('.dataTables').dataTable({
                    "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page",
                        "oPaginate": {
                            "sPrevious": "Prev",
                            "sNext": "Next"
                        }
                    },
                    "aoColumnDefs": [
                        {
                          "bSortable": false,
                          "aTargets": [9]
                        }
                    ]
                });
                jQuery('.dataTables_filter input').addClass("form-control");
                jQuery('.dataTables_length select').addClass("form-control");
            }
        });
    }

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
        var cart_boxes = 0;
        var cart_gr_wt = 0;
        var cart_nt_wt = 0;
        var checkedcollection = oTable01.$(".chkBoxId:checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
        });
        $("#selected_boxes").val(matches);
    });

    function addToCart() {
        var selected_boxes = $("#selected_boxes").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('store/th_outer_add_to_cart'); ?>",
            data: {'selected_boxes':selected_boxes},
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                load_cart_items();
                load_inner_boxes();
                // console.log(response);
            }
        });
    }

    function load_cart_items() {
        $.ajax({
            url: "<?php echo base_url('store/th_outer_cart_items'); ?>",
            success: function(response)
            {
                jQuery('#cart_items').html(response);
                $('#cart_items table').dataTable({
                    "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page",
                        "oPaginate": {
                            "sPrevious": "Prev",
                            "sNext": "Next"
                        }
                    },
                    "aoColumnDefs": [
                        {
                          "bSortable": false,
                          "aTargets": [9]
                        }
                    ]
                });
                jQuery('.dataTables_filter input').addClass("form-control");
                jQuery('.dataTables_length select').addClass("form-control");
            }
        });
    }

    $(document).on('click', ".remove-cart-item", function(e){
        var row_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('store/th_outer_remove_cart'); ?>",
                data: {'row_id':row_id},
                failure: function(errMsg) {
                    console.error("error:",errMsg);
                },
                success: function(response)
                {
                    load_cart_items();
                    load_inner_boxes();
                }
            });
        }
        else{
            return false;
        }
    });
</script>

</body>
</html>
