<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Legrand charles">
      <meta name="keyword" content="">
      <link rel="shortcut icon" href="img/favicon.html">
      <title><?=$page_title; ?></title>

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
      @media print{
         @page{
            margin: 2.5mm;
         }
         .packing-register th
         {
            border: 1px solid #000 !important;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
         }
         .packing-register td
         {
            border: 1px solid #000!important;
         }
         .dataTables_filter
         {
            display: none;
         }
         .screen_only
         {
            display: none;
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
               <div class="row screen-only">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           <h3><i class=" icon-file"></i><?=$page_title; ?></h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row screen-only">
                  <div class="col-lg-12">
                  <?php
                  if($this->session->flashdata('warning'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-warning fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                           </button>
                           <strong>Warning!</strong> <?=$this->session->flashdata('warning'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }                                  
                  /*if($this->session->flashdata('error'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="alert alert-block alert-danger fade in">
                           <button data-dismiss="alert" class="close close-sm" type="button">
                           <i class="icon-remove"></i>
                           </button>
                           <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
                        </div>
                     </header>
                  </section>
                  <?php
                  }*/
                  if($this->session->flashdata('success'))
                  {
                  ?>
                  <section class="panel">
                     <header class="panel-heading">
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
                     </header>
                  </section>
                  <?php
                  }
                  ?>
                  </div>
               </div>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url();?>production/prod_entry_operator_reg_3">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="date">From Date</label>
                                 <input class="form-control" type="date" value="<?=$from_date; ?>" id="date" name="from_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="date">To Date</label>
                                 <input class="form-control" type="date" value="<?=$to_date; ?>" id="date" name="to_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="operator_name">Operator Name</label>
                                 <select class="selects_operator form-control select2" id="operator_name" name="operator_name">
                                    <option value="">Select Operator Name</option>
                                    <?php
                                    foreach ($operators as $row) {
                                       ?>
                                       <option value="<?=$row['operator_id'];?>" <?=($row['operator_id'] == $operator_id)?'selected="selected"':''; ?>><?=$row['op_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="operator_id">Operator Code</label>
                                 <select class="selects_operator form-control select2" id="operator_id" name="operator_id">
                                    <option value="">Select Operator Code</option>
                                    <?php
                                    foreach ($operators as $row) {
                                       ?>
                                       <option value="<?=$row['operator_id'];?>" <?=($row['operator_id'] == $operator_id)?'selected="selected"':''; ?>><?=$row['operator_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="shift">Shift</label>
                                 <select class="form-control" id="shift" name="shift">
                                    <option value="" default>Select</option>
                                    <option value="Day" <?=($shift == 'Day')?'selected="selected"':''; ?>>Day</option>                                          
                                    <option value="Night" <?=($shift == 'Night')?'selected="selected"':''; ?>>Night</option>                                          
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="sample">Sample / Production</label>
                                 <select class="form-control" id="sample" name="sample">
                                    <option value="" default>Select</option>
                                    <option value="1" <?=($sample == '1')?'selected="selected"':''; ?>>Sample</option>                                          
                                    <option value="2" <?=($sample == '2')?'selected="selected"':''; ?>>Production</option>                                          
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="machine_id">Machine</label>
                                 <select class="form-control select2" id="machine_id" name="machine_id">
                                    <option value="">Select Machine</option>
                                    <?php
                                    foreach ($machines as $row) {
                                       ?>
                                       <option value="<?=$row['machine_id'];?>" <?=($row['machine_id'] == $machine_id)?'selected="selected"':''; ?>><?=$row['machine_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_id">Item Code</label>
                                 <select class="selects_items form-control select2" id="item_id" name="item_id">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="selects_items form-control select2" id="item_name" name="item_name">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $row) {
                                       ?>
                                       <option value="<?=$row['item_id'];?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div style="clear:both;"></div>
                              <div class="form-group col-lg-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-danger" type="submit" name="search">Search</button>
                              </div>                             
                           </div>
                        </section>
                     </div> 
                  </div>
                </form>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>             
                    <div class="panel-body">
                        <h3 class="visible-print" align="center"><?=$page_title; ?></h3>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                           <strong>Printed By :<?=$this->session->userdata('display_name'); ?></strong>
                        </div>
                        <div class="col-md-4 text-right">
                           <strong>Print Date : <?=date("d-m-Y h:ia"); ?></strong>
                        </div>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                            <thead>
                              <tr>
                                  <td>#</td>
                                  <td>ID</td>
                                  <td>Date</td>
                                  <td>Operator Name</td>
                                  <td>Machine Name</td>
                                  <td>Item Name</td>
                                  <td>MPM</td><!--//ER-09-18-62-->
                                  <td>Sizes</td>
                                  <td># of Repts</td>
                                  <td>Machine Run Time</td>
                                  <td>Vir. Prod. Mtrs</td><!--//ER-09-18-62-->
                                  <td>Vir. Prod. Kgs</td><!--//ER-09-18-62-->
                                  <td class="text-info"><b>Phy. Prod. kgs</b></td><!--//ER-09-18-62-->
                                  <td class="text-danger">Diff.  / Shortage.</td><!--//ER-09-18-62-->
                                  <td>Entered By</td><!--//ER-09-18#-56-->
                                  <td>Remarks</td>
                                  <td class="screen-only"></td>
                              </tr>
                              </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($today_production as $row) {
                                  $mac_run_time=array();
                                  $item_size=array();
                                  $no_repts=array();
                                  $condition=array(
                                    'id'=>$row['id'],
                                    'is_deleted'=>1);
                                  $item_sizes=$this->m_mir->get_two_table_values('dyn_lbl_prod_size_entry','','*','','',$condition);
                                  $tot_phy_pdtn=array();//ER-09-18#-62
                                  $vir_pdtn=array();//ER-09-18#-62
                                  $meter_per_min_arr=array();//ER-09-18#-62
                                  $tot_meter_prod_arr=array();//ER-09-18#-62
                                  $diff=array();//ER-09-18#-62
                                  foreach ($item_sizes as $key => $value) {
                                    $item_size[]=$value['item_size'];
                                    $no_repts[]=$value['no_repts'];
                                    $cl_time=$value['mac_cl_time'];
                                    $op_time=$value['mac_op_time'];
                                    $hour_diff=$cl_time-$op_time;
                                    $hour=floor($hour_diff);   //ER-09-18#-56               
                                    $mins=round(($hour_diff-$hour)*60);//ER-09-18#-56
                                    $mac_run_time[]=$hour.':'.$mins;//ER-09-18#-56
                                    //ER-09-18#-62
                                    $tot_mins=($hour*60)+($mins);
                                    $meter_per_min=0;
                                    $machine_rpm=($row['shift']=='day')?$row['machine_rpm_day']:$row['machine_rpm_night'];
                                    if($row['item_pick_density']){
                                      if ($machine_rpm) {
                                        $meter_per_min=$machine_rpm/$row['item_pick_density'];
                                        $meter_per_min=$meter_per_min/39.33;
                                        $meter_per_min_arr[]=number_format($meter_per_min,2);
                                      }
                                    }
                                    $tot_meter_prod=$tot_mins*$meter_per_min*$value['no_repts'];
                                    $tot_meter_prod_arr[]=round($tot_meter_prod);
                                    $tot_kg_prod=0;
                                    if($row['one_meter_weight']){
                                      $tot_kg_prod=$tot_meter_prod*$row['one_meter_weight'];
                                    }                                    
                                    $vir_pdtn[]=number_format($tot_kg_prod,3);
                                    $tot_phy_pdtn[]=$value['tot_phy_pdtn'];
                                    $diff[]=number_format($value['tot_phy_pdtn']-$tot_kg_prod,3);
                                    //ER-09-18#-62
                                  }
                                  ?>
                                  <tr>
                                    <td><?=$sno; ?></td>
                                    <td><?=$row['id']; ?></td>
                                    <td><?=date('d-M-y',strtotime($row['prod_date'])).'-'.$row['shift']; ?>-<?=($row['sample']==1)?'S':'P'; ?></td><!--//ER-09-18#-62-->
                                    <td><?=$row['op_name'].'/'.$row['operator_id']; ?></td><!--//ER-09-18#-62-->
                                    <td><?=$row['machine_name'].'/'.$row['machine_id']; ?></td>
                                    <td><?=$row['item_name'].'/'.$row['item_id']; ?></td><!--//ER-09-18#-62-->
                                    <td><?=implode('<br>',$meter_per_min_arr); ?></td><!--//ER-09-18#-62-->
                                    <td><?=implode('<br>',$item_size); ?></td>
                                    <td><?=implode('<br>',$no_repts); ?></td>
                                    <td><?=implode('<br>',$mac_run_time); ?></td>
                                    <td><?=implode('<br>',$tot_meter_prod_arr);?></td><!--//ER-09-18-62-->
                                    <td><?=implode('<br>',$vir_pdtn);?></td><!--//ER-09-18-62-->
                                    <td class="text-info"><b><?=implode('<br>',$tot_phy_pdtn);?></b></td><!--//ER-09-18-62-->
                                    <td class="text-danger"><?=implode('<br>',$diff);?></td><!--//ER-09-18#-62-->
                                    <td><?=$row['entered_by'].' '.date('d-M-y H:i',strtotime($row['entered_date'])) ;?></td><!--//ER-09-18#-56-->
                                    <td width="10pi"></td><!--//ER-09-18-62-->
                                    <td class="screen-only">
                                      <a href="<?=base_url(); ?>production/prod_entry_operator_3/<?=$row['id']; ?>" target="_blank" class="btn btn-success">Duplicate</a><!--//ER-09-18-62-->
                                      <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="updateId(<?=$row['id']?>)">Delete
                                      </button>
                                    </td>
                                  </tr>
                                  <?php
                                  $sno++;
                                }
                                ?>
                            </tbody>
                          </table>
                           <hr>
                        <button class="btn btn-danger screen-only" type="button" onclick="window.print()">Print</button>
                     </div>
                  </section>
                  <!-- End Talbe List  -->
               </div>
            </div>
               <div class="pageloader"></div>                   
               <!-- page end-->
            </section>
         </section>
         <!--main content end-->
      </section>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete Entry</h4>
          </div>
          <form>
          <div class="modal-body">
            <input type="text" id="entryId" value="" hidden>
            <label>Remarks:</label>
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="custChanged" value="Typing Mistake">Typing Mistake</label>
            </div>       
            <div class="radio">
              <label><input type="radio" name="remarks" class="remarks" id="WrongQty" value="System Error">System Error</label>
            </div>
            <div class="radio">
              <label><input type="radio" name="remarks" id='others' value="others">Others</label>
            </div>
            <div class="form-group" id="otherRemarks">
              <label for="comment">Comment:</label>
              <textarea class="form-control" rows="5" name="others" id="otherRemarkValue"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" onclick="deleteEntry()">Delete</button>
          </div>
        </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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

      $('.datatable').dataTable({
            "sDom": "<'row'<'col-sm-6'f>r>",
            // "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": true,
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': true,
                'aTargets': [0]
            }]
        });
      jQuery('#example_wrapper .dataTables_filter input').addClass("form-control"); // modify table search input
      jQuery('#example_wrapper .dataTables_length select').addClass("form-control"); // modify table per page dropdown

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

      $(".selects_operator").change(function(){
          $("#operator_name").select2("val", $(this).val());
          $("#operator_id").select2("val", $(this).val());
      });
      $(".selects_items").change(function(){
        $("#item_id").select2("val", $(this).val());
        $("#item_name").select2("val", $(this).val());
      });
      </script>
      <script>
        $('#otherRemarks').hide();
      $('#others').click(function(event) {
      if(this.checked) { // check select status
        $('#otherRemarks').show();
      }
      else
      {
        $('#otherRemarks').hide();
      }
      });
      $('.remarks').click(function(event) {
      $('#otherRemarks').hide();
      });
      function updateId(id){
        $('#entryId').val(id);
      }
      function deleteEntry(){
        var remarks = $( "input:checked" ).val();
        if(remarks=="others")
        {
          remarks=$('#otherRemarkValue').val();
        }
        var id=$('#entryId').val();
        var url = "<?php echo base_url('production/prod_entry_3_delete')?>";
        $.ajax({
            type: "POST",
            url: url,
            data:  {
            "id": id,
            "remarks": remarks
            },
            success: function(result)
            {
              alert(result);
              location.reload(true);
            }
          });
      }
      </script>
   </body>
</html>
