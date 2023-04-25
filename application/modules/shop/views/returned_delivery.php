<?php include APPPATH.'views/html/header.php'; ?>
    <?php
    $dc_active = false;
    $cash_inv_active = false;
    $credit_inv_active = false;
    $quote_active = false;
    $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
    $shop_active = $this->m_users->is_privileged('shop', 'upriv_controller', $logged_user_id);

    $is_privileged = $this->m_users->is_privileged('delivery', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $dc_active = true;
    }

    $is_privileged = $this->m_users->is_privileged('cash_invoice', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $cash_inv_active = true;
    }

    $is_privileged = $this->m_users->is_privileged('credit_invoice', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $credit_inv_active = true;
    }

    $is_privileged = $this->m_users->is_privileged('quotation', 'upriv_function', $this->session->userdata('user_id'));
    if($is_admin || ($shop_active && $is_privileged))
    {
        $quote_active = true;
    }
    ?>
	<section id="main-content">
		<section class="wrapper sh_delivery">
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
                  }                                  
                  if($this->session->flashdata('error'))
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
                           <b><?=$this->session->flashdata('success'); ?></b><!--//ER-08-18#-43-->
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
                            <h3 align="center" class="text-danger"><?=$page_title;?></h3>
                        </header><!--//ER-08-18#-43-->
                        <div class="panel-body">
                            <div id="formResponse"></div>
                            <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>shop/delivery/returned_dc">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Customer Name / JO NO.</label><!--//ER-08-18#-43-->
                                        <select class="select2 cust_select form-control" id="customer_name" name="customer_id">
                                            <option value="0">Select</option>
                                            <?php if(sizeof($customers) > 0): ?>
                                                <?php foreach($customers as $row): ?>
                                                    <option value="<?php echo $row->cust_id; ?>" ><?php echo $row->cust_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="text-large">Customer Code / JO Code</label><!--//ER-08-18#-43-->
                                        <select class="select2 cust_select form-control" id="customer_id">
                                            <option value="0">Select</option>
                                            <?php if(sizeof($customers) > 0): ?>
                                                <?php foreach($customers as $row): ?>
                                                    <option value="<?php echo $row->cust_id; ?>" ><?php echo $row->cust_id; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="text-large">Deliveries</label>
                                        <select class="select2 form-control" id="delivery_id" name="delivery_id">
                                            <option value="">Select</option>
                                            <?php if($delivery_id):?>
                                            <option value="<?php echo $delivery_id; ?>" selected='selected'><?php echo $delivery_id; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-danger" type="submit" name="search" value="search">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <header class="panel-heading">
                           <h3 class="text-danger">Select colour from following boxes to be returned to Store</h3> <!--//ER-08-18#-43-->
                        </header>
                        <div class="panel-body">
                            <?php
                                $tot_boxes = 0;
                                $tot_gr_weight = 0;
                                $tot_nt_weight = 0;
                                $tot_bal_weight = 0;
                                if(sizeof($boxes) > 0)
                                {
                                    foreach ($boxes as $box) {
                                        $tot_boxes++;
                                        $tot_gr_weight += $box->gr_weight;
                                        $tot_nt_weight += $box->nt_weight;
                                        $bal_qty = $box->nt_weight ;
                                    }
                                }
                                ?>
                                <table class="packing-boxes table table-bordered dataTables">
                                    <thead>
                                        <tr class="total-row">
                                            <th></th>
                                            <th><?=$tot_boxes; ?></th>
                                            <th></th>
                                            <th>Boxes</th>
                                            <th>Total Qty</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?=$tot_gr_weight; ?></th>
                                            <th><?=$tot_nt_weight; ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr class="total-row">
                                            <th></th>
                                            <th class="cart-boxes">0</th>
                                            <th></th>
                                            <th>Boxes</th>
                                            <th>Total Qty</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="cart-gr-wt">0</th>
                                            <th class="cart-nt-wt">0</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Box no</th>
                                            <th>Grp</th>
                                            <th>Item name/<br>code</th>
                                            <th>Shade name/<br>code</th>
                                            <th>Shade no</th>
                                            <th>Lot no</th>
                                            <th>Stock Room</th>
                                            <th>#Cones</th>
                                            <th>Gr.Wt</th>
                                            <th>Nt.Wt</th>
                                            <th>Del.Qty</th>
                                            <th>
                                                <label>
                                                    <input type="checkbox" id="select_all">
                                                    All
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 1;
                                        ?>
                                        <?php if(sizeof($boxes) > 0): ?>
                                            <?php foreach($boxes as $box): ?>
                                                <tr>
                                                    <td><?=$sno++; ?></td>
                                                    <td><?=$box->box_prefix; ?><?=$box->box_no; ?></td>
                                                    <td>
                                                        <?=($box->item_group_id != '0')?'$i'.$box->item_group_id:''; ?>
                                                    </td>
                                                    <td><?=$box->item_name; ?>/<?=$box->item_id; ?></td>
                                                    <td><?=$box->shade_name; ?>/<?=$box->shade_id; ?></td>
                                                    <td class="text-danger"><?=$box->shade_code; ?></td>
                                                    <td><?=$box->lot_no; ?></td>
                                                    <td class="text-danger"><?=$box->stock_room_name; ?></td>
                                                    <td><?=$box->no_cones; ?></td>
                                                    <td class="box-gr-wt"><?=$box->gr_weight; ?></td>
                                                    <td class="box-nt-wt"><?=$box->nt_weight; ?></td>
                                                    <td class="box-del-qty"><?=$box->delivery_qty; ?></td>
                                                    <td>
                                                        <input type="checkbox" class="chkBoxId" value="<?=$box->box_id; ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="total-row">
                                            <th></th>
                                            <th><?=$tot_boxes; ?></th>
                                            <th></th>
                                            <th>Boxes</th>
                                            <th>Total Qty</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?=$tot_gr_weight; ?></th>
                                            <th><?=$tot_nt_weight; ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <input type="hidden" id="selected_boxes">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-danger" onclick="addToCart()">Add to List</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <hr>
                            <h4>Selected Boxes</h4>
                            <form class="cmxform form-horizontal tasi-form" role="form" method="post" action="<?=base_url();?>shop/delivery/rdc_save">
                            <div id="cart_items"></div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Stock Room</label>
                                    <select class="select2 form-control" id="stock_room_id" name="stock_room_id">
                                        <option value="">Select</option>
                                        <?php if(sizeof($stock_rooms) > 0): ?>
                                            <?php foreach($stock_rooms as $row): ?>
                                                <option value="<?php echo $row->stock_room_id; ?>"><?php echo $row->stock_room_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <input type="hidden" name="delivery_id" value="<?=$delivery_id;?>">
                                <div class="form-group col-md-6">
                                    <label>Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-danger" type="submit" name="save" value="save">Save</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $(".cust_select").change(function(){
        $("#customer_name").select2("val", $(this).val());
        $("#customer_id").select2("val", $(this).val());
        return false;
    });
    $(".cust_select").change(function(){
        $.ajax({
          type : "POST",
          url  : "<?=base_url();?>shop/delivery/dcs/"+$(this).val(),
          success: function(e){
            $("#delivery_id").html(e);
          }
        });
    });
