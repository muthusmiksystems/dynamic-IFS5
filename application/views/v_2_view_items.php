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
                                <h3><i class="icon-map-marker"></i> View Items</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Item Details
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
                                ?>                                                                                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>masters/items_2_view">                                                                                                    <div class="form-group col-lg-6">
                                      <label for="from_date">From Date</label>
                                      <input class="datepicker form-control" id="from_date" name="from_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label for="to_date">To Date</label>
                                      <input class="datepicker form-control" id="to_date" name="to_date" value="<?=date('d-m-Y'); ?>" type="text" required>
                                    </div>                                                                <div class="clear"></div>
                                    <div class="form-group col-lg-4">
                                      <button class="btn btn-danger" type="submit" name="search">Search</button>
                                      <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <!-- Start Talbe List  -->
                        <?php
                        $report_text = '';
                        if(isset($_POST['search']))
                        {
                          $from_date = $this->input->post('from_date');
                          $to_date = $this->input->post('to_date');
                          $report_text = '<h4>'.$from_date.' to '.$to_date.'</h4>';
                          $ed = explode("-", $from_date);
                          $from_date = $ed[2].'-'.$ed[1].'-'.$ed[0];

                          $ed = explode("-", $to_date);
                          $to_date = $ed[2].'-'.$ed[1].'-'.$ed[0];

                          $items = $this->m_masters->getall_datewise('bud_te_items', 'item_created_on', $from_date, $to_date);
                        }
                        ?>                                       <section class="panel">
                          <header class="panel-heading">
                              Summery
                              <h4><?=$report_text; ?></h4>
                          </header>
                          <table class="table table-striped border-top" id="itemlist">
                            <thead>
                              <tr>
                                  <th width="5%">#</th>
                                  <th width="10%">Date</th>
                                  <th width="15%">Group Name</th>
                                  <th width="5%">Item Code</th>
                                  <th width="15%">Item Name</th>
                                  <th width="10%">Second Name</th>
                                  <th width="10%">Third Name</th>
                                  <th width="5%">Width</th>
                                  <th width="10%">Wt/Meter</th>
                                  <th width="5%">Combos</th>
                                  <th width="10%">Status</th>
                                  <th></th>
                              </tr>
                              </thead>
                            <tbody>
                              <?php
                              $sno = 1;
                              foreach ($items as $item) {
                                $ed = explode("-", $item['item_created_on']);
                                $item_created_on = $ed[2].'-'.$ed[1].'-'.$ed[0];
                                $colorcombos = $this->m_masters->getmasterdetails('bud_te_color_combos', 'item_id', $item['item_id']);
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$item_created_on; ?></td>
                                    <td>
                                      <?=$this->m_masters->getmasterIDvalue('bud_te_itemgroups', 'group_id', $item['item_group'], 'group_name'); ?>
                                    </td>
                                    <td><?=$item['item_id']; ?></td>                                                                <td><?=$item['item_name']; ?></td>                                                                <td><?=$item['item_second_name']; ?></td>                                                                <td><?=$item['item_third_name']; ?></td>                                                         <td><?=$item['item_width']; ?></td>                                                                <td><?=$item['item_weight_mtr']; ?></td>                                                                <td><?=sizeof($colorcombos); ?></td>                                                                <td>
                                      <span class="<?=($item['item_status']==1)?'label label-success':'label label-danger'; ?>"><?=($item['item_status']==1)?'Active':'Inactive'; ?></span>
                                    </td>
                                    <td>
                                      <a href="<?=base_url();?>masters/items_2_technical/<?=$item['item_id']?>" data-placement="top" data-original-title="Update Technical Data" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-table"></i></a>
                                      <a href="<?=base_url();?>masters/edititems_2/<?=$item['item_id']?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                      <a href="<?=base_url();?>masters/deletemaster/bud_te_items/item_id/<?=$item['item_id']?>/itemgroups_2" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
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
      $(".col-sm-6.right").append('<div class="dataTables_filter col-sm-6" style="float:left;"><label>Search Item Code: <input type="text" class="form-control" id="itemcode_search" style="width:50%;"></label></div>');
  </script>

  </body>
</html>
