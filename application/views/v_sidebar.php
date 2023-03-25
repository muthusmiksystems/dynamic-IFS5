<?php
$user_viewed = $this->session->userdata('user_viewed');
$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
$logged_user_id = $this->session->userdata('user_id');
?>
<!--sidebar start-->
<?php
if($this->session->userdata('logged_as') == 'user')
{
?>
  <aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li class="<?=(isset($activeItem) && $activeTab=='dashboard')?'active':'';?>">
                <a class="" href="<?=base_url(); ?>">
                    <i class="icon-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php
            $is_privileged = $this->m_users->is_privileged('admin', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('admin', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
            ?>
            <li class="sub-menu <?=(isset($activeTab) && $activeTab=='admin')?'active':'';?>">
                <a class="" href="javascript:;">
                    <i class="icon-dashboard"></i>
                    <span>Admin</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                <li><a href="#">Password</a></li>
                <?php
                $is_privileged = $this->m_users->is_privileged('rateconfirmation', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('rateconfirmation', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='rateconfirmation')?'active':'';?>"><a class="" href="<?=base_url()?>admin/rateconfirmation">Item Retes</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('rate_master_3', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('rate_master_3', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='rate_master_3')?'active':'';?>"><a class="" href="<?=base_url()?>admin/rate_master_3">Item Rate Master</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('rate_master_1', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('rate_master_1', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='rate_master_1')?'active':'';?>"><a class="" href="<?=base_url()?>admin/rate_master_1">Item Rate Master</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('concernMaster', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('concernMaster', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='concernMaster')?'active':'';?>"><a class="" href="<?=base_url()?>admin/concernMaster">Concern Master</a></li>
                  <?php
                }
                $is_manu_active = $this->m_users->is_manu_active('deletedBoxes', 'upriv_function', $this->session->userdata('user_viewed'));                        if($is_admin && $is_manu_active)
                {
                  ?>
                  <li class="<?=($activeItem=='deletedBoxes')?'active':'';?>"><a class="" href="<?=base_url()?>reports/deletedBoxes">Deleted Boxes</a></li>                          <?php
                }
                $is_manu_active = $this->m_users->is_manu_active('deletedBoxes_1', 'upriv_function', $this->session->userdata('user_viewed'));                        if($is_admin && $is_manu_active)
                {
                  ?>
                  <li class="<?=($activeItem=='deletedBoxes_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/deletedBoxes_1">Deleted Boxes</a></li>                          <?php
                }
				/* legrand charles (labels) */
				$is_manu_active = $this->m_users->is_manu_active('deletedBoxes_3', 'upriv_function', $this->session->userdata('user_viewed'));                        if($is_admin && $is_manu_active)
                {
                  ?>
                  <li class="<?=($activeItem=='deletedBoxes_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/deletedBoxes_3">Deleted Boxes</a></li>                          <?php
                }
				/* legrand charles (labels) */
                ?>
                <?php if($is_admin): ?>
                  <li class="<?=($activeItem=='sh_deleted_boxes')?'active':'';?>"><a class="" href="<?php echo base_url('shop/packing/deleted_boxes'); ?>">Shop Deleted Boxes</a></li>
                <?php endif; ?>
                </ul>
            </li>
            <?php
            }
            $is_privileged = $this->m_users->is_privileged('general', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('general', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
            ?>
            <li class="sub-menu <?=(isset($activeTab) && $activeTab=='general')?'active':'';?>">
                <a class="" href="javascript:;">
                    <i class="icon-dashboard"></i>
                    <span>Gen.Del. In Group</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                <?php
                $is_privileged = $this->m_users->is_privileged('generalPartyMaster', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalPartyMaster', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalPartyMaster')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalPartyMaster">General Party Master</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('generalItemGroup', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalItemGroup', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalItemGroup')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalItemGroup">General Item Group</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('generalItemMaster', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalItemMaster', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalItemMaster')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalItemMaster">General Item Master</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('materialInward', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('materialInward', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='materialInward')?'active':'';?>"><a class="" href="<?=base_url()?>general/materialInward">Material Inward</a></li>
                  <?php
                }                       $is_privileged = $this->m_users->is_privileged('generalStockTransfer', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalStockTransfer', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalStockTransfer')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalStockTransfer">Stock Transfer DC</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('generalStockTransfer', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalStockTransfer', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalStockTransfer')?'active':'';?>"><a class="" href="<?=base_url()?>general/genStockTranDc_print">Print Stock Trans.DC</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('generalDcAcceptance', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalDcAcceptance', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalDcAcceptance')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalDcAcceptance">Stock Acceptence</a></li>
                  <?php
                }                        $is_privileged = $this->m_users->is_privileged('materialConsumption', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('materialConsumption', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='materialConsumption')?'active':'';?>"><a class="" href="<?=base_url()?>general/materialConsumption">Material Consumption</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('stock_transfer_store', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('stock_transfer_store', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='stock_transfer_store')?'active':'';?>"><a class="" href="<?=base_url()?>general/stock_transfer_store">Stock Tfr (In House)</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('IOweYou', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('IOweYou', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='IOweYou')?'active':'';?>"><a class="" href="<?=base_url()?>general/IOweYou">I Owe You Voucher</a></li>
                  <?php
                }
                ?>
                </ul>
            </li>
            <?php
            }
            $is_privileged = $this->m_users->is_privileged('general', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('general', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
            ?>
            <li class="sub-menu <?=(isset($activeTab) && $activeTab=='general_others')?'active':'';?>">
                <a class="" href="javascript:;">
                    <i class="icon-dashboard"></i>
                    <span>Gen.Del. Others</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                <?php
                $is_privileged = $this->m_users->is_privileged('generalDelivery', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalDelivery', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalDelivery')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalDelivery">General Delivery</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('generalDeliveryInward', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('generalDeliveryInward', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='generalDeliveryInward')?'active':'';?>"><a class="" href="<?=base_url()?>general/generalDeliveryInward">Delivery Recd Back</a></li>
                  <?php
                }
                ?>
                </ul>
            <?php
            }
            $is_privileged = $this->m_users->is_privileged('general_dc_report', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('general_dc_report', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
            ?>
            <li class="sub-menu <?=(isset($activeTab) && $activeTab=='general_dc_report')?'active':'';?>">
                <a class="" href="javascript:;">
                    <i class="icon-dashboard"></i>
                    <span>General DC Report</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                <?php
                $is_privileged = $this->m_users->is_privileged('itemstockRegister', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('itemstockRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='itemstockRegister')?'active':'';?>"><a class="" href="<?=base_url()?>general_dc_report/itemstockRegister">General Stock Register</a></li>
                  <?php
                }                        ?>
                </ul>
            </li>
            <?php
            }
            ?>
            <?php
            $is_privileged = $this->m_users->is_privileged('users', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('users', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='user')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-user"></i>
                      <span>Users</span>
                      <span class="arrow"></span>
                      <span class="label label-danger pull-right mail-info"><?=sizeof($this->m_users->getallusers()); ?></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('addnew', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('addnew', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='adduser')?'active':'';?>"><a class="" href="<?=base_url()?>users/addnew">Add User</a></li>
                      <?php
                    }
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='createcustomerlogin')?'active':'';?>"><a class="" href="<?=base_url()?>users/createcustomerlogin">Create Cust Login</a></li>
                      <li class="<?=($activeItem=='listusers')?'active':'';?>"><a class="" href="<?=base_url()?>users">Users List</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('marketing', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('marketing', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='marketing')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-user"></i>
                      <span>Marketing</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('manageAppointments', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('manageAppointments', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='manageAppointments')?'active':'';?>"><a class="" href="<?=base_url()?>marketing/manageAppointments">Add Appointment</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dailyPlans', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dailyPlans', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dailyPlans')?'active':'';?>"><a class="" href="<?=base_url()?>marketing/dailyPlans">Daily Plans</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('addVisitDetails', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('addVisitDetails', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='addVisitDetails')?'active':'';?>"><a class="" href="<?=base_url()?>marketing/addVisitDetails">Add Visit Details</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('targetSalesReceipt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('targetSalesReceipt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='targetSalesReceipt')?'active':'';?>"><a class="" href="<?=base_url()?>marketing/targetSalesReceipt">Collection Budget</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('salesBudget', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('salesBudget', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='salesBudget')?'active':'';?>"><a class="" href="<?=base_url()?>marketing/salesBudget">Sales Budget</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('masters', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('masters', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='masters')?'active':'';?>">
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
                    $is_privileged = $this->m_users->is_privileged('request_form', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('request_form', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='request_form')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/request_form">Request Form</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('customerGroup', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('customerGroup', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='customerGroup')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/customerGroup">Customer Group</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('customers', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('customers', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='customers')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/customers">Customers</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('supplierGroup', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('supplierGroup', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='supplierGroup')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/supplierGroup">Supplier Group</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('suppliers', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('suppliers', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='suppliers')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/suppliers">Suppliers</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('deniermaster', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('deniermaster', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_manu_active && $is_admin) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='deniermaster')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/deniermaster">Denier Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('colorfamily', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('colorfamily', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='colorfamily')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/colorfamily">Color Family</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('shades', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('shades', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='color_category')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/color_category">Color Category</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('shades', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('shades', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='shades')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/shades">Color Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('weavemaster_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('weavemaster_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='weavemaster_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/weavemaster_2">Weave Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dc_family', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dc_family', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dc_family')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/dc_family">Dyes family Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyes_chemicals', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyes_chemicals', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyes_chemicals')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/dyes_chemicals">Dyes &amp; Chemicals</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('recipemaster', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('recipemaster', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='recipemaster')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/recipemaster">Recipe Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('machines', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('machines', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='machines')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/machines">Machine Prefix</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('lots', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('lots', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='lots')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/lots">Dyeing Lot Master</a></li>
                      <?php
                    }                                $is_privileged = $this->m_users->is_privileged('uoms', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('uoms', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='uoms')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/uoms">Unit of measurement</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('tax', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('tax', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='tax')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/tax">Tax</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('othercharges', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('othercharges', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='othercharges')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/othercharges">Other Charges</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('tareweights', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('tareweights', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='tareweights')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/tareweights">Tare Weight</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('agents', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('agents', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='agents')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/agents">Agents</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('itemgroups', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('itemgroups', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='itemgroups')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/itemgroups">Item Groups</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('items', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('items', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='items')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/items">Items</a></li>                                <?php
                    }

                    // Tabs And Elastics
                    $is_privileged = $this->m_users->is_privileged('machines_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('machines_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='machines_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/machines_2">Machine Master</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('shades_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('shades_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='shades_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/shades_2">Shade Master</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('stockrooms_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stockrooms_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='stockrooms_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/stockrooms_2">Stock Rooms</a></li>                                <?php
                    }
                    // Labels
                    $is_privileged = $this->m_users->is_privileged('machines_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('machines_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='machines_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/machines_2">Machine Master</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('departments_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('departments_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='departments_1')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/departments_1">Departments</a></li>                                <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
                $is_privileged = $this->m_users->is_privileged('poy', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('poy', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='poy')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>POY</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('poydenier', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poydenier', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poydenier')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/poydenier">POY Dn Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('poy_lots', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_lots', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_lots')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/poy_lots">POY Lot Master</a></li>
                      <?php
                    }
					
					
					
					
					
                    $is_privileged = $this->m_users->is_privileged('yarndenier', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_inward', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='yarndenier')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/yarndenier">Yarn Dn Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('yarn_lots', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_issue', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='yarn_lots')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/yarn_lots">Yarn Lot Master</a></li>
                      <?php
                    }					
					
					
					
					
					
                    $is_privileged = $this->m_users->is_privileged('po_issue', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_issue', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_issue')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/po_issue">PO Issue To Supplier</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('poy_inward', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_inward', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_inward')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/poy_inward">POY Inward</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('poy_issue', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_issue', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_issue')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/poy_issue">POY Issue</a></li>
                      <?php
                    }

                    /*
                    $is_privileged = $this->m_users->is_privileged('poy_accept', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_accept', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_accept')?'active':'';?>"><a class="" href="<?=base_url(); ?>deliveryaccept/poy_accept">POY Acceptance</a></li>
                      <?php
                    }*/

                    $is_privileged = $this->m_users->is_privileged('yarn_delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('yarn_delivery', 'upriv_function', $this->session->userdata('user_viewed'));



                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>


                      <li class="<?=($activeItem=='poy_delivery')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/wpoy_delivery">W.POY delivery</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('yarn_delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('yarn_delivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>



                      <li class="<?=($activeItem=='yarn_delivery')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/yarn_delivery">Yarn Delivery</a></li>
                      <?php
                    }




                    $is_privileged = $this->m_users->is_privileged('wpoy_acceptance', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('wpoy_acceptance', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>

                      <li class="<?=($activeItem=='wpoy_acceptance')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/wpoy_acceptance">W.POY Acceptance</a></li>
                      <?php
                    }                      


                    $is_privileged = $this->m_users->is_privileged('pyarn_acceptance', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('pyarn_acceptance', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>

                      <li class="<?=($activeItem=='pyarn_acceptance')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/pyarn_acceptance">P.Yarn Acceptance</a></li>
                      <?php
                    }










                    $is_privileged = $this->m_users->is_privileged('sales_entry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('sales_entry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sales_entry')?'active':'';?>"><a class="" href="<?=base_url(); ?>poy/sales_entry">Sales Entry</a></li>
                      <?php
                    }                                ?>

                  </ul>
                </li>
                <?php
              }
            $is_privileged = $this->m_users->is_privileged('deliveryaccept', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('deliveryaccept', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='deliveryaccept')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>Delivery Accept</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('poy_accept', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_accept', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_accept')?'active':'';?>"><a class="" href="<?=base_url(); ?>deliveryaccept/poy_accept">POY Acceptance</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
            <?php
            }
            $is_privileged = $this->m_users->is_privileged('item_masters', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('item_masters', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='item_masters')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>Item Master</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('itemgroups_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('itemgroups_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='itemgroups_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/itemgroups_2">Item Group</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('items_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('items_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='items_2')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/items_2">Item Master</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('items_2_technical', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('items_2_technical', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='items_2_technical')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/items_2_technical">Technical Master</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('items_2_view', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('items_2_view', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='items_2_view')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/items_2_view">View Items</a></li>                                <?php
                    }
                    // Labels
                    $is_privileged = $this->m_users->is_privileged('itemgroups_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('itemgroups_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='itemgroups_3')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/itemgroups_3">Item Group</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('items_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('items_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='items_3')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/items_3">Item Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('item_size_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('item_size_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='item_size_3')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/item_size_3">Item Size Master</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('item_technical_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('item_technical_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='item_technical_3')?'active':'';?>"><a class="" href="<?=base_url(); ?>masters/item_technical_3">Item Technical Master</a></li>
                      <?php
                    }                                ?>
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('purchase', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('purchase', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='purchase')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>Purchase Orders</span>
                      <span class="arrow"></span>
                      <!-- <span class="label label-danger pull-right mail-info">0</span> -->
                  </a>
                  <ul class="sub">
                    <?php
                    /*$is_privileged = $this->m_users->is_privileged('enquiry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('enquiry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='enquiry')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/enquiry">New Enquiry</a></li>
                      <?php
                    }*/
                    /*$is_privileged = $this->m_users->is_privileged('enquiries', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('enquiries', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='enquiries')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/enquiries">Enquiries</a></li>
                      <?php
                    }*/
                    /*$is_privileged = $this->m_users->is_privileged('quotations', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('quotations', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='quotations')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/quotations">Quotation Sent</a></li>
                      <?php
                    }*/
                    /*$is_privileged = $this->m_users->is_privileged('purchaseorders', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('purchaseorders', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='neworder')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/purchaseorders">Purchase Orders</a></li>                                <?php
                    }*/
                    $is_privileged = $this->m_users->is_privileged('newenquiry_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('newenquiry_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='newenquiry_2')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/newenquiry_2">New Enquiry</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('enquiries_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('enquiries_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='enquiries_2')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/enquiries_2">Enquiries Recieved</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('quotations_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('quotations_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='quotations_2')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/quotations_2">Quotation Sent</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('purchaseorders_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('purchaseorders_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='purchaseorders_2')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/purchaseorders_2"> PO Recieved</a></li>                                <?php
                    }
                    // Labels
                    $is_privileged = $this->m_users->is_privileged('po_received_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_received_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_received_3')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/po_received_3"> PO Received</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('po_register_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_register_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_register_3')?'active':'';?>"><a class="" href="<?=base_url()?>purchase/po_register_3"> PO Register</a></li>                                <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('production', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('production', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='production')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>Production</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('joborder_custwise', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('joborder_custwise', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='joborder_custwise')?'active':'';?>"><a class="" href="<?=base_url()?>production/joborder_custwise">JOB Order (Cust.Wise)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('joborder_itemwise', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('joborder_itemwise', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='joborder_itemwise')?'active':'';?>"><a class="" href="<?=base_url()?>production/joborder_itemwise">JOB Order (Item Wise)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('jobsheet_warping', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('jobsheet_warping', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='jobsheet_warping')?'active':'';?>"><a class="" href="<?=base_url()?>production/jobsheet_warping">JOB card (Warping)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('jobsheet_ps', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('jobsheet_ps', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='jobsheet_ps')?'active':'';?>"><a class="" href="<?=base_url()?>production/jobsheet_ps">JOB card / P.S.</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('production_hrs_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('production_hrs_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='production_hrs_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/production_hrs_2">Production Entry (Hrs)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('production_e_item_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('production_e_item_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='production_e_item_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/production_e_item_2">Production Entry (Item)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('production_r_item_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('production_r_item_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='production_r_item_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/production_r_item_2">Production Rpt (Item)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('rollingentry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rollingentry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rollingentry')?'active':'';?>"><a class="" href="<?=base_url()?>production/rollingentry">Rolling Entry</a></li>                              <?php
                    }                                $is_privileged = $this->m_users->is_privileged('predelivery_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/predelivery_2">Pre Delivery</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('predelivery_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery_2_list')?'active':'';?>"><a class="" href="<?=base_url()?>production/predelivery_2_list">Pre Deliveries</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('delivery_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='delivery_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/delivery_2">Delivery</a></li>                              <?php
                    }                                /*$is_privileged = $this->m_users->is_privileged('internalpo', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('internalpo', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='internalpo')?'active':'';?>"><a class="" href="<?=base_url()?>production/internalpo">Job Card Entry</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('POrecieved', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('POrecieved', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='POrecieved')?'active':'';?>"><a class="" href="<?=base_url()?>production/POrecieved">Job Cards Receive</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('processcard', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('processcard', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='processcard')?'active':'';?>"><a class="" href="<?=base_url()?>production/processcard">Process Card</a></li>                              <?php
                    }                                $is_privileged = $this->m_users->is_privileged('predelivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery')?'active':'';?>"><a class="" href="<?=base_url()?>production/predelivery">Pre Delivery</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='delivery')?'active':'';?>"><a class="" href="<?=base_url()?>production/delivery">Delivery</a></li>                              <?php
                    }*/
                    $is_privileged = $this->m_users->is_privileged('prod_entry_operator_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('prod_entry_operator_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='prod_entry_operator_3')?'active':'';?>"><a class="" href="<?=base_url()?>production/prod_entry_operator_3">Prod. Entry Operator</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('roll_entry_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('roll_entry_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='roll_entry_3')?'active':'';?>"><a class="" href="<?=base_url()?>production/roll_entry_3">Roll Entry</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('packing_entry_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packing_entry_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packing_entry_3')?'active':'';?>"><a class="" href="<?=base_url()?>production/packing_entry_3">Packing Entry</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('packing_entry_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packing_entry_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='final_packing_entry_3')?'active':'';?>"><a class="" href="<?=base_url()?>production/final_packing_entry_3">Final Packing Entry</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('predelivery_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery_3')?'active':'';?>"><a class="" href="<?=base_url()?>production/predelivery_3">Pre Delivery</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('predelivery_3_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery_3_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery_3_list')?'active':'';?>"><a class="" href="<?=base_url()?>production/predelivery_3_list">Edit Pre Delivery</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('delivery_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='delivery_3')?'active':'';?>"><a class="" href="<?=base_url()?>production/delivery_3">Delivery</a></li>                              <?php
                    }
                    /*$is_privileged = $this->m_users->is_privileged('salesentry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('salesentry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sales')?'active':'';?>"><a class="" href="<?=base_url()?>sales/salesentry">Sales Entry</a></li>                              <?php
                    }*/

                    $is_privileged = $this->m_users->is_privileged('rpt_delivery_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rpt_delivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rpt_delivery_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/rpt_delivery_3">Deliveries</a></li>
                      <?php
                    }
                    ?>
                      <!-- <li class="<?=($activeItem=='salesreturn')?'active':'';?>"><a class="" href="<?=base_url()?>sales/salesentry">Sales Return</a></li> -->
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('production', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('production', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='purchase_order')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-dropbox"></i>
                      <span>Puchase Order</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php                                $is_privileged = $this->m_users->is_privileged('po_from_customers', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_from_customers', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_from_customers')?'active':'';?>"><a class="" href="<?=base_url()?>purchase_order/po_from_customers">PO from Customers</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('po_to_dye', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_to_dye', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_to_dye')?'active':'';?>"><a class="" href="<?=base_url()?>purchase_order/po_to_dye">PO issued to Dyeing</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('po_dyeing_production', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_dyeing_production', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_dyeing_production')?'active':'';?>"><a class="" href="<?=base_url()?>purchase_order/po_dyeing_production">Dyeing Production</a></li>
					          <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('po_DLCPacking', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_DLCPacking', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_DLCPacking')?'active':'';?>"><a class="" href="<?=base_url()?>purchase_order/po_DLCPacking">Dyed L.C Packing</a></li>
					          <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('po_DLCDelivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('po_DLCDelivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='po_DLCDelivery')?'active':'';?>"><a class="" href="<?=base_url()?>purchase_order/po_DLCDelivery">Dyed L.C delivery</a></li>
					          <?php 
            				}
                    $is_privileged = $this->m_users->is_privileged('dyes_chem_inward', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyes_chem_inward', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyes_chem_inward')?'active':'';?>"><a class="" href="<?=base_url()?>purchase_order/dyes_chem_inward">Dyes Chemical Inward</a></li>
                      <?php
                    }
            				?>
                  </ul>
              </li>
			       <!--   end of ak side bar -->
             <?php
            }
            $is_privileged = $this->m_users->is_privileged('production', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('production', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='packing')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-dropbox"></i>
                      <span>Packing</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('packingentry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packingentry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packingentry')?'active':'';?>"><a class="" href="<?=base_url()?>production/packingentry">Packing Entry</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('packingreport', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packingreport', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packingreport')?'active':'';?>"><a class="" href="<?=base_url()?>production/packingreport">Packing Items</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('innerbox_packing', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('innerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='innerbox_packing')?'active':'';?>"><a class="" href="<?=base_url()?>production/innerbox_packing">Inner Box Pack (Roll)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('innerbox_packing_pcs', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('innerbox_packing_pcs', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='innerbox_packing_pcs')?'active':'';?>"><a class="" href="<?=base_url()?>production/innerbox_packing_pcs">Inner Box Pack (Pcs)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('outerbox_packing', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('outerbox_packing', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='outerbox_packing')?'active':'';?>"><a class="" href="<?=base_url()?>production/outerbox_packing">Outer Box Packing</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('outerbox_pack_without_ib', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('outerbox_pack_without_ib', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='outerbox_pack_without_ib')?'active':'';?>"><a class="" href="<?=base_url()?>production/outerbox_pack_without_ib">Outer Pack (no inner)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('outerbox_pack_kgs', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('outerbox_pack_kgs', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='outerbox_pack_kgs')?'active':'';?>"><a class="" href="<?=base_url()?>production/outerbox_pack_kgs">Outer Box (Kgs)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('outerBoxQtyWise_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('outerBoxQtyWise_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='outerBoxQtyWise_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/outerBoxQtyWise_2">Outer Box - Qty wise</a></li>                              <?php
                    }
                    /*$is_privileged = $this->m_users->is_privileged('zip_outerbox', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('zip_outerbox', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='zip_outerbox')?'active':'';?>"><a class="" href="<?=base_url()?>production/zip_outerbox">Zip Outerbox</a></li>                              <?php
                    }*/
                    $is_privileged = $this->m_users->is_privileged('print_box_sticker_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('print_box_sticker_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='print_box_sticker_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/print_box_sticker_2">Print Box Sticker</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('print_item_sticker_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('print_item_sticker_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='print_item_sticker_2')?'active':'';?>"><a class="" href="<?=base_url()?>production/print_item_sticker_2">Print Item Sticker</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('matetailReturened', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('matetailReturened', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='matetailReturened')?'active':'';?>"><a class="" href="<?=base_url()?>packing/matetailReturened">Material Returned</a></li>                              <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('lot_form', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('lot_form', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='lot_form')?'active':'';?>"><a class="" href="<?=base_url('directpack/lot_form')?>">Direct Lot Entry</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('packing_entry', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packing_entry', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='direct_packing')?'active':'';?>"><a class="" href="<?=base_url('directpack/packing_entry')?>">Direct Packing Entry</a></li>                              <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('reports', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('reports', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='reports')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-dropbox"></i>
                      <span>Reports</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('packingRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packingRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packingRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/packingRegister_1">Packing Register</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('custPackRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custPackRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custPackRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custPackRegister_1">Cust.Item Packing Reg</a></li>
                      <?php
                    }
					
					/*legrand charles (yarn and thread) */
					/* deleted boxes register */
					$is_privileged = $this->m_users->is_privileged('deletedboxRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('deletedboxRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='deletedboxRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/deletedboxRegister_1">Deleted Boxes </a></li>
                      <?php
                    }
					
					/* delivery register date and item wise */
					        /*$is_privileged = $this->m_users->is_privileged('itemdeliveryRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('itemdeliveryRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='itemdeliveryRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/itemdeliveryRegister_1">Item Delivery Register</a></li>
                      <?php
                    }*/
					
					/* delivery register date and customer wise */
					$is_privileged = $this->m_users->is_privileged('custdeliveryRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custdeliveryRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custdeliveryRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custdeliveryRegister_1">Cust.Item Delivery Reg</a></li>
                      <?php
                    }
					
					/* invoice register date and item wise */
					/*$is_privileged = $this->m_users->is_privileged('iteminvoiceRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('iteminvoiceRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='iteminvoiceRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/iteminvoiceRegister_1">Item Invoice Register</a></li>
                      <?php
                    }*/
					
					/* invoice register date and customer wise */
					         $is_privileged = $this->m_users->is_privileged('custinvoiceRegister_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custinvoiceRegister_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custinvoiceRegister_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custinvoiceRegister_1">Cust.Item Invoice Reg</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('cust_sales_register_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_sales_register_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_sales_register_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/cust_sales_register_1">Customer Sales Reg</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('stock_register_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stock_register_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='stock_register_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/stock_register_1">Stock Register</a></li>
                      <li class="<?=($activeItem=='stock_register_2')?'active':'';?>"><a class="" href="<?=base_url()?>reports/stock_register_m">Stock Register(As On)</a></li>

                    <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('stock_register_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stock_register_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                    

                      <?php
                    }
					
					/*legrand charles (yarn and thread) */
					
                    $is_privileged = $this->m_users->is_privileged('packingRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packingRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packingRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/packingRegister">Packing Register</a></li>
                      <?php
                    }
					
					/* legrand charles (tapes and elastic) */
					 $is_privileged = $this->m_users->is_privileged('custPackRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custPackRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custPackRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custPackRegister">Cust.Item Packing Reg</a></li>
                      <?php
                    }
					
					/* deleted boxes register */
					$is_privileged = $this->m_users->is_privileged('deletedboxRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('deletedboxRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='deletedboxRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/deletedboxRegister">Deleted Boxes</a></li>
                      <?php
                    }
					
					/* delivery register date and item wise */
					/*$is_privileged = $this->m_users->is_privileged('itemdeliveryRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('itemdeliveryRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='itemdeliveryRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/itemdeliveryRegister">Item Delivery Register</a></li>
                      <?php
                    }*/
					
					/* delivery register date and customer wise */
					$is_privileged = $this->m_users->is_privileged('custdeliveryRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custdeliveryRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custdeliveryRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custdeliveryRegister">Cust.Item Delivery Reg</a></li>
                      <?php
                    }
					
					/* invoice register date and item wise */
					/*$is_privileged = $this->m_users->is_privileged('iteminvoiceRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('iteminvoiceRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='iteminvoiceRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/iteminvoiceRegister">Item Invoice Register</a></li>
                      <?php
                    }*/
					
					/* invoice register date and customer wise */
					         $is_privileged = $this->m_users->is_privileged('custinvoiceRegister', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custinvoiceRegister', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custinvoiceRegister')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custinvoiceRegister">Cust.Item Invoice Reg</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('cust_sales_register_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_sales_register_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_sales_register_2')?'active':'';?>"><a class="" href="<?=base_url()?>reports/cust_sales_register_2">Customer Sales Reg</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('stock_register_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stock_register_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='stock_register_2')?'active':'';?>"><a class="" href="<?=base_url()?>reports/stock_register_2">Stock Register</a></li>
                      <?php
                    }
					
					/* legrand charles (tapes and elastic) */
					
					
                    $is_privileged = $this->m_users->is_privileged('rpt_predelivery_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rpt_predelivery_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rpt_predelivery_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/rpt_predelivery_1">Pre Deliveries</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('tpt_delivery_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('tpt_delivery_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='tpt_delivery_1')?'active':'';?>"><a class="" href="<?=base_url()?>reports/tpt_delivery_1">Deliveries</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('rpt_predelivery_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rpt_predelivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rpt_predelivery_2')?'active':'';?>"><a class="" href="<?=base_url()?>reports/rpt_predelivery_2">Pre Deliveries</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('rpt_delivery_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rpt_delivery_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rpt_delivery_2')?'active':'';?>"><a class="" href="<?=base_url()?>reports/rpt_delivery_2">Deliveries</a></li>
                      <?php
                    }
                    
					
					/* legrand charles (labels) */
					$is_privileged = $this->m_users->is_privileged('packingRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packingRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packingRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/packingRegister_3">Packing Register</a></li>
                      <?php
                    }
					
					 $is_privileged = $this->m_users->is_privileged('custPackRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custPackRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custPackRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custPackRegister_3">Cust.Item Packing Reg</a></li>
                      <?php
                    }
					
					/* deleted boxes register */
					$is_privileged = $this->m_users->is_privileged('deletedboxRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('deletedboxRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='deletedboxRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/deletedboxRegister_3">Deleted Boxes</a></li>
                      <?php
                    }
					
					/* delivery register date and item wise */
					/*$is_privileged = $this->m_users->is_privileged('itemdeliveryRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('itemdeliveryRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='itemdeliveryRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/itemdeliveryRegister_3">Item Delivery Register</a></li>
                      <?php
                    }*/
					
					/* delivery register date and customer wise */
					$is_privileged = $this->m_users->is_privileged('custdeliveryRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custdeliveryRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custdeliveryRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custdeliveryRegister_3">Cust.Item Delivery Reg</a></li>
                      <?php
                    }
					
					/* invoice register date and item wise */
					/*$is_privileged = $this->m_users->is_privileged('iteminvoiceRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('iteminvoiceRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='iteminvoiceRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/iteminvoiceRegister_3">Item Invoice Register</a></li>
                      <?php
                    }*/
					
					/* invoice register date and customer wise */
					         $is_privileged = $this->m_users->is_privileged('custinvoiceRegister_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('custinvoiceRegister_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='custinvoiceRegister_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/custinvoiceRegister_3">Cust.Item Invoice Reg</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('cust_sales_register_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_sales_register_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_sales_register_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/cust_sales_register_3">Customer Sales Reg</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('stock_register_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stock_register_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='stock_register_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/stock_register_3">Stock Register</a></li>
                      <?php
                    }
					
					/* legrand charles (labels) */
					
					
					$is_privileged = $this->m_users->is_privileged('rpt_predelivery_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rpt_predelivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rpt_predelivery_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/rpt_predelivery_3">Pre Deliveries</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('rpt_delivery_3', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rpt_delivery_3', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='rpt_delivery_3')?'active':'';?>"><a class="" href="<?=base_url()?>reports/rpt_delivery_3">Deliveries</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('recipe_register', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('recipe_register', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='recipe_register')?'active':'';?>"><a class="" href="<?=base_url()?>reports/recipe_register">Recipe Register</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyes_cost_reg', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyes_cost_reg', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyes_cost_reg')?'active':'';?>"><a class="" href="<?=base_url()?>reports/dyes_cost_reg">Dyes Cost Reg</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyes_stock_reg', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyes_stock_reg', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyes_stock_reg')?'active':'';?>"><a class="" href="<?=base_url()?>reports/dyes_stock_reg">Dyes Stock Reg</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('poy_gain_report', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_gain_report', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_gain_report')?'active':'';?>"><a class="" href="<?=base_url()?>reports/poy_gain_report">POY Gain Report</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            //Dynamic Dost 3.0
            // MIR Reports
            $is_privileged = $this->m_users->is_privileged('mir_reports', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('mir_reports', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='mir_reports')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-dropbox"></i>
                      <span>MIR Reports</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    //Customer Wise Sales Reports
                    $is_privileged = $this->m_users->is_privileged('cust_sales_report_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_sales_report_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_sales_report_2')?'active':'';?>"><a class="" href="<?=base_url()?>mir_reports/cust_sales_report_2">C S R</a></li>                                <?php
                    }
                     //Item Wise Sales Reports
                    $is_privileged = $this->m_users->is_privileged('item_sales_report_2', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('item_sales_report_2', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='item_sales_report_2')?'active':'';?>"><a class="" href="<?=base_url()?>mir_reports/item_sales_report_2">I S R</a></li>                                <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            //end of dynamic dost3.0
            $is_privileged = $this->m_users->is_privileged('stock', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('stock', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='stock')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>Stock Transfer</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('gy_transfer', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('gy_transfer', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='gy_transfer')?'active':'';?>"><a class="" href="<?=base_url(); ?>stock/gy_transfer">Gray Yarn Trans</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
            <?php
            }

            $is_privileged = $this->m_users->is_privileged('delivery', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('delivery', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='delivery')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-truck"></i>
                      <span>Delivery</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('gray_yarn_soft_delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('gray_yarn_soft_delivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='gray_yarn_soft_delivery')?'active':'';?>"><a class="" href="<?=base_url(); ?>delivery/gray_yarn_soft_delivery">Gray Yarn Soft DC</a></li>
                      <?php
                    }
                    /*$is_privileged = $this->m_users->is_privileged('gray_yarn_soft_dc_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('gray_yarn_soft_dc_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='gray_yarn_dc_list')?'active':'';?>"><a class="" href="<?=base_url(); ?>delivery/gray_yarn_dc_list">Print Gray Yarn DC</a></li>
                      <?php
                    }*/

                    $is_privileged = $this->m_users->is_privileged('predelivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery')?'active':'';?>"><a class="" href="<?=base_url(); ?>delivery/predelivery">Pre Delivery</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('predelivery_1_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery_1_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery_1_list')?'active':'';?>"><a class="" href="<?=base_url(); ?>delivery/predelivery_1_list">Pre Deliveries</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('delivery_1', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery_1', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='delivery_1')?'active':'';?>"><a class="" href="<?=base_url(); ?>delivery/delivery_1">Delivery</a></li>
                      <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('delivery_1_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery_1_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='delivery_1_list')?'active':'';?>"><a class="" href="<?=base_url(); ?>delivery/delivery_1_list">Deliveries</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
            <?php
            }

            $is_privileged = $this->m_users->is_privileged('store', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('store', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='store')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class=" icon-shopping-cart"></i>
                      <span>Packing &amp; Poy Dept</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('poy_store', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_store', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_store')?'active':'';?>"><a class="" href="<?=base_url()?>store/poy_store">POY Stock</a></li>                
					          <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('poy_physical_stock', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_physical_stock', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_physical_stock')?'active':'';?>"><a class="" href="<?=base_url(); ?>store/poy_physical_stock">POY Physical Stock</a></li>
                      <?php
                    }
					          $is_privileged = $this->m_users->is_privileged('porecieved', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('porecieved', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='porecieved')?'active':'';?>"><a class="" href="<?=base_url()?>store/porecieved">PO Received</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('wastage', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('wastage', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='wastage')?'active':'';?>"><a class="" href="<?=base_url()?>store/wastage">Wastage POY</a></li>                              <?php
                    }
                    /*$is_privileged = $this->m_users->is_privileged('poy_sales', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('poy_sales', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='poy_sales')?'active':'';?>"><a class="" href="<?=base_url()?>store/poy_sales">POY Sales</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('polyster_yarn', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('polyster_yarn', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='polyster_yarn')?'active':'';?>"><a class="" href="#">POLYSTER Yarn</a></li>                              <?php
                    }*/
                    $is_privileged = $this->m_users->is_privileged('gray_yarn_soft', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('gray_yarn_soft', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='gray_yarn_soft')?'active':'';?>"><a class="" href="<?=base_url()?>store/gray_yarn_soft">Gray Yarn Soft Packing</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('gray_yarn_packing', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('gray_yarn_packing', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='gray_yarn_packing')?'active':'';?>"><a class="" href="<?=base_url()?>store/gray_yarn_packing">Gray Yarn Packing</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyed_yarn_packing', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyed_yarn_packing', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyed_yarn_packing')?'active':'';?>"><a class="" href="<?=base_url()?>store/dyed_yarn_packing">Dyed Yarn Packing</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyed_thread_inner', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyed_thread_inner', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyed_thread_inner')?'active':'';?>"><a class="" href="<?=base_url()?>store/dyed_thread_inner">Dyed Thread inner</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyed_thread_outer', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyed_thread_outer', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyed_thread_outer')?'active':'';?>"><a class="" href="<?=base_url()?>store/dyed_thread_outer">Dyed Thread outer</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('dyed_thread_packing', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('dyed_thread_packing', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='dyed_thread_packing')?'active':'';?>"><a class="" href="<?=base_url()?>store/dyed_thread_packing">Dyed Thread Packing</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('sales_return_box', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('sales_return_box', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sales_return_box')?'active':'';?>"><a class="" href="<?=base_url()?>store/sales_return_box">Sales Return (Box)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('sales_return_item', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('sales_return_item', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sales_return_item')?'active':'';?>"><a class="" href="<?=base_url()?>store/sales_return_item">Sales Return (Item)</a></li>                              <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('stockissue', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stockissue', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='stockissue')?'active':'';?>"><a class="" href="<?=base_url()?>store/stockissue">Stock Issue</a></li>                              <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }
            $is_privileged = $this->m_users->is_privileged('sales', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('sales', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_manu_active && $is_admin) || $is_privileged)
            {
            ?>
            <li class="sub-menu <?=(isset($activeTab) && $activeTab=='sales')?'active':'';?>">
                <a class="" href="javascript:;">
                    <i class="icon-bar-chart"></i>
                    <span>Sales</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                <?php
                $is_privileged = $this->m_users->is_privileged('create_invoice_1', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('create_invoice_1', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='create_invoice_1')?'active':'';?>"><a class="" href="<?=base_url()?>sales/create_invoice_1">Create Invoice</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('invoices_1', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('invoices_1', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='invoices_1')?'active':'';?>"><a class="" href="<?=base_url()?>sales/invoices_1">Print Invoices</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('proforma_invoices_1', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('proforma_invoices_1', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='proforma_invoices_1')?'active':'';?>"><a class="" href="<?=base_url()?>sales/proforma_invoices_1">Proforma Invoices</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('create_invoice_2', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('create_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='create_invoice_2')?'active':'';?>"><a class="" href="<?=base_url()?>sales/create_invoice_2">Create Invoice</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('create_invoice_2', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('create_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='invoices_2')?'active':'';?>"><a class="" href="<?=base_url()?>sales/invoices_2">Print Invoice</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('create_invoice_2', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('create_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='proforma_invoices_2')?'active':'';?>"><a class="" href="<?=base_url()?>sales/proforma_invoices_2">Proforma Invoices</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('cash_invoice_2', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('cash_invoice_2', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='cash_invoice_2')?'active':'';?>"><a class="" href="<?=base_url()?>sales/cash_invoice_2">Cash Invoices</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('packing_slip_2', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('packing_slip_2', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='packing_slip_2')?'active':'';?>"><a class="" href="<?=base_url()?>sales/packing_slip_2">Packing Slip</a></li>
                  <?php
                }
                // Labels
                $is_privileged = $this->m_users->is_privileged('create_invoice_3', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('create_invoice_3', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='create_invoice_3')?'active':'';?>"><a class="" href="<?=base_url()?>sales/create_invoice_3">Create Invoice</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('invoices_3', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('invoices_3', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='invoices_3')?'active':'';?>"><a class="" href="<?=base_url()?>sales/invoices_3">Print Invoice</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('proforma_invoices_3', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('proforma_invoices_3', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='proforma_invoices_3')?'active':'';?>"><a class="" href="<?=base_url()?>sales/proforma_invoices_3">Proforma Invoice</a></li>
                  <?php
                }
                $is_privileged = $this->m_users->is_privileged('job_work_invoice', 'upriv_function', $logged_user_id);
                $is_manu_active = $this->m_users->is_manu_active('job_work_invoice', 'upriv_function', $this->session->userdata('user_viewed'));
                if(($is_manu_active && $is_admin) || $is_privileged)
                {
                  ?>
                  <li class="<?=($activeItem=='job_work_invoice')?'active':'';?>"><a class="" href="<?=base_url()?>sales/job_work_invoice">Job Work Invoices</a></li>
                  <?php
                }
                ?>
                </ul>
            </li>
            <?php
            }
            // Start Shop Estimate
            $is_privileged = $this->m_users->is_privileged('shop', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('shop', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='shop')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-briefcase"></i>
                      <span>Branch</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('stocktrans', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('stocktrans', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='stocktrans')?'active':'';?>"><a class="" href="<?=base_url(); ?>shop/stocktrans">Stock Trans(In group)</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('accept_dc', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('accept_dc', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='accept_dc')?'active':'';?>"><a class="" href="<?=base_url(); ?>shop/stocktrans/accept_dc">Accept Stock Trans</a></li>
                      <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('packing', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('packing', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='packing')?'active':'';?>"><a class="" href="<?=base_url()?>shop/packing">Br.Packing Entry</a></li>                                <?php
                    }

                    $is_privileged = $this->m_users->is_privileged('predelivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predelivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='predelivery')?'active':'';?>"><a class="" href="<?=base_url()?>shop/predelivery">Br.Pre Delivery</a></li>                                <?php
                    }
                    ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('predc_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predc_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='predc_list')?'active':'';?>">
                      <a href="<?php echo base_url('shop/predelivery/predc_list'); ?>">Print Pre-DC</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('predc_edit', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('predc_edit', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='predc_edit')?'active':'';?>">
                      <a href="<?php echo base_url('shop/predelivery/predc_edit'); ?>">Edit Pre-DC</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('delivery_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='delivery_list')?'active':'';?>">
                      <a href="<?php echo base_url('shop/delivery/delivery_list'); ?>">Print DC</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('cash_inv_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cash_inv_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='cash_inv_list')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/cash_inv_list'); ?>">Print Cash Invoice</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('quotation_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('quotation_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='quotation_list')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/quotation_list'); ?>">Print Enquiry</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('credit_inv_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('credit_inv_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='credit_inv_list')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/credit_inv_list'); ?>">Print Credit Invoice</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('create_cr_invoice', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('create_cr_invoice', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='create_cr_invoice')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/create_cr_invoice'); ?>">Create Credit Invoice</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('cash_receipt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cash_receipt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='cash_receipt')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/cash_receipt'); ?>">Cash Receipt</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('credit_receipt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('credit_receipt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='credit_receipt')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/credit_receipt'); ?>">Credit Voucher</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('debit_receipt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('debit_receipt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='debit_receipt')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/debit_receipt'); ?>">Debit Voucher</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('scrap_sales', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('scrap_sales', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='scrap_sales')?'active':'';?>">
                      <a href="<?php echo base_url('shop/scrapsales'); ?>">CLQ Sales</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('scrap_inv_list', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('scrap_inv_list', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='scrap_inv_list')?'active':'';?>">
                      <a href="<?php echo base_url('shop/scrapsales/scrap_inv_list'); ?>">Print CLQ Sales</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('cash_recpt_delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cash_recpt_delivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?php echo ($activeItem == 'cash_recpt_delivery')?'active':'';?>">
                      <a href="<?php echo base_url('shop/cashreceipts/cash_recpt_delivery'); ?>">Cash Trans Cash Recpt</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('cash_inv_delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cash_inv_delivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?php echo ($activeItem == 'cash_inv_delivery')?'active':'';?>">
                      <a href="<?php echo base_url('shop/cashinvoice/cash_inv_delivery'); ?>">Cash Trans Cash Inv</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('quotation_delivery', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('quotation_delivery', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?php echo ($activeItem == 'quotation_delivery')?'active':'';?>">
                      <a href="<?php echo base_url('shop/quotation/quotation_delivery'); ?>">Cash Trans Enqries</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('rate_master', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('rate_master', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='rate_master')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/rate_master'); ?>">Rate Master</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('general_rate_master', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('general_rate_master', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged):
                    ?>
                    <li class="<?=($activeItem=='general_rate_master')?'active':'';?>">
                      <a href="<?php echo base_url('shop/sales/general_rate_master'); ?>">General Rate Master</a>
                    </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('inward', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('inward', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='inward')?'active':'';?>"><a class="" href="<?=base_url()?>estimate/inward">Inward Entry</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('inward_register', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('inward_register', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='inward_register')?'active':'';?>"><a class="" href="<?=base_url()?>estimate/inward_register">Inward Register</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('estimate', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('estimate', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='estimate')?'active':'';?>"><a class="" href="<?=base_url()?>estimate">Target</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('estimate_reg', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('estimate_reg', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='estimate_reg')?'active':'';?>"><a class="" href="<?=base_url()?>estimate/estimate_reg">Target Register</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('cust_item_est_reg', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_item_est_reg', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_item_est_reg')?'active':'';?>"><a class="" href="<?=base_url()?>estimate/cust_item_est_reg">Cust.Item Target Reg</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('estimate_report', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('estimate_report', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='estimate_report')?'active':'';?>"><a class="" href="<?=base_url()?>estimate/estimate_report">Target Report</a></li>
                      <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }

            $is_privileged = $this->m_users->is_privileged('shop', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('shop', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='shop_registers')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-briefcase"></i>
                      <span>Branch Registers</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('pre_delivery_boxes', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('pre_delivery_boxes', 'upriv_function', $this->session->userdata('user_viewed'));
                    ?>
                    <?php if(($is_admin) || $is_privileged): ?>
                        <li class="<?php echo ($activeItem == 'pre_delivery_boxes')?'active':'';?>">
                            <a href="<?php echo base_url('shop/registers/pre_delivery_boxes'); ?>">Pre Delivery Boxes</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('delivery_boxes', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('delivery_boxes', 'upriv_function', $this->session->userdata('user_viewed'));
                    ?>
                    <?php if(($is_admin) || $is_privileged): ?>
                        <li class="<?php echo ($activeItem == 'delivery_boxes')?'active':'';?>">
                            <a href="<?php echo base_url('shop/registers/delivery_boxes'); ?>">Delivery Boxes</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('cash_inv_boxes', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cash_inv_boxes', 'upriv_function', $this->session->userdata('user_viewed'));
                    ?>
                    <?php if(($is_admin) || $is_privileged): ?>
                        <li class="<?php echo ($activeItem == 'cash_inv_boxes')?'active':'';?>">
                            <a href="<?php echo base_url('shop/registers/cash_inv_boxes'); ?>">Cash Inv Boxes</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('credit_inv_boxes', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('credit_inv_boxes', 'upriv_function', $this->session->userdata('user_viewed'));
                    ?>
                    <?php if(($is_admin) || $is_privileged): ?>
                        <li class="<?php echo ($activeItem == 'credit_inv_boxes')?'active':'';?>">
                            <a href="<?php echo base_url('shop/registers/credit_inv_boxes'); ?>">Credit Inv Boxes</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $is_privileged = $this->m_users->is_privileged('enquiry_boxes', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('enquiry_boxes', 'upriv_function', $this->session->userdata('user_viewed'));
                    ?>
                    <?php if(($is_admin) || $is_privileged): ?>
                        <li class="<?php echo ($activeItem == 'enquiry_boxes')?'active':'';?>">
                            <a href="<?php echo base_url('shop/registers/enquiry_boxes'); ?>">Enquiry Boxes</a>
                        </li>
                    <?php endif; ?>
                  </ul>
              </li>
              <?php
            }                  // End Shop Estimate
            $is_privileged = $this->m_users->is_privileged('accounts', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('accounts', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='accounts')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-briefcase"></i>
                      <span>Accounts</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <li><a href="<?php echo base_url('accounts/print_cash_receipt'); ?>">Cash Receipt</a></li>
                    <li><a href="<?php echo base_url('accounts/print_cheque_receipt'); ?>">Credit Voucher</a></li>
                    <li><a href="<?php echo base_url('accounts/print_disc_voucher'); ?>">Debit Voucher</a></li>
                    <?php
                    $is_privileged = $this->m_users->is_privileged('cust_statement_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_statement_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_statement_yt')?'active':'';?>"><a class="" href="<?=base_url()?>accounts/cust_statement_yt">Cust.Acc Statement</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('cust_payment_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_payment_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_payment_yt')?'active':'';?>"><a class="" href="<?=base_url()?>accounts/cust_payment_yt">Cust.Bill Payment</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('cust_payments_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_payments_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_payments_yt')?'active':'';?>"><a class="" href="<?=base_url()?>accounts/cust_payments_yt">Cust.Payment Reg</a></li>                                <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }

            // Reques Form
            $is_privileged = $this->m_users->is_privileged('request_form', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('request_form', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='request_form')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-briefcase"></i>
                      <span>Request Form</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('send_req_email', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('send_req_email', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='send_req_email')?'active':'';?>"><a class="" href="<?=base_url()?>request_form/send_req_email">Send Cust Email</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('sale_tax_email_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('sale_tax_email_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sale_tax_email_yt')?'active':'';?>"><a class="" href="<?=base_url()?>request_form/sale_tax_email_yt">Sale Tax Email</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('sale_tax_email_te', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('sale_tax_email_te', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sale_tax_email_te')?'active':'';?>"><a class="" href="<?=base_url()?>request_form/sale_tax_email_te">Sale Tax Email</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('sale_tax_email_lbl', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('sale_tax_email_lbl', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='sale_tax_email_lbl')?'active':'';?>"><a class="" href="<?=base_url()?>request_form/sale_tax_email_lbl">Sale Tax Email</a></li>                                <?php
                    }
                    ?>
                  </ul>
              </li>
              <?php
            }

            // Reques Form
            $is_privileged = $this->m_users->is_privileged('registers', 'upriv_controller', $logged_user_id);
            $is_manu_active = $this->m_users->is_manu_active('registers', 'upriv_controller', $this->session->userdata('user_viewed'));
            if(($is_admin && $is_manu_active) || $is_privileged)
            {
              ?>
              <li class="sub-menu <?=(isset($activeTab) && $activeTab=='registers')?'active':'';?>">
                  <a href="javascript:;" class="">
                      <i class="icon-briefcase"></i>
                      <span>Registers</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                    <?php
                    $is_privileged = $this->m_users->is_privileged('deleted_box_reg_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('deleted_box_reg_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='deleted_box_reg_yt')?'active':'';?>"><a class="" href="<?=base_url()?>registers/deleted_box_reg_yt">Deleted Boxes Reg</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('cust_item_est_reg_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('cust_item_est_reg_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='cust_item_est_reg_yt')?'active':'';?>"><a class="" href="<?=base_url()?>registers/cust_item_est_reg_yt">Cust.Item.Sales Reg</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('item_rate_reg_yt', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('item_rate_reg_yt', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='item_rate_reg_yt')?'active':'';?>"><a class="" href="<?=base_url()?>registers/item_rate_reg_yt">Item Rate Reg</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('general_party_reg', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('general_party_reg', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='general_party_reg')?'active':'';?>"><a class="" href="<?=base_url()?>registers/general_party_reg">Gen.Party Master</a></li>                                <?php
                    }
                    $is_privileged = $this->m_users->is_privileged('material_inw_reg', 'upriv_function', $logged_user_id);
                    $is_manu_active = $this->m_users->is_manu_active('material_inw_reg', 'upriv_function', $this->session->userdata('user_viewed'));
                    if(($is_admin && $is_manu_active) || $is_privileged)
                    {
                      ?>
                      <li class="<?=($activeItem=='material_inw_reg')?'active':'';?>"><a class="" href="<?=base_url()?>registers/material_inw_reg">Material Inw.Reg</a></li>                                <?php
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
else
{
  ?>
  <aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="sub-menu <?=(isset($activeTab) && $activeTab=='customer')?'active':'';?>">
              <a href="javascript:;" class="">
                  <i class=" icon-shopping-cart"></i>
                  <span>Customer</span>
                  <span class="arrow"></span>
              </a>
              <ul class="sub">
                <li class=""><a class="" href="#">PO Status</a></li>
                <li class=""><a class="" href="#">Job Order Status</a></li>
                <li class=""><a class="" href="#">Dispatch Details</a></li>
                <li class="<?=($activeItem=='change_cust_password')?'active':'';?>"><a class="" href="<?=base_url(); ?>users/change_cust_password">Change Password</a></li>
              </ul>
          </li>          </ul>
    </div>
  </aside>
  <?php
}
?>
<!--sidebar end-->