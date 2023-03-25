<?php
$user_viewed = $this->session->userdata('user_viewed');
$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
$logged_user_id = $this->session->userdata('user_id');
?>
<!--sidebar start-->
<?php
if ($this->session->userdata('logged_as') == 'user') {
?>
  <aside>
    <div id="sidebar" class="nav-collapse ">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu">
        <li class="<?= (isset($activeItem) && $activeTab == 'dashboard') ? 'active' : ''; ?>">
          <a class="" href="<?= base_url(); ?>">
            <i class="icon-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <?php
        $is_privileged = $this->m_users->is_privileged('admin', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('admin', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'admin') ? 'active' : ''; ?>">
            <a class="" href="javascript:;">
              <i class="icon-dashboard"></i>
              <span>Admin</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('rateconfirmation', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('rateconfirmation', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'rateconfirmation') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>admin/rateconfirmation">Item Retes</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('rate_master_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('rate_master_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'rate_master_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>admin/rate_master_3">Item Rate Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('concernMaster', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('concernMaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'concernMaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>admin/concernMaster">Concern Master</a></li>
              <?php
              }
              if ($is_admin) {
              ?>
                <li class="<?= ($activeItem == 'deletedBoxes') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>reports/deletedBoxes">Deleted Boxes</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('general', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('general', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'general') ? 'active' : ''; ?>">
            <a class="" href="javascript:;">
              <i class="icon-dashboard"></i>
              <span>Gen.Del. In Group</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('generalPartyMaster', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalPartyMaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalPartyMaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalPartyMaster">General Party Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('generalItemGroup', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalItemGroup', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalItemGroup') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalItemGroup">General Item Group</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('generalItemMaster', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalItemMaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalItemMaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalItemMaster">General Item Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('materialInward', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('materialInward', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'materialInward') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/materialInward">Material Inward</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('generalStockTransfer', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalStockTransfer', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalStockTransfer') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalStockTransfer">Stock Transfer DC</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('generalStockTransfer', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalStockTransfer', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalStockTransfer') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/genStockTranDc_print">Print Stock Trans.DC</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('generalDcAcceptance', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalDcAcceptance', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalDcAcceptance') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalDcAcceptance">Stock Acceptence</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('materialConsumption', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('materialConsumption', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'materialConsumption') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/materialConsumption">Material Consumption</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('stock_transfer_store', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('stock_transfer_store', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'stock_transfer_store') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/stock_transfer_store">Stock Tfr (In House)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('IOweYou', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('IOweYou', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'IOweYou') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/IOweYou">I Owe You Voucher</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('general', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('general', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'general_others') ? 'active' : ''; ?>">
            <a class="" href="javascript:;">
              <i class="icon-dashboard"></i>
              <span>Gen.Del. Others</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('generalDelivery', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalDelivery', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalDelivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalDelivery">General Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('generalDeliveryInward', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('generalDeliveryInward', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'generalDeliveryInward') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general/generalDeliveryInward">Delivery Recd Back</a></li>
              <?php
              }
              ?>
            </ul>
          <?php
        }
        $is_privileged = $this->m_users->is_privileged('general_dc_report', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('general_dc_report', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
          ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'general_dc_report') ? 'active' : ''; ?>">
            <a class="" href="javascript:;">
              <i class="icon-dashboard"></i>
              <span>General DC Report</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('itemstockRegister', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('itemstockRegister', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'itemstockRegister') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>general_dc_report/itemstockRegister">General Stock Register</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        ?>
        <?php
        $is_privileged = $this->m_users->is_privileged('users', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('users', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'user') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-user"></i>
              <span>Users</span>
              <span class="arrow"></span>
              <span class="label label-danger pull-right mail-info"><?= sizeof($this->m_users->getallusers()); ?></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('addnew', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('addnew', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'adduser') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users/addnew">Add User</a></li>
              <?php
              }
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'createcustomerlogin') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users/createcustomerlogin">Create Cust Login</a></li>
                <li class="<?= ($activeItem == 'listusers') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users">Users List</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('marketing', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('marketing', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'marketing') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-user"></i>
              <span>Marketing</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('manageAppointments', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('manageAppointments', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'manageAppointments') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>marketing/manageAppointments">Add Appointment</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('dailyPlans', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('dailyPlans', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'dailyPlans') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>marketing/dailyPlans">Daily Plans</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('addVisitDetails', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('addVisitDetails', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'addVisitDetails') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>marketing/addVisitDetails">Add Visit Details</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('targetSalesReceipt', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('targetSalesReceipt', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'targetSalesReceipt') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>marketing/targetSalesReceipt">Collection Budget</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('salesBudget', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('salesBudget', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'salesBudget') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>marketing/salesBudget">Sales Budget</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('masters', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('masters', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'masters') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-cogs"></i>
              <span>Masters</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              /*$is_privileged = $this->m_users->is_privileged('categories', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('categories', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='categories')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/categories">Categories</a></li>
                      <?php
                    }*/
              $is_privileged = $this->m_users->is_privileged('customerGroup', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('customerGroup', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'customerGroup') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/customerGroup">Customer Group</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('customers', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('customers', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'customers') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/customers">Customers</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('supplierGroup', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('supplierGroup', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'supplierGroup') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/supplierGroup">Supplier Group</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('suppliers', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('suppliers', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'suppliers') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/suppliers">Suppliers</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('deniermaster', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('deniermaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'deniermaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/deniermaster">Denier Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('colorfamily', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('colorfamily', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'colorfamily') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/colorfamily">Color Family</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('shades', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('shades', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'shades') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/shades">Color Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('weavemaster_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('weavemaster_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'weavemaster_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/weavemaster_2">Weave Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('dc_family', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('dc_family', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'dc_family') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/dc_family">Dyes family Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('dyes_chemicals', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('dyes_chemicals', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'dyes_chemicals') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/dyes_chemicals">Dyes &amp; Chemicals</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('recipemaster', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('recipemaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'recipemaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/recipemaster">Recipe Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('machines', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('machines', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'machines') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/machines">Machine Prefix</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('lots', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('lots', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'lots') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/lots">Lots</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('uoms', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('uoms', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'uoms') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/uoms">Unit of measurement</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('tax', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('tax', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'tax') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/tax">Tax</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('othercharges', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('othercharges', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'othercharges') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/othercharges">Other Charges</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('tareweights', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('tareweights', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'tareweights') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/tareweights">Tare Weight</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('agents', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('agents', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'agents') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/agents">Agents</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('itemgroups', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('itemgroups', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'itemgroups') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/itemgroups">Item Groups</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('items', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('items', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'items') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items">Items</a></li>
              <?php
              }

              // Tabs And Elastics
              $is_privileged = $this->m_users->is_privileged('machines_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('machines_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'machines_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/machines_2">Machine Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('shades_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('shades_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'shades_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/shades_2">Shade Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('stockrooms_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('stockrooms_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'stockrooms_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/stockrooms_2">Stock Rooms</a></li>
              <?php
              }
              // Labels
              $is_privileged = $this->m_users->is_privileged('machines_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('machines_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'machines_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/machines_2">Machine Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('departments_1', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('departments_1', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'departments_1') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/departments_1">Departments</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }

        $is_privileged = $this->m_users->is_privileged('poy', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('poy', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'poy') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>POY</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('poydenier', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('poydenier', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'poydenier') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/poydenier">POY Denier</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('poy_lots', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('poy_lots', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'poy_lots') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/poy_lots">POY Lots</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('po_issue', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('po_issue', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'po_issue') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/po_issue">PO Issue</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('poy_inward', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('poy_inward', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'poy_inward') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/poy_inward">POY Inward</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('poy_issue', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('poy_issue', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'poy_issue') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/poy_issue">POY Issue</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('yarn_delivery', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('yarn_delivery', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'yarn_delivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/yarn_delivery">Yarn Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('sales_entry', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('sales_entry', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'sales_entry') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>poy/sales_entry">Sales Entry</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('deliveryaccept', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('deliveryaccept', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'deliveryaccept') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Delivery Accept</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('poy_accept', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('poy_accept', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'poy_accept') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>deliveryaccept/poy_accept">POY Acceptance</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('item_masters', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('item_masters', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'item_masters') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Item Master</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('itemgroups_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('itemgroups_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'itemgroups_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/itemgroups_2">Item Group</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('items_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('items_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'items_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_2">Item Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('items_2_technical', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('items_2_technical', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'items_2_technical') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_2_technical">Technical Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('items_2_view', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('items_2_view', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'items_2_view') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_2_view">View Items</a></li>
              <?php
              }
              // Labels
              $is_privileged = $this->m_users->is_privileged('itemgroups_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('itemgroups_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'itemgroups_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/itemgroups_3">Item Group</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('items_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('items_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'items_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_3">Item Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('item_size_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('item_size_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'item_size_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/item_size_3">Item Size Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('item_technical_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('item_technical_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'item_technical_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/item_technical_3">Item Technical Master</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('purchase', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('purchase', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'purchase') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Purchase Orders</span>
              <span class="arrow"></span>
              <!-- <span class="label label-danger pull-right mail-info">0</span> -->
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('enquiry', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('enquiry', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'enquiry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiry">New Enquiry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('newenquiry_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('newenquiry_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'newenquiry_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/newenquiry_2">New Enquiry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('enquiries', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('enquiries', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'enquiries') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiries">Enquiries</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('enquiries_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('enquiries_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'enquiries_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiries_2">Enquiries Recieved</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('quotations', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('quotations', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'quotations') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/quotations">Quotation Sent</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('quotations_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('quotations_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'quotations_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/quotations_2">Quotation Sent</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('purchaseorders', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('purchaseorders', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'neworder') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/purchaseorders">Purchase Orders</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('purchaseorders_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('purchaseorders_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'purchaseorders_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/purchaseorders_2"> PO Recieved</a></li>
              <?php
              }
              // Labels
              $is_privileged = $this->m_users->is_privileged('po_received_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('po_received_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'po_received_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/po_received_3"> PO Received</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('production', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('production', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'production') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Production</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('joborder_custwise', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('joborder_custwise', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'joborder_custwise') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/joborder_custwise">JOB Order (Cust.Wise)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('joborder_itemwise', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('joborder_itemwise', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'joborder_itemwise') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/joborder_itemwise">JOB Order (Item Wise)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('jobsheet_warping', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('jobsheet_warping', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'jobsheet_warping') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/jobsheet_warping">JOB card (Warping)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('jobsheet_ps', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('jobsheet_ps', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'jobsheet_ps') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/jobsheet_ps">JOB card / P.S.</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('production_hrs_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('production_hrs_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'production_hrs_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/production_hrs_2">Production Entry (Hrs)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('production_e_item_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('production_e_item_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'production_e_item_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/production_e_item_2">Production Entry (Item)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('production_r_item_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('production_r_item_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'production_r_item_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/production_r_item_2">Production Rpt (Item)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('rollingentry', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('rollingentry', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'rollingentry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/rollingentry">Rolling Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('predelivery_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('predelivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'predelivery_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery_2">Pre Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('predelivery_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('predelivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'predelivery_2_list') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery_2_list">Pre Deliveries</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('delivery_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('delivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'delivery_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/delivery_2">Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('internalpo', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('internalpo', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'internalpo') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/internalpo">Job Card Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('POrecieved', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('POrecieved', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'POrecieved') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/POrecieved">Job Cards Recieved</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('processcard', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('processcard', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'processcard') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/processcard">Process Card</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('predelivery', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('predelivery', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'predelivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery">Pre Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('delivery', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('delivery', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'delivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/delivery">Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('prod_entry_operator_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('prod_entry_operator_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'prod_entry_operator_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/prod_entry_operator_3">Prod. Entry Operator</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('roll_entry_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('roll_entry_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'roll_entry_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/roll_entry_3">Roll Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('packing_entry_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('packing_entry_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packing_entry_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packing_entry_3">Packing Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('packing_entry_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('packing_entry_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'final_packing_entry_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/final_packing_entry_3">Final Packing Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('predelivery_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('predelivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'predelivery_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery_3">Pre Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('predelivery_3_list', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('predelivery_3_list', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'predelivery_3_list') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery_3_list">Edit Pre Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('delivery_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('delivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'delivery_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/delivery_3">Delivery</a></li>
              <?php
              }
              /*$is_privileged = $this->m_users->is_privileged('salesentry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('salesentry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sales')?'active':'';?>"><a class="" href="<?=base_url()?>sales/salesentry">Sales Entry</a></li>                              <?php
                    }*/
              ?>
              <!-- <li class="<?= ($activeItem == 'salesreturn') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/salesentry">Sales Return</a></li> -->
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('production', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('production', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'packing') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-dropbox"></i>
              <span>Packing</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('packingentry', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('packingentry', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packingentry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packingentry">Packing Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('packingreport', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('packingreport', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packingreport') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packingreport">Packing Items</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('innerbox_packing', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('innerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'innerbox_packing') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/innerbox_packing">Inner Box Pack (Roll)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('innerbox_packing_pcs', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('innerbox_packing_pcs', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'innerbox_packing_pcs') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/innerbox_packing_pcs">Inner Box Pack (Pcs)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('outerbox_packing', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('outerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'outerbox_packing') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerbox_packing">Outer Box Packing</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('outerbox_pack_without_ib', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('outerbox_pack_without_ib', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'outerbox_pack_without_ib') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerbox_pack_without_ib">Outer Pack (no inner)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('outerbox_pack_kgs', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('outerbox_pack_kgs', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'outerbox_pack_kgs') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerbox_pack_kgs">Outer Box (Kgs)</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('outerBoxQtyWise_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('outerBoxQtyWise_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'outerBoxQtyWise_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerBoxQtyWise_2">Outer Box - Qty wise</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('print_box_sticker_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('print_box_sticker_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'print_box_sticker_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/print_box_sticker_2">Print Box Sticker</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('print_item_sticker_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('print_item_sticker_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'print_item_sticker_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/print_item_sticker_2">Print Item Sticker</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('matetailReturened', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('matetailReturened', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'matetailReturened') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>packing/matetailReturened">Material Returened</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('reports', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('reports', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'reports') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-dropbox"></i>
              <span>Reports</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('packingRegister', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('packingRegister', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packingRegister') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>reports/packingRegister">Packing Register</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('store', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('store', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'store') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Store</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('porecieved', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('porecieved', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'porecieved') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>store/porecieved">PO Recieved</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('stockissue', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('stockissue', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'stockissue') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>store/stockissue">Stock Issue</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('sales', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('sales', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_manu_active && $is_admin) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'sales') ? 'active' : ''; ?>">
            <a class="" href="javascript:;">
              <i class="icon-bar-chart"></i>
              <span>Sales</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('create_invoice_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('create_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'create_invoice_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/create_invoice_2">Create Invoice</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('create_invoice_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('create_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'invoices_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/invoices_2">Print Invoice</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('create_invoice_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('create_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'proforma_invoices_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/proforma_invoices_2">Proforma Invoices</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('cash_invoice_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('cash_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cash_invoice_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/cash_invoice_2">Cash Invoices</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('packing_slip_2', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('packing_slip_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packing_slip_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/packing_slip_2">Packing Slip</a></li>
              <?php
              }
              // Labels
              $is_privileged = $this->m_users->is_privileged('create_invoice_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('create_invoice_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'create_invoice_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/create_invoice_3">Create Invoice</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('invoices_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('invoices_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'invoices_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/invoices_3">Print Invoice</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('proforma_invoices_3', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('proforma_invoices_3', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_manu_active && $is_admin) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'proforma_invoices_3') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/proforma_invoices_3">Proforma Invoice</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('accounts', 'upriv_controller', $logged_user_id);
        $is_manu_active = $this->m_users->is_manu_active('accounts', 'upriv_controller', $this->session->userdata('user_viewed'));
        if (($is_admin && $is_manu_active) || $is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'accounts') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-briefcase"></i>
              <span>Accounts</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('customeropenbalance', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('customeropenbalance', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cust_open_bal') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/customeropenbalance">Cust Opening Balance</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('supplieropenbalance', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('supplieropenbalance', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'sup_open_bal') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/supplieropenbalance">Supp Opening Balance</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('cashpayment', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('cashpayment', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cashpayment') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/cashpayment">Cash Payment</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('cashreceipt', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('cashreceipt', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cashreceipt') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/cashreceipt">Cash Receipt</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('bankpayment', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('bankpayment', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'bankpayment') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/bankpayment">Bank Payment</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('debitnote', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('debitnote', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'debitnote') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/debitnote">Debit Note</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('creditnote', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('creditnote', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'creditnote') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/creditnote">Credit Note</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('chequecollection', 'upriv_function', $logged_user_id);
              $is_manu_active = $this->m_users->is_manu_active('chequecollection', 'upriv_function', $this->session->userdata('user_viewed'));
              if (($is_admin && $is_manu_active) || $is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'chequecollection') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/chequecollection">Cheque Colletion</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        ?>
      </ul>
      <!-- sidebar menu end-->
    </div>
  </aside>
<?php
} else {
?>
  <aside>
    <div id="sidebar" class="nav-collapse ">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu">
        <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'customer') ? 'active' : ''; ?>">
          <a href="javascript:;" class="">
            <i class=" icon-shopping-cart"></i>
            <span>Customer</span>
            <span class="arrow"></span>
          </a>
          <ul class="sub">
            <li class=""><a class="" href="#">PO Status</a></li>
            <li class=""><a class="" href="#">Job Order Status</a></li>
            <li class=""><a class="" href="#">Dispatch Details</a></li>
            <li class="<?= ($activeItem == 'change_cust_password') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>users/change_cust_password">Change Password</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>
<?php
}
?>
<!--sidebar end-->