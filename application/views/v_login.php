<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Mosaddek">
  <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <link rel="shortcut icon" href="img/favicon.html">

  <title><?= $page_title; ?></title>

  <!-- Bootstrap core CSS -->
  <?php
  foreach ($css as $path) {
  ?>
    <link href="<?= base_url() . 'themes/default/' . $path; ?>" rel="stylesheet">
  <?php
  }
  ?>

  
  

</head>

<body class="login-body">

  <div class="container">
    <form class="form-signin" action="<?= base_url() ?>users/submitlogin" method="post">
      <h2 class="form-signin-heading">sign in now</h2>
      <?php
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
          <h4>
            <i class="icon-ok-sign"></i>
            Success!
          </h4>
          <p><?= $this->session->flashdata('success'); ?></p>
        </div>
      <?php
      }
      ?>
      <div class="login-wrap">
        <input type="text" class="form-control" name="username" placeholder="User ID" autofocus>
        <input type="password" class="form-control" name="password" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
          <span class="pull-right"> <a href="<?= base_url() ?>users/forgotpassword"> Forgot Password?</a></span>
        </label>
        <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
      </div>
    </form>
  </div>
</body>

</html>