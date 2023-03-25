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
                                <h3></i> <?=$this->m_masters->getmasterIDvalue('bud_general_items', 'item_id', $item_id, 'item_name'); ?></h3>
                            </header>
                        </section>
                    </div>
                </div>
                <?php
                $item_array = array();
                $lot_type_array = array();
                $concerns = array();
                $stockrooms = array();
                $current_stock = 0;

                $itemsData = $this->m_masters->getmasterdetails('bud_general_items','item_id', $item_id);
                        foreach ($itemsData as $item) {
                  $concern_id = $item['concern_id'];
                  $stockroom_id = $item['stockroom_id'];
                  $item_id = $item['item_id'];
                  $opening_stock = $item['opening_stock'];
                  $item_array[$concern_id][$stockroom_id] = $opening_stock;

                  $concern_name = $this->m_masters->getmasterIDvalue('bud_concern_master', 'concern_id', $concern_id, 'concern_name');
                  $stock_room_name = $this->m_masters->getmasterIDvalue('bud_stock_rooms', 'stock_room_id', $stockroom_id, 'stock_room_name');
                  $concerns[$concern_id] = $concern_name;
                  $stockrooms[$stockroom_id] = $stock_room_name;
                }

                $result = $this->m_general->GenStockLog($item_id);

                foreach ($result as $row) {
                  $id = $row['id'];
                  $concern_id = $row['concern_id'];
                  $stockroom_id = $row['stockroom_id'];
                  $item_id = $row['item_id'];
                  $qty = $row['qty'];
                  $type = $row['type'];
                  if($type == '+')
                  {
                    if(isset($item_array[$concern_id][$stockroom_id]))
                    {
                      $item_array[$concern_id][$stockroom_id] = $item_array[$concern_id][$stockroom_id] + $qty;
                    }
                    else
                    {
                      $item_array[$concern_id][$stockroom_id] = $qty;
                    }
                  }
                  if($type == '-')
                  {
                    if(isset($item_array[$concern_id][$stockroom_id]))
                    {
                      $item_array[$concern_id][$stockroom_id] = $item_array[$concern_id][$stockroom_id] - $qty;
                    }
                    else
                    {
                      $item_array[$concern_id][$stockroom_id] = 0 - $qty;
                    }
                  }
                  $concern_name = $row['concern_name'];
                  $stock_room_name = $row['stock_room_name'];
                  $concerns[$concern_id] = $concern_name;
                  $stockrooms[$stockroom_id] = $stock_room_name;
                  $lot_type_array[$id] = $type;
                }
                /*echo "<pre>";
                print_r($item_array);
                // print_r($lot_type_array);
                print_r($concerns);
                echo "</pre>";*/
                ?>
                <div class="row">
                    <div class="col-lg-12">                                                          <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
                      <!-- Start Talbe List  -->                                      <section class="panel">
                        <header class="panel-heading">
                            Stock Register
                        </header>
                        <table class="table table-striped border-top">
                          <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Concern Name</th>
                                <th>Stock Room</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($item_array as $key => $value) {
                              foreach ($value as $key2 => $value2) {
                                ?>
                                <tr>
                                  <td><?=$sno; ?></td>
                                  <td><?=$concerns[$key]; ?></td>
                                  <td><?=$stockrooms[$key2]; ?></td>
                                  <td><?=$value2; ?></td>
                                </tr>
                                <?php
                                $sno++;
                              }
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

  </script>

  </body>
</html>
