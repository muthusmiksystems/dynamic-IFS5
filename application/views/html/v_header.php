<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
    </div>
    <!--logo start-->
    <!-- <a href="#" class="logo hidden-phone">Dynamic<span> Dost</span></a> -->
    <!--logo end-->

    <!-- Start Logged Module -->
    <style>
        .dropbtn {
            background-color: red;
            color: white;
            padding: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown2 {
            float: left;
            margin-right: 10px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
    <?php
    $user_viewed = $this->session->userdata('user_viewed');
    $is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
    ?>
    <?php
    if ($user_viewed == 1) {
    ?>
        <a href="<?= base_url(); ?>" class="logo"><span>M1-Yarn &amp; Thread</span></a>
    <?php
    } elseif ($user_viewed == 2) {
    ?>
        <a href="<?= base_url(); ?>" class="logo"><span>M2-Tapes &amp; Zippers</span></a>
    <?php
    } elseif ($user_viewed == 3) {
    ?>
        <a href="<?= base_url(); ?>" class="logo"><span>M3-Labels</span></a>
    <?php
    } elseif ($user_viewed == 4) {
    ?>
        <a href="<?= base_url(); ?>" class="logo"><span>M4-Zippers</span></a>
    <?php
    } else {
    ?>
        <a href="<?= base_url(); ?>" class="logo">Dynamic<span> Dost</span></a>
    <?php
    }
    ?>
    <?php
    if ($this->session->userdata('logged_as') == 'user') {
    ?>
        <!-- End Logged Module -->
        <div class="nav notify-row hidden-phone" id="top_menu">
            <?php if ($is_admin) { ?>
                <div class="dropdown dropdown2">
                    <button class="dropbtn">V</button>
                    <div class="dropdown-content">
                        <a href="<?= base_url(); ?>dashboard/categorieshome/1"><span>M1-Yarn &amp; Thread</span></a>
                        <a href="<?= base_url(); ?>dashboard/categorieshome/2"><span>M2-Tapes &amp; Zippers</span></a>
                        <a href="<?= base_url(); ?>dashboard/categorieshome/3"><span>M3-Labels</span></a>
                        <a href="<?= base_url(); ?>dashboard/categorieshome/4"><span>M4-Zippers</span></a>
                    </div>
                </div>
            <?php } ?>
            <!--  notification start -->
            <ul class="nav top-menu">
                <!-- settings start -->
                <?php
                $this->load->model('shop/Stocktrans_model');
                $filter = array();
                $filter['transfer_status'] = 1;
                $filter['from_user_id'] = $this->session->userdata('user_id');
                $filter['to_user_id'] = $this->session->userdata('user_id');
                $pending_sh_dc = $this->Stocktrans_model->get_stocktransfer_list($filter, true);
                ?>
                <li class="dropdown">
                    <a target="_blank" href="<?php echo base_url('shop/stocktrans/accept_dc/1'); ?>">
                        Pending STDC
                        <span class="badge bg-success"><?php echo sizeof($pending_sh_dc); ?></span>
                    </a>
                </li>
                <?php
                $this->load->model('shop/Cashinvoice_model');
                $pending_c_i_trans = $this->Cashinvoice_model->get_transfer_list(array('pending_only' => true));
                ?>
                <li class="dropdown">
                    <a target="_blank" href="<?php echo base_url('shop/cashinvoice/pending_cash_trans'); ?>">
                        Pending C Invoices
                        <span class="badge bg-success"><?php echo sizeof($pending_c_i_trans); ?></span>
                    </a>
                </li>
                <?php
                $this->load->model('shop/Cashreceipts_model');
                $pending_c_r_trans = $this->Cashreceipts_model->get_transfer_list(array('pending_only' => true));
                ?>
                <li class="dropdown">
                    <a target="_blank" href="<?php echo base_url('shop/cashreceipts/pending_cash_trans'); ?>">
                        Pending C Receipts
                        <span class="badge bg-success"><?php echo sizeof($pending_c_r_trans); ?></span>
                    </a>
                </li>
                <?php
                $this->load->model('shop/Quotation_model');
                $pending_quote_trans = $this->Quotation_model->get_transfer_list(array('pending_only' => true));
                ?>
                <li class="dropdown">
                    <a target="_blank" href="<?php echo base_url('shop/quotation/pending_cash_trans'); ?>">
                        Pending Enquiries
                        <span class="badge bg-success"><?php echo sizeof($pending_quote_trans); ?></span>
                    </a>
                </li>

                <?php
                $is_privileged = $this->m_users->is_privileged('predelivery', 'upriv_function', $this->session->userdata('user_id'));
                $is_manu_active = $this->m_users->is_manu_active('predelivery', 'upriv_function', $this->session->userdata('user_viewed'));
                if (($is_admin && $is_manu_active) || $is_privileged) : ?>
                    <li class="dropdown">
                        <a target="_blank" class="" href="<?= base_url() ?>shop/predelivery">Br.Pre Delivery</a>
                    </li>
                <?php endif; ?>
                <li class="dropdown">
                    <a target="_blank" class="" href="#">Pending GDC</a>
                </li>
                <?php
                if ($user_viewed == 1) {
                ?>
                    <li class="dropdown">
                        <a target="_blank" class="" href="<?= base_url('delivery/predelivery'); ?>">Pre Delivery</a>
                    </li>
                <?php
                } elseif ($user_viewed == 2) {
                ?>
                    <li class="dropdown">
                        <a target="_blank" class="" href="<?= base_url('production/predelivery_2'); ?>">Pre Delivery</a>
                    </li>
                <?php
                } elseif ($user_viewed == 3) {
                ?>
                    <li class="dropdown">
                        <a target="_blank" class="" href="<?= base_url('production/predelivery_3'); ?>">Pre Delivery</a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="dropdown">
                        <?php
                        $pending_delivery = $this->m_masters->getactivemaster('bud_te_delivery', 'invoice_status');
                        ?>
                        <a target="_blank" href="<?= base_url(); ?>sales/create_invoice_2">
                            Pending DC
                            <span class="badge bg-success"><?= sizeof($pending_delivery); ?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <?php
                        $count_pi = $this->m_masters->getactivemaster('bud_te_proforma_invoices', 'invoice_status');
                        ?>
                        <a target="_blank" href="<?= base_url(); ?>sales/proforma_invoices_2">
                            Pending PI
                            <span class="badge bg-success"><?= sizeof($count_pi); ?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <?php
                        $count_stock_trans = $this->m_general->pendingDcCount();
                        ?>
                        <a target="_blank" href="<?= base_url(); ?>general/generalDcAcceptance" title="Stock Transfer Pending">
                            <i class="icon-truck"></i>
                            <span class="badge bg-success"><?= $count_stock_trans; ?></span>
                        </a>
                    </li>
                <?php
                }
                ?>
                <!-- notification dropdown end -->
            </ul>
            <!--  notification end -->
        </div>
    <?php } ?>
    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!-- <li>
                <input type="text" class="form-control search" placeholder="Search">
            </li> -->
            <!-- user login dropdown start-->
            <?php
            if ($this->session->userdata('logged_in') == true) {
                $user_photo = $this->m_masters->getmasterIDvalue('bud_users', 'ID', $this->session->userdata('user_id'), 'user_photo');
            ?>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <?php
                        if ($user_photo != '') {
                        ?>
                            <img alt="" src="<?= base_url() ?>uploads/users/<?= $user_photo; ?>" width="30" height="30">
                        <?php
                        } else {
                        ?>
                            <img alt="" src="<?= base_url() ?>themes/default/img/avatar-blank.jpg" width="30" height="30">
                        <?php
                        }
                        ?>
                        <span class="username"><?= $this->session->userdata('display_name'); ?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <!-- <li><a href="#"><i class=" icon-suitcase"></i>Profile</a></li>
                        <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
                        <li><a href="#"><i class="icon-bell-alt"></i> Notification</a></li> -->
                        <li><a href="<?= base_url() ?>users/logout"><i class="icon-key"></i> Log Out</a></li>
                    </ul>
                </li>
            <?php
            }
            ?>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>