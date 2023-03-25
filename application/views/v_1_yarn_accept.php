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
                                <h3><i class="icon-user"></i> Polyster YARN Acceptance</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Talbe List  --> 
                      <?php
                      /*echo "<pre>";
                      print_r($poy_issue);
                      echo "</pre>";*/
                      ?>                                     <section class="panel">
                        <header class="panel-heading">
                            Summery
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
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
								<th>Issue No</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                                <th>Qty</th>
                                <th>Uom</th>
								<th>Details</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($yarn_delivery as $row) {
                              $delivery_id = $row['delivery_id'];
                              $is_accepted = $row['is_accepted'];
                              if($delivery_id != '')
                              {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['delivery_id']; ?></td>
									<td><?=$row['from_dept']; ?></td> 
                                    <td><?=$row['to_dept']; ?></td>                                                             <td><?=$row['delivery_date_time']; ?></td>                                                             <td><?=$row['tatalqty']; ?></td> 
                                    <td><?=$row['uom_name']; ?></td>
									<td><span class="label label-primary" onclick="get_detail(<?=$row['delivery_id']; ?>)">Detail</span></td>
                                    <td>
                                          <?php
                                      if($is_accepted == 1)
                                      {
                                        ?>
                                      <span class="label label-primary">Got</span>  
                                        <?php
                                      }
                                      else
                                      {
                                      ?>
                                                                    <a href="#<?=$row['delivery_id']; ?>" data-toggle="modal" data-placement="top" data-original-title="Click to Accept" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">Accept</a>
                                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?=$row['delivery_id']; ?>" class="modal fade">
                                         <div class="modal-dialog">
                                            <div class="modal-content">
                                               <div class="modal-header">
                                                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                  <h4 class="modal-title">Enter Your Password</h4>
                                               </div>
                                               <div class="modal-body">
                                                  <form role="form" method="post" action="<?=base_url(); ?>poy/pyarn_accept_update">
                                                     <input type="hidden" name="id" value="<?=$row['delivery_id']; ?>">
                                                     <div class="form-group" style="margin-bottom: 15px;">
                                                     <label>Password</label>
                                                     <input type="password" class="form-control" name="password" required placeholder="Your Password">
                                                     </div>
                                                     <div style="clear:both;"></div>
                                                     <button type="submit" class="btn btn-default">Accept</button>
                                                  </form>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <?php
                                      }
                                      ?>
                                      

                                    </td>
                                </tr>
                                <?php                                                      }
                              $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </section>
					
					
					
										<section class="panel">
                        <header class="panel-heading">
                            Detail
                        </header>
                        <table class="table table-striped border-top">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Issue No</th>
                                <th>Item Name</th>
                                <th>Item code</th>
                                <th>POY denier</th>
								<th>Yarn denier</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                          <tbody id="Detail_table">

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
      });


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

      $(function(){

      });

      function get_yarn(id)
      {
        $.ajax({
            type : "POST",
            url  : "<?=base_url(); ?>poy/get_yarn/"+id,
            success: function(ele){
              location.reload();
            }
          })
      }
	  
	  function get_detail(po_no)
	  {
		$.ajax({
			type : "POST",
			url  : "<?=base_url(); ?>poy/yarn_detail/"+po_no,
			success: function(e){
				$("#Detail_table").html(e);
			}
		});
	  }	  
  </script>

  </body>
</html>
