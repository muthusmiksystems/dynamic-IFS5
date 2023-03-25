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
                    <div class="col-lg-10">
                        <section class="panel">
                            <header class="panel-heading">
                              <h4><i class="icon-truck"></i><strong> Purchase Order List</strong></h4>
                            </header>
                        </section>
                    </div>
                    <div class="col-lg-2">
                      <section class="panel">
                        <header class="panel-heading">
                          <a class="btn btn-info btn-default" href="<?=base_url();?>purchase_order/po_from_customers_lbl"><strong>ADD New PO</strong></a>
                        </header>
                      </section>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                      <section class="panel">
                        <div class="panel-heading">
                          <STRONG>PO List</STRONG>
                        </div>
                        <div class="panel-body">
                          <form class="cmxform form-inline tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>purchase_order/po_list_lbl">
                            <div class="row">
                              <div class="col-lg-3 form-group">
                               <label ><strong>Item name:  </strong></label>
                               <select class="select2 form-control itemsselects col-lg-3" id="item_name" name="item_id">
                                  <option value="">Select Item Name</option>
                                  <?php
                                  foreach ($items as $row) {
                                    ?>
                                    <option value="<?=$row['item_id']; ?>"><?=$row['item_name']." - ".$row['item_id']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="col-lg-3 form-group">
                                <label >Item Width</label>
                                <input class="select2 form-control itemsselects" type='text' name='item_width' value="">
                              </div>
                              <div class="form-group col-lg-4">
                                <label for="sales_to">Customer</label>
                                <select class="select2 form-control itemsselects" id="customer" name="customer" required>
                                  <option value="">Select customer</option>
                                  <?php
                                  foreach ($customers as $row) {
                                    ?>
                                    <option value="<?=$row['cust_id']; ?>"><?=$row['cust_name']." - ".$row['cust_id']; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>                              
                              <div class="col-lg-1">
                                <br>
                                <button class="btn btn-danger" type="submit" name="search">Search</button>
                              </div>
                              
                            </div>
                          </form>
                        </div>
                      </section>            
                      <section class="panel">
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
                        }                                  
                        if($this->session->flashdata('error'))
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
                      <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>purchase_order/ps_items_lbl_save">
                      <section class="panel">
                        <table class="table table-striped border-top datatable">
                          <thead>
                            <tr>
                              <th>Sno</th>
                              <th>ERP.PO NO</th>
                              <th>PO Date</th>
                              <th>Customer name</th>                              
                              <th>Item Name</th>
                              <th>Item Width</th>
                              <th>Item Size</th>
                              <th>PO. Qty</th>
                              <th>PS Qty</th>
                              <th>PS Stock Qty</th>
                              <th>Bal. Qty</th>
                              <th>
                                <label class="checkbox-inline">
                                <input type="checkbox" id="selecctall">
                                <b>Select All</b>
                                </label>
                              </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sno = 1;
                            foreach ($po_list as $row) {
                              $tot_ps_qty=$this->m_purchase->getTotPSQty($row['erp_po_no'],$row['po_item_id'],$row['po_item_size'],'ps_qty');
                              $tot_stock_qty=$this->m_purchase->getTotPSQty($row['erp_po_no'],$row['po_item_id'],$row['po_item_size'],'ps_stock_qty');
                              $bal_qty=$row['po_item_qty']-$tot_ps_qty;
                              if($bal_qty<=0)
                              {
                                continue;
                              }
                              ?>
                              <tr class="odd gradeX">
                                  <td><?=$sno; ?></td>
                                  <td><?=$row['erp_po_no']; ?></td>
                                  <td><?=date('d-M-y',strtotime($row['po_date'])); ?></td> 
                                  <td><?=$row['cust_name']; ?></td>
                                  <td><?=$row['item_name']; ?></td><input type="text" name="items[]" value="<?=$row['po_item_id'];?>" hidden> 
                                  <td><?=$row['item_width']; ?></td> 
                                  <td><?=$row['po_item_size']; ?></td>      
                                  <td><?=$row['po_item_qty']; ?></td>
                                  <td><?=($tot_ps_qty)?$tot_ps_qty:0; ?></td>
                                  <td><?=$tot_stock_qty; ?></td>
                                  <td><?=$bal_qty ?></td>
                                  <td><input type="checkbox" name="rows[]" value="<?=$row['row_id'];?>" class="checkBox"></td>
                              </tr>
                              <?php                                
                            $sno++;
                          }
                          ?>
                        </tbody>
                      </table> 
                    </section>
                    <section class="panel">
                      <header class="panel-heading">
                          <button class="btn btn-danger" type="submit" name="save">Add To List</button>
                          <button class="btn btn-default" type="button">Cancel</button>
                      </header>
                    </section>
                  </form>
                  <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?=base_url();?>purchase_order/ps_lbl_save">
                    <section class="panel">
                      <header class="panel-heading">
                      PS Generation
                      </header>
                        <div class="panel-body" id="po_cartitems">
                          <div class="form-group col-lg-3">
                             <label for="item_uom">Machines</label>
                             <select class="select2 form-control" name="machine_id" required>
                              <option value="">Select</option>
                              <?php
                              foreach ($machines as $row) {
                                ?>
                                <option value="<?=$row['machine_id']; ?>"><?=$row['machine_name']; ?></option>
                                <?php
                              }
                              ?>
                              </select>
                          </div>
                          <?php
                          $ps_item_id=$this->m_masters->getmasterIDvalue('bud_lbl_po_item_temp','id',1,'item_id');
                          $ps_item_name=($ps_item_id)?$this->m_masters->getmasterIDvalue('bud_lbl_items','item_id',$ps_item_id,'item_name'):'';
                          ?>
                          <div class="form-group col-lg-4">
                            <label for="item_uom">Item Name</label>
                            <input class="form-control" type='text' name='item' value="<?=$ps_item_name.'/'.$ps_item_id;?>" required="required" disabled>
                            <input type='text' name='item' value="<?=$ps_item_id;?>" hidden required>
                          </div>
                          <div class="form-group col-lg-5">
                             <label for="item_uom">Remarks</label>
                             <textarea name="remarks" cols="40" rows="3">Remarks</textarea>
                          </div>
                          <table class="table table-striped border-top datatable">
                            <thead>
                            <tr>
                              <th>Sno</th>
                              <th>ERP PO No</th>
                              <th>Item Size</th>
                              <th>Pending Qty</th>
                              <th>PO Qty to be produced</th>
                              <th>Extra Qty to be prod. for Stock</th>
                              <th ><a href="<?=base_url();?>purchase_order/remove_cart"><span class="text-danger">Remove All</span></a></th>
                            </tr>
                            </thead>
                            <tbody id="add_values">
                              <?php
                                $rows=$this->m_masters->getallmaster("bud_lbl_po_item_temp");
                                $n_id=1;
                                foreach ($rows as $row) {
                                  $po_items=$this->m_purchase->getpolist($row['row_id']);
                                  foreach ($po_items as  $value) {
                                    $tot_ps_qty=$this->m_purchase->getTotPSQty($value['erp_po_no'],$value['po_item_id'],$value['po_item_size'],'ps_qty');
                              ?>
                              <tr id='<?=$n_id;?>' class='psItems'>
                                <td><?=$n_id?></td>
                                <td><?=$value['erp_po_no']?></td>
                                <input type='hidden' name='erp_po_no[]' value='<?=$value['erp_po_no'];?>'>
                                <td><?=$value['po_item_size']?></td><input type='hidden' name='item_size[]' value='<?=$value['po_item_size']?>'>
                                <td><?=$value['po_item_qty']-$tot_ps_qty; ?></td>
                                <td><input type='text' class='form-control' name='ps_qty[]' value='<?=$value['po_item_qty']-$tot_ps_qty; ?>' required></td>
                                <td><input type='text' class='form-control' name='ps_stock_qty[]' value=''></td>
                                <td onclick='remove_row(<?=$value['row_id'].",".$n_id;?>)'><span class="text-danger">Remove</span></td></tr>
                              <?php
                              $n_id++;
                              }
                            } 
                            ?>
                            
                            </tbody>
                            </table>
                            <input type="hidden" name="user" value="<?=$this->session->userdata('user_id'); ?>">
                            <input type="hidden" name="date" value="<?=date("Y-m-d H:i:s"); ?>">
                              
                          </div>
                        </section>
                        <section class="panel">
                        <header class="panel-heading">
                          <button class="btn btn-danger" type="submit">Generate PS</button>
                          <button class="btn btn-default" type="button">Cancel</button>
                        </header>
                      </section>
                    </form>  
                  </div>
                </div>     
                <!-- page end-->
            </section>
      </section>
      <!--main cont<ent end-->
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
            // "sDom": "<'row'<'col-sm-6'f>r>",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "sPaginationType": "bootstrap",
            "bSort": true,
            "bPaginate": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
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
    
    function remove_row(row_id,r_id)
    {
    var select = "#"+r_id;
    $(select).remove();
    $.ajax({
      type : "POST",
       url  : "<?=base_url(); ?>purchase_order/remove_cart/"+row_id,
      });
    }
    function tab_detail(id)
    {
    $.ajax({
      type : "POST",
      url  : "<?=base_url(); ?>purchase_order/po_from_customers_table_details/"+id,
      success: function(e){
        $("#tab_details").html(e);
      }
    })
    }
    $('#selecctall').click(function(event) {
      if(this.checked) { // check select status
        $('.checkBox').each(function() { //loop through each checkbox
          this.checked = true;
        });
      }
      else
      {
        $('.checkBox').each(function() { //loop through each checkbox
          this.checked = false;
        });
      }

    });
  </script>

  </body>
</html>
