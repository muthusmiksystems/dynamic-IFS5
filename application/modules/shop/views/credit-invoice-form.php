<?php include APPPATH.'views/html/header.php'; ?>
<style type="text/css">
    @media print{
        @page{
            margin: 3mm;
        }
    }
</style>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shop Credit Invoice
                    </header>
                    <?php
                    $credit_inv_terms = array();
                    if(sizeof($cart_items) > 0)
                    {
                        foreach ($cart_items as $item) {
                            $lot_no = ($item->lot_no != '') ? $item->lot_no : '0' ;
                            $box_list[$item->lot_no][] = $item;
                        }
                    }
                    if($this->session->userdata('credit_inv_terms'))
                    {
                        $credit_inv_terms = $this->session->userdata('credit_inv_terms');
                        $predc_items = (isset($credit_inv_terms['predc_items'])) ? $credit_inv_terms['predc_items'] : array();
                        if(count($predc_items) > 0)
                        {
                            foreach ($predc_items as $box_id) {
                                $box = $this->Packing_model->get_shop_box($box_id);
                                if($box)
                                {
                                    $box_list[$box->lot_no][] = $box;
                                }
                            }
                        }
                        // predc_items
                    }
                    $concern = false;
                    $customer = false;
                    ?>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/sales/credit_invoice_save/'.$p_delivery_id); ?>">                            
                            <?php if(count($credit_inv_terms) > 0): ?>
                                <?php
                                $concern = $this->Sales_model->get_concern($credit_inv_terms['p_concern_id']);
                                $customer = $this->Sales_model->get_customer($credit_inv_terms['p_customer_id']);

                                if($concern)
                                {
                                    $invoice_count = $this->Sales_model->get_invoice_count($concern->concern_id,'credit');//ER-07-18#-22
                                    $invoice_start = $concern->invoice_start;
                                    $prefix = $concern->concern_prefix;
                                    $bill_year = date("y");
                                    $bill_month = date("m");
                                    $financialyear = ($bill_month<'04') ? $bill_year - 1 : $bill_year;
                                    $bill_year = $financialyear;

                                    $credit_inv_no = $prefix.'-'.$financialyear.'-'.($bill_year+1).'/'.($invoice_count + 1 + $invoice_start);
                                }
                                ?>
                                <input type="hidden" name="p_concern_id" value="<?php echo $credit_inv_terms['p_concern_id']; ?>">
                                <input type="hidden" name="p_customer_id" value="<?php echo $credit_inv_terms['p_customer_id']; ?>">
                                <input type="hidden" name="p_delivery_to" value="<?php echo $credit_inv_terms['p_delivery_to']; ?>">
                                <input type="hidden" name="name" value="<?php echo $credit_inv_terms['name']; ?>">
                                <input type="hidden" name="mobile_no" value="<?php echo $credit_inv_terms['mobile_no']; ?>">
                                <input type="hidden" name="remarks" value="<?php echo $credit_inv_terms['remarks']; ?>">
                                <input type="hidden" name="credit_inv_no" value="<?php echo $credit_inv_no; ?>">
                            <?php endif; ?>
                            <div id="formResponse-2"></div>
                            <table class="table table-bordered invoice-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="13" class="text-center" align="center">
                                            <h3 style="margin:0px;">Credit Invoice</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6" valign="top" style="vertical-align:top;">
                                            <strong>From:&emsp;</strong>
                                            <?php if($concern): ?>
                                                <strong style="text-transform:uppercase;font-size:14px;"><?php echo $concern->concern_name; ?></strong><br>
                                                <?php echo $concern->concern_address; ?><br>
                                                GST: <?php echo $concern->concern_gst; ?>
                                            <?php endif; ?>
                                        </th>
                                        <th colspan="6" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <?php if($customer): ?>
                                                <strong style="text-transform:uppercase;font-size:14px;"><?php echo $customer->cust_name; ?></strong><br>
                                                <?php echo $customer->cust_address; ?><br>
                                                GST: <?php echo $customer->cust_gst; ?>
                                            <?php endif; ?>
                                        </th>
                                    <!--ER-07-18#-22-->
                                        <th valign="top" style="vertical-align:top;">
                                            New/Old
                                            <select class="form-control" name="old_invoice_no">
                                                <option value="new">New</option>
                                                <?php
                                                foreach ($exist_inv_nos as $id=>$value) {
                                                  ?>
                                                  <option value="<?=$value; ?>" ><?=$value ?></option>
                                                  <?php
                                                }
                                                ?>
                                             </select>
                                        </th>
                                        <!--end of ER-07-18#-22-->

                                    </tr>
                                    <tr>
                                        <th colspan="8">
                                            CREDIT INV NO: <span style="font-size:18px;">SH/CR-<?php echo $credit_inv_no; ?></span>
                                        </th>
                                        <th colspan="5" class="text-right" align="right">
                                            <?php echo date("d-m-Y g:i a"); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Box No</th>
                                        <th>Item Name/Code</th>
                                        <th>HSN Code</th>
                                        <th>Shade Name/No</th>
                                        <th>Shade Code</th>
                                        <th>Lot No</th>
                                        <th># of Units</th>
                                        <th>Uom</th>
                                        <th>Gr.Wt</th>
                                        <th>Nt.Wt</th>
                                        <th>Rate</th>
                                        <th style="text-align:right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tot_boxes = 0;
                                    $tot_no_cones = 0;
                                    $tot_gr_weight = 0;
                                    $tot_nt_weight = 0;
                                    $active_save = true;
                                    $tot_item_amount = 0;
                                    $sno = 1;
                                    ?>
                                    <?php if(count($box_list) > 0): ?>
                                        <?php foreach($box_list as $lot_no => $boxes): ?>
                                            <?php if(sizeof($boxes) > 0): ?>
                                                <?php
                                                $row_key = 1;
                                                $lot_net_weight = 0;
                                                ?>
                                                <?php foreach($boxes as $box): ?>
                                                    <?php
                                                    /*echo "<pre>";
                                                    print_r($box);
                                                    echo "</pre>";*/
                                                    $lot_net_weight += $box->delivery_qty;
                                                    $tot_no_cones += $box->no_cones;
                                                    $tot_gr_weight += $box->gr_weight;
                                                    $tot_nt_weight += $box->delivery_qty;
                                                    $tot_boxes++;

                                                    $item_rate = 0;
                                                    $cust_item_rate = $this->Sales_model->get_item_rate($customer->cust_id, $box->item_id, $box->shade_id);
                                                    if($cust_item_rate)
                                                    {
                                                        $item_rates = explode(",", $cust_item_rate->item_rates);
                                                        $item_rate_active = $cust_item_rate->item_rate_active;
                                                        $item_rate = $item_rates[$item_rate_active];
                                                    }
                                                    elseif($this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id))
                                                    {
                                                        $gen_item_rate = $this->Sales_model->get_gen_item_rate($box->delivery_qty, $box->item_id, $box->category_id);
                                                        $item_rate = $gen_item_rate->item_rate;                                                        
                                                    }
                                                    else
                                                    {
                                                        $active_save = false;
                                                    }
                                                    $item_amount = number_format($box->delivery_qty * $item_rate, 2, '.', '');
                                                    $tot_item_amount += $item_amount;
                                                    //$item_id = explode('/', $item_names_arr[$key_1]);

                                                    if (!empty($box->item_id)) {
                                                        $item_uom = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $box->item_id, 'item_uom');
                                                        $hsn_code = $this->m_masters->getmasterIDvalue('bud_items', 'item_id', $box->item_id, 'hsn_code');
                                                        $uom_name = $this->m_masters->get_uom('bud_uoms', $item_uom, 'uom_name');
                                                        
                                                        
                                                    } else {
                                                       $item_uom='';
                                                       $uom_name='';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sno++; ?></td>
                                                        <td><?php echo $box->box_prefix; ?><?php echo $box->box_no; ?></td>
                                                        <td><?php echo $box->item_name; ?>/<?php echo $box->item_id; ?></td>
                                                        <td><?php echo substr($hsn_code, 0, 8); ?></td>
                                                        <td><?php echo $box->shade_name; ?>/<?php echo $box->shade_id; ?></td>
                                                        <td><?php echo $box->shade_code; ?></td>
                                                        <td><?php echo $box->lot_no; ?></td>
                                                        <td><?php echo $box->no_cones; ?></td>
                                                        <td><?php echo $uom_name; ?></td>
                                                        <td><?php echo $box->gr_weight; ?></td>
                                                        <td><?php echo $box->delivery_qty; ?></td>
                                                        <td><?php echo $item_rate; ?></td>
                                                        <td align="right"><?php echo $item_amount; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <label>Transport Mode</label>
                                            <textarea class="form-control" name="transport_mode" id="transport_mode"></textarea>
                                        </td>
                                        <td colspan="5" align="right">
                                            <ul class="unstyled amounts">
                                                <li><strong>Other Charges :</strong></li>
                                                <?php
                                                $othercharges = $this->m_masters->getactivemaster('bud_othercharges','othercharge_status');
                                                foreach ($othercharges as $othercharge) {
                                                    ?>
                                                    <li>
                                                        <strong><?=$othercharge['othercharge_name']; ?> :</strong>                                            
                                                        <input name="order_othercharges[<?=$othercharge['othercharge_id']; ?>]" style="width:150px;" type="text">
                                                        <input name="order_othercharges_type[<?=$othercharge['othercharge_id']; ?>]" type="hidden" value="<?=$othercharge['othercharge_type']; ?>">
                                                        <input name="order_othercharges_names[<?=$othercharge['othercharge_id']; ?>]" type="hidden" value="<?=$othercharge['othercharge_name']; ?>">
                                                        <select name="order_othercharges_unit[<?=$othercharge['othercharge_id']; ?>]">
                                                            <option value="Rs">Rs</option>
                                                            <option value="%">%</option>
                                                        </select>
                                                        <input name="order_othercharges_desc[<?=$othercharge['othercharge_id']; ?>]" type="text" placeholder="Description">
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                                <li>
                                                    <strong>Tax :</strong>
                                                    <!-- <?php
                                                    $taxs = $this->m_masters->getactivemaster('bud_tax','tax_status');
                                                    foreach ($taxs as $tax) {
                                                        ?>
                                                        <input type="hidden" name="order_tax_names[<?=$tax['tax_id']; ?>]" value="<?=$tax['tax_name']; ?>">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="taxs[<?=$tax['tax_id']; ?>]" value="<?=$tax['tax_value']; ?>">
                                                            <?=$tax['tax_name']; ?> (<?=$tax['tax_value']; ?> %)
                                                        </label>
                                                        <?php
                                                    }
                                                    ?> -->

<?php
                                                    //echo $customer->cust_gst;
                                                    $checked = false;
                                                    if (substr($customer->cust_gst, 0, 2) == 33) {
                                                        $checked = true;
                                                    }
                                                    $taxs = $this->m_masters->getactivemaster('bud_tax', 'tax_status');
                                                    foreach ($taxs as $tax) {
                                                        $taxClick = '';
                                                        if ($tax['tax_name'] == 'IGST(Other State)' && $checked == false) {
                                                            $taxClick = ' checked="true" ';
                                                        }  if ($tax['tax_name'] == 'CGST' && $tax['tax_value'] == '6.00' && $checked == true) {
                                                            $taxClick = ' checked="true" ';
                                                        }  if ($tax['tax_name'] == 'SGST' && $tax['tax_value'] == '6.00' && $checked == true) {
                                                            $taxClick = ' checked="true" ';
                                                        }
                                                    ?>
                                                        <input type="hidden" name="order_tax_names[<?= $tax['tax_id']; ?>]" value="<?= $tax['tax_name']; ?>">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="taxs[<?= $tax['tax_id']; ?>]" value="<?= $tax['tax_value']; ?>" <?= $taxClick; ?>>
                                                            <?= $tax['tax_name']; ?> (<?= $tax['tax_value']; ?> %)
                                                        </label>
                                                    <?php
                                                    }
                                                    ?>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            <?php
                            /*echo "<pre>";
                            print_r($accounts_data);
                            print_r($customer);
                            echo "</pre>";*/
                            $credit_bal = 0;
                            $cust_credit_min = 0;
                            $cust_credit_max = 0;
                            if($customer)
                            {
                                $cust_credit_limit = explode(",", $customer->cust_credit_limit);
                                if(count($cust_credit_limit) > 0)
                                {
                                    $cust_credit_min = (isset($cust_credit_limit[0])) ? $cust_credit_limit[0] : 0 ;
                                    $cust_credit_max = (isset($cust_credit_limit[1])) ? $cust_credit_limit[1] : 0 ;
                                }
                            }
                            if($accounts_data)
                            {
                                $credit_bal = ($accounts_data->tot_invoice_amt + $tot_item_amount) - $accounts_data->tot_cash_receipt;
                            }
                            ?>

                            <?php if($credit_bal > $cust_credit_min): ?>
                                <p class="text-danger">
                                    <strong>Attenstion</strong> <?php echo $this->session->userdata('display_name'); ?> this customer invoice can't be generate becouse it will exceed the credit limit alloted by the management, Please collect the old payment to make this Invoice possible. Thanks Mahesh Bhardwaj
                                </p>
                            <?php else: ?>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <?php if($active_save == true): ?>
                                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Save Invoice</button>
                                        <?php endif; ?>
                                        <!-- <button type="button" name="submit" value="submit" class="btn btn-default">Update Rate</button> -->
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </section>
            </div>
        </div>

    </section>
    <h5 style="text-align:right;font-size:5px;margin-right:20px">application\modules\shop\views\credit-invoice-form.php</h5>
    <h5 style="text-align:right;font-size:5px;margin-right:20px">application\modules\shop\controllers\sales.php</h5>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript" language="javascript" src="<?=base_url('themes/default'); ?>/tabletools/js/dataTables.tableTools.js"></script>
<script type="text/javascript">
</script>
</body>
</html>