</script>
<script type="text/javascript">
    load_cart_items();
    var oTable01 = $('.dataTables').dataTable({
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
            cart_boxes++;
            cart_gr_wt += parseFloat($(elem).closest('tr').find('td.box-gr-wt').text());
            cart_nt_wt += parseFloat($(elem).closest('tr').find('td.box-nt-wt').text());
        });
        $("#selected_boxes").val(matches);
        $(".cart-boxes").text(cart_boxes);
        $(".cart-gr-wt").text(cart_gr_wt.toFixed(3));
        $(".cart-nt-wt").text(cart_nt_wt.toFixed(3));
    });
    function addToCart() {
        var selected_boxes = $("#selected_boxes").val();
        var delivery_id=$("#delivery_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/delivery/rdc_add_to_cart'); ?>",
            data: {'selected_boxes':selected_boxes,
                    'delivery_id':delivery_id},
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                load_cart_items();
            }
        });
    }

    function load_cart_items() {

        $.ajax({
            url: "<?php echo base_url('shop/delivery/rdc_cart_temp_items/'.$delivery_id); ?>",
            success: function(response)
            {
                jQuery('#cart_items').html(response);
            }
        });
    }

    $(document).on('click', ".remove-cart-item", function(e){
        var row_id = $(this).attr('id');
        alert(row_id);
        if(confirm("Are you sure you want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('shop/delivery/rdc_remove_to_cart'); ?>",
                data: {'row_id':row_id},
                failure: function(errMsg) {
                    console.error("error:",errMsg);
                },
                success: function(response)
                {
                    load_cart_items();
                }
            });
        }
        else{
            return false;
        }
    });
    function cartRemoveAll() {
        if(confirm("Are you sure you want to delete all items?")){
            $.ajax({
                url: "<?php echo base_url('shop/delivery/rdc_remove_all_item'); ?>",
                success: function(response)
                {
                    load_cart_items();
                }
            });
        }
        else
        {
            return false;  
        }
    }
    function update_cart_item(qty_input, row_id, no_cones) {//ER-08-18#-42
        var return_qty = (qty_input)?$(qty_input).val():'';//ER-08-18#-42
        var return_cones = (no_cones)?$(no_cones).val():'';//ER-08-18#-42
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/Delivery/update_rdc_cart_item'); ?>",
            data: {'row_id':row_id,'return_qty':return_qty,'return_cones':return_cones},//ER-08-18#-42
            failure: function(errMsg) {
                console.error("error:",errMsg);
            },
            success: function(response)
            {
                load_cart_items();
            }
        });
    }
    function save_rdc() {
        $('.btn-submit').attr('disabled', true);
    }
</script>
</body>
</html>