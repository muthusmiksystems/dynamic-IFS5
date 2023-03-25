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
               <form class="cmxform form-horizontal tasi-form screen-only" role="form" id="commentForm" method="post" action="<?=base_url()?>Mir_reports/abstract_report_2">
                  <div class="row">
                     <div class="col-lg-12">
                        <section class="panel">                            
                           <header class="panel-heading">
                              <?=$page_title; ?>
                           </header>
                           <div class="panel-body">
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
                              <div class="form-group col-lg-3">
                                 <label for="year">Years</label>
                                 <select class="get_item_detail form-control select2" id="year" name="year">
                                    <option value="0">Select</option>
                                    <?php
                                    $y_value=date('Y');
                                    while($y_value>=2015){
                                      ?>
                                      <option value="<?=$y_value; ?>" <?=($y_value == $year)?'selected="selected"':''; ?>><?=$y_value; ?></option>
                                      <?php
                                      $y_value--;
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
                        <h3 class="visible-print"><?=$page_title; ?></h3>
                        <div align='center'>
                           <strong><?=$page_title; ?></strong>
                        </div>
                        <?php
                        /*if($item_detail['tot_invs']=='0')
                        {
                           ?>
                            <div class="col-sm-4">
                              <strong>No Data Printed</strong>
                           </div>
                           <?php
                        }
                        else
                        {*/
                        ?>
                           <table id="example" class="datatable table table-bordered table-striped table-condensed cf packing-register">
                              <thead>
                                <tr>
                                    <th></th>
                                    <th><strong color='red'>Total:<strong></th>
                                    <th><strong color='red'><?php echo round(array_sum($item_detail['tot_pkd_qty'])/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round(array_sum($item_detail['tot_pkd_amt'])/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_inv_qty']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_inv_amt_b']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_inv_amt_a']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_pkd_qty']['del']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_pkd_qty']['stock']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_pkd_amt']['stock']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php 
                                    $qty=$item_detail['tot_pkd_qty']['del']-$item_detail['tot_inv_qty'];
                                    echo round($qty/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php 
                                    $amt=$item_detail['tot_pkd_amt']['del']-$item_detail['tot_inv_amt_b'];
                                    echo round($amt/100000,2); ?></strong></th>
                                 </tr>
                                 <tr>
                                    <th>#</th>  
                                    <th>Term</th>
                                    <th>Qty Pkd. lakhs</th>
                                    <th>Qty Pkd. in L Rs.</th>
                                    <th>Qty Invoiced lakhs</th>
                                    <th>Inv. before Tax in L</th>
                                    <th>Inv. after Tax in L</th>
                                     <th>Qty delvd. lakh</th>
                                    <th>Qty Stock lakhs</th>
                                    <th>Stock in Lakhs Rs.</th>
                                    <th>Qty Not-Inv. in lakhs Rs.</th>
                                    <th>Not-Invoiced in Lakhs Rs.</th>
                                 </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                    <th></th>
                                    <th><strong color='red'>Total:<strong></th>
                                    <th><strong color='red'><?php echo round(array_sum($item_detail['tot_pkd_qty'])/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round(array_sum($item_detail['tot_pkd_amt'])/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_inv_qty']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_inv_amt_b']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_inv_amt_a']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_pkd_qty']['del']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_pkd_qty']['stock']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php echo round($item_detail['tot_pkd_amt']['stock']/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php 
                                    $qty=$item_detail['tot_pkd_qty']['del']-$item_detail['tot_inv_qty'];
                                    echo round($qty/100000,2); ?></strong></th>
                                    <th><strong color='red'><?php 
                                    $amt=$item_detail['tot_pkd_amt']['del']-$item_detail['tot_inv_amt_b'];
                                    echo round($amt/100000,2); ?></strong></th>
                                 </tr>
                              </tfoot>
                              <tbody>
                              <?php
                                 $sno=1;
                                 foreach ($item_detail['details'] as  $term=>$term_value) {
                                    ?>
                                    <tr>
                                       <td><?=$sno; ?></td>
                                       <td><?=$term;?></td>
                                       <td><?=round(array_sum($term_value['pkd_qty'])/100000,2);?></td>
                                       <td><?=round(array_sum($term_value['pkd_amt'])/100000,2);?></td>
                                       <td><?=round($term_value['inv_qty']/100000,2);?></td>
                                       <td><?=round($term_value['inv_amt_b']/100000,2);?></td>
                                       <td><?=round($term_value['inv_amt_a']/100000,2);?></td>
                                       <td><?=round($term_value['pkd_qty']['del']/100000,2);?></td>
                                       <td><?=round($term_value['pkd_qty']['stock']/100000,2);?></td>
                                       <td><?=round($term_value['pkd_amt']['stock']/100000,2);?></td>
                                       <td><?php
                                          $non_inv=$term_value['pkd_qty']['del']-$term_value['inv_qty'];
                                          echo round($non_inv/100000,2);
                                       ?></td>
                                       <td><?php
                                          $non_inv=$term_value['pkd_amt']['del']-$term_value['inv_amt_b'];
                                          echo round($non_inv/100000,2);
                                       ?></td>
                                    </tr>
                                    <?php
                                    $sno++;
                                 }  
                                 ?>
                              </tbody>
                           </table>
                           <?php
                        //}
                        ?>
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
      $(".get_cust_detail").change(function(){
        $("#cust_name").select2("val", $(this).val());
        $("#cust_id").select2("val", $(this).val());       
        return false;
      });
      </script>
   </body>
</html>