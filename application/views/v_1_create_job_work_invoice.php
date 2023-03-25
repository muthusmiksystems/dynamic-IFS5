<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="legrand">
    <meta name="keyword" content="indofila,indofila-synthetics,synthetics">
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
    


  
    <style type="text/css">
      @media print{
          @page{
            margin: 3mm;
          }
         .packing-register th
         {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }
         .packing-register td
         {
            border: 1px solid #000!important;
         }
         .dataTables_filter, .dataTables_info, .dataTables_paginate, .dataTables_length
         {
            display: none;
         }
         .screen_only
         {
            display: none;
         }
      }
      </style>
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
                                <h3><i class="icon-truck"></i> Job Work Invoice</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="work_invoice" method="post" action="<?=base_url();?>sales/job_work_invoice_save">
                        <section class="panel">
                            <div class="panel-body">
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
                                }                                                          if($this->session->flashdata('error'))
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

                                
								<div style="clear:both;"></div>
                  <div class="form-group col-lg-3">
                                   <label for="item_id">Invoice No</label><br>
                                   <input type="text" name="invoice_no" class="form-control" id="invoice_no" 
                   value="<?php echo (!empty($invoice_gen->jwi_invoice_no)) ? $invoice_gen->jwi_invoice_no+1 : '001'; ?>" readonly/>
                                </div>
                          <div style="clear:both;"></div>
                                <div class="form-group col-lg-3">
                                   <label>From Concern</label>
                                   <select class="select2 form-control" id="concern_id" name="concern_id" required>
                      <option value="">Select Concern</option>
                      <?php
                      foreach ($concern_list as $row) {
                      ?>
                      <option value="<?=$row['concern_id']; ?>"><?=$row['concern_name']; ?></option>
                      <?php
                      }
                      ?>
                  </select>
                                </div>

                                <div class="form-group col-lg-3">
                                   <label for="item_name">To Customer</label>
                                   <select class="select2 form-control itemsselects" id="customer" name="customer" required>
										  <option value="">Select customer</option>
										  <?php
										  foreach ($customers as $row) {
											?>
											<option value="<?=$row['cust_id']; ?>"><?=$row['cust_name']." - ".$row['cust_id']; ?></option>
											<?php
										  }
										  ?>
									</select>
                                </div>

                                <div class="form-group col-lg-3">
                                   <label for="item_id">Date</label><br>
                                   <input type="text" name="jwi_date" class="form-control datepicker" id="jwi_date" 
                   value=""/>
                                </div>
								
                                <!-- <div class="form-group col-lg-3">
                                   <label for="po_qty">Tax</label><br>
									  <?php if($taxes && !empty($taxes[0]['tax_id'])) {
										$count=1;
										foreach($taxes as $tax):
									  ?>
									  <label class="radio-inline"><input type="radio" name="tax_radio" id="tax_radio<?php echo $count; ?>" value="<?php echo $tax['tax_value']; ?>" autocomplete="off">
									  <?php echo $tax['tax_name']; ?></label>
									  <?php $count++; endforeach; } ?>
                                </div> -->

								
                                
								
								
								
								<!-- next row -->
								<div style="clear:both;"></div>
                                <div class="form-group col-lg-3">
                                   <label for="item_name">Particulars</label>
                                   <input type="text" name="particulars" class="form-control" id="particulars" value=""/>
                                </div>
                                <div class="form-group col-lg-3">
                                   <label for="po_qty">Quantity</label>
                                   <input type="text" name="quantity" class="calc-amount form-control" id="quantity" value=""/>
                                </div>

                                <div class="form-group col-lg-3">
                                   <label for="po_qty">Rate</label>
                                   <input type="text" name="rate" id="rate" class="calc-amount form-control" value=""/>
                                </div>
                                        <div class="form-group col-lg-3">
                                   <label for="item_id">Amount</label>
                                   <input type="text" name="amount" class="form-control" id="amount" value="" readonly="" />
                                </div>

								<!-- next row -->
								
								<!-- next row -->
								<div class="form-group col-lg-8">
                                   <label for="item_id">Note</label>
                                   <textarea name="note" id="note" class="form-control"></textarea>
                                </div>

                                <div class="form-group col-lg-4">
                                   <button type="button" class="btn btn-primary pull-right" onclick="add_job_work()">ADD</button>
                                </div>
								<!-- next row -->
								

                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>
                        <section class="panel">
                            <header class="panel-heading">
                            Items
                            </header>
                            <div class="panel-body" id="po_cartitems">
												<table class="table table-striped border-top">
												  <thead>
													<tr>
														<th>Sno</th>
														<th>Customer</th>
														<th>Tax</th>
														<th>Particular</th>
														<th>Qty</th>
														<th>Rate</th>
                            <th>Amount</th>
														<th>Note</th>
														<th></th>
													</tr>
													</thead>
												  <tbody id="add_values">
												  
												  </tbody>
												  </table>
												  <input type="hidden" name="user" value="<?=$this->session->userdata('display_name'); ?>">
												  <input type="hidden" name="date" value="<?=date("Y-m-d H:i:s"); ?>">
                                                  </div>
							<input type="hidden" name="total_row_count" id="total_row_count" value="1"/>
                        </section>
                        <section class="panel">
                            <div class="panel-body">
                              <ul class="unstyled amounts">
                                <li>
                                    <strong>Tax :</strong><br>
                                    <?php
                                    $taxs = $this->m_masters->getactivemaster('bud_tax','tax_status');
                                    foreach ($taxs as $tax) {
                                    ?>
                                    <input type="hidden" name="order_tax_names[<?=$tax['tax_id']; ?>]" value="<?=$tax['tax_name']; ?>">
                                    <label class="checkbox-inline">
                                    <input type="checkbox" name="taxs[<?=$tax['tax_id']; ?>]" value="<?=$tax['tax_value']; ?>">
                                    <?=$tax['tax_name']; ?> (<?=$tax['tax_value']; ?> %)
                                    </label>
                                    <?php
                                    }
                                    ?>
                                 </li>
                              </ul>
                            </div>
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form> 

                      <!-- Start Talbe List  --> 
                      <?php
                      /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
                      ?>                                     <section class="panel">
                        <header class="panel-heading">
                            Summary 
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
								<th>Invoice</th>
								<th>Customer</th>
								<th>Tax</th>
								<th>Qty</th>
								<th>Amount</th>
								<th>Date</th>
								<th></th>
                                 </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($table as $row) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['jwi_invoice_no']; ?></td>
                                    <td><?=$row['cust_name']; ?></td>                                                             <td><?=$row['jwi_detail_rate']; ?></td> 
                                    <td><?=$row['qty']; ?></td> 
									                  <td><?=$row['amount']; ?></td>                                 
									                  <td><?=date("d-m-Y", strtotime($row['jwi_created_on'])); ?></td>                                                                                 <td>
                                      <!-- <label class="btn btn-xs btn-success" onclick="tab_detail(<?=$row['jwi_id']; ?>)">Details</label> -->
                                      <a href="<?php echo base_url('sales/print_jwi/'.$row['jwi_id']); ?>" class="btn btn-primary btn-xs" target="_blank">Print</a>
                                    </td>
                                </tr>
                                <?php                                                      $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </section>
					
					
						<section class="panel" id="jwi_content">
                        <header class="panel-heading">
                            Jobwork Invoice
                        </header>
                        <table class="table table-striped border-top">
                          <thead>
                            <tr>
                                <th>Sno</th>
								<th>Customer</th>
								<th>Tax</th>
								<th>Particular</th>
								<th>Qty</th>
								<th>Amount</th>
								<th>Rate</th>
								<th>Note</th>
								<th></th>
                            </tr>
                          </thead>
							<tbody id="tab_details">
							</tbody>
                        </table>
						<p class="text-center"><label><strong>indofla</strong></label></p>
                <button class="btn btn-primary print screen_only" type="button">Print</button>
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

      $(function(){
			var n_id = 1;
      });
	  
    $(".calc-amount").keyup(function() {
      if(!$.isNumeric($(this).val()))
      {
        $(this).val('');
      }
      var quantity = $("#quantity").val();
      var rate = $("#rate").val();
      var amount = quantity * rate;
      $("#amount").val(amount);
    });

	  function add_job_work()
	  {
		 	var n_id = $('#total_row_count').val();
			var flag = 1;
		 var customer = $("#customer :selected").text();
				var customer_id = $("#customer :selected").val();
				var tax = $("input[name=tax_radio]:checked").val();
				var tax_val = $("input[name=tax_radio]:checked").text();
				var invoice = $("#invoice_no").val();
				var particular = $("#particulars").val();
				var qty = $("#quantity").val();
				var amount = $("#amount").val();
				var rate = $("#rate").val();
				var note = $("#note").val();
				
				if(customer_id === '')
				{
					alert('Select Customer');
					flag = 0;
				}
				/*if(tax == undefined)
				{
					alert('Select Tax');
					flag = 0;
				}*/
				if(invoice === '')
				{
					alert('Invoice no falied to create');
					flag = 0;
				}
				if(particular === '')
				{
					alert('Enter Particular');
					flag = 0;
				}
				if(qty === '')
				{
					alert('Enter Quantity');
					flag = 0;
				}
				if(isNaN(qty))
				{
					alert('Quantity should be integer');
					flag = 0;
				}
				if(amount === '')
				{
					alert('Enter Amount');
					flag = 0;
				}
				if(rate === '')
				{
					alert('Enter Rate');
					flag = 0;
				}
				if(flag)
				{
				var row = "<tr id='"+n_id+"'>"+
							"<td>"+n_id+"</td>"+
							"<td>"+customer+"</td><input type='hidden' name='a_customers[]' value='"+customer_id+"'>"+
							"<td>"+tax+"</td><input type='hidden' name='a_tax[]' value='"+tax+"'>"+
							"<td>"+particular+"</td><input type='hidden' name='a_particular[]' value='"+particular+"'>"+
							"<td>"+qty+"</td><input type='hidden' name='a_qty[]' value='"+qty+"'>"+
              "<td>"+rate+"</td><input type='hidden' name='a_rate[]' value='"+rate+"'>"+
							"<td>"+amount+"</td><input type='hidden' name='a_amount[]' value='"+amount+"'>"+
							"<td>"+note+"</td><input type='hidden' name='a_note[]' value='"+note+"'>"+
							"<td onclick='remove_row("+n_id+")'>Remove</td></tr>";
				$("#add_values").append(row);
				$('#total_row_count').val(parseInt(n_id)+1);
				}
	  }
	  
	  function remove_row(r_id)
	  {
		var select = "#"+r_id;
		$(select).remove();
	  }

	  function tab_detail(id)
	  {
		$.ajax({
			type : "POST",
			url  : "<?=base_url(); ?>sales/jwi_table_details/"+id,
			success: function(e){
				$("#tab_details").html(e);
			}
		})
	  }
  </script>
  <script type="text/javascript" src="<?=base_url('themes/default/js/jQuery.print.js'); ?>"></script>
  <script type="text/javascript">
  $("#jwi_content").find('.print').on('click', function() {
    $.print("#jwi_content");
    return false;
  });
  </script>
  </body>
</html>
