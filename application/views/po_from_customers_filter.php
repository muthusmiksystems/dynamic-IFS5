<div class="row">
    <div class="col-lg-12">
        <form class="cmxform form-horizontal tasi-form" role="form" id="commentForm" method="post" action="<?= base_url(); ?>customer_purchase_order/<?= @$this->uri->segment(2); ?>">
            <section class="panel">
                <div class="panel-body">

                    <?php
                    if ($this->session->flashdata('warning')) {
                    ?>
                        <div class="alert alert-warning fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Warning!</strong> <?= $this->session->flashdata('warning'); ?>
                        </div>
                    <?php
                    }
                    if ($this->session->flashdata('error')) {
                    ?>
                        <div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Oops sorry!</strong> <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php
                    }
                    if ($this->session->flashdata('success')) {
                    ?>
                        <div class="alert alert-success alert-block fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <h4>
                                <i class="icon-ok-sign"></i>
                                Thank You!
                            </h4>
                            <p><?= $this->session->flashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="form-group col-lg-2">
                        <label for="filter_from_date">From Date</label>
                        <input type="text" class="form-control dateplugin" name="filter_from_date" id="filter_from_date" value="<?= (@$filter['filter_from_date'] != '') ? date("d-m-Y", strtotime(@$filter['filter_from_date'])) : "01" . date("-m-Y"); ?>">
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="filter_to_date">To Date</label>
                        <input type="text" class="form-control dateplugin" name="filter_to_date" id="filter_to_date" value="<?= (@$filter['filter_from_date'] != '') ? date("d-m-Y", strtotime(@$filter['filter_to_date'])) : date("d-m-Y"); ?>">
                    </div>

                    <?php
                    if ($this->session->userdata('logged_as') == 'user') {
                        $user_category = @$this->session->userdata('user_category');
                        if ($user_category == 9 || $user_category == 10 || $user_category == 11 || $user_category == 12 || $user_category == 20 || $user_category == 4) {
                            $customers = $this->m_masters->getallmaster('bud_customers'); ?>
                            <div class="form-group col-lg-3">
                                <label for="filter_cust_id">Customer</label>
                                <select class="form-control select2" name="filter_cust_id" id="filter_cust_id">
                                    <option value="">Select</option>
                                    <?php foreach ($customers as $customer) { ?>
                                        <option value="<?= $customer['cust_id']; ?>" <?= (@$filter['filter_cust_id'] == $customer['cust_id']) ? 'selected="true"' : ''; ?>><?= $customer['cust_name']; ?> / c-<?= $customer['cust_id']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <?php
                    $categories = $this->m_masters->getallcategories();
                    ?>
                    <div class="form-group col-lg-3">
                        <label for="filter_module_id">Select Product <i class="text-danger">*</i></label>
                        <select class="form-control select2" name="filter_module_id" id="filter_module_id">
                            <option value="">Select</option>
                            <?php
                            $x = 1;
                            foreach ($categories as $category) {
                            ?>
                                <option value="<?= $category['category_id']; ?>" <?= (@$filter['filter_module_id'] == $category['category_id']) ? 'selected="true"' : ''; ?>><?= $category['category_name']; ?>/ M<?= $category['category_id']; ?></option>
                            <?php
                                $x++;
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="filter_item_id">Item name</label>
                        <select class="select2 form-control itemsselects" name="filter_item_id" id="filter_item_id">
                            <option value="">Select</option>
                        </select>
                    </div>

                    <?php
                    $shades = $this->m_masters->getallmaster('bud_shades');
                    $shade_ids = '';
                    $shade_code = '';
                    if (sizeof($shades) > 0) :
                        foreach ($shades as $row) :
                            $selectop = ' ';
                            if (@$filter['filter_shade_id'] == $row['shade_id']) {
                                $selectop = ' selected="true" ';
                            }
                            $shade_ids .= '<option value="' . $row['shade_id'] . '" ' . $selectop . '>' . $row['shade_name'] . '/' . $row['shade_id'] . '</option>';
                            $shade_code .= '<option value="' . $row['shade_id'] . '" ' . $selectop . '>' . $row['shade_code'] . '</option>';
                        endforeach;
                    endif; ?>

                    <div class="form-group col-lg-3">
                        <label for="filter_shade_id">Colour Name/Code</label>
                        <select class="select2 filter-shade-select itemsselects form-control" name="filter_shade_id" id="filter_shade_id">
                            <option value="">Select</option>
                            <?php echo $shade_ids; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="filter_shade_code">Colour No</label>
                        <select class="select2 filter-shade-select itemsselects form-control" id="filter_shade_code">
                            <option value="">Select</option>
                            <?php echo $shade_code; ?>
                        </select>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="form-group col-lg-12">
                        <input type="submit" class="btn btn-danger" name="filter" value="Search" />
                    </div>
                </div>
                <!-- Loading -->
                <div class="pageloader"></div>
                <!-- End Loading -->
            </section>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <a class="btn btn-xs btn-danger"><b>S</b></a> = Sample in Progress,
                <a class="btn btn-xs btn-warning"><b>S</b></a> = Sample Completed,
                <a class="btn btn-xs btn-success"><b>S</b></a> = Approved by Customer,
                <a class="btn btn-xs btn-primary"><b>S</b></a> = Sample not Required,
                <a class="btn btn-xs btn-successblue"><b>S</b></a> = Sample form Old Stock,
                <a class="btn btn-xs btn-"><b>S</b></a>= Waiting for acceptance
                <br><br>
                <a class="btn btn-xs btn-danger"><b>P</b></a> = Production in Progress,
                <a class="btn btn-xs btn-warning"><b>P</b></a> = Production Completed,
                <a class="btn btn-xs btn-success"><b>P</b></a> = Approved by Customer,
                <a class="btn btn-xs btn-primary"><b>P</b></a> = Production not Required,
                <a class="btn btn-xs btn-"><b>P</b></a>= Waiting for acceptance
                <br><br>
                <a class="btn btn-xs btn-danger"><b>G</b></a> = GPO in Progress,
                <a class="btn btn-xs btn-success"><b>G</b></a> = GPO Completed
                <br><br>
                <a class="btn btn-xs btn-success"><b>F</b></a> = Factory Stock
            </div>
        </section>
    </div>
</div>