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
                                Request Form Master
                            </header>
                                                <div class="panel-body">
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
                                ?>                                                    <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/request_form/<?=$id; ?>">
                                    <div class="form-group col-lg-12">
                                      <h2>No : <span style="color:red"><?=$next; ?></span></h2>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="subject">Subject</label>
                                        <textarea class="form-control" name="subject" id="subject" required><?=$subject; ?></textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="header">Header</label>
                                        <textarea class="form-control" name="header" id="header" required><?=$header; ?></textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="greetings">Greetings</label>
                                        <textarea class="form-control" name="greetings" id="greetings" required><?=$greetings; ?></textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="main_content">Mail Content</label>
                                        <textarea class="form-control" name="main_content" id="main_content" required><?=$main_content; ?></textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="footer">Footer</label>
                                        <textarea class="form-control" name="footer" id="footer" required><?=$footer; ?></textarea>
                                    </div>

                                    <div class="clear"></div>
                                    <div class="form-group col-lg-6">
                                        <div class="col-lg-10">
                                            <button class="btn btn-danger" type="submit" name="submit" value="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Loading -->
                            <div class="pageloader"></div>
                            <!-- End Loading -->
                        </section>

                        <!-- Start Talbe List  -->                                        <section class="panel">
                          <header class="panel-heading">
                              Request Forms
                          </header>
                          <table class="table table-bordered table-striped table-condensed" id="sample_1">
                            <thead>
                              <tr>
                                  <th>S.No</th>
                                  <th>Subject</th>
                                  <th>Header</th>
                                  <th>Greetings</th>
                                  <th>Main Content</th>
                                  <th>Footer</th>
                                  <th>Action</th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($request_forms as $row) {
                                ?>
                                <tr>
                                  <td><?=$sno; ?></td>
                                  <td><?=$row->subject; ?></td>
                                  <td><?=$row->header; ?></td>
                                  <td><?=$row->greetings; ?></td>
                                  <td><?=$row->main_content; ?></td>
                                  <td><?=$row->footer; ?></td>
                                  <td>
                                    <a href="<?=base_url('masters/request_form/'.$row->id); ?>" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="<?=base_url('masters/delete_request_form/'.$row->id); ?>" class="btn btn-xs btn-danger">Delete</a>
                                  </td>
                                </tr>
                                <?php
                                $sno++;
                              }
                              ?>
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
        $("#category").change(function () {
            var category = $('#category').val();
            // alert(category);
            var url = "<?=base_url()?>masters/getLotscategorydatas/"+category;
            var postData = 'category='+category;
            $.ajax({
                type: "POST",
                url: url,
                // data: postData,
                success: function(shades)
                {
                    $("#lot_shade_no").html(shades);
                }
            });
            return false;
        });
      });

      $(".shade").change(function(){
        $("#shade_name").select2("val", $(this).val());
        $("#shade_code").select2("val", $(this).val());
      });

  </script>

  </body>
</html>
