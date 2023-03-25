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
                        Category Master For Recipe Other Purpose
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
                                <p><?php echo $this->session->flashdata('success'); ?></p>
                            </div>
                        <?php
                        }
                        ?>
                        <div id="formResponse"></div>
                        <form class="cmxform" role="form" method="post" id="ajaxForm" action="<?php echo base_url('masters/recipecategorymaster/' . $category_id); ?>">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="category_name">Category Name</label>
                                    <input class="form-control" id="category_name" name="category_name" value="<?= @$category_name; ?>" type="text" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="category_prefix">Category Prefix</label>
                                    <input class="form-control" id="category_prefix" name="category_prefix" value="<?= @$category_prefix; ?>" type="text" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="category_active">Active</label>
                                    <input class="form-control checkbox" <?= ($category_active == 1) ? 'checked="ckecked"' : ''; ?> value="1" id="category_active" name="category_active" type="checkbox">
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
                        Color Category List
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered datatables">
                            <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>Category Name</th>
                                    <th>Category Prefix</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                ?>
                                <?php if (sizeof($categorymasters) > 0) : ?>
                                    <?php foreach ($categorymasters as $row) : ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $row->category_name; ?></td>
                                            <td><?php echo $row->category_prefix; ?></td>
                                            <td class="hidden-phone">
                                                <span class="<?= ($row->category_active == 1) ? 'label label-success' : 'label label-danger'; ?>"><?= ($row->category_active == 1) ? 'Active' : 'Inactive'; ?></span>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('masters/recipecategorymaster/' . $row->category_id); ?>" class="btn btn-xs btn-primary"><i class="icon-pencil"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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