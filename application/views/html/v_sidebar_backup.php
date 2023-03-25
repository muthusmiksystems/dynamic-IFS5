<?php
$user_viewed = $this->session->userdata('user_viewed');
$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
$logged_user_id = $this->session->userdata('user_id');
?>
<!--sidebar start-->
<?php
if ($is_admin) {
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
        $is_manu_active = $this->m_users->is_manu_active('users', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
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
              $is_manu_active = $this->m_users->is_manu_active('addnew', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'adduser') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users/addnew">Add User</a></li>
              <?php
              }
              ?>
              <li class="<?= ($activeItem == 'createcustomerlogin') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users/createcustomerlogin">Create Cust Login</a></li>
              <li class="<?= ($activeItem == 'listusers') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users">Users List</a></li>
            </ul>
          </li>
        <?php
        }
        $is_manu_active = $this->m_users->is_manu_active('masters', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'masters') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-cogs"></i>
              <span>Masters</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_manu_active = $this->m_users->is_manu_active('categories', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'categories') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/categories">Categories</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('customers', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'customers') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/customers">Customers</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('suppliers', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'suppliers') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/suppliers">Suppliers</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('deniermaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'deniermaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/deniermaster">Denier Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('colorfamily', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'colorfamily') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/colorfamily">Color Family</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('shades', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'shades') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/shades">Color Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('weavemaster_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'weavemaster_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/weavemaster_2">Weave Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('recipemaster', 'upriv_function', $this->session->userdata('user_viewed'));
              $is_manu_active = $this->m_users->is_manu_active('dc_family', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'dc_family') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/dc_family">Dyes family Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('dyes_chemicals', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'dyes_chemicals') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/dyes_chemicals">Dyes &amp; Chemicals</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('recipemaster', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'recipemaster') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/recipemaster">Recipe Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('machines', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'machines') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/machines">Machine Prefix</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('lots', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'lots') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/lots">Lots</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('poy_lots', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'poy_lots') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/poy_lots">POY Lots</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('uoms', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'uoms') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/uoms">Unit of measurement</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('tax', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'tax') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/tax">Tax</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('othercharges', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'othercharges') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/othercharges">Other Charges</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('tareweights', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'tareweights') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/tareweights">Tare Weight</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('agents', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'agents') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/agents">Agents</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('itemgroups', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'itemgroups') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/itemgroups">Item Groups</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('items', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'items') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items">Items</a></li>
              <?php
              }

              // Tabs And Elastics
              $is_manu_active = $this->m_users->is_manu_active('machines_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'machines_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/machines_2">Machine Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('shades_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'shades_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/shades_2">Shade Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('stockrooms_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'stockrooms_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/stockrooms_2">Stock Rooms</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_manu_active = $this->m_users->is_manu_active('item_masters', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'item_masters') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Item Master</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_manu_active = $this->m_users->is_manu_active('itemgroups_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'itemgroups_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/itemgroups_2">Item Group</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('items_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'items_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_2">Item Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('items_2_technical', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'items_2_technical') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_2_technical">Technical Master</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('items_2_view', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'items_2_view') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items_2_view">View Items</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_manu_active = $this->m_users->is_manu_active('purchase', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
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
              $is_manu_active = $this->m_users->is_manu_active('enquiry', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'enquiry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiry">New Enquiry</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('newenquiry_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'newenquiry_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/newenquiry_2">New Enquiry</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('enquiries', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'enquiries') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiries">Enquiries</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('enquiries_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'enquiries_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiries_2">Enquiries Recieved</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('quotations', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'quotations') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/quotations">Quotation Sent</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('quotations_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'quotations_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/quotations_2">Quotation Sent</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('purchaseorders', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'neworder') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/purchaseorders">Purchase Orders</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('purchaseorders_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'purchaseorders_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/purchaseorders_2"> PO Recieved</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_manu_active = $this->m_users->is_manu_active('production', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'production') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Production</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_manu_active = $this->m_users->is_manu_active('joborder_custwise', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'joborder_custwise') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/joborder_custwise">JOB Order (Cust.Wise)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('joborder_itemwise', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'joborder_itemwise') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/joborder_itemwise">JOB Order (Item Wise)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('jobsheet_warping', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'jobsheet_warping') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/jobsheet_warping">JOB card (Warping)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('jobsheet_ps', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'jobsheet_ps') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/jobsheet_ps">JOB card / P.S.</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('production_hrs_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'production_hrs_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/production_hrs_2">Production Entry (Hrs)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('production_e_item_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'production_e_item_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/production_e_item_2">Production Entry (Item)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('production_r_item_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'production_r_item_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/production_r_item_2">Production Rpt (Item)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('rollingentry', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'rollingentry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/rollingentry">Rolling Entry</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('innerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'innerbox_packing') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/innerbox_packing">Inner Box Packing</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('outerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'outerbox_packing') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerbox_packing">Outer Box Packing</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('outerbox_pack_without_ib', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'outerbox_pack_without_ib') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerbox_pack_without_ib">Outer Pack (no inner)</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('predelivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'predelivery_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery_2">Pre Delivery</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('delivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'delivery_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/delivery_2">Delivery</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('internalpo', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'internalpo') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/internalpo">Job Card Entry</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('POrecieved', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'POrecieved') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/POrecieved">Job Cards Recieved</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('processcard', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'processcard') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/processcard">Process Card</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('packingentry', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'packingentry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packingentry">Packing Entry</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('packingreport', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'packingreport') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packingreport">Packing Items</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('predelivery', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'predelivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery">Pre Delivery</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('delivery', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'delivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/delivery">Delivery</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('salesentry', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'sales') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/salesentry">Sales Entry</a></li>
              <?php
              }
              ?>
              <!-- <li class="<?= ($activeItem == 'salesreturn') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/salesentry">Sales Return</a></li> -->
            </ul>
          </li>
        <?php
        }
        $is_manu_active = $this->m_users->is_manu_active('store', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'store') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Store</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_manu_active = $this->m_users->is_manu_active('porecieved', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'porecieved') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>store/porecieved">PO Recieved</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('stockissue', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'stockissue') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>store/stockissue">Stock Issue</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_manu_active = $this->m_users->is_manu_active('accounts', 'upriv_controller', $this->session->userdata('user_viewed'));
        if ($is_manu_active) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'accounts') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-briefcase"></i>
              <span>Accounts</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_manu_active = $this->m_users->is_manu_active('customeropenbalance', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'cust_open_bal') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/customeropenbalance">Cust Opening Balance</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('supplieropenbalance', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'sup_open_bal') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/supplieropenbalance">Supp Opening Balance</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('cashpayment', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'cashpayment') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/cashpayment">Cash Payment</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('cashreceipt', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'cashreceipt') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/cashreceipt">Cash Receipt</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('bankpayment', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'bankpayment') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/bankpayment">Bank Payment</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('debitnote', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'debitnote') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/debitnote">Debit Note</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('creditnote', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
              ?>
                <li class="<?= ($activeItem == 'creditnote') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/creditnote">Credit Note</a></li>
              <?php
              }
              $is_manu_active = $this->m_users->is_manu_active('chequecollection', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_manu_active) {
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
        <li class="<?= (isset($activeItem) && $activeTab == 'dashboard') ? 'active' : ''; ?>">
          <a class="" href="<?= base_url(); ?>">
            <i class="icon-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <?php
        $is_manu_active = $this->m_users->is_manu_active('users', 'upriv_controller', $this->session->userdata('user_viewed'));
        $is_user_privileged = $this->m_users->is_privileged('users', 'upriv_controller', $logged_user_id);
        if ($is_user_privileged) {
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
              $is_adduser_privileged = $this->m_users->is_privileged('addnew', 'upriv_function', $logged_user_id);
              if ($is_adduser_privileged) {
              ?>
                <li class="<?= ($activeItem == 'adduser') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users/addnew">Add User</a></li>
              <?php
              }
              $is_userindex_privileged = $this->m_users->is_privileged('index', 'upriv_function', $logged_user_id);
              if ($is_userindex_privileged) {
              ?>
                <li class="<?= ($activeItem == 'listusers') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>users">Users List</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_masters_privileged = $this->m_users->is_privileged('masters', 'upriv_controller', $logged_user_id);
        if ($is_masters_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'masters') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class="icon-cogs"></i>
              <span>Masters</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_categories_privileged = $this->m_users->is_privileged('categories', 'upriv_function', $logged_user_id);
              if ($is_categories_privileged) {
              ?>
                <li class="<?= ($activeItem == 'categories') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/categories">Categories</a></li>
              <?php
              }
              $is_customers_privileged = $this->m_users->is_privileged('customers', 'upriv_function', $logged_user_id);
              if ($is_customers_privileged) {
              ?>
                <li class="<?= ($activeItem == 'customers') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/customers">Customers</a></li>
              <?php
              }
              $is_suppliers_privileged = $this->m_users->is_privileged('suppliers', 'upriv_function', $logged_user_id);
              if ($is_suppliers_privileged) {
              ?>
                <li class="<?= ($activeItem == 'suppliers') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/suppliers">Suppliers</a></li>
              <?php
              }
              $is_shades_privileged = $this->m_users->is_privileged('shades', 'upriv_function', $logged_user_id);
              if ($is_shades_privileged) {
              ?>
                <li class="<?= ($activeItem == 'shades') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/shades">Color Master</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('machines', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'machines') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/machines">Machine Prefix</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('lots', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'lots') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/lots">Lots</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('uoms', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'uoms') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/uoms">Unit of measurement</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('tax', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'tax') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/tax">Tax</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('othercharges', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'othercharges') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/othercharges">Other Charges</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('tareweights', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'tareweights') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/tareweights">Tare Weight</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('agents', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'agents') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/agents">Agents</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('itemgroups', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'itemgroups') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/itemgroups">Item Groups</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('items', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'items') ? 'active' : ''; ?>"><a class="" href="<?= base_url(); ?>masters/items">Items</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('purchase', 'upriv_controller', $logged_user_id);
        if ($is_privileged) {
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
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'enquiry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiry">New Enquiry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('enquiries', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'enquiries') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/enquiries">Enquiries</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('quotations', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'quotations') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/quotations">Quotation Sent</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('neworder', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'neworder') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/purchaseorders">Purchase Orders</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('newpurchaseorder_2', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'newpurchaseorder_2') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>purchase/newpurchaseorder_2">New Purchase Order</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('production', 'upriv_controller', $logged_user_id);
        if ($is_privileged) {
        ?>
          <li class="sub-menu <?= (isset($activeTab) && $activeTab == 'production') ? 'active' : ''; ?>">
            <a href="javascript:;" class="">
              <i class=" icon-shopping-cart"></i>
              <span>Production</span>
              <span class="arrow"></span>
            </a>
            <ul class="sub">
              <?php
              $is_privileged = $this->m_users->is_privileged('jobcard_entry', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'jobcard_entry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/jobcard_entry">Jobcard Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('rollingentry', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'rollingentry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/rollingentry">Rolling Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('innerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'innerbox_packing') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/innerbox_packing">Inner Box Packing</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('outerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'outerbox_packing') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/outerbox_packing">Outer Box Packing</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('internalpo', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'internalpo') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/internalpo">Job Card Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('POrecieved', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'POrecieved') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/POrecieved">Job Cards Recieved</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('processcard', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'processcard') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/processcard">Process Card</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('packingentry', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packingentry') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packingentry">Packing Entry</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('packingreport', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'packingreport') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/packingreport">Packing Items</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('predelivery', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'predelivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/predelivery">Pre Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('delivery', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'delivery') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>production/delivery">Delivery</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('salesentry', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'sales') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>sales/salesentry">Sales Entry</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('store', 'upriv_controller', $logged_user_id);
        if ($is_privileged) {
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
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'porecieved') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>store/porecieved">PO Recieved</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('stockissue', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'stockissue') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>store/stockissue">Stock Issue</a></li>
              <?php
              }
              ?>
            </ul>
          </li>
        <?php
        }
        $is_privileged = $this->m_users->is_privileged('accounts', 'upriv_controller', $logged_user_id);
        if ($is_privileged) {
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
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cust_open_bal') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/customeropenbalance">Cust Opening Balance</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('supplieropenbalance', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'sup_open_bal') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/supplieropenbalance">Supp Opening Balance</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('cashpayment', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cashpayment') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/cashpayment">Cash Payment</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('cashreceipt', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'cashreceipt') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/cashreceipt">Cash Receipt</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('bankpayment', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'bankpayment') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/bankpayment">Bank Payment</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('debitnote', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'debitnote') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/debitnote">Debit Note</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('creditnote', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
              ?>
                <li class="<?= ($activeItem == 'creditnote') ? 'active' : ''; ?>"><a class="" href="<?= base_url() ?>accounts/creditnote">Credit Note</a></li>
              <?php
              }
              $is_privileged = $this->m_users->is_privileged('chequecollection', 'upriv_function', $logged_user_id);
              if ($is_privileged) {
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
}
?>

<!--sidebar end-->