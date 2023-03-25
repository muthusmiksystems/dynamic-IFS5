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
               <?php
              // $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status'); 
              $uom_value=($uom_val!=null)?$uom_val:$uoms;         
               ?>
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>Mir_reports/item_pack_report_2">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title;?>
                           </header>
                           <div class="panel-body">
                              <div class="form-group col-lg-3">
                                 <label for="from_date">From</label>
                                 <input type="text" value="<?=$f_date; ?>" class="form-control dateplugin" id="from_date" name="from_date">
                              </div>
                              <div class="form-group col-lg-3">
                                 <label for="to_date">To</label>
                                 <input type="text" value="<?=$t_date; ?>" class="form-control dateplugin" id="to_date" name="to_date">
                              </div>  
                               <div class="form-group col-lg-3">
                                 <label for="term">Term</label>
                                 <select class="form-control select2" name="term">
                                    <option value="1">month</option>
                                    <option value="2"<?=($term=='2')?'selected':'';?> >yearly</option>
                                 </select>
                              </div>
                               <div class="form-group col-lg-3">
                                 <label for="term">Months</label>
                                 <select class="form-control select2" name="month">
                                    <option value="0">Select</option>
                                    <option value="1"<?=($month=='1')?'selected':'';?> >January</option>
                                    <option value="2"<?=($month=='2')?'selected':'';?> >February</option>
                                    <option value="3"<?=($month=='3')?'selected':'';?>>March</option>
                                    <option value="4"<?=($month=='4')?'selected':'';?>>April</option>
                                    <option value="5"<?=($month=='5')?'selected':'';?>>May</option>
                                    <option value="6"<?=($month=='6')?'selected':'';?>>June</option>
                                    <option value="7"<?=($month=='7')?'selected':'';?>>July</option>
                                    <option value="8"<?=($month=='8')?'selected':'';?>>August</option>
                                    <option value="9"<?=($month=='9')?'selected':'';?>>September</option>
                                    <option value="10"<?=($month=='10')?'selected':'';?>>October</option>
                                    <option value="11"<?=($month=='11')?'selected':'';?>>November</option>
                                    <option value="12"<?=($month=='12')?'selected':'';?>>December</option>
                                 </select>
                              </div>
                              <div class="form-group col-lg-7">
                                 <label for="term">Uoms</label>
                                 <div class="input-group">
                                    <?php
                                    $x=1;
                                    foreach ($uoms as $uom1) {
                                       $val_uom='checked';
                                       if($uom1['uom_id']!='1'){
                                          $val_uom='';
                                          if($uom_val!=null)
                                          {
                                             foreach ($uom_val as $key => $value) {
                                                $val_uom=($value['uom_id']==$uom1['uom_id'])?'checked':'';
                                                if($val_uom=='checked')
                                                   break;
                                             }
                                          }
                                       }
                                       ?>
                                       <span class="input-group-addon form-control">
                                          <input type="checkbox" aria-label="Checkbox for following text input" value="<?=$uom1['uom_id'];?>" name="uom[]"<?=$val_uom;?>>
                                       </span>
                                       <label class="form-control form-inline"><?=$uom1['uom_name'];?></label>                                 
                                    <?php
                                    $x++;
                                    }
                                    ?>
                                 </div>
                              </div>
                               <div class="form-group col-lg-3">
                                 <label for="item_name">Item Name</label>
                                 <select class="get_item_detail form-control select2" id="item_name" name="item_name">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_name']; ?></option>
                                      <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group col-lg-2">
                                 <label for="item_id">Item Code</label>
                                 <select class="get_item_detail form-control select2" id="item_id" name="item_id">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($items as $row) {
                                      ?>
                                      <option value="<?=$row['item_id']; ?>" <?=($row['item_id'] == $item_id)?'selected="selected"':''; ?>><?=$row['item_id']; ?></option>
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

               <?php
               
               ?>
               <div class="row">
               <div class="col-lg-12">
                  <!-- Start Talbe List  -->                        
                  <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>             
                    <div class="panel-body">
                        <h3 class="visible-print"><?=$page_title;?></h3>
                        <div class="col-sm-4">
                           <strong>From Date : <?=$f_date; ?>  To Date: <?=$t_date; ?></strong>
                        </div>
                        <div class="col-sm-4">
                           <strong><?=$page_title;?></strong>
                        </div>
                        <div class="col-md-4 text-right">
                           <strong>Print Date : <?=date("d-m-Y H:i:s"); ?></strong>
                        </div>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                              <thead>
                                 <tr>
                                    <th style="color:'red';"><strong>Total:<strong></th>
                                    <th ><?=sizeof($item_detail['tot_items']); ?></th>
                                    <th></th>
                                    <th ><?=array_sum($item_detail['tot_kgs']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['stock']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['delivered']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['invoiced']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['non-invoiced']); ?></th>
                                 </tr>
                                 <tr>
                                    <th>#</th>  
      						            <th>Term</th>
                                    <th>Item</th>
                                    <th>kgs</th>
                                    <th>Stock Qty</th>
                                    <th>Delivered Qty</th>
                                    <th>Invoiced Qty</th>
                                    <th>Non- Invoiced qty</th>
                                 </tr>
                              </thead>
      							   <tfoot>
      							     <tr>
                                    <th style="color:'red';"><strong>Total:<strong></th>
                                    <th ><?=sizeof($item_detail['tot_items']); ?></th>
                                    <th></th>
                                    <th ><?=array_sum($item_detail['tot_kgs']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['stock']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['delivered']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['invoiced']); ?></th>
                                    <th ><?=array_sum($item_detail['tot_qty']['non-invoiced']); ?></th>
                                 </tr>
                              </tfoot>
                              <tbody>
                              <?php
                                 $sno = 1;
                                 foreach ($item_detail as $item_id=>$item_value) {
                                    if(($item_id=='tot_qty')||($item_id=='tot_items')||($item_id=='tot_kgs'))
                                       continue;
                                    foreach ($item_value as $term=>$term_value) {
                                    ?>
                                       <tr>
                                          <td><?=$sno; ?></td>
                                          <td><?=$item_id;?></td>
                                          <td><?=$term;?></td> 
                                          <td><?=array_sum($term_value['kgs']);?></td> 
                                          <?php
                                          foreach ($term_value['uom_qty'] as $status=>$status_value) {
                                             ?>
                                             <td><?php
                                             foreach ($status_value as $uom=>$uom_value) {
                                                echo array_sum($uom_value).$uom.',';
                                             }
                                             ?> 
                                             </td>
                                          <?php
                                          }
                                          ?>
                                       </tr>
                                       <?php
                                       $sno++;
                                    }
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

      $(".get_item_detail").change(function(){
        $("#item_name").select2("val", $(this).val());
        $("#item_id").select2("val", $(this).val());       
        return false;
      });
      </script>
   </body>
</html>
