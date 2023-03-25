<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Mosaddek">
  <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <link rel="shortcut icon" href="img/favicon.html">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <style>
    .modal-dialog {
      right: auto;
      left: 50%;
      width: 80% !important;
      padding-top: 30px;
      padding-bottom: 30px;
    }
  </style>

  <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

  <!-- Bootstrap core CSS -->
  <?php
  foreach ($css as $path) {
  ?>
    <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
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
                <h3><i class="fa fa-file"></i> <?= $msg; ?> </h3>
              </header>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <!-- Loading -->
            <div class="pageloader"></div>
            <!-- End Loading -->
            <?php
            /*echo "<pre>";
                      print_r($stock_register);
                      echo "</pre>";*/
            ?>
            <!-- Start Talbe List  -->
            <section class="panel">
              <header class="panel-heading">
                <?= $msg; ?>
              </header>

              <script>
                var data = [];
              </script>
              <table class="table table-bordered sample_1x" id="sample_1x">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">
                      Concern
                    </th>
                    <th class="text-center">
                      Customer
                    </th>
                    <th>
                      Quotation No
                    </th>
                    <th>
                      Total Qty
                    </th>
                    <?php
                    if ($status != 0) {
                      echo '<th> Remark </th>';
                    }
                    ?>
                    <th>
                      Date
                    </th>
                    <th>
                      Email
                    </th>
                    <th>
                      Print
                    </th>
                    <th>
                      Success
                    </th>
                    <th>
                      Action
                    </th>
                  </tr>
                </thead>

                <?php
                $where['tbl_quote.is_active'] = 'Y';
                $where['tbl_quote.status'] = $status;
                $where['tbl_quote.quote_type'] = $this->session->userdata('user_viewed');
                $data = $this->quote->sale_outward_detail($where);
                $a = 1;
                foreach ($data as $row) {

                  $email = '<button class="btn btn-xs btn-primary btn-click" data-toggle="modal" data-target="#myModal" data-value="' . $row['id'] . '"><i class="fa fa-envelope"></i></button>';

                  $print = '<a href="' . base_url('quote/print_quote') . '/' . $row['id'] . '" target="_blank" class="btn btn-xs btn-info" ><i class="fa fa-print"></i></a>';

                  $success = '<a href="javascript:void(0);" class="btn btn-xs btn-success success_click" data-value="' . $row['id'] . '"><i class="fa fa-check"></i></a>';

                  $trash = '<a href="' . base_url('quote/index') . '/' . $row['id'] . '/duplicate" class="btn btn-xs btn-success"><i class="icon-copy"></i></a><a href="javascript:void(0);" class="btn btn-xs btn-danger cancel_click" data-value="' . $row['id'] . '"><i class="fa fa-trash"></i></a>';
                  /* <a href="' . base_url('quote/index') . '/' . $row['id'] . '" class="btn btn-xs btn-primary"><i class="icon-pencil"></i></a> */

                ?>




                  <?php
                  if ($status != 0) {
                  ?>
                    <script>
                      data.push(['<?= $a; ?>', '<?= $row['bname']; ?>', '<?= $row['cname']; ?>', '<?= $row['bill_no']; ?>', '<?= $row['total_qty']; ?>', '<?= $row['remark']; ?>', '<?= date("d-M-Y", strtotime($row['bill_date'])); ?>', '<?= $email; ?>', '<?= $print; ?>', '<?= $success; ?>', '<?= $trash; ?>']);
                    </script>
                  <?php
                  } else {
                  ?>
                    <script>
                      data.push(['<?= $a; ?>', '<?= $row['bname']; ?>', '<?= $row['cname']; ?>', '<?= $row['bill_no']; ?>', '<?= $row['total_qty']; ?>', '<?= date("d-M-Y", strtotime($row['bill_date'])); ?>', '<?= $email; ?>', '<?= $print; ?>', '<?= $success; ?>', '<?= $trash; ?>']);
                    </script>
                  <?php
                  }
                  ?>

                <?php

                  $a++;
                }
                ?>

              </table>
            </section>
            <!-- End Talbe List  -->
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
  </section>
  <form action="" id="submitEmail">

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Email Content</h4>
          </div>
          <div class="modal-body">
            <div id="sendMail"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-success3x">SEND</button>

          </div>
        </div>

      </div>
    </div>
  </form>

  <form action="<?= base_url('quote/quote_update'); ?>" method="post">
    <div id="successModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Success</h4>
          </div>
          <div class="modal-body">
            <textarea name="remark" class="form-control"></textarea>
            <input type="hidden" name="id" id="s_id">
            <input type="hidden" name="status" value="1">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">SUBMIT</button>
          </div>
        </div>

      </div>
    </div>
  </form>
  <form action="<?= base_url('quote/quote_update'); ?>" method="post">
    <div id="cancelModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Cancel</h4>
          </div>
          <div class="modal-body">
            <textarea name="remark" class="form-control"></textarea>
            <input type="hidden" name="id" id="c_id">
            <input type="hidden" name="status" value="2">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">SUBMIT</button>
          </div>
        </div>

      </div>
    </div>
  </form>
  <!-- js placed at the end of the document so the pages load faster -->
  <?php
  foreach ($js as $path) {
  ?>
    <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
  <?php
  }
  ?>

  <!--common script for all pages-->
  <?php
  foreach ($js_common as $path) {
  ?>
    <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
  <?php
  }
  ?>

  <!--script for this page-->
  <?php
  foreach ($js_thispage as $path) {
  ?>
    <script src="<?= base_url() . 'themes/default/' . $path; ?>"></script>
  <?php
  }
  ?>
  <script>
    $(document).ready(function() {

      $('.btn-success3x').on('click', function() {
        $(this).hide();
      });

      $('.sample_1x').DataTable({
        'data': data,
        'deferRender': true,
        'processing': true,
        'language': {
          'loadingRecords': '&nbsp;',
          'processing': 'Loading...'
        },
        "order": [
          [0, "asc"]
        ]
      });
      jQuery('.dataTables_filter input').addClass("form-control");
      jQuery('.dataTables_filter').parent().addClass('col-sm-6');
      jQuery('.dataTables_length select').addClass("form-control");
      jQuery('.dataTables_length').parent().addClass('col-sm-6');

      $('select').select2();

      $('#mySelect2').select2({
        ajax: {
          url: 'https://api.github.com/orgs/select2/repos',
          data: function(params) {
            var query = {
              search: params.term,
              type: 'public'
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
          }
        }
      });


      $(".success_click").click(function() {
        var id = $(this).attr('data-value');
        $("#s_id").val(id);
        $("#successModal").modal();
      });
      $(".cancel_click").click(function() {
        var id = $(this).attr('data-value');
        $("#c_id").val(id);
        $("#cancelModal").modal();
      });

    });
  </script>
  <script>
    //owl carousel

    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true

      });
      $("#submitEmail").submit(function(e) {

        var data = $("#emailContent").html();
        var subject = $("#subject").val();
        var email = $("#email").val();

        $.ajax({
          type: "POST",
          url: "<?= base_url(); ?>quote/confirmEmail",
          data: 'message=' + data + '&&subject=' + subject + '&&email=' + email,
          success: function(result) {
            $("#sendMail").html(result);
          }
        });


        e.preventDefault();
      });
    });

    //custom select box

    $(function() {
      $('select.styled').customSelect();
    });

    $(".btn-click").live('click', function() {
      var id = $(this).attr('data-value');
      $.ajax({
        type: "POST",
        url: "<?= base_url(); ?>quote/sendEmail",
        data: 'id=' + id,
        success: function(result) {
          $("#sendMail").html(result);
        }
      });
    });


    $(document).ajaxStart(function() {
      $('.pageloader').show();
    });
    $(document).ajaxStop(function() {
      $('.pageloader').hide();
    });

    $("#add").live('click', function() {
      var $tableBody = $('#tbl').find("tbody"),
        $trFirst = $tableBody.find("tr:first"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trFirst.clone(true);
      $trLast.after($trNew);
      $trNew.find("input").val("");
      return false;
    });
    $('.remove-row').live('click', function() {
      $(this).closest('tr').remove();
    });
  </script>

</body>

</html>