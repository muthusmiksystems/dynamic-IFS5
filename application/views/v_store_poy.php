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
                                <h3><i class="icon-book"></i> POY Stock at Main Store</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Action Messages -->
                      <section class="panel">
                          <header class="panel-heading">
						  POY STORE ITEMS
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
									<td>POY Denier</td>
									<td>Item Name</td>
									<td>In store</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<?php 
								for($a=0; $a<count($poy_deniers); $a++)
								{ 
								$b = $a+1;
								?>
									<tr>
									<td><?=$b ?></td>
									<td><?=$poy_deniers[$a]['denier_name']?></td>
									<td><?php 
											for($ak=0;$ak<count($poy_items);$ak++) 
											{
												if(  $poy_items[$ak]['poy_denier'] ==   $poy_deniers[$a]['denier_id']  )
												{ //echo "inw.item : ".$poy_items[$ak]['item_id']."<br>";
													for($ka=0;$ka<count($poy_items_name);$ka++)
													{
														if( $poy_items_name[$ka]['item_id'] == $poy_items[$ak]['item_id']  )
														echo $poy_items_name[$ka]['item_name']."<br>";
													}
												}
												
												
											}
										?>
									</td>
									<td id="remain<?=$a; ?>"></td>
									<td id="id<?=$a; ?>" value="<?=$poy_deniers[$a]['denier_id']?>"><button class="btn btn-success" onclick="issue_table(<?=$poy_deniers[$a]['denier_id']?>)" class="label label-success">Details</button></td>
									</tr>
								<?php }  ?>
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
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                          <tr>
                                <th>Sno</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Issue To</th>
                                <th>Supplier Group</th>
                                <th>Supplier</th>
                                <th>POY Denier</th>
                                <th>POY Lot</th>
                                <th>Qty</th>
                                <th>Uom</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                          </thead>
                          <tbody id="poy_issue_table">
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
