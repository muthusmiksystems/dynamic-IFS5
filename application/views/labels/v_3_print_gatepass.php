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
                           <h3><i class=" icon-file-text"></i> Gatepass</h3>
                        </header>
                     </section>
                  </div>
               </div>
               <div class="row">
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
                  }                                            if($this->session->flashdata('error'))
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
                  }
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
                  $invoice_details = $this->m_masters->getmasterdetails($table_name,'invoice_id', $invoice_id);
                  foreach ($invoice_details as $row) {
                     $concern_name = $row['concern_name'];
                     $invoice_no = $row['invoice_no'];
                     $invoice_date = $row['invoice_date'];
                     $customer = $row['customer'];
                     $selected_dc = explode(",", $row['selected_dc']);
                     $invoice_items = explode(",", $row['invoice_items']);
                     $item_weights = explode(",", $row['item_weights']);
                     $item_rate = explode(",", $row['item_rate']);
                     $no_of_boxes = explode(",", $row['no_of_boxes']);
                     $boxes_array = array_filter(explode(",", $row['boxes_array']));//removal of empty array values
                     $addtions_names = explode(",", $row['addtions_names']);
                     $addtions_values = explode(",", $row['addtions_values']);
                     $addtions_amounts = explode(",", $row['addtions_amounts']);
                     $tax_names = explode(",", $row['tax_names']);
                     $tax_values = explode(",", $row['tax_values']);
                     $tax_amounts = explode(",", $row['tax_amounts']);
                     $deduction_names = explode(",", $row['deduction_names']);
                     $deduction_values = explode(",", $row['deduction_values']);
                     $deduction_amounts = explode(",", $row['deduction_amounts']);
                     $sub_total = explode(",", $row['sub_total']);
                     $net_amount = $row['net_amount'];
                     $lr_no = $row['lr_no'];
                     $transport_name = $row['transport_name'];
                  }
                  sort($boxes_array);
                  $ed = explode("-", $invoice_date);
                  $invoice_date = $ed[2].'-'.$ed[1].'-'.$ed[0];
                  $items = array();
                  $item_weights_array = array();
                  $item_rate_array = array();
                  foreach ($invoice_items as $key => $value) {
                     $item_group = $this->m_masters->getmasterIDvalue('bud_te_items', 'item_id', $value, 'item_group');
                     $items[$item_group][] = $value;
                     $item_weights_array[$value] = $item_weights[$key];
                     $item_rate_array[$value] = $item_rate[$key];
                  }
                  $invoice_dc = array();
                  foreach ($selected_dc as $key => $value) {
                     // $invoice_dc[]  = $this->m_masters->getmasterIDvalue($table_name, 'invoice_id', $value, 'invoice_no');
                     $invoice_dc[] = $this->m_masters->getmasterIDvalue('bud_lbl_delivery', 'delivery_id', $value, 'dc_no');
                  }
                  ?>
                  <div class="row">                                  <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Gatepass Details
                            </header>
                            <div class="panel-body">
                               <table style="border:none;" class="table table-bordered table-striped table-condensed">
                                 <thead>                                                                <tr style="border:none;">
                                       <th width="10" style="border-width:0px;"></th>
                                       <th width="30%" style="border-width:0px;"></th>
                                       <th width="20%" style="border-width:0px;"></th>
                                       <th width="20%" style="border-width:0px;"></th>                                                                   </tr>
                                    <tr>
                                       <th colspan="4" align="center" style="text-align:center;"><h3>Gate Pass</h3></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>Gate Pass No</td>
                                       <td><strong><?=$invoice_no; ?> / <?=date("d-m-Y"); ?> / <?=date("H:i:s"); ?></strong></td>
                                       <td>Invoice No</td>
                                       <td><?=$invoice_no; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Customer Code</td>
                                       <td><?=$customer; ?></td>
                                       <td>DC No</td>
                                       <td><?=implode(", ", $invoice_dc); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Item Codes</td>
                                       <td><?=implode(", ", $invoice_items); ?></td>
                                       <td># of Boxes</td>
                                       <td><strong style="font-size:24px;border:1px solid red;padding:0px 10px;" ><?=sizeof($boxes_array); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Box No Allowed</td>
                                       <td colspan="3"><strong style="font-size:24px;"><?=implode(", ", $boxes_array); ?></strong></td>
                                    </tr>                                                               <tr>
                                       <td colspan="4">
                                          <div class="col-lg-12">
                                             <div class="print-div col-lg-3">
                                                <strong>Received By</strong>
                                                <br/>
                                                <br/>
                                             </div>
                                             <div class="print-div col-lg-3" style="border-right:none;">
                                                <strong>Prepared By</strong>
                                                <br/>
                                                <br/>
                                             </div>
                                             <div class="print-div col-lg-3" style="border-right:none;">
                                                Checked By
                                                <br/>
                                                <br/>
                                             </div>
                                             <div class="print-div right-align col-lg-3">
                                                <strong>For DYNAMIC CREATION.</strong>
                                                <br/>
                                                <br/>
                                                <br/>
                                                <br/>
                                                Auth.Signatury
                                             </div>
                                          </div>
                                       </td>
                                    </tr>                                                          </tbody>
                               </table>
                               <br/>
                               <br/>
                               <br/>
                               <br/>
                               <table style="border:none;" class="table table-bordered table-striped table-condensed">
                                 <tr>
                                 <td width="25%">
                                    <h1>Boxes Allowed</h1>
                                 </td>
                                 <td width="75%">
                                    <h1><?=implode(", ", $boxes_array); ?></h1>
                                 </td>
                                 </tr>
                                 <tr>
                                    <td colspan="2">
                                       <div class="col-lg-12">
                                          <div class="print-div col-lg-3">
                                             <strong>Received By</strong>
                                             <br/>
                                             <br/>
                                          </div>
                                          <div class="print-div col-lg-3" style="border-right:none;">
                                             <strong>Prepared By</strong>
                                             <br/>
                                             <br/>
                                          </div>
                                          <div class="print-div col-lg-3" style="border-right:none;">
                                             Checked By
                                             <br/>
                                             <br/>
                                          </div>
                                          <div class="print-div right-align col-lg-3">
                                             <strong>For DYNAMIC CREATION.</strong>
                                             <br/>
                                             <br/>
                                             <br/>
                                             <br/>
                                             Auth.Signatury
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                               </table>
                            </div>
                        </section>
                     </div>                                 <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <button class="btn btn-default" type="button" onclick="window.print()">Print</button>
                            </header>
                        </section>
                     </div>
                  </div>
               <?php
               function no_to_words($no)
               {   
                  $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
                  if($no == 0)
                  return ' ';
                  else {
                     $novalue='';
                     $highno=$no;
                     $remainno=0;
                     $value=100;
                     $value1=1000;                    while($no>=100)    {
                        if(($value <= $no) &&($no  < $value1))    {
                           $novalue=$words["$value"];
                           $highno = (int)($no/$value);
                           $remainno = $no % $value;
                           break;
                        }
                        $value= $value1;
                        $value1 = $value * 100;
                     }                    if(array_key_exists("$highno",$words))
                     return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
                     else {
                        $unit=$highno%10;
                        $ten =(int)($highno/10)*10;                            return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
                     }
                  }
               }                      ?>
               <div class="pageloader"></div>                          <!-- page end-->
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
