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
                                <h3><i class="icon-book"></i> POY Store</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Action Messages -->
                      <section class="panel">
                          <header class="panel-heading">
						  POY Acceptance
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
                          }                                                    if($this->session->flashdata('error'))
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
						  <div class="panel-body">
						  <div class="form-group col-lg-12">
						  <table class="table">
							<thead>
								<tr>
									<td>Sl No</td>
									<td>Date</td>
									<td>Dc No</td>
									<td>Supp sub group</td>
									<td>Poy code</td>
									<td>Poy Denier</td>
									<td>Merge No</td>
									<td>Palette No</td>
									<td>Qty</td>
									<td>Uom</td>
									<td>Store room</td>
									<td>View</td>
								</tr>
							</thead>
							<tbody>

									<tr>
									<td>DUMMY</td>
									<td>DUMMEY</td>
									<td>1</td>
									<td></td>
									<td>1</td>
									<td>600</td>
									<td>123</td>
									<td>345</td>
									<td>100</td>
									<td>Kg</td>
									<td>SGS store</td>
									<td><button class="btn btn-success" onclick="POY_inf()">View</button></td>
									</tr>

							</tbody>
						  </table>

						  </div>
						  </div>
                      </section>
                      <!-- End Action Messages -->
                      <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            POY ISSUED BY DENIER WISE
                        </header>
                        <table class="table">
							<thead>
								<tr>
									<td>Sl No</td>
									<td>Date</td>
									<td>Dc No</td>
									<td>Supp sub group</td>
									<td>Poy code</td>
									<td>Poy Denier</td>
									<td>Merge No</td>
									<td>Palette No</td>
									<td>Qty</td>
									<td>Uom</td>
								</tr>
							</thead>
							<tbody id="insert_poy_detail">

							</tbody>
						  </table>
                    </section>
                    <!-- End Talbe List  -->
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
		  
			<?php 
			for($a=0; $a<count($poy_deniers); $a++)
			{ ?>
					var id = $("#id<?=$a ?>").attr("value");
					$("#remain<?=$a ?>").load("<?=base_url(); ?>store/get_store_poy_remain/"+id);
			<?php } ?>
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

      });

	  
	  
	  	function issue_table(id)
		{
			$.ajax({
				type:"POST",
				url :"<?=base_url(); ?>store/poy_issue_list",
				data:{id:id}
			}).done(function(e){
				$("#poy_issue_table").html(e);
			})
		}
  </script>

  </body>
</html>
