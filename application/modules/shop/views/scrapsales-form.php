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
                        CLQ Sales
                    </header>
                    <?php
                    $box_list = array();
                    $scrap_terms = array();
                    $item_weight = 0;
                    $quotation_ids = array();
                    if(sizeof($cart_items) > 0)
                    {
                        foreach ($cart_items as $item) {
                            $quotation_ids[$item['id']] = $item['id'];
                            $quotation_items = $this->Sales_model->get_quotation_items($item['id']);
                            if(sizeof($quotation_items) > 0)
                            {
                                foreach ($quotation_items as $row) {
                                    $item_weight += $row->delivery_qty;
                                }
                            }
                        }
                    }
                    if($this->session->userdata('scrap_terms'))
                    {
                        $scrap_terms = $this->session->userdata('scrap_terms');
                        // predc_items
                    }
                    $concern = false;
                    $customer = false;
                    ?>
                    <div class="panel-body">
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('shop/scrapsales/scrapsales_save'); ?>">                            
                            <?php if(count($scrap_terms) > 0): ?>
                                <?php
                                $concern = $this->Sales_model->get_concern($scrap_terms['concern_id']);
                                $customer = $this->Sales_model->get_customer($scrap_terms['customer_id']);

                                $scrap_inv_no = '';
                                if($concern)
                                {
                                    $invoice_count = $this->Sales_model->get_scrapsales_count($concern->concern_id);
                                    $invoice_start = $concern->invoice_start;
                                    $prefix = $concern->concern_prefix;
                                    $bill_year = date("y");
                                    $bill_month = date("m");
                                    $financialyear = ($bill_month<'04') ? $bill_year - 1 : $bill_year;
                                    $bill_year = $financialyear;

                                    $scrap_inv_no = $prefix.'-'.$financialyear.'-'.($bill_year+1).'/'.($invoice_count + 1 + $invoice_start);
                                }

                                ?>
                                <input type="hidden" name="quotation_ids" value="<?php echo implode(",", $quotation_ids); ?>">
                                <input type="hidden" name="concern_id" value="<?php echo $scrap_terms['concern_id']; ?>">
                                <input type="hidden" name="customer_id" value="<?php echo $scrap_terms['customer_id']; ?>">
                                <input type="hidden" name="delivery_to" value="<?php echo $scrap_terms['delivery_to']; ?>">
                                <input type="hidden" name="name" value="<?php echo $scrap_terms['name']; ?>">
                                <input type="hidden" name="mobile_no" value="<?php echo $scrap_terms['mobile_no']; ?>">
                                <input type="hidden" name="remarks" value="<?php echo (isset($scrap_terms['remarks']))?$scrap_terms['remarks']:''; ?>">
                                <input type="hidden" name="scrap_inv_no" value="<?php echo $scrap_inv_no; ?>">
                            <?php endif; ?>
                            <div id="formResponse-2"></div>
                            <table class="table table-bordered invoice-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center" align="center">
                                            <h3 style="margin:0px;">Scrap Sales</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" valign="top" style="vertical-align:top;">
                                            <strong>From:&emsp;</strong>
                                            <?php if($concern): ?>
                                                <strong style="text-transform:uppercase;font-size:14px;"><?php echo $concern->concern_name; ?></strong><br>
                                                <?php echo $concern->concern_address; ?><br>
                                                TIN: <?php echo $concern->concern_tin; ?> CST: <?php echo $concern->concern_cst; ?>
                                            <?php endif; ?>
                                        </th>
                                        <th colspan="3" valign="top" style="vertical-align:top;">
                                            <strong>To:&emsp;</strong>
                                            <?php if($customer): ?>
                                                <strong style="text-transform:uppercase;font-size:14px;"><?php echo $customer->cust_name; ?></strong><br>
                                                <?php echo $customer->cust_address; ?><br>
                                                TIN: <?php echo $customer->cust_tinno; ?> CST: <?php echo $customer->cust_cst; ?>
                                            <?php endif; ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            INV NO: <span style="font-size:18px;"><?php echo $scrap_inv_no; ?></span>
                                        </th>
                                        <th colspan="3" class="text-right" align="right">
                                            <?php echo date("d-m-Y g:i a"); ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Description</th>
                                        <th>Nt.Wt</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="5%">1</td>
                                        <td width="50%">
                                            <textarea class="form-control" name="item_description" id="item_description" required=""></textarea>
                                        </td>
                                        <td width="15%">
                                            <input type="hidden" name="item_weight" id="item_weight" value="<?php echo $item_weight; ?>">
                                            <span id="item_weight_text"><?php echo $item_weight; ?></span>
                                            &emsp;
                                            <select name="uom_name" id="uom_name">
                                                <option value="">Select UOM</option>
                                                <?php if(sizeof($uoms) > 0): ?>
                                                    <?php foreach($uoms as $row): ?>
                                                        <option value="<?php echo $row->uom_name; ?>"><?php echo $row->uom_name; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </td>
                                        <td width="15%">
                                            <input type="text" name="item_rate" id="item_rate" class="form-control" required>
                                        </td>
                                        <td width="15%">
                                            <input type="hidden" name="item_amount" id="item_amount" value="">
                                            <span id="item_amount_text"></span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <label>Transport Mode</label>
                                            <textarea class="form-control" name="transport_mode" id="transport_mode"></textarea>
                                        </td>
                                        <td colspan="3" align="right">
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
                                                    <?php
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
                                                    ?>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">Save Invoice</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript" language="javascript" src="<?=base_url('themes/default'); ?>/tabletools/js/dataTables.tableTools.js"></script>
<script type="text/javascript">
    active_submit();
    $("#item_rate").keyup(function() {
        var item_rate = $(this).val();
        var item_weight = $("#item_weight_text").text();
        var item_amount = parseFloat(item_rate) * parseFloat(item_weight);
        $("#item_amount").val(item_amount.toFixed(2));
        $("#item_amount_text").text(item_amount.toFixed(2));
        active_submit();
    });

    function active_submit(argument) {
        var item_amount = $("#item_amount").val();
        if(item_amount > 0)
        {
            $("#submit").css('display', 'block');
        }
        else
        {
            $("#submit").css('display', 'none');
        }
    }
</script>
</body>
</html>