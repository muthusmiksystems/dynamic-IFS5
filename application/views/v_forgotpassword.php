<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title><?=$page_title; ?></title>

    <!-- Bootstrap core CSS -->
    <?php
    foreach ($css as $path) {
      ?>
      <link href="<?=base_url().'themes/default/'.$path; ?>" rel="stylesheet">
      <?php
    }
    ?>



</head>

  <body class="login-body">

    <div class="container">
      <form class="form-signin" action="<?=base_url()?>users/getpassword" method="post">
        <h2 class="form-signin-heading">Forgot your password</h2>
        <?php
        if($this->session->flashdata('error'))
        {
          ?>
          <div class="alert alert-block alert-danger fade in">
            <strong>Oops sorry!</strong> <?=$this->session->flashdata('error'); ?>
        </div>
          <?php
        }
        ?>
        <div class="login-wrap">
            <label class="radio-inline">
              <input type="radio" name="login_type" id="user" value="user" checked="checked"> User
            </label>
            <label class="radio-inline">
              <input type="radio" name="login_type" id="customer" value="customer"> Customer
            </label>
            <div style="clear:both;"></div>
            <br/>
            <input type="email" class="form-control" name="email" placeholder="Email" autofocus>
            <label class="checkbox"></label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Get password</button>
        </div>

      </form>

    </div>


  </body>
</html>
