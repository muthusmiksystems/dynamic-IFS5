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
    .gross-weight
    {
      height: 100px;
      font-size: 62px;
      font-weight: bold;
      color: red;
    }
    .gross-weight-lbl
    {
      font-size: 32px;
      color: red;
      text-transform: uppercase;
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
                                <h3>Gray Yarn Soft Packing Entry</h3>
                            </header>
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
                        </section>
                    </div>
                </div>
                        <?php
                $t_wt = 0;
                if(isset($id))
                {
                  $result = $this->m_masters->getmasterdetails('bud_yt_packing_boxes', 'box_id', $id);
                  foreach ($result as $row) {                                $item_id = $row['item_id'];
                    $edit_box_no = $row['box_no'];
                    $poy = $row['poy_denier'];
                    $poy_inward_no = $row['poy_inward_no'];
                    $poy_lot_id = $row['poy_lot_id'];
                    $yarn = $row['yarn_denier'];
                    $shade = $row['shade_no'];
                    $grant_wt = $row['gross_weight'];
                    $net_wt = $row['net_weight'];
                    $lot_wastage = $row['lot_wastage'];
                    $packed_by = $row['packed_by'];
                    $date = $row['packed_date'];
                    $box_weight = $row['box_weight'];
                    $no_of_box = $row['no_boxes'];
                    $poly_bag = $row['poly_bag_weight'];
                    $no_of_poly_bag = $row['no_bags'];
                    $other_weight = $row['other_weight'];
                    $spring_weight = $row['spring_weight'];
                    $stock_room_id = $row['stock_room_id'];
                  }
                  $t_wt = ($box_weight * $no_of_box) + ($poly_bag * $no_of_poly_bag) + $other_weight;
                  $next = $id;
                }
                else
                {
                  $id = '';
                  $item_id = '';
                  $poy = '';
                  $yarn = '';
                  $shade = '';
                  $grant_wt = '';
                  $net_wt = '';
                  $lot_wastage = '';
                  $packed_by = '';
                  $date = '';
                  $box_weight = '';
                  $no_of_box = '';
                  $poly_bag = '';
                  $no_of_poly_bag = '';
                  $other_weight = '';
                  $poy_inward_no = '';
                  $poy_lot_id = '';
                  $spring_weight = '';
                  $stock_room_id = '';
                }

                $inward_qty = 0.000;
                $tot_packed_qty = 0.000;
                $tot_balancd_qty = 0.000;
                $tot_wastage_qty = 0.000;
                $percentage = 0;
                if(!empty($poy_inward_no))
                {
                  if(!empty($poy_inward_no))
                  {
                    $inward = $this->m_poy->get_poy_inward_qty($poy_inward_no);
                    if($inward)
                    {
                      $inward_qty = $inward->tot_inward_qty;
                    }

                    $pack_qty = $this->m_masters->get_inward_pack_qty($poy_inward_no);
                    if($pack_qty)
                    {
                      if($pack_qty->tot_packed_qty > 0)
                      {
                        $tot_packed_qty = $pack_qty->tot_packed_qty;
                        $tot_wastage_qty = $pack_qty->tot_wastage_qty;
                      }
                    }
                  }
                  $tot_balancd_qty = $inward_qty - ($tot_packed_qty + $tot_wastage_qty);
                  if($inward_qty > 0)
                  {
                    // $percentage = (($tot_packed_qty - $inward_qty) / $inward_qty) * 100;
                    if($tot_wastage_qty > 0)
                    {
                      $percentage = ($tot_wastage_qty / $tot_packed_qty) * 100;
                    }
                  }

                  $inward_qty = number_format($inward_qty, 3, '.', '');
                  $tot_packed_qty = number_format($tot_packed_qty, 3, '.', '');
                  $tot_balancd_qty = number_format($tot_balancd_qty, 3, '.', '');
                }

                if(!empty($edit))
                {
                  $box_no = $edit_box_no;
                }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url(); ?>store/gray_yarn_soft_save">
                        <input type="hidden" name="id" value="<?=$id; ?>">
                        <section class="panel">                                                <header class="panel-heading">
                                <div class="form-group col-lg-12">
                                   <label >Box No : </label>
                                   <span class="label label-danger" style="padding: 0 1em;font-size:24px;">S<?=$box_no; ?></span>
                                </div>
                            </header>                                                <div class="panel-body">


                              <div class="form-group col-lg-2">
                                <label>Poy Inward No</label>
                                <select class="form-control select2" name="poy_inward_no" id="poy_inward_no">
                                  <option value="">Select</option>
                                  <?php
                                  foreach ($poy_inwards as $row) {
                                    ?>
                                    <option value="<?=$row->po_no; ?>" <?=($row->po_no == $poy_inward_no)?'selected="selected"':''; ?>><?=$row->po_no; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date">POY Inward Qty</label>
                                <span class="label label-primary" id="label_inward_qty" style="padding: 0 1em;font-size:24px;"><?=$inward_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date">Total Lot Packed Qty</label>
                                <span class="label label-warning" id="label_pack_qty" style="padding: 0 1em;font-size:24px;"><?=$tot_packed_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date">Balance Lot Qty</label>
                                <span class="label label-danger" id="label_bal_qty" style="padding: 0 1em;font-size:24px;"><?=$tot_balancd_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="label_tot_wastage_qty">Wastage Qty</label><br>
                                <span class="label label-danger" id="label_tot_wastage_qty" style="padding: 0 1em;font-size:24px;"><?=$tot_balancd_qty; ?></span>
                              </div>
                              <div class="form-group col-lg-2">
                                <label for="po_date" class="text-danger">This Lot Wastage Qty</label>
                                <input class="form-control" name="lot_wastage" id="lot_wastage" value="<?=$lot_wastage; ?>" type="text" style="color:red;font-weight:bold;">
                              </div>
                              <div class="form-group col-lg-1">
                                <label for="po_date" class="text-danger">%</label>
                                <span class="label label-danger" id="label_percentage" style="padding: 0 1em;font-size:24px;"><?=number_format($percentage, 2, '.', ''); ?></span>
                              </div>
                              <div style="clear:both;"></div>
                              <p class="text-danger" style="font-weight:bold;">Supplier &emsp;&emsp;  Poy Denier &emsp;&emsp;  Poy Lot No  &emsp;&emsp;   Item Name  &emsp;&emsp; Qty</p>
                              <div class="form-group col-lg-2">
                                 <label for="item_name">Item Name</label>
                                 <select class="item-select form-control select2" id="item_name" name="item_name">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$item['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_id">Item Code</label>
                                 <select class="item-select form-control select2" id="item_id" name="item_id">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                       ?>
                                       <option value="<?=$item['item_id'];?>" <?=($item['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$item['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>

                              <div class="form-group col-lg-2">
                                <label for="po_category">Poy denier</label>
                                <select class="form-control select2" name="poy_denier" id="poy_denier" required>
                                  <option value="">Select denier</option>
                                  <?php
                                  foreach ($poydeniers as $row) {
                                    ?>
                                    <option value="<?=$row['denier_id']; ?>" <?=($row['denier_id'] == $poy)?'selected="selected"':''; ?>><?php echo $row['denier_name']." - ".$row['denier_tech']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                                                      <div class="form-group col-lg-2">
                                <label for="po_category">Yarn denier</label>
                                <select class="form-control select2" name="yarn_denier" id="yarn_denier" required>
                                  <option value="">Select denier</option>
                                  <?php
                                  foreach ($yarndeniers as $row) {
                                    ?>
                                    <option value="<?=$row['denier_id']; ?>" <?=($row['denier_id'] == $yarn)?'selected="selected"':''; ?>><?php echo $row['denier_name']." - ".$row['denier_tech']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>

                              <div class="form-group col-lg-2">
                                <label for="po_category">POY Lot</label>
                                <select class="form-control select2" name="poy_lot_id" id="poy_lot_id" required>
                                  <option value="">Select Lot</option>
                                  <?php
                                  foreach ($poy_lots as $row) {
                                    ?>
                                    <option value="<?=$row['poy_lot_id']; ?>" <?=($row['poy_lot_id'] == $poy_lot_id)?'selected="selected"':''; ?>><?php echo $row['poy_lot_no']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-2">
                                <span class="text-danger">Yarn Lot Master Link</span>
                              </div>
                              <div style="clear:both"></div>
                                                    <div class="row col-md-12">
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="po_date" class="gross-weight-lbl">Gross Weight</label>
                                    <input class="form-control gross-weight" id="g_wt" name="g_wt" value="<?=$grant_wt; ?>" type="text" required>
                                  </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group col-lg-6">
                                      <label for="po_category">Colour</label>
                                      <select class="form-control select2 color-select" name="colour" id="colour" required>
                                        <option value="">Select colour</option>
                                        <?php
                                        foreach ($shades as $row) {
                                          ?>
                                          <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade)?'selected="selected"':''; ?>><?=$row['shade_name']." / ".$row['shade_id']; ?></option> -->
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>

                                     <div class="form-group col-lg-6">
                                      <label for="po_category">Colour Code</label>
                                      <select class="form-control select2 color-select" id="colour_code" required>
                                        <option value="">Select colour</option>
                                        <?php
                                        foreach ($shades as $row) {
                                          ?>
                                          <option value="<?=$row['shade_id']; ?>" <?=($row['shade_id'] == $shade)?'selected="selected"':''; ?>><?=$row['shade_code']; ?></option> -->
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label for="spring_weight">Springs</label>
                                      <input class="form-control" name="spring_weight" id="spring_weight" value="<?=$spring_weight; ?>">
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label for="stock_room_id">Stock Room</label>
                                      <select class="form-control select2" name="stock_room_id" id="stock_room_id" required>
                                        <option value="">Select Box</option>
                                        <?php
                                        foreach ($stock_rooms as $row) {
                                          ?>
                                          <option value="<?=$row['stock_room_id']; ?>" <?=($row['stock_room_id'] == $stock_room_id)?'selected="selected"':''; ?>><?=$row['stock_room_name']; ?></option>
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                </div>
                              </div>
                              <div style="clear:both"></div>


                              <br/>

                              <div class="form-group col-lg-4">
                                <label for="po_category">Box Weight</label>
                                <select class="form-control select2" name="box_weight" id="b_wt" required>
                                  <option value="0">Select Box</option>
                                  <?php
                                  foreach ($tareweights as $row) {
                                    ?>
                                    <option value="<?=$row['tareweight_value']; ?>" <?=($row['tareweight_value'] == $box_weight)?'selected="selected"':''; ?>><?=$row['tareweight_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>  
                                              <div class="form-group col-lg-4">
                                <label for="po_date">No of boxe(s)</label>
                                <input class="form-control" id="n_bx" name="no_of_box"  value="<?=$no_of_box; ?>" type="text" onkeyup="total_box()" required>
                              </div>
                                      <div class="form-group col-lg-4">
                                <label for="po_date">Total Box weight</label>
                                <input class="form-control" id="t_bx" value="<?=($box_weight * $no_of_box); ?>" type="text" required readonly>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_category">Poly Bag Weight</label>
                                <select class="form-control select2" name="poly_bag" id="p_wt" required>
                                  <option value="0">Select Box</option>
                                  <?php
                                  foreach ($tareweights as $row) {
                                    ?>
                                    <option value="<?=$row['tareweight_value']; ?>" <?=($row['tareweight_value'] == $poly_bag)?'selected="selected"':''; ?>><?=$row['tareweight_name']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>  
                                              <div class="form-group col-lg-4">
                                <label for="po_date">No of Bags</label>
                                <input class="form-control" name="no_of_poly_bag" id="n_bg"  value="<?=$no_of_poly_bag; ?>" type="text" onkeyup="total_bag()" required>
                              </div>
                                      <div class="form-group col-lg-4">
                                <label for="po_date">Total Bag Weight</label>
                                <input class="form-control" id="t_bg" value="<?=($poly_bag * $no_of_poly_bag); ?>" type="text" required readonly>
                              </div>

                              <div class="form-group col-lg-4">
                                <label for="po_date">Other Weight</label>
                                <input class="form-control" name="other_weight" id="ot_wt" value="<?=$other_weight; ?>" type="text" required  min="-1" onkeyup="tare_wt()">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_date">Net Weight</label>
                                <input class="form-control" id="nt_wt" name="nt_wt" value="<?=$net_wt; ?>" type="text" required readonly>
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="po_date">Tare Weight</label>
                                <input class="form-control" id="t_wt" name="t_wt" value="<?=$t_wt; ?>" type="text" readonly>
                              </div>
                              <input type="hidden" id="pack_by" name="pack_by" value="<?=$this->session->userdata('display_name'); ?>">
                            </div>
                        </section>

                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-danger" type="submit" name="action" value="save" id="submit">Save</button>
                                <button class="btn btn-danger" type="submit" name="action" value="duplicate">Duplicate</button>
                                <button class="btn btn-warning" type="submit" name="action" value="save_continue">Save &amp; Continue</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </header>
                        </section>
                      </form>
                      <!-- Loading -->
                      <div class="pageloader"></div>
                      <!-- End Loading -->
                  </div>
                </div>             <!-- page end-->
                              <section class="panel">
                        <header class="panel-heading">
                            Summery
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                          <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Date</th>
                                <th>Box No</th>
                                <th>Yarn Dn</th>
                                <th>Colour Name</th>
                                <th>Colour Code</th>
                                <th>POY Denier</th>
                                <th>POY Lot</th>
                                <th>Gr.Weight</th>
                                <th>Net Weight</th>
                                <th>Lot Wastage</th>
                                <th>Packed By</th>
                                <th></th>
                            </tr>
                            </thead>
                          <tbody>
                            <?php
                            $sno = 1;
                            foreach ($gray_yarn_soft as $row) {
                                $box_id = $row['box_id'];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['packed_date']; ?></td>
                                    <td>S<?=$row['box_no']; ?></td>
                                    <td><?=$row['denier_tech']; ?></td>                                          <td><?=$row['shade_name']; ?></td>                                    <td><?=$row['shade_code']; ?></td>
                                    <td><?=$row['poy_denier_name']; ?></td>
                                    <td><?=$row['poy_lot_name']; ?></td>
                                    <td><?=$row['gross_weight']; ?></td>
                                    <td><?=$row['net_weight']; ?></td>
                                    <td><?=$row['lot_wastage']; ?></td>
                                    <td><?=$row['packed_by']; ?></td>
                                    <td>
                                      <a href="<?=base_url('store/print_gray_yarn_soft/'.$box_id); ?>" target="_blank" class="btn btn-xs btn-warning" title="Print">Print</a>
                                      <a href="<?=base_url(); ?>store/gray_yarn_soft/<?=$row['box_id']; ?>/edit" class="btn btn-xs btn-primary" title="Duplicate">Edit</a>
                                      <a href="<?=base_url(); ?>store/gray_yarn_soft/<?=$row['box_id']; ?>" class="btn btn-xs btn-success" title="Duplicate">Duplicate</a>
                                      <a href="#<?=$row['box_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger" title="Delete">Delete</a>
                                      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?=$row['box_id']; ?>" class="modal fade">                                                                         <div class="modal-dialog">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h4 class="modal-title">Remarks</h4>
                                             </div>
                                             <div class="modal-body">
                                                <form role="form" method="post" action="<?=base_url(); ?>store/delete_packing_box/<?=$row['box_id']; ?>/gray_yarn_soft">
                                                   <input type="hidden" name="box_id" value="<?=$row['box_id']; ?>">
                                                   <input type="hidden" name="function_name" value="gray_yarn_soft">
                                                   <div class="form-group col-lg-12" style="margin-bottom: 15px;">
                                                      <textarea class="form-control" name="remarks" required style="width:100%;"></textarea>
                                                   </div>
                                                   <div style="clear:both;"></div>
                                                   <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                      </div>
                                    </td>
                                </tr>
                                <?php                                                      $sno++;
                            }
                            ?>
                          </tbody>
                        </table>
                    </section>
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
        // alert('Start');
        $('.pageloader').show();
      });
      $(document).ajaxStop(function() {
        $('.pageloader').hide();
      });

function total_box()
    {
    $("#t_bx").val( $("#b_wt").val() * $("#n_bx").val()  );
    }
    function total_bag()
    {
    $("#t_bg").val( $("#p_wt").val() * $("#n_bg").val()  );
    }
    function tare_wt(){
      var grant = parseFloat( $("#g_wt").val() );
      var box = parseFloat( $("#t_bx").val() );
      var bag = parseFloat( $("#t_bg").val() );
      var other = parseFloat( $("#ot_wt").val() );
      var tare = parseFloat( $("#t_wt").val() );
    if( other >= 0 )
      {
        if( grant >= 0 )
        {
          if( ( box >= 0 ) && ( bag >= 0 ) )
          {
            var tare_total = box + bag + other;
            if( tare_total < grant )
            {
              $("#t_wt").val( tare_total );
              $("#nt_wt").val( grant - $("#t_wt").val() );                }
            else
            {
              $("#ot_wt").val("");
              alert("tare wt is greater than grant");
            }

          }
          else
          {
            $("#ot_wt").val("");
            alert("check box and bag weight");
          }
        }
        else
        {
          $("#ot_wt").val("");
          alert("check Grant weight");
        }
      }
      else
      {
        $("#g_wt").val();
        $("#ot_wt").val("");
        $("#t_wt").val("");
        $("#nt_wt").val("");
      }
    }

  $(function(){
      $("#submit").click(function(){
        if( $("#nt_wt").val() != "" )
        {
          $("#commentForm").submit();
        }
        else
        {
          alert("check all the fields are filled");
        }
      })
      });

      $(".item-select").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());
      });
      $(".color-select").change(function(){
        $("#colour").select2("val", $(this).val());
        $("#colour_code").select2("val", $(this).val());
      });

      $(function(){
        $("#poy_inward_no").change(function () {
          var poy_inward_no = $('#poy_inward_no').val();
          var url = "<?=base_url()?>store/get_poy_inward_qty/"+poy_inward_no;
          var postData = 'poy_inward_no='+poy_inward_no;
          $.ajax({
              type: "POST",
              url: url,
              // data: postData,
              success: function(result)
              {
                // console.log(result);
                var result = $.parseJSON(result);
                $("#label_inward_qty").text(result.inward_qty);
                $("#label_pack_qty").text(result.tot_packed_qty);
                $("#label_bal_qty").text(result.tot_balancd_qty);
                $("#label_percentage").text(result.percentage);
                $("#label_tot_wastage_qty").text(result.tot_wastage_qty);
              }
          });
          return false;
        });
      });

  </script>

  </body>
</html>
