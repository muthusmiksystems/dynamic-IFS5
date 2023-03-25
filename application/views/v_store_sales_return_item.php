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
                                <h3><i class="icon-book"></i>Sales Return Item Wise</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
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
                            }                                                      if($this->session->flashdata('error'))
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
                            </header>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>store/sales_return_item_save">
                        <section class="panel">                                                <header class="panel-heading">
                                <div class="form-group col-lg-12">
                                   <label >Box No : </label>
                                   <span class="label label-danger" style="padding: 0 1em;font-size:24px;" id="box" value="">SRI <?=$next ?></span>
                                </div>
                            </header>                                                 <div class="panel-body">
							
							  
							  <div class="form-group col-lg-4">
                                <label>Item Name / Code</label>
                                <select class="form-control select2" id="item" required>
                                  <option value="">Select item</option>
                                  <?php
                                  foreach ($items as $category) {
                                    ?>
                                    <option value="<?=$category['item_id']; ?>"><?=$category['item_name']." / ".$category['item_id']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
							  <div class="form-group col-lg-4">
                                <label>Colour Name / Code</label>
                                <select class="form-control select2" id="shade" required>
                                  <option value="">Select colour</option>
                                  <?php
                                  foreach ($shades as $category) {
                                    ?>
                                    <option value="<?=$category['shade_id']; ?>"><?=$category['shade_name']." / ".$category['shade_code']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>							  
							  
							  							  
							  <div class="form-group col-lg-4">
                                <label for="po_date">Number of cones</label>
                                <input class="form-control" id="cone" type="text">
                              </div>
							  
							  <div class="form-group col-lg-4">
                                <label for="po_date">Gross wt</label>
                                <input class="form-control" id="gross" type="text">
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Net Wt</label>
                                <input class="form-control" id="net" type="text">
                              </div>							  
							  
<div style="clear: both"></div>							  						  
							  <div class="form-group col-lg-4">
							 	<input type="button" id="add" class="btn btn-success" value="add">
                              </div>
<div style="clear: both"></div>									  
							  
							  <!--  88888888888888888888888888888888888888888888 --> <!-- add boxes -->   <!--88888888888888888888888888888888888888888888888888888888888888888  -->
							  <div>
							  	<table class="table col-lg-8">
							  		
							  		<thead><th>Item name/code </th><th>colour name/code </th><th>no of cones</th><th>Gross Wt</th><th>Net Wt</th><th></th></thead>
							  		<tbody id="items">
							  			
							  		</tbody>
							  	</table>
							  	
							  </div>
							  
							  <!--  88888888888888888888888888888888888888888888 --> <!-- add boxes -->   <!--88888888888888888888888888888888888888888888888888888888888888888  -->
							  
							  
							  <div class="form-group col-lg-4">
                                <label for="po_date">Goods Received back by</label>
                                <input class="form-control" id="to" name="received_by" value="" type="text" required>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Goods Accepted by</label>
                                <input class="form-control" id="to" name="accepted_by" value="" type="text" required>
                              </div>
							  <div class="form-group col-lg-4">
                                <label for="po_date">Remarks</label>
                                <textarea class="form-control" name="remarks"></textarea>
                              </div>							  							  

                            </div>
                        </section>

                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
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
                                <th>SRI NO</th>
                                <th>Item Name/Code</th>
                                <th>Shade Name/Code</th>
                								<th>#Cones</th>
                								<th>G.Wt</th>
                								<th>N.Wt</th>
                								<th>Rec by</th>
                								<th>Accepted by</th>
                								<th>Remark</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($table as $row) {
                                ?>
                                <tr>
                                  <td><?=$sno ?></td>
                                  <td><?=$row['date']; ?></td>
                                  <td><?=$row['form_id']; ?></td>
                                  <td><?=$row['item_name']; ?>/<?=$row['bud_items']; ?></td>
                                  <td><?=$row['shade_name']; ?>/<?=$row['bud_shades']; ?></td>
                                  <td><?=$row['cone']; ?></td>
                                  <td><?=$row['gross']; ?></td>
                                  <td><?=$row['net']; ?></td>
                                  <td><?=$row['received_by']; ?></td>
                                  <td><?=$row['accepted_by']; ?></td>
                                  <td><?=$row['remarks']; ?></td>
                                </tr>
                                <?php
                              $sno++;
                              }
                              ?>
                            </tbody>
                        </table>
                    </section>
					  
					  
					  
					  
					  
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
                  </div>
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
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      $(function(){
			var ak = 1;	
			$("#add").click(function(){
				debugger;
      	var item = $("#item").val();
      	var shade = $("#shade").val();
      	var item_f = $("#item option:selected").html();
      	var shade_f = $("#shade option:selected").html();		
		var cone = $("#cone").val();
		var gross = $("#gross").val();
		var net = $("#net").val();
      	var remove = "<input type=button value=remove class='btn btn-danger' onclick=$('#rem"+ak+"').remove(); >";
      	var content = "<tr id=rem"+ak+"><td><input type=hidden name='item[]' value="+item+">"+item_f+"</td><td><input type=hidden name='shade[]' value="+shade+">"+shade_f+"</td>"
						+"<td><input type=hidden name='cone[]' value="+cone+">"+cone+"</td>"
						+"<td><input type=hidden name='gross[]' value="+gross+">"+gross+"</td>"
						+"<td><input type=hidden name='net[]' value="+net+">"+net+"</td>"
						+"<td>"+remove+"</td></tr>"
      	$("#items").append(content);
      	++ak;				
				
			});
			
      });
      
  </script>

  </body>
</html>
