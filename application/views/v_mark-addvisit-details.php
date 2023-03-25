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
    


  
    <style type="text/css">
    #items_row td input
    {
      width: 100%;
    }
    #items_row td textarea
    {
      width: 100%;
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
                                <h3><i class="icon-calendar"></i> Add Visit Details</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>marketing/saveVisitDetails">
                <div class="row">
                    <div class="col-lg-12">
                      <section class="panel">                                          <div class="panel-body">
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

                            <table class="table table-bordered table-striped table-condensed">
                            <thead>
                              <tr>
                                <th width="5%">#</th>
                                <th width="15%">Time</th>
                                <th width="25%">Customer</th>
                                <th width="35%">Purpose Of Visit</th>
                                <th width="20%">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              $statusArray = array(
                                '1' => 'Pending', 
                                '2' => 'Failur', 
                                '3' => 'Re Visit', 
                                '4' => 'Success', 
                                );
                              foreach ($pending_works as $row) {
                                $id = $row['id'];
                                $date = $row['date'];
                                $time = $row['time'];
                                $customer_id = $row['customer_id'];
                                $purpose_visit = $row['purpose_visit'];
                                $status = $row['status'];
                                ?>
                                <tr>
                                  <td><?=$sno; ?></td>
                                  <td>
                                    <?=$date; ?>  <?=$time; ?>
                                  </td>
                                  <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_name');?></td>
                                  <td><?=$purpose_visit; ?></td>
                                  <td>
                                    <?=$statusArray[$status]; ?>
                                  </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>                                                </tbody>
                            </table>

                        </div>
                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            Add Visit Details
                        </header>
                        <div class="panel-body">
                          <div class="form-group col-lg-3">
                            <input type="hidden" name="id" value="<?=$id; ?>">
                             <label for="visit_date">Time</label>
                             <input class="form-control dateplugin" value="<?=date("d-m-Y"); ?>" id="visit_date" name="visit_date" required type="text">                                               </div>
                          <div class="form-group col-lg-3">
                             <label for="visit_time">Time</label>
                             <input class="form-control timepicker-default" value="<?=date("h:i:s A"); ?>" id="visit_time" name="visit_time" required type="text">                                               </div>
                          <div class="form-group col-lg-3">
                             <label for="visit_person">Person Met</label>
                             <input class="form-control" id="visit_person" name="visit_person" required type="text">                                               </div>
                          <div class="form-group col-lg-3">
                             <label for="status_person">Status of Person</label>
                             <input class="form-control" id="status_person" name="status_person" required type="text">                                               </div>
                          <div class="form-group col-lg-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                              <option value="1" <?=($status == 1)?'selected="selected"':''; ?>>Pending</option>
                              <option value="2" <?=($status == 2)?'selected="selected"':''; ?>>Failur</option>
                              <option value="3" <?=($status == 3)?'selected="selected"':''; ?>>Re Visit</option>
                              <option value="4" <?=($status == 4)?'selected="selected"':''; ?>>Success</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6">
                             <label for="details_meeting">Details of Meeting</label>
                             <textarea class="form-control" id="details_meeting" name="details_meeting" required></textarea>
                          </div>
                        </div>
                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit">Update</button>
                        </header>
                    </section>
                    <section class="panel">
                      <header class="panel-heading">
                          Visits Summery
                      </header>
                      <div class="panel-body">
                        <table class="table table-striped border-top" id="sample_1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Person Met</th>
                            <th>Status of Person</th>
                            <th>Details of meeting</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sno = 1;
                          foreach ($visits as $row) {
                            $visit_date = $row['visit_date'];
                            $visit_time = $row['visit_time'];
                            $visit_person = $row['visit_person'];
                            $status_person = $row['status_person'];
                            $details_meeting = $row['details_meeting'];
                            $qd = explode("-", $visit_date);
                            $visit_date = $qd[2].'-'.$qd[1].'-'.$qd[0];
                            ?>
                            <tr>
                              <td><?=$sno; ?></td>
                              <td><?=$visit_date; ?></td>
                              <td><?=$visit_time; ?></td>
                              <td><?=$visit_person; ?></td>
                              <td><?=$status_person; ?></td>
                              <td><?=$details_meeting; ?></td>
                            </tr>
                            <?php
                            $sno++;
                          }
                          ?>
                        </tbody>
                        </table>
                      </div>
                    </section>
                    <!-- Loading -->
                    <div class="pageloader"></div>
                    <!-- End Loading -->
                </div>
              </div>           </form>
              <!-- page end-->
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

    $(function() {
      var scntDiv = $('#items_row');
      var i = $('#items_row tr').size() + 1;
      $('#addrow').live('click', function() {
        var rowText = '<tr><td>'+i+'</td><td><input type="text" name="itemnames[]"></td><td><input type="text" name="qty_required[]"></td><td><input type="text" name="amt_required[]"></td><td><button type="button" class="form-control btn btn-danger removeRow"><i class="icon-minus"></i> Remove</button></td></tr>';
        $(rowText).appendTo(scntDiv);
        i++;
        return false;
      });

      $('.removeRow').live('click', function() {
        if( i > 2 ) {
          $(this).parents('#items_row tr').remove();
          i--;
        }
        return false;
      });
    });

    $('.timepicker-default').timepicker();
  </script>

  </body>
</html>
