<?php include APPPATH . 'views/html/header.php'; ?>
<style type="text/css">
    @media print {
        @page {
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
                        Shade
                    </header>
                    <div class="panel-body">
                        <?php
                        if (function_exists('validation_errors') && validation_errors() != '') {
                            $error  = validation_errors();
                        ?>
                            <div class="alert alert-block alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="icon-remove"></i>
                                </button>
                                <?php echo $error; ?>
                            </div>
                        <?php
                        }
                        if ($this->session->flashdata('success')) {
                        ?>
                            <div class="alert alert-success alert-block fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="icon-remove"></i>
                                </button>
                                <p><?= $this->session->flashdata('success'); ?></p>
                            </div>
                        <?php
                        }
                        ?>
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('masters/shades/' . $shade_id); ?>">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="shade_family">Color Family</label>
                                    <select class="select2 form-control" multiple="multiple" name="shade_family[]" required>
                                        <?php
                                        $colors = $this->m_masters->getactivemaster('bud_color_families', 'family_status');
                                        foreach ($colors as $color) {
                                        ?>
                                            <option value="<?= $color['family_id']; ?>" <?= (in_array($color['family_id'], $shade_family)) ? 'selected="selected"' : ''; ?>><?= $color['family_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Color Category</label>
                                    <select class="select2 form-control" name="category_id" id="category_id" required>
                                        <option value="">Select</option>
                                        <?php if (sizeof($color_categories) > 0) : ?>
                                            <?php foreach ($color_categories as $row) : ?>
                                                <option value="<?php echo $row->category_id ?>" <?php echo ($row->category_id == $category_id) ? 'selected="selected"' : ''; ?>><?php echo $row->color_category; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="shade_name">Color Name</label> <?php echo $this->session->userdata('user_id') . "= User id"; ?>
                                    <input class="form-control" id="shade_name" name="shade_name" value="<?= $shade_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="shade_second_name">Second Name</label>
                                    <input class="form-control" id="shade_second_name" name="shade_second_name" value="<?= $shade_second_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="shade_third_name">Third Name</label>
                                    <input class="form-control" id="shade_third_name" name="shade_third_name" value="<?= $shade_third_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="shade_fourth_name">Fourth Name</label>
                                    <input class="form-control" id="shade_fourth_name" name="shade_fourth_name" value="<?= $shade_fourth_name; ?>" type="text" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="shade_code">Shade Code</label>
                                    <input class="form-control" id="shade_code" name="shade_code" value="<?= $shade_code; ?>" type="text" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="shade_code">Customers</label>
                                    <select class="select2 form-control" name="shade_customers[]" multiple="multiple">
                                        <?php
                                        $customers = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
                                        foreach ($customers as $customer) {
                                        ?>
                                            <option value="<?= $customer['cust_id']; ?>" <?= (in_array($customer['cust_id'], $shade_customers)) ? 'selected="selected"' : ''; ?>><?= $customer['cust_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Color Code</label><br>
                                    <input type="color" name="color_code" value="<?php echo $color_code; ?>" class="custom" style="height: 50px;width: 50px;">
                                    <!-- <div data-color-format="rgb" data-color="<?php echo ($color_code != '') ? $color_code : 'rgb(124, 66, 84)'; ?>" class="input-append colorpicker-default color">
                                        <input type="text" name="color_code" readonly="" value="<?php echo $color_code; ?>" class="form-control">
                                        <span class="input-group-btn add-on">
                                            <button class="btn btn-white" type="button" style="padding: 8px">
                                                <i style="background-color: <?php echo ($color_code != '') ? $color_code : 'rgb(124, 66, 84)'; ?>;"></i>
                                            </button>
                                        </span>
                                    </div> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"><?= @$remarks; ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="shade_status">Active</label>
                                    <input type="checkbox" style="width: 20px;" <?= ($shade_status == 1) ? 'checked="ckecked"' : ''; ?> class="checkbox form-control" value="1" id="shade_status" name="shade_status" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" value="submit" class="ajax-submit btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Shade List
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered datatables">
                            <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>Color Family</th>
                                    <th>Name 1</th>
                                    <th>Name 2</th>
                                    <th>Name 3</th>
                                    <th>Name 4</th>
                                    <th>Shade No</th>
                                    <th>Recipe No</th>
                                    <th>CL NO. / Item ID</th>
                                    <th>Code</th>
                                    <th>Color Category</th>
                                    <th>Costomers</th>
                                    <th>Remarks</th>
                                    <th>Added User</th>
                                    <th>Status</th>
                                    <th class="hidden-phone"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                foreach ($shades as $shade) {
                                    $shade_customers = explode(",", $shade->shade_customers);
                                    $customer_data = array();
                                    foreach ($shade_customers as $key => $value) {
                                        $customer_data[] = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $value, 'cust_name');
                                    }
                                    $family_name = '';
                                    if (!empty($shade->shade_family)) {
                                        $shade_family_arr = explode(',', $shade->shade_family);
                                        foreach ($shade_family_arr as $shade_familyvx) {
                                            $vx = trim($shade_familyvx);
                                            $currentvx = current(array_filter($colors, function ($e) use ($vx) {
                                                return $e['family_id'] == $vx;
                                            }));
                                            $family_name .= @$currentvx['family_name'] . ', ';
                                        }
                                    }

                                    $v = $shade->shade_code;
                                    $current = current(array_filter($recipe_list, function ($e) use ($v) {
                                        return $e->shade_code == $v;
                                    }));
                                    $recipe_id = (@$current->recipe_id != '') ? 'RCP' . @$current->recipe_id : 'NA';
                                    $poy_lot_id = (@$current->poy_lot_id != '') ? @$current->poy_lot_id : 'NA';
                                    $denier_id = (@$current->denier_id != '') ? @$current->denier_id : 'NA';
                                ?>
                                    <tr>
                                        <td><?= $sno; ?></td>
                                        <td><?= rtrim($family_name, ','); ?></td>
                                        <td><?= $shade->shade_name; ?></td>
                                        <td><?= $shade->shade_second_name; ?></td>
                                        <td><?= $shade->shade_third_name; ?></td>
                                        <td><?= $shade->shade_fourth_name; ?></td>
                                        <td><?= $shade->shade_code; ?></td>
                                        <td><?= $recipe_id; ?></td>
                                        <td><?= $poy_lot_id; ?> / <?= $denier_id; ?></td>
                                        <td>
                                            <?php if ($shade->color_code != '') : ?>
                                                <label class="label" style="background-color: <?php echo $shade->color_code; ?>"><?php echo $shade->color_code; ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $shade->color_category; ?></td>
                                        <td><?= implode(",", $customer_data); ?></td>
                                        <td><?= $shade->remarks; ?></td>
                                        <td><?= $shade->user_login; ?><br><br><?= ($shade->date) ? $shade->date : 'Old'; ?></td>
                                        <td class="hidden-phone">
                                            <span class="<?= ($shade->shade_status == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($shade->shade_status == 1) ? 'Active' : 'Inactive'; ?></span>
                                        </td>

                                        <td>
                                            <a href="<?= base_url(); ?>masters/shades/<?= $shade->shade_id; ?>" data-placement="top" data-original-title="Edit" data-toggle="tooltip" class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
                                            <a href="#" data-placement="top" data-original-title="Delete" data-toggle="tooltip" class="btn btn-danger btn-xs tooltips delete-user"><i class="icon-trash "></i></a>
                                        </td>

                                    </tr>
                                <?php
                                    $sno++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<?php include APPPATH . 'views/html/footer.php'; ?>
<script type="text/javascript">
    $('.colorpicker-default').colorpicker({
        format: 'hex'
    });
    oTable01 = $('.datatables').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        }
    });
    jQuery('.dataTables_filter input').addClass("form-control");
    jQuery('.dataTables_length select').addClass("form-control");
</script>
</body>

</html>