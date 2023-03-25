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
    @media print
    {
      @page
      {
        margin: 5mm;
      }
    }
    .technical-data td, .technical-data th
    {
      font-size:13px;
      font-weight: bold;
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
                                <h3> Print Production Sheet</h3>
                            </header>
                        </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">                        
                        <?php
                        if(isset($ps_id))
                        {
                          $result = $this->m_purchase->getPsDetails($ps_id);
                        }
                        if($result)
                        {
                          foreach ($result as $row) {
                            $ps_id=$row['ps_id'];
                            $ps_user=$row['ps_entered_by'];
                            $ps_date=$row['ps_date'];
                            $item_code = $row['item_id'];
                            $item_name = $row['item_name'];
                            $item_width = $row['item_width'];
                            $item_height = $row['item_height'];
                            $tot_warp_ends = $row['tot_warp_ends'];
                            $item_pick_density = $row['item_pick_density'];
                            $item_design_code = $row['item_design_code'];
                            $po_remarks = $row['ps_remarks'];
                            $demask_length = $row['demask_length'];

                            $default_repeats = $row['default_repeats'];
                            $total_wefts = $row['total_wefts'];

                            $machine_name = $row['machine_name'];
                            $machine_rpm = $row['machine_rpm'];
                            $machine_no_tapes = $row['machine_no_tapes'];
                            $machine_pick_density = $row['machine_pick_density'];
                            $machine_no_tapes_act = $row['machine_no_tapes_act'];
                            $machine_no_tapes = $row['machine_no_tapes'];
                          }
                          ?>
                          <section class="panel">
                            <table id="table" class="table table-bordered table-condensed">
                              <tbody>
                                <tr>
                                  <td colspan="3" align="center">
                                    <h3><strong><?=$machine_name; ?></strong> : Production Sheet of Dynamic Label Division</h3>
                                  </td>
                                </tr>
                                <tr>
                                  <td><strong>Production Sheet No : <?=$ps_id; ?></strong></td>
                                  <td>
                                    Date : <?=date("d-m-Y", strtotime($ps_date)); ?>
                                    Staff Name: <?=$this->m_masters->getmasterIDvalue('bud_users','ID',$ps_user,'user_nicename');; ?>
                                    <span class="pull-right">Print Date: <?php echo date("d-m-Y"); ?></span>
                                  </td>
                                  <td>Shift : Day / Night</td>
                                </tr>
                                <tr>
                                  <td>Label : <strong style="font-size:16px;"><?=$item_name; ?> / <?=$item_code; ?></strong></td>
                                  <td>
                                    Size : <strong style="font-size:16px;"><?=$item_width; ?>mm x <?=$item_height; ?>mm</strong> &emsp; Dmsk Length : <strong style="font-size:16px;"><?=$demask_length; ?></strong>
                                  </td>                                  
                                  <td>Design Code : <strong style="font-size:16px;"><?=$item_design_code; ?></strong></td>
                                </tr>
                                <tr>
                                  <td>Pick Density : <strong><?=$item_pick_density; ?></strong></td>
                                  <td>
                                    Ends x Picks : <strong><?=$tot_warp_ends; ?> x <?=$total_wefts; ?></strong> <br>
                                  </td>
                                  <td>Machine No : <strong><?=$machine_name; ?></strong></td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <table class="table table-bordered table-condensed">
                                      <tbody>
                                        <tr>
                                          <td>Size</td>
                                          <td>SAP_PO No</td>
                                          <td><strong>Prod.Repts</strong></td>
                                          <td><strong>Rpts. By Operator</strong></td>
                                          <td>Tot. Machine Repeats</td>
                                          <td>Time (H/M)</td>
                                          <td>PO Qty</td>
                                          <td>Excess Qty</td>
                                          <td>Tot Qty</td>
                                        </tr>
                                        <?php
                                        $total_repeats = 0;
                                        $total_qty = 0;
                                        $total_time = 0;
                                        $total_ps_qty =0;
                                        $total_stock_qty=0;
                                        $ps_items = $this->m_masters->getmasterdetails('bud_lbl_ps_items', 'ps_id', $ps_id);
                                        foreach ($ps_items as $item) {
                                          $delivery_form[$item['erp_po_no']]=$this->m_masters->getmasterIDvalue('bud_lbl_po','erp_po_id',$item['erp_po_no'],'po_delivery_form');
                                          $ps_item_size = $item['ps_item_size'];
                                          $ps_qty = $item['ps_qty'];
                                          $ps_stock_qty = $item['ps_stock_qty'];
                                          $tot_qty=$ps_qty+$ps_stock_qty; 
                                          $repeats = 0;
                                          $repeats = ceil(($tot_qty / (($machine_no_tapes_act / $tot_warp_ends) * $machine_no_tapes)));
                                          $time = 0;
                                          // $time = ($machine_rpm / $total_wefts) * $repeats;
                                          $time = ($repeats * $total_wefts) / $machine_rpm;

                                          $total_repeats += $repeats;
                                          $total_qty += $tot_qty;
                                          $total_ps_qty += $ps_qty;
                                          $total_stock_qty += $ps_stock_qty;
                                          $total_time += $time;

                                          $hours = floor($time / 60);
                                          $minutes = $time % 60;
                                          // $time = $time * 60;
                                          ?>
                                          <tr>
                                            <td><?=$ps_item_size; ?></td>
                                            <td><?=$item['erp_po_no'];?></td>
                                            <td><strong><?=$repeats; ?></strong></td>
                                            <td></td>
                                            <td><?=(int)($machine_no_tapes_act / $tot_warp_ends) * $machine_no_tapes; ?></td>
                                            <td><?=$hours.':'.$minutes; ?></td>
                                            <!-- <td><?=$tot_qty; ?></td> -->
                                            <td><?=$ps_qty; ?></td>
                                            <td><?=$ps_stock_qty; ?></td>
                                            <td><?=$tot_qty; ?></td>
                                          </tr>
                                          <?php
                                        }

                                        $hours = floor($total_time / 60);
                                        $minutes = $total_time % 60;
                                        ?>
                                        <tr>
                                          <td><strong>Total</strong></td>
                                          <td></td>
                                          <td><strong><?=$total_repeats; ?></strong></td>
                                          <td></td>
                                          <td></td>
                                          <td><strong><?=$hours.':'.$minutes; ?></strong></td>
                                          <td><strong><?=$total_ps_qty; ?></strong></td>
                                          <td><strong><?=$total_stock_qty; ?></strong></td>
                                          <td><strong><?=$total_qty; ?></strong></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>                                

                                <tr>
                                  <td colspan="2" rowspan="2">
                                    <strong>Label Should be</strong>
                                      <?php
                                      foreach ($delivery_form as $key => $value) {
                                        echo 'SAP_PONO_'.$key.' - '.$value.', ';
                                      }
                                      ?>
                                    <strong>Only.</strong><br>
                                    <strong>Special Instruction: </strong>
                                    <br><?=$po_remarks; ?><br>
                                  </td>
                                  <td><strong>Demask Length : <?=$demask_length; ?></strong></td>
                                </tr>
                                <!-- <tr>
                                  <td>Tefeta Length : </td>
                                </tr> -->
                                <tr>
                                  <td><strong>Total Length : <?=$item_height; ?></strong></td>
                                </tr>
                                <?php
                                // Technical Data
                                $shade_name = array();
                                $denier = array();
                                $color_names = array();
                                $color_ids = array();
                                $color_codes = array();
                                $denier_ids = array();
                                $deniers = array();
                                $net_weights = array();
                                $colorcombos = $this->m_masters->getmasterdetails('bud_lbl_color_combos', 'item_id', $item_code);
                                if(sizeof($colorcombos) > 0)
                                {
                                  foreach ($colorcombos as $combo) {
                                    $shade_name = explode(",", $combo['shade_name']);
                                    $denier_ids = explode(",", $combo['denier']);
                                    $net_weights = explode(",", $combo['net_weight']);
                                  }
                                }

                                array_shift($net_weights);
                                $key = 1;
                                array_shift($shade_name);
                                foreach ($shade_name as $shade_id) {
                                  $shade = $this->m_masters->get_shade($shade_id);
                                  if($shade)
                                  {
                                    $color_names[] = $shade->shade_name;
                                    $color_ids[] = $shade->shade_id;
                                    $color_codes[] = $shade->shade_code;
                                  }
                                }

                                $key = 0;
                                array_shift($denier_ids);
                                foreach ($denier_ids as $denier_id) {
                                  $denier = $this->m_masters->get_denier_lbl($denier_id);
                                  if($denier)
                                  {
                                    $deniers[$key] = $denier->denier_name;
                                    $key++;                                    
                                  }
                                }
                                ?>
                                <tr>
                                  <td colspan="3">
                                    <table class="table table-bordered table-condensed technical-data">
                                      <thead>
                                        <tr>
                                          <th>WEFT Needle</th>
                                          <th>Shade / Code</th>
                                          <th>Denier</th>
                                          <th>Shade No</th>
                                          <th align="right" style="text-align:right">JOB (Kgs)</th>
                                          <th>STOCK (Kgs)</th>
                                          <th width="20%">Remarks</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $sno = 0;
                                        $yarn_need = 0;
                                        foreach ($color_names as $key => $shade_name) {
                                          $yarn_need = ($net_weights[$key] * $total_qty) / 1000;
                                          ?>
                                          <tr>
                                            <td>WEFT <?=$sno; ?></td>
                                            <td><?=$shade_name; ?> / <?=$color_ids[$key]; ?></td>
                                            <td><?=$deniers[$key]; ?></td>
                                            <td><?=$color_codes[$key]; ?></td>
                                            <td align="right"><?=number_format($yarn_need, 3, '.', ''); ?></td>
                                            <td></td>
                                            <td></td>
                                          </tr>
                                          <?php
                                          $sno++;
                                        }
                                        ?>
                                      </tbody>
                                    </table>
                                  </td>  
                                </tr>
                                <tr>
                                  <td>
                                    <br>
                                    <br>
                                    <br>
                                    Prepared By
                                  </td>
                                  <td>
                                    <br>
                                    <br>
                                    <br>
                                    Operator's Signature
                                  </td>
                                  <td>
                                    <br>
                                    <br>
                                    <br>
                                    Authorized Signatory
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                        </section>
                        <?php
                          $next_page=($next==1)?'purchase_order/po_list_lbl':'reports/prod_sheet_3';
                        ?>
                        <a onclick="window.print()" class="btn btn-danger screen-only"  type="button" href="<?=base_url().$next_page?>">Print</a>
                          <?php
                        }
                        ?>                        
                      <!-- End Talbe List  -->
                      
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

      $(".get_outerboxes").change(function(){
        window.location = "<?=base_url(); ?>purchase/po_received_3/"+$(this).val();
      });
      $(".selects_customers").change(function(){
          $("#customer_name").select2("val", $(this).val());
          $("#customer_id").select2("val", $(this).val());
      });     

  </script>

  </body>
</html>
