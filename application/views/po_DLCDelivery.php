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
                                <h3><i class="icon-book"></i>Dyed Loose Cone Delivery</h3>
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
				              <section class="panel">                                        <table class="table datatable table-bordered border-top" id="example">
                          <thead>
                            <tr>
                                <th>S.No</th>
                                <th>DLCP No</th>
                                <th>Date</th><!--Inclusion of DLC Date-->
                                <th>Lot No</th>
                                <th>Item Name</th>
                                <th>Shade Name</th>
                                <th>Shade No</th>
                                <th>Hold # Springs</th>
                                <th>Hold Nt.Weight</th>
                                <th># Of Springs</th>
                                <th>Net Weight</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            /*echo "<pre>";
                            print_r($register);
                            echo "</pre>";*/
                            $sno = 1;
                            foreach ($register as $box) {
                              $items = $this->m_purchase->get_dlc_packing_item_reg($box->id);
                              $id_display = false;
                              $action_display = false;
                              foreach ($items as $row) {
                                ?>
                                <tr>
                                  <?php
                                  if($id_display == false)
                                  {
                                    $id_display = true;
                                    ?>
                                    <td><?=$sno; ?></td>
                                    <td><?=$box->id; ?></td>
                                    <td><?=date('d-M-y h:i a',strtotime($box->packed_date)); ?></td><!--Inclusion of DLC Date-->
                                    <?php
                                  }
                                  else
                                  {
                                    ?>
                                    <td></td>
                                    <td></td>
                                    <td></td><!--Inclusion of DLC Date-->
                                    <?php
                                  }
                                  ?>
                                  <td><?=$row->lot_no; ?></td>
                                  <td><?=$row->item_name; ?>/<?=$row->item_id; ?></td>
                                  <td><?=$row->shade_name; ?>/<?=$row->shade_id; ?></td>
                                  <td><?=$row->shade_code; ?></td>
                                  <td><?=$row->no_springs_hold; ?></td>
                                  <td><?=$row->net_weight_hold; ?></td>
                                  <td><?=$row->no_springs; ?></td>
                                  <td><?=$row->net_weight; ?></td>
                                  <?php
                                  if($action_display == false)
                                  {
                                    $action_display = true;
                                    ?>
                                    <td>
                                      <a href="<?=base_url('purchase_order/po_dlcp_print/'.$box->id); ?>" target="_blank" class="btn btn-xs btn-warning">Print</a>
                                    </td>
                                    <?php
                                  }
                                  else
                                  {
                                    ?>
                                    <td></td>
                                    <?php
                                  }
                                  ?>
                                </tr>
                                <?php
                              }
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                      </section>
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

          $('.datatable').dataTable({
            // "sDom": "<'row'<'col-sm-6'f>r>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": false,
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
        jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
        jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown
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

	
	function checkbox()
	{
	   var check = $("#check").prop("checked");
		
		if( check == true)
		{
			$(".delivery").prop("checked",true);
		}
		if( check == false)
		{
			$(".delivery").prop("checked",false);
		}
	}
	  
	  
      $(function(){
			$("#submit").click(function(){
				var tot_tr = $("#tab_body").children("tr").size();
				var ids = [];
				for(var i=0;i<tot_tr;i++)
				{
					if($("#chk"+i).prop("checked") == true)
					{
						var id = $("#chk"+i).val();
						ids.push(id);
					}
				}
				
						$.ajax({
						type : "POST",
						url  : "<?=base_url(); ?>purchase_order/po_DLCDelivery_save",
						data : {data:ids},
						success: function(e){
							alert(e);
						}
						})
				setTimeout(function(){location.reload()}, 1000);
			})
      });

  </script>

  </body>
</html>
