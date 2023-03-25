<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Mosaddek">
  <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <link rel="shortcut icon" href="img/favicon.html">


  <title><?= $page_title; ?> | INDOFILA SYNTHETICS</title>

  <!-- Bootstrap core CSS -->
  <?php
  foreach ($css as $path) {
  ?>
    <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
  <?php
  }
  ?>


  
  
  
  <link media="print" rel="stylesheet" href="<?php echo base_url(); ?>themes/default/css/invoice-print.css">
  <style type="text/css">
    #items_row td input {
      width: 100%;
    }

    #items_row td textarea {
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
        <!-- // Old heading
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
							<h3><i class="icon-inr"></i> I Owe You Form</h3>
                            </header>
                        </section>
                    </div>
                </div> -->
        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>general/IOweYouSave">
          <div class="row">
            <div class="col-lg-12">
              <div id="PrintG">
                <section class="panel">
                  <header class="panel-heading">
                    <h3>I Owe You Form</h3>
                  </header>
                  <?php
                  $big = 1;
                  foreach ($iou as $a) {
                    if ($a['iou_voucher_no'] > $big) {
                      $big = $a['iou_voucher_no'];
                    }
                  }
                  $io_no = $big + 1;
                  echo "<h2>No : " . $io_no . "</h2>";
                  ?>
                  <div class="panel-body">
                    <?php
                    if ($this->session->flashdata('warning')) {
                    ?>
                      <div class="alert alert-warning fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove"></i>
                        </button>
                        <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                      </div>
                    <?php
                    }
                    if ($this->session->flashdata('error')) {
                    ?>
                      <div class="alert alert-block alert-danger fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove"></i>
                        </button>
                        <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                      </div>
                    <?php
                    }
                    if ($this->session->flashdata('success')) {
                    ?>
                      <div class="alert alert-success alert-block fade in">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove"></i>
                        </button>
                        <h4>
                          <i class="icon-ok-sign"></i>
                          Success!
                        </h4>
                        <p><?= $this->session->flashdata('success'); ?></p>
                      </div>
                    <?php
                    }
                    ?>
                    <div class="form-group col-lg-3 col-sm-3 col-md-3">
                      <label for="concern_name">Select Concern</label>
                      <select class="form-control select2" id="concern_name" name="concern_name" required">
                        <option value="">Select</option>
                        <?php
                        foreach ($concerns as $row) {
                        ?>
                          <option value="<?= $row['concern_id']; ?>"><?= $row['concern_name']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-lg-3 col-sm-3 col-md-3">
                      <label for="given_from">From</label>
                      <select class="form-control select2" id="given_from" name="given_from" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($staffs as $row) {
                        ?>
                          <option value="<?= $row['ID']; ?>" data.nam="<?= $row['user_login']; ?>"><?= $row['user_login']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-lg-3 col-sm-3 col-md-3">
                      <label for="given_to">To</label>
                      <select class="form-control select2" id="given_to" name="given_to" required>
                        <option value="">Select</option>
                        <!-- <option value="makesh.dynamic@live.com">Makesh Live</option>
                                 <option value="makesh.dynamic@gmail.com">Makesh Gmail</option>
                                 <option value="purohit.dynamic@gmail.com">Purohit</option>
                                 <option value="sapna.dynamic@gmail.com">Sapna</option>
                                 <option value="bharat78.dynamic@gmail.com">Bharat</option> -->
                        <?php
                        foreach ($staffs as $row) {
                        ?>
                          <option value="<?= $row['ID']; ?>" data.nam="<?= $row['user_login']; ?>"><?= $row['user_login']; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group col-lg-3 col-sm-3 col-md-3">
                      <label>Date</label>
                      <input type="text" class="form-control" value="<?= date("d-m-Y H:i:s"); ?>" disabled="disabled">
                    </div>
                  </div>
                </section>
                <section class="panel">
                  <div class="panel-body" id="get_item_table">
                    <table class="table table-bordered table-striped table-condensed">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="50%">Item Name</th>
                          <th width="15%">Qty Required</th>
                          <th width="15%">Amount Required</th>
                          <th width="10%" class="screen-only"><button type="button" id="addrow" class="form-control btn btn-primary"><i class="icon-plus"></i> Add</button></th>
                        </tr>
                      </thead>
                      <tbody id="items_row">
                        <tr>
                          <td>1</td>
                          <td><input type="text" name="itemnames[]"></td>
                          <td><input type="text" name="qty_required[]"></td>
                          <td><input type="text" name="amt_required[]"></td>
                          <td class="screen-only"></td>
                        </tr>
                      </tbody>
                    </table>

                    <table class="table table-condensed">
                      <thead>
                        <tr>
                          <th width="25%">signature of the person</th>
                          <th width="25%">Prepared by</th>
                          <th width="25%">A/C DEPT</th>
                          <th width="25%">Passed By</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td><?= $this->session->userdata('display_name'); ?></td>
                          <td></td>
                          <td></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </section>
              </div>
              <section class="panel">
                <header class="panel-heading">

                  <!-- <button class="btn btn-danger" type="button" id="mail">Mail</button> -->
                  <!-- <input type="button" class="btn btn-default" id="printme" value="Print" onclick="window.print();"> -->
                  <button class="btn btn-success" type="submit">Save &amp; Print</button>
        </form>
        </header>
      </section>



      <div class="screen-only">

        <section class="panel screen-only">

          <div class="panel-body" id="tab">

          </div>
        </section>



        <section class="panel">
          <header class="panel-heading">
            I Owe You Pending
          </header>
          <div class="panel-body">
            <script>
              var data = [];
            </script>
            <table class="table table-striped border-top" id="sample_1x">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Voucher No</th>
                  <th>Concern</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sno = 1;
                foreach ($iou as $row) {
                  $iou_voucher_no = $row['iou_voucher_no'];
                  $date_time = $row['date_time'];
                  $concern_name = $row['concern_name'];
                  $given_from = $row['given_from'];
                  $given_to = $row['given_to'];
                  $date = $row['date_time'];
                  $status = $row['status'];

                  $concern = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_name, 'concern_name');
                  $from_name = $this->m_masters->getmasterIDvalue('bud_users', 'ID', $given_from, 'user_login');
                  $to_name = $this->m_masters->getmasterIDvalue('bud_users', 'ID', $given_to, 'user_login');

                  $total_amt_req = 0;
                  $items = $this->m_masters->getmasterdetails('bud_general_iou_items', 'iou_voucher_id', $iou_voucher_no);
                  foreach ($items as $item) {
                    $total_amt_req += $item['amt_required'];
                  }
                ?>

                  <script>
                    data.push(['<?= $sno; ?>', '<?= $iou_voucher_no; ?>', '<?= $concern; ?>', '<?= $from_name; ?>', 'Admin<?= $to_name; ?>', '<?= $date; ?>', '<?= $total_amt_req; ?>', '<a href="#" class="label label-primary"><span onclick="view_sep(<?= $iou_voucher_no; ?>)">View</span></a><a href="<?= base_url('general/ioweu_receipt/' . $iou_voucher_no); ?>" class="btn btn-primary btn-xs" target="_blank">Print</a>']);
                  </script>

                <?php
                  $sno++;
                }
                ?>
              </tbody>
            </table>
          </div>
        </section>
      </div>

      <!-- Loading -->
      <div class="pageloader"></div>
      <!-- End Loading -->
      </div>
      </div>

      <!-- page end-->
    </section>
  </section>
  <!--main content end-->
  </section>

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
    //owl carousel
    $(document).ready(function() {
      $('#sample_1x').DataTable({
        'data': data,
        'deferRender': true,
        'processing': true,
        'language': {
          'loadingRecords': '&nbsp;',
          'processing': 'Loading...'
        },
        "order": [
          [0, "desc"]
        ]
      });
      jQuery('.dataTables_filter input').addClass("form-control");
      jQuery('.dataTables_filter').parent().addClass('col-sm-6');
      jQuery('.dataTables_length select').addClass("form-control");
      jQuery('.dataTables_length').parent().addClass('col-sm-6');

    });

    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true

      });
    });

    //custom select box

    $(function() {
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
        var rowText = '<tr><td>' + i + '</td><td><input type="text"  name="itemnames[]"></td><td><input type="text" name="qty_required[]"></td><td><input type="text" name="amt_required[]"></td><td class="screen-only"><button type="button" class="form-control btn btn-danger removeRow"><i class="icon-minus"></i> Remove</button></td></tr>';
        $(rowText).appendTo(scntDiv);
        i++;
        return false;
      });

      $('.removeRow').live('click', function() {
        $(this).parents('#items_row tr').remove();
        //return false;
      });
    });
  </script>

  <script>
    $(function() {








      $('#mail').click(function() {
        if (($("#given_from :selected").val() != "") && ($("#given_to :selected").val() != "")) {
          var tot_rows = $("#items_row").children("tr").size();
          var tr = $("#items_row").children("tr");
          var msg = "<table border='1'><tr><td>Item name</td><td>Quantity</td><td>Amount</td></tr>";
          for (var i = 0; i < tot_rows; i++) {
            msg += "<tr><td>";
            msg += tr[i].children[1].children[0].value;
            msg += "</td><td>";
            msg += tr[i].children[2].children[0].value;
            msg += "</td><td>";
            msg += tr[i].children[3].children[0].value;
            msg += "</td></tr>";
          }
          msg += "</table>";

          var from = $("#given_from :selected").text();
          var to = $("#given_to :selected").text();
          var tab_item = $("#get_item_table").html();
          $.ajax({
            type: 'POST',
            url: 'mail',
            data: {
              msg: msg,
              from: from,
              to: to
            }
          }).done(function(arun) {
            alert(arun);
          });
        } else {
          alert("select all fields to send mail");
        }
      });


    });
  </script>
  <script>
    function view_sep(voc) {
      $.ajax({
        type: "POST",
        url: "<?php base_url(); ?>get_vocher_detail",
        data: {
          vocher: voc
        }
      }).done(function(z) {
        $("#tab").html(z);
      })
    }
  </script>
  <script>
    function close_vocher(id, iou_voc) {
      var spend = $("#spend" + id).val();
      var balance = $("#balance" + id).val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>general/complete_vocher_item",
        data: {
          id: id,
          spend: spend,
          balance: balance
        }
      }).done(function(a) {
        view_sep(iou_voc);
      });
    }
    /*function close_vocher_all(id)
    {
    	$.ajax({
    		type : "POST",
    		url : "<?php echo base_url(); ?>general/complete_vocher",
    		data : {id:id}
    	}).done(function(a){
    		$("#tab").html("");
    		alert("clear all");
    	});
    }*/
  </script>
</body>

</html>