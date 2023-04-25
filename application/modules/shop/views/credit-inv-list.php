<?php include APPPATH . 'views/html/header.php'; ?>
<style type="text/css">
  @media print {
    @page {
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
            Print Credit Invoice
          </header>
          <div class="panel-body" id="transfer_dc">
            <table class="table table-bordered dataTables">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Invoice No</th>
                  <th>Invoice ID</th>
                  <th>Date</th>
                  <th>Concern</th>
                  <th>Customer</th>
                  <th>Delivery To</th>
                  <th>Name</th>
                  <th>Mobile No</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $sno = 1; ?>
                <?php if (sizeof($invoices) > 0) : ?>
                  <?php foreach ($invoices as $row) : ?>
                    <tr>
                      <td><?php echo $sno++; ?></td>
                      <td><?php echo $row->invoice_no; ?></td>
                      <td><?php echo $row->invoice_id; ?></td>
                      <td><?php echo date("d-m-Y g:i a", strtotime($row->invoice_date)); ?></td>
                      <td><?php echo $row->concern_name; ?></td>
                      <td><?php echo $row->cust_name; ?></td>
                      <td><?php echo $row->del_cust_name; ?></td>
                      <td><?php echo $row->name; ?></td>
                      <td><?php echo $row->mobile_no; ?></td>
                      <td><?php echo $row->invoice_amt; ?></td>
                      <td>
                        <a target="_blank" href="<?php echo base_url('shop/sales/print_credit_preprint/' . $row->invoice_id); ?>" class="btn btn-xs btn-warning">Print Pre-printed</a>
                        <a target="_blank" href="<?php echo base_url('shop/sales/print_credit_gatepass/' . $row->invoice_id); ?>" class="btn btn-xs btn-warning">Print Gatepass</a>
                        <a target="_blank" href="<?php echo base_url('shop/sales/print_credit_invoice/' . $row->invoice_id); ?>" class="btn btn-xs btn-primary">Print Orig.Copy</a>
                        <a target="_blank" href="<?php echo base_url('shop/sales/print_credit_invoicedc/' . $row->invoice_id); ?>" class="btn btn-xs btn-primary">Print Dup.Copy</a>
                        <a target="_blank" href="<?php echo base_url('shop/sales/print_credit_invoiceac/' . $row->invoice_id); ?>" class="btn btn-xs btn-primary">Print A/C.Copy</a>
                        <a target="_blank" href="<?php echo base_url('shop/sales/print_credit_invoicesc/' . $row->invoice_id); ?>" class="btn btn-xs btn-primary">Print Shop.Copy</a>
                        <!--ER-07-18#-22-->
                        <?php if ($this->session->userdata('user_id') == '1') : ?>
                          <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateINVId(<?= $row->invoice_id ?>)">Delete
                          </button>
                        <?php endif; ?>
                        <!--//ER-07-18#-22-->
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
<!--ER-07-18#-22-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delete Quotation</h4>
      </div>
      <form>
        <div class="modal-body">
          <input type="text" id="invoiceId" value="" hidden>
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
          <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deleteinv()">Delete</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--ER-07-18#-22-->
<?php include APPPATH . 'views/html/footer.php'; ?>
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
<!--ER-07-18#-22-->
<script>
  $('#otherRemarks').hide();
  $('#others').click(function(event) {
    if (this.checked) { // check select status
      $('#otherRemarks').show();
    } else {
      $('#otherRemarks').hide();
    }
  });
  $('.remarks').click(function(event) {
    $('#otherRemarks').hide();
  });

  function updateINVId(inv_id) {
    $('#invoiceId').val(inv_id);
  }

  function deleteinv() {
    var remarks = $("input:checked").val();
    if (remarks == "others") {
      remarks = $('#otherRemarkValue').val();
    }
    var invoice_id = $('#invoiceId').val();
    var url = "<?php echo base_url('shop/sales/invoice_delete') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        "invoice_id": invoice_id,
        "remarks": remarks,
        "type": 'credit'
      },
      success: function(result) {
        alert(result);
        location.reload(true);
      }
    });
  }
</script>
</body>

</html>