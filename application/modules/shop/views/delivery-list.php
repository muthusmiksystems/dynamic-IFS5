<?php include APPPATH.'views/html/header.php'; ?>
    <style type="text/css">
        @media print{
          @page{
            margin: 3mm;
          }
      }
    </style>
	<section id="main-content">
		<section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Shop Deliveries
                        </header>
                        <div class="panel-body" id="transfer_dc">
                            <table class="table table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>SDC No</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Boxes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    ?>
                                    <?php if(sizeof($delivery_list) > 0): ?>
                                        <?php foreach($delivery_list as $row): ?>
                                            <?php
                                            $item_names = array();
                                            $item_boxes = array();
                                            $delivery_items = $this->Delivery_model->get_delivery_items($row->delivery_id);
                                            if(sizeof($delivery_items) > 0)
                                            {
                                                foreach ($delivery_items as $item) {
                                                    $item_names[$item->item_id] = $item->item_name;
                                                    $item_boxes[$item->box_id] = $item->box_prefix.$item->box_no;
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo date("d-m-Y g:i A", strtotime($row->delivery_date)); ?></td>
                                                <td><?php echo $row->dc_no; ?></td>
                                                <td><?php echo $row->cust_name; ?></td>
                                                <td><?php echo implode(",", $item_names); ?></td>
                                                <td><?php echo implode(",", $item_boxes); ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('shop/delivery/print_delivery/'.$row->delivery_id); ?>" target="_blank" class="btn btn-xs btn-primary">Print DC</a>
                                                    <!--ER-07-18#-3-->
                                                    <?php if($row->delivery_status==0):?>
                                                    <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateDCId(<?=$row->delivery_id?>)">Delete
                                                    </button>
                                                    <?php endif; ?>
                                                    <!--//ER-07-18#-3--> 
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>       
                        </div>
                    </section>
                </div>
            </div>
		</section>
	</section>
     <!--ER-07-18#-3-->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete Delivery</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" id="deliveryId" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="custChanged" value="Customer is Changed">Customer is Changed</label>
            </div>       
            <div class="radio">
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
    <!--ER-07-18#-3-->
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });

    var index = $(".dataTables").find('th:last').index();
    oTable01 = $('.dataTables').dataTable({
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
</script>
    <!--ER-07-18#-3-->
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
      function updateDCId(dc_id){
        $('#deliveryId').val(dc_id);
      }
      function deletedc(){
        var remarks = $( "input:checked" ).val();
        if(remarks=="others")
        {
          remarks=$('#otherRemarkValue').val();
        }
        var delivery_id=$('#deliveryId').val();
        var url = "<?php echo base_url('shop/delivery/delivery_delete')?>";
        $.ajax({
            type: "POST",
            url: url,
            data:  {
            "delivery_id": delivery_id,
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