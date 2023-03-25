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
                                <h3><i class="icon-truck"></i> Purchase Order To Dyeing</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>purchase_order/po_from_customers_save">
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
						            <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                              <th>Sno</th>
                              <th>R.PO NO</th>
                              <th>Date</th>
                              <th>Customer name</th>
                              <th>Contact Name</th>
              								<th>From filled by</th>
              								<th>Remark</th>
              								<th>Need Date</th>
              								<th>Master Date</th>
              								<th>Delivery Date</th>
                              <th></th>
							                <th></th>
                              </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($table as $row) {
                                $need_date = $row['need_date'];
                                if($need_date != '')
                                {
                                  $date = explode("-", $need_date);
                                  $need_date = $date[2].'-'.$date[1].'-'.$date[0];                                                          }
                                ?>
                                <tr class="odd gradeX">
                                  <td><?=$sno; ?></td>
                                  <td><?=$row['R_po_no']; ?></td>
                                  <td><?=$row['date']; ?></td>                                                           <td><?=$row['cust_name']; ?></td>                                                           <td><?=$row['c_name']." - ".$row['c_tel']; ?></td> 
                									<td><?=$row['user']; ?></td>                                         									<td><?=$row['remark']; ?></td>                                   									<td><input class="datepicker form-control" type="text" id="need_date<?=$row['R_po_no'] ?>" value="<?=$need_date; ?>"></td>
                									<td></td>
                									<td></td>
                                  <td><label class="btn btn-xs btn-primary" onclick="tab_detail(<?=$row['R_po_no']; ?>)">Details</label></td>
                									<?php
                									switch($row['status'])
                									{
                										case 0: ?> <td><label id="send<?=$row['R_po_no'] ?>" class="btn btn-xs btn-danger" onclick="send(<?=$row['R_po_no']; ?>)">SEND</label></td> <?php break;
                										case 1: ?> <td><span class="label label-xs label-warning">DYEING</span></td> <?php break;
                										case 2: ?> <td><span class="label label-xs label-success">DELIVERED</span></td> <?php break;
                										case 3: ?> <td><span class="label label-xs label-primary">CLEAR</span></td> <?php break;
                									}

                									?>
                                </tr>
                                <?php                                                      $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
								
								
								
								
								
								
								
								
								
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>


                      </form> 

                      <!-- Start Talbe List  --> 
                      <?php
                      /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
                      ?>                       
						<section class="panel">
                        <header class="panel-heading">
                            Details
                        </header>
                        <table class="table table-striped border-top">
                          <thead>
                            <tr>
                              <th>Sno</th>
                              <th>R.PO NO</th>
                              <th>Item Name</th>
                              <th>Customer Colour</th>
                              <th>Colour Name</th>
              								<th>Qty</th>
              								<th>UOM</th>
                              <th>Unit Rate</th>
							                <th>Tax</th>
                            </tr>
                          </thead>
							<tbody id="tab_details">
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
  		  $('.datepicker').datepicker({
  				format: "yyyy/mm/dd"
  			})
      });


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      $(function(){
		
      });
	  
	  function tab_detail(id)
	  {
		$.ajax({
			type : "POST",
			url  : "<?=base_url(); ?>purchase_order/po_from_customers_table_details/"+id,
			success: function(e){
				$("#tab_details").html(e);
			}
		})
	  }
	  
	  function send(id)
	  {
		var date = $("#need_date"+id).val();
		if(date != "")
		{
			$.ajax({
				type : "POST",
				url  : "<?=base_url(); ?>purchase_order/update_po_from_customers/"+id+"/"+date,
				success: function(e){
					if(e == "success")
					{
						alert("R_po_no : "+id+" has been successfully send for dyeing");					
						$("#send"+id).attr("class","label label-warning");
						$("#send"+id).html("DYEING");
						$("#send"+id).removeAttr("onclick");			
					}
				}
			})
		}
		else
		{
			alert("Fill the Need Date Field");
		}
	  }
  </script>

  </body>
</html>
