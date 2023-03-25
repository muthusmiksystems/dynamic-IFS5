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
                                <h3><i class="icon-book"></i> Job Sheet - Production Sheet for Tapes &amp; Elastic</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <!-- Start Action Messages -->
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
                      </section>
                      <!-- End Action Messages -->
                      <!-- Start Talbe List  -->                                    <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <div class="panel-body">
                          <table class="table table-striped border-top" id="sample_1">
                            <thead>
                              <tr>
                                  <th>Sno</th>
                                  <th>Item Name</th>
                                  <th>Po Ref</th>
                                  <th>Po Qty</th>
                                  <th>UOM</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($jobcards as $jobcard) {
                                ?>
                                <tr>
                                  <td><?=$sno; ?></td>
                                  <td><?=$this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $jobcard['jobcard_item'], 'item_name'); ?></td>
                                  <td><?=$jobcard['jobcard_po']; ?></td>
                                  <td><?=$jobcard['jobcard_qty']; ?></td>
                                  <td><?=$this->m_masters->getmasterIDvalue('bud_uoms', 'uom_id', $jobcard['jobcard_item_uom'], 'uom_name'); ?></td>
                                  <td>
                                    <a href="<?=base_url(); ?>production/jobsheet_ps_view/<?=$jobcard['jobcard_no']; ?>" data-placement="top" data-original-title="View Job Card" data-toggle="tooltip" class="btn btn-success btn-xs tooltips">View Job Card</a>
                                  </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
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
          $("#tbl").find("select").select2();
          $("#add").click(function () {

            $( "select" ).each(function( i ) {                      $( this ).select2("destroy");
            });

            var $tableBody = $('#tbl').find("tbody"),
            $trFirst = $tableBody.find("tr:first"),
            $trLast = $tableBody.find("tr:last"),
            $trNew = $trFirst.clone();
            $trLast.after($trNew);

            $( "select" ).each(function( i ) {                      $( this ).select2();
            });

            return false;
          });
      });

      //custom select box

      $(function(){
        $("#job_artno").change(function () {
            var job_artno = $('#job_artno').val();
            $("#job_item").select2("val", job_artno);
        });
      });
      $(function(){
        $("#job_item").change(function () {
            var job_item = $('#job_item').val();
            $("#job_artno").select2("val", job_item);
        });
      });


      /*$(function(){
        // $("select.colors").live("change", function () {
        $('select[name="colors[]"]').live("change", function () {
            var colors = $(this).val();
            alert($(this).index());
        });
      });*/

      $(function(){
          $('select.styled').customSelect();
      });


      $(document).ajaxStart(function() {
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });     

      //timepicker start
      $('.timepicker-default').timepicker();      

  </script>

  </body>
</html>
