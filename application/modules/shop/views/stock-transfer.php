<?php include APPPATH.'views/html/header.php'; ?>
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Stock Transfer In Group
                        </header>
                        <div class="panel-body">

                            <div id="formResponse"></div>

                            <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/stocktrans/stocktrans_save'); ?>">
                                <div class="row">
                                    <div class="form-group col-lg-3">
                                        DC No <label class="label label-danger" style="font-size:14px;"><span id="next_box_no">1</span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>From Concern</label>
                                        <select class="form-control select2" onchange="get_packing_boxes();" name="from_concern_id" id="from_concern_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($concerns) > 0): ?>
                                                <?php foreach($concerns as $row): ?>
                                                    <option value="<?php echo $row->concern_id; ?>"><?php echo $row->concern_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-offset-6 col-md-3">
                                        <label>To Concern</label>
                                        <select class="form-control select2" name="to_concern_id" id="to_concern_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($concerns) > 0): ?>
                                                <?php foreach($concerns as $row): ?>
                                                    <option value="<?php echo $row->concern_id; ?>"><?php echo $row->concern_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>From Stock Room</label>
                                        <select class="form-control select2" onchange="get_packing_boxes();" name="from_stock_room_id" id="from_stock_room_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($stock_rooms) > 0): ?>
                                                <?php foreach($stock_rooms as $row): ?>
                                                    <option value="<?php echo $row->stock_room_id; ?>"><?php echo $row->stock_room_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-offset-6 col-md-3">
                                        <label>To Stock Room</label>
                                        <select class="form-control select2" name="to_stock_room_id" id="to_stock_room_id">
                                            <option value="">Select</option>
                                            <?php if(sizeof($stock_rooms) > 0): ?>
                                                <?php foreach($stock_rooms as $row): ?>
                                                    <option value="<?php echo $row->stock_room_id; ?>"><?php echo $row->stock_room_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>From Staff</label><br>
                                        <input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                                        <?php echo $this->session->userdata('display_name'); ?>
                                    </div>
                                    <div class="form-group col-md-offset-6 col-md-3">
                                        <label>To Staff</label>
                                        <select class="form-control select2" name="to_user_id[]" id="to_user_id" multiple="">
                                            <option value="">Select</option>
                                            <?php if(sizeof($users) > 0): ?>
                                                <?php foreach($users as $row): ?>
                                                    <option value="<?php echo $row->ID; ?>"><?php echo $row->display_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>                                                                
                                <div class="row">
                                    <div class="col-md-12" id="box_list">
                                        
                                    </div>
                                    <input type="hidden" name="selected_boxes" id="selected_boxes">
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <button type="button" class="ajax-submit btn btn-primary" name="submit" id="save" value="save">Save</button>
                                        <button type="button" class="ajax-submit btn btn-primary" name="submit" id="transfer" value="transfer">Transfer to shop inward</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div id="formResponse-2"></div>
                    <section class="panel">
                        <header class="panel-heading">
                            Stock Transfer List
                        </header>
                        <div class="panel-body" id="transfer_list">
                            
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">

load_dc_list();
get_next_dc_no();

$(".shade-select").change(function(){
    $("#shade_id").select2("val", $(this).val());
    $("#shade_code").select2("val", $(this).val());
});

$("#from_concern_id").change(function() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('shop/stocktrans/get_stock_rooms'); ?>",
        data: {'from_concern_id':$(this).val()},
        success: function(response)
        {
            // console.log(response);
            var response = $.parseJSON(response);
            $("#from_stock_room_id").html('');
            $("#from_stock_room_id").select2('destroy');
            $("#from_stock_room_id").html(response.stock_rooms);
            $("#from_stock_room_id").select2();
        }
    });
});

$("#to_concern_id").change(function() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('shop/stocktrans/get_to_stock_rooms'); ?>",
        data: {'to_concern_id':$(this).val()},
        success: function(response)
        {
            // console.log(response);
            var response = $.parseJSON(response);
            $("#to_stock_room_id").html('');
            $("#to_stock_room_id").select2('destroy');
            $("#to_stock_room_id").html(response.stock_rooms);
            $("#to_stock_room_id").select2();
        }
    });
});

function get_packing_boxes() {
    var data = 'from_concern_id=' + $("#from_concern_id").val();
    data += '&from_stock_room_id=' + $("#from_stock_room_id").val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('shop/stocktrans/get_packing_boxes'); ?>",
        data: data,
        success: function(response)
        {
            // alert(response);
            $("#box_list").html(response);
            
            oTable01 = $('#box_list table').dataTable({
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
                     "aTargets": [ -1 ]
                  }
                ]
            });
            jQuery('.dataTables_wrapper .dataTables_filter input').addClass("form-control");
            jQuery('.dataTables_wrapper .dataTables_length select').addClass("form-control");
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
    var checkedcollection = oTable01.$(".chkBoxId:checked", { "page": "all" });
    checkedcollection.each(function (index, elem) {
        matches.push($(elem).val());
    });
    $("#selected_boxes").val(matches);
    // alert(matches);
});

$(".ajax-submit").click(function(e) {
    var url =  $("#ajaxForm").attr('action');
    var data = $("#ajaxForm").serialize();
    data +=  '&submit=' + $(this).val();
    // alert(data);
   $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(data)
        {
            response = $.parseJSON(data);
            $.each(response, function(k, v) {
                if(k=='error')
                {
                    $("#formResponse").html('<div class="alert alert-danger">'+v+'</div>');
                }
                if(k=='success')
                {
                    // $('#modal_ajax').modal('hide');
                    $("#formResponse").html('<div class="alert alert-success">'+v+'</div>');
                }
                /*if(k == 'submit')
                {
                    location.reload();
                }*/
                location.reload();
            });

            load_dc_list();
            get_next_dc_no();
        }
    });
    e.preventDefault();
});

function load_dc_list() {
    $.ajax({
        url: "<?php echo base_url('shop/stocktrans/transfer_list_data'); ?>",
        success: function(response)
        {
            jQuery('#transfer_list').html(response);
            
            $('#transfer_list table').dataTable({
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
            jQuery('.dataTables_wrapper .dataTables_filter input').addClass("form-control");
            jQuery('.dataTables_wrapper .dataTables_length select').addClass("form-control");
        }
    });
}

$(document).on('click', ".remove-dc", function(){
    var id = $(this).attr('id');
    if (confirm('Are You Sure You Want To Delete This?')) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('shop/stocktrans/delete_stocktransfer'); ?>",
            data:{id:id},
            success: function(data)
            {
                response = $.parseJSON(data);
                $.each(response, function(k, v) {
                    if(k=='error')
                    {
                        $("#formResponse-2").html('<div class="alert alert-danger">'+v+'</div>');
                    }
                    if(k=='success')
                    {
                        $("#formResponse-2").html('<div class="alert alert-success">'+v+'</div>');
                        load_dc_list();
                    }
                });
            }
        });
    } else {
        return false;
    }
});

function get_next_dc_no() {
    $.ajax({
        url: "<?php echo base_url('shop/stocktrans/get_next_dc_no'); ?>",
        success: function(response)
        {
            $("#box_no").val(response);
            $("#next_box_no").html(response);
        }
    });
}
</script>
</body>
</html>