<?php //$this->load->view('user/include/header');
?>

<link href="http://shivatapes.com/trialversion3.0/assets/select/bootstrap.css" rel="stylesheet">

<!-- Select 2 css -->
<link rel="stylesheet" href="http://shivatapes.com/trialversion3.0/assets/select/select2.css" />
<link rel="stylesheet" type="text/css" href="http://shivatapes.com/trialversion3.0/assets/select/s2-docs.css">
<link href="http://select2.github.io/select2/font-awesome/css/font-awesome.min.css">

<script src="http://select2.github.io/select2/js/jquery-1.7.1.min.js"></script>
<script src="http://shivatapes.com/trialversion3.0/assets/select/select2.js"></script>
<script src="http://select2.github.io/select2/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<style>
  .select2-results__option--highlighted[aria-selected=true] {
    display: none;
  }
</style>
<!-- page content -->
<div class="content-wrapper">
  <!-- Container-fluid starts -->
  <div class="container-fluid">
    <!-- Row Starts -->
    <div class="row">
      <div class="col-sm-12 p-0">
        <div class="main-header">
          <ol class="breadcrumb breadcrumb-title breadcrumb-arrow">
            <li class="breadcrumb-item">

            </li>
          </ol>
        </div>
      </div>
    </div>
    <!-- Row end -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Select2</h5>
          </div>
          <div class="card-block">
            <form method="post" action="<?php echo base_url('select/add_new'); ?>">
              <div class="col-sm-12">
                <select name="" id="mySelect2" class="form-control js-example-data-ajax ">
                  <option value=""> Choose </option>
                </select>
              </div>
              <div class="" align="right">
                <br>
                <button type="submit" class="btn btn-info btn-md"> Submit </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



  </div>
  <!-- Container-fluid ends -->
</div>
</div>


<!-- /page content -->

<?php //$this->load->view('user/include/footer');
?>


<script type="text/javascript">
  $(".js-example-data-ajax").select2({
    ajax: {
      url: "<?= base_url('quote/load_data'); ?>",
      dataType: 'json',
      delay: 150,
      data: function(params) {
        return {
          search: params.term, // search term
          page: params.page
        };
      },
      processResults: function(data, params) {
        params.page = params.page || 1;

        return {
          results: data.items,
          pagination: {
            more: (params.page * 30) < data.total_count
          }
        };
      },
      cache: true
    },
    placeholder: 'Search for a repository',
    escapeMarkup: function(markup) {
      return markup;
    }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatRepo,
    templateSelection: formatRepoSelection
  });

  function formatRepo(repo) {
    if (repo.loading) {
      return repo.text;
    }

    var markup = "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__avatar'><img src='<?= base_url('uploads/quote'); ?>/" + repo.item_sample + "'  /></div>" +
      "<div class='select2-result-repository__meta'>" +
      "<div class='select2-result-repository__title'>" + repo.item_name + "</div>";

    if (repo.item_width) {
      markup += "<div class='select2-result-repository__description'>" + repo.item_width + "</div>";
    }

    "</div></div>";

    return markup;
  }

  function formatRepoSelection(repo) {
    return repo.item_name || repo.text;
  }
</script>