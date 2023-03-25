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
    foreach ($css_print as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet" media="print">
      <?php
      }
    ?>
    


  
    <style type="text/css">
    .print-only
    {
      display: none;
    }
    @media print{
         @page{
            margin: 3mm;
         }
         h2
         {
          margin: 0px;
          margin-bottom: 5px;
          padding: 0px;
          font-size: 16px;
         }
         .screen_only
         {
            display: none;
         }
         .print-only
         {
          display: block;
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
                    <div class="col-lg-12">                                    <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            POY Physical Stock
                        </header>
                        <?php
                        foreach ($stock_list as $row) {
                          $id = $row->id;
                          $denier_name = $row->denier_name;
                          $poy_lot_no = $row->poy_lot_no;
                          $closing_stock = $row->closing_stock;
                          $uom_name = $row->uom_name;
                          $remarks = $row->remarks;
                          $username = $row->username;
                          $updated_date = $row->updated_date;
                        }
                        ?>
                        <h2 class="print-only">POY Physical Stock</h2>
                        <table class="datatable table table-bordered table-striped table-condensed cf packing-register">                                            <tbody>
                            <tr>
                              <td>UNIQUE NO: <strong><?=$id; ?></strong></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Report Given By: <strong><?=$username; ?></strong></td>
                              <td class="text-right">Date &amp; Time : <?=date("d-m-Y H:i:s", strtotime($updated_date)); ?></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <table class="datatable table table-bordered table-striped table-condensed">
                                  <thead>
                                    <tr>
                                      <th>Poy Denier</th>
                                      <th>Poy Lot</th>
                                      <th>Physical Stock</th>
                                      <th>Remarks</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?=$denier_name; ?></td>
                                      <td><?=$poy_lot_no; ?></td>
                                      <td><?=$closing_stock; ?> <?=$uom_name; ?></td>
                                      <td><?=$remarks; ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                Prepared By <br>
                                <?=$this->session->userdata('display_name'); ?>
                              </td>
                              <td class="text-right">
                                Physical Stock Checked By <br><br><br>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <br/>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
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
        $("#shade_category").change(function () {
            var shade_category = $('#shade_category').val();
            var url = "<?=base_url()?>masters/getshadesdatas/"+shade_category;
            var postData = 'shade_category='+shade_category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(shades)
                {
                    var dataArray = shades.split(',');
                    $("#shade_family").html(dataArray[0]);
                    $(".shade_uoms").html(dataArray[1]);
                }
            });
            return false;
        });
      });

  </script>

  </body>
</html>
