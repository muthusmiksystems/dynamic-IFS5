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
                                <h3><i class="icon-calendar"></i> Manage Appointment</h3>
                            </header>
                        </section>
                    </div>
                </div>
                <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>marketing/updateAppoinements">
                <div class="row">
                    <div class="col-lg-12">
                      <section class="panel">
                        <!-- <header class="panel-heading">
                            No :
                        </header> -->                                            <div class="panel-body">
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
                            <!-- <div class="form-group col-lg-3">
                               <label for="given_from">Select Staff</label>
                               <select class="form-control select2" id="given_from" name="given_from" required>
                               <option value="">Select</option>
                               <?php
                               foreach ($staffs as $row) {
                                 ?>
                                 <option value="<?=$row['ID']; ?>"><?=$row['user_login']; ?></option>
                                 <?php
                               }
                               ?>
                               </select>
                            </div> -->
                        </div>
                    </section>
                    <section class="panel">
                    <div class="panel-body">
                      <table class="table table-bordered table-striped table-condensed">
                      <thead>
                        <tr>
                          <th width="15%">Time</th>
                          <th width="35%">Customer</th>
                          <th width="50%">Purpose Of Visit</th>
                          <!-- <th width="20%">Status</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $time = '9:00'; // start
                        $now = time();
                        for ($i = 0; $i <= 23; $i++)
                        {
                          $prev = date('g:i A', strtotime($time)); // format the start time
                          $next = strtotime('+60mins', strtotime($time)); // add 30 mins
                          $time = date('g:i A', $next); // format the next time
                          $result = $this->m_marketing->getAppointment($prev, $this->session->userdata('user_id'));
                          if($result)
                          {
                            foreach ($result as $row) {
                              $customer_id = $row['customer_id'];
                              $purpose_visit = $row['purpose_visit'];
                              $status = $row['status'];
                            }
                          }
                          else
                          {
                            $customer_id = null;
                            $purpose_visit = null;
                            $status = null;
                          }
                          if($next > $now)
                          {
                                                ?>
                            <tr>
                              <!-- <td><?=$prev; ?> - <?=$time; ?></td> -->
                              <td>
                                <input type="hidden" name="time[]" value="<?=$prev; ?>">
                                <?=$prev; ?>
                              </td>
                              <td>
                                <select class="form-control select2" name="customer_id[]">
                                 <option value="">Select Customer</option>
                                 <?php
                                 foreach ($customers as $row) {
                                   ?>
                                   <option value="<?=$row['cust_id']; ?>" <?=($row['cust_id'] == $customer_id)?'selected="selected"':''; ?> ><?=$row['cust_name']; ?></option>
                                   <?php
                                 }
                                 ?>
                                </select>
                              </td>
                              <td>
                                <textarea name="purpose_visit[]" style="width:100%;"><?=$purpose_visit; ?></textarea>
                              </td>
                              <!-- <td>
                                <select name="status[]">
                                  <option value="1" <?=($status == 1)?'selected="selected"':''; ?>>Pending</option>
                                  <option value="2" <?=($status == 2)?'selected="selected"':''; ?>>Failur</option>
                                  <option value="3" <?=($status == 3)?'selected="selected"':''; ?>>Re Visit</option>
                                  <option value="4" <?=($status == 4)?'selected="selected"':''; ?>>Success</option>
                                </select>
                              </td> -->
                            </tr>
                            <?php
                            // echo "<option value=\"$prev - $time\">$prev - $time</option>";
                          }
                          else
                          {
                            ?>
                            <tr>
                              <td>
                                <input type="hidden" name="time[]" value="<?=$prev; ?>">
                                <input type="hidden" name="customer_id[]" value="<?=$customer_id; ?>">
                                <input type="hidden" name="purpose_visit[]" value="<?=$purpose_visit; ?>">
                                <?=$prev; ?>
                              </td>
                              <td><?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $customer_id, 'cust_name');?></td>
                              <td><?=$purpose_visit; ?></td>
                              <!-- <td>
                                <select name="status[]">
                                  <option value="1" <?=($status == 1)?'selected="selected"':''; ?>>Pending</option>
                                  <option value="2" <?=($status == 2)?'selected="selected"':''; ?>>Failur</option>
                                  <option value="3" <?=($status == 3)?'selected="selected"':''; ?>>Re Visit</option>
                                  <option value="4" <?=($status == 4)?'selected="selected"':''; ?>>Success</option>
                                </select>
                              </td> -->
                            </tr>
                            <?php
                          }
                        }
                        ?>                                          </tbody>
                      </table>
                    </div>
                    </section>
                    <section class="panel">
                        <header class="panel-heading">
                            <button class="btn btn-danger" type="submit">Update</button>
                        </header>
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
  </script>

  </body>
</html>
