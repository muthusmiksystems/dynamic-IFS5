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
                           <h3><i class=" icon-file-text"></i> Invoice Preview</h3>
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
               </div>                            <div class="row">                                  <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Invoice
                            </header>
                            <div class="panel-body">
                               <table class="table table-bordered table-striped table-condensed">                                                          <tbody>
                                    <tr class="no-border no-padding">
                                       <td width="5%"></td>
                                       <td width="35%"></td>
                                       <td width="10%"></td>
                                       <td width="10%"></td>
                                       <td width="7%"></td>
                                       <td width="8%"></td>
                                       <td width="5%"></td>
                                       <td width="10%"></td>
                                       <td width="10%"></td>
                                    </tr>
                                    <tr class="first-row">
                                       <td colspan="9" align="center" style="text-align:center;"><h3>Invoice</h3></td>
                                    </tr>
                                    <tr>
                                       <td colspan="3" rowspan="3">
                                          INDOFILA SYNTHETICSES(SHOP)<br/>
                                          18-A, ASHER NAGAR,<br/>
                                          3rd STREET, GANDHI NAGAR.<br/>
                                       </td>
                                       <td colspan="6">
                                          Customer Name
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">Invoice No</td>
                                       <td colspan="4">1</td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">Date</td>
                                       <td colspan="4"><?=date("d-m-Y"); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Sno</td>
                                       <td>Item Name</td>
                                       <td>Color</td>
                                       <td>Shade</td>                                                                      <td>Lot No</td>                                                                      <td align="right">Weight</td>                                                                      <td>UOM</td>                                                                      <td align="right">Rate</td>                                                                      <td align="right">Amount</td>                                                                   </tr>                                                                <tr>
                                       <td colspan="4"></td>
                                       <td colspan="3"><strong>Net Amount</strong></td>
                                       <td colspan="2" align="right"><strong>00000</strong></td>
                                    </tr>
                                    <tr>
                                       <td colspan="9">
                                          <strong>OUR DC NO: 1, 2, 3</strong>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="9">
                                          <strong style="text-transform:capitalize;"> Only.</strong>
                                       </td>
                                    </tr>
                                    <tr class="no-border">
                                       <td colspan="2">
                                          Received By
                                          <br/>
                                          <br/>
                                       </td>
                                       <td colspan="3">
                                          Prepared By
                                          <br/>
                                          <br/>
                                       </td>
                                       <td colspan="4" align="right">
                                          For INDOFILA SYNTHETICSES(SHOP).
                                          <br/>
                                          <br/>
                                       </td>
                                    </tr>                                                            </tbody>
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
               }
               ?>
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
