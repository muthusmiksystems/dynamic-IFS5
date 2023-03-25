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
                        Gray Yarn DC List
                    </header>
                    <div class="panel-body">
                        
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<?php include APPPATH.'views/html/footer.php'; ?>
<script type="text/javascript">
    $("#transfer_dc").find('.print').on('click', function() {
        $.print("#transfer_dc");
        return false;
    });
</script>
</body>
</html>