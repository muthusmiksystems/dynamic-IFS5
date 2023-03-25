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
                                <h3><i class="icon-book"></i> Enquiries</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                                    <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Category</th>
                              <th>Customer</th>
                              <th>Remarks</th>
                              <th class=""></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          $sno = 1;
                          foreach ($enquiries as $enquiry) {
                            ?>
                            <tr>
                                <td><?=$sno; ?></td>
                                <td>
                                  <?=$enquiry['enq_date']; ?>
                                </td>
                                <td>
                                  <?=$this->m_masters->getmasterIDvalue('bud_categories', 'category_id', $enquiry['enq_category'], 'category_name'); ?>
                                </td>
                                <td class="">
                                  <?=$this->m_masters->getmasterIDvalue('bud_customers', 'cust_category', $enquiry['enq_customer'], 'cust_name'); ?>
                                </td>
                                <td class="">
                                  <?=$enquiry['enq_remarks']; ?>
                                </td>
                                <td>
                                  <a href="<?=base_url(); ?>productions/newquotation/<?=$enquiry['enq_id']; ?>" data-placement="top" data-original-title="View" data-toggle="tooltip" class="btn btn-success btn-xs tooltips"><i class="icon-file-text"></i></a>
                                  <a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user removecart"><i class="icon-trash "></i></a>
                                </td>
                            </tr>
                            <?php
                            $sno++;
                          }
                          ?>                                                </tbody>
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
