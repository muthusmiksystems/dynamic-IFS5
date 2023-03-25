<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Customer_purchase_order extends CI_Controller
{
    public $data = array();
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->helper('url');
        $this->load->helper('string');
        $this->load->model('m_users');
        $this->load->model('m_masters');
        $this->load->model('m_purchase');
        $this->load->model('m_production');
        $this->load->model('m_general');
        $this->load->model('ak');
        $this->load->model('m_mycart'); //lbl PO & PS
        $this->load->model('m_mir'); //lbl PO & PS
        $this->load->model('m_admin'); //lbl PO & PS
        $this->load->library('cart');

        if (!$this->session->userdata('logged_in')) {
            // Allow some methods?
            $allowed = array();
            if (!in_array($this->router->method, $allowed)) {
                redirect(base_url() . 'users/login', 'refresh');
            }
        }
    }

    function po_from_customers_items_by_module($id = null)
    {
        if ($id == "") {
            return;
        }

        $data = '';
        if ($id == 1) {
            $data = $this->m_masters->getallitemmasteractive('bud_items');
        } else if ($id == 2) {
            $data = $this->m_masters->getallitemmasteractive('bud_te_items');
        } else if ($id == 3) {
            $data = $this->m_masters->getallitemmasteractive('bud_lbl_items');
        } else if ($id == 4) {
            $data = $this->m_masters->getallitemmasteractive('bud_te_items');
        }
        echo json_encode($data);
    }

    function set_assets_paths()
    {
        $data['css'] = array(
            'css/bootstrap.min.css',
            'css/bootstrap-reset.css',
            'assets/font-awesome/css/font-awesome.css',
            'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
            'css/owl.carousel.css',
            'css/style.css',
            'css/select2.css',
            'css/style-responsive.css',
            'assets/data-tables/jquery.dataTables.min.css',
            'assets/data-tables/select.dataTables.min.css',
            'assets/bootstrap-datepicker/css/datepicker.css'
        );
        $data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
        $data['js'] = array(
            'js/jquery.js',
            'js/jquery-1.8.3.min.js',
            'js/select2.js',
            'js/bootstrap.min.js',
            'js/jquery.scrollTo.min.js',
            'js/jquery.nicescroll.js',
            'js/bootstrap-switch.js',
            'js/jquery.tagsinput.js',
            'js/jquery.sparkline.js',
            'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js',
            'js/owl.carousel.js',
            'js/jquery.customSelect.min.js',
            'assets/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'assets/bootstrap-daterangepicker/date.js',
            'assets/bootstrap-daterangepicker/daterangepicker.js',
            'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
            'js/jquery.validate.min.js',
            'assets/data-tables/jquery.dataTables.min.js',
            'assets/data-tables/dataTables.select.min.js',
            'assets/data-tables/DT_bootstrap.js'
        );
        $data['js_common'] = array('js/common-scripts.js');
        $data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');

        return $data;
    }

    function po_from_customers_enquiry()
    {
        $next = $this->db->query("SHOW TABLE STATUS LIKE 'dost_customers_po_enquiry'");
        $next = @$next->row(0);

        $data = $this->set_assets_paths();

        $data['next'] = @$next->Auto_increment;

        if ($this->session->userdata('logged_as') == 'user') {
            $data['activeItem'] = 'po_from_customers_enquiry';
            $data['page_title'] = 'Add Stock PO';
            $data['page_heading'] = 'Add PO For Factory Stock';
        } else {
            $data['activeItem'] = 'po_from_customers_enquiry';
            $data['page_title'] = 'PO enquiry receipt from online customer';
            $data['page_heading'] = 'PO enquiry receipt from online customer';
        }

        $data['activeTab'] = 'po';
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();
        $data['table'] = $this->ak->ak_po_from_customers();

        $this->session->set_userdata('cimages', array());

        $this->load->view('po_from_customers_enquiry', $data);
    }

    function po_from_customers_enquiry_save()
    {
        if (!empty($_FILES['file']['name'])) {
            $this->load->library('upload');
            $this->load->library('image_lib');
            $imagePath  = realpath(APPPATH . '../uploads/customeritems');
            $rand       = random_string('alnum', 16);
          

            $config = array(
                'file_name'     => $rand,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 3000,
                'overwrite'     => FALSE,
                'upload_path'   => $imagePath
            );

            //Load upload library
            //$this->load->library('upload', $config);
            $this->upload->initialize($config);

            // File upload
            if ($this->upload->do_upload('file')) {
                // Get data about the file
                $uploadData = $this->upload->data();
                $myImg      = $uploadData['file_name'];
                $cimages    = $this->session->userdata('cimages');
                array_push($cimages, $myImg);
                $this->session->set_userdata('cimages', $cimages);
            }

            $config = array(
                'file_name'     => 'sx_' . $rand,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 3000,
                'overwrite'     => FALSE,
                'upload_path'   => $imagePath
            );

            //Load upload library
            $this->upload->initialize($config);

            // File upload
            if ($this->upload->do_upload('file')) {
                // Get data about the file
                $uploadData = $this->upload->data();
                $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $uploadData['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'width'           =>  116,
                    'height'          =>  116,
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
            }

            print_r($this->session->userdata('cimages'));
        } else {
            $data = array(
                'cust_id' => $this->input->post('cust_id'),
                'module_id' => intval(str_replace('d', '',$this->input->post('module_id'))),
                'item_id' => $this->input->post('item_id'),
                'cust_item_name' => $this->input->post('cust_item_name'),
                'cust_color_name' => $this->input->post('cust_color_name'),
                'shade_id' => $this->input->post('shade_id'),
                'po_qty' => $this->input->post('po_qty'),
                'po_uom' => $this->input->post('po_uom'),
                'po_price' => $this->input->post('po_price'),
                'po_need_date' => date("Y-m-d H:i:s", strtotime($this->input->post('po_need_date'))),
                'remarks' => $this->input->post('remarks'),
                'cust_staff_name' => $this->input->post('cust_staff_name'),
                'cust_staff_mobile' => $this->input->post('cust_staff_mobile'),
                'cust_staff_email' => $this->input->post('cust_staff_email'),
                'cimages' => implode(', ', $this->session->userdata('cimages')),
                'status' => 1,
                'date' => date("Y-m-d H:i:s")
               
            );
           
           
            if (!empty($this->input->post('company_stock_active'))) {
                $data['company_stock_active'] = $this->input->post('company_stock_active');
            }
            $this->ak->insert_new('dost_customers_po_enquiry', $data);

            $this->session->set_flashdata('success', 'Dear Customer, Greetings from Dynamic Dost. Thanks for giving us this purchase order enquiry. Our marketting staff will be in contact with you soon.');
            redirect(base_url() . 'customer_purchase_order/po_from_customers_enquiry_list', 'refresh');
        }
    }

    function po_from_customers_enquiry_update($poeno)
    {
        $data = array(
            'cust_id' => $this->input->post('cust_id'),
            'module_id' => $this->input->post('module_id'),
            'item_id' => $this->input->post('item_id'),
            'cust_item_name' => $this->input->post('cust_item_name'),
            'cust_color_name' => $this->input->post('cust_color_name'),
            'shade_id' => $this->input->post('shade_id'),
            'po_qty' => $this->input->post('po_qty'),
            'po_uom' => $this->input->post('po_uom'),
            'po_price' => $this->input->post('po_price'),
            'po_need_date' => date("Y-m-d H:i:s", strtotime($this->input->post('po_need_date'))),
            'remarks' => $this->input->post('remarks'),
            'cust_staff_name' => $this->input->post('cust_staff_name'),
            'cust_staff_mobile' => $this->input->post('cust_staff_mobile'),
            'cust_staff_email' => $this->input->post('cust_staff_email'),
            'status' => 1,
            'user' => $this->session->userdata('display_name'),
            'updated' => date("Y-m-d H:i:s")
        );
        if (!empty($this->input->post('remarkstocust'))) {
            $data['remarkstocust'] = $this->input->post('remarkstocust');
        }
        $this->ak->update_all('dost_customers_po_enquiry', 'poeno', $poeno, $data);

        if ($this->session->userdata('logged_as') == 'customer') {
            $podata = $this->ak->get_cust_po_enquiry($poeno);
            if ($podata) {
                $podata = $podata[0];

                // $data = array(
                //     'a_poeno' => $poeno,
                //     'a_status' => 1,
                //     'a_option' => $podata['a_option'],
                //     'a_remarks' => '',
                //     'a_user' => $this->session->userdata('display_name'),
                //     'a_date' => date("Y-m-d H:i:s")
                // );
                // $a_id = $this->ak->insert_new('dost_customers_po_accept', $data);

                // $data = array(
                //     's_poeno' => $poeno,
                //     's_status' => $podata['s_status'],
                //     's_option' => $podata['s_option'],
                //     's_remarks' => '',
                //     's_user' => $this->session->userdata('display_name'),
                //     's_date' => date("Y-m-d H:i:s")
                // );
                // $s_id = $this->ak->insert_new('dost_customers_po_sample', $data);

                // $data = array(
                //     'po_accept_no' => $a_id,
                //     'po_sample_no' => $s_id,
                //     'status' => 2
                // );

                $data = array(
                    'po_accept_no' => 0,
                    'po_sample_no' => 0,
                    'po_reject_no' => 0
                );
                $this->ak->update_all('dost_customers_po_enquiry', 'poeno', $poeno, $data);
            }
        }

        $this->session->set_flashdata('success', 'Successfully Updated!!!');
        redirect(base_url() . 'customer_purchase_order/po_from_customers_enquiry_list', 'refresh');
    }

    function po_reject_no($poeno)
    {
        $podata = $this->ak->get_cust_po_enquiry($poeno);
        if ($podata) {
            $podata = $podata[0];

            $data = array(
                'r_poeno' => $poeno,
                'r_status' => 1,
                'r_option' => $this->input->post('po_reject_no'),
                'r_remarks' => $this->input->post('po_reject_remarks'),
                'r_user' => $this->session->userdata('display_name'),
                'r_date' => date("Y-m-d H:i:s")
            );
            $r_id = $this->ak->insert_new('dost_customers_po_reject', $data);

            $data = array(
                'po_reject_no' => $r_id,
                'status' => 0,
                'user' => ''
            );
            $this->ak->update_all('dost_customers_po_enquiry', 'poeno', $poeno, $data);

            $this->session->set_flashdata('success', 'PO Request Rejected Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/po_from_customers_enquiry_list', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/po_from_customers_enquiry_list', 'refresh');
    }

    function po_accept_no($poeno)
    {
        $podata = $this->ak->get_cust_po_enquiry($poeno);
        if ($podata) {
            $podata = $podata[0];

            $data = array(
                'a_poeno' => $poeno,
                'a_status' => 1,
                'a_option' => $this->input->post('po_accept_no'),
                'a_remarks' => '',
                'a_user' => $this->session->userdata('display_name'),
                'a_date' => date("Y-m-d H:i:s")
            );
           
            $a_id = $this->ak->insert_new('dost_customers_po_accept', $data);

            $data = array(
                's_poeno' => $poeno,
                's_status' => $this->input->post('po_sample_no'),
                //'s_option' => '',
                's_remarks' => '',
                's_user' => $this->session->userdata('display_name'),
                's_date' => date("Y-m-d H:i:s")
            );
            $s_id = $this->ak->insert_new('dost_customers_po_sample', $data);

            $data = array(
                'po_accept_no' => $a_id,
                'po_sample_no' => $s_id,
                'remarkstocust' => $this->input->post('remarkstocust'),
                'status' => 2
            );
            $this->ak->update_all('dost_customers_po_enquiry', 'poeno', $poeno, $data);

            if ($this->input->post('po_accept_no') != 1) {

                $data = array(
                    'date' => $podata['po_need_date'],
                    'bud_customers' => $podata['cust_id'],
                    'c_name' => $podata['cust_staff_name'],
                    'cust_epono' => $poeno,
                    'c_tel' => $podata['cust_staff_mobile'],
                    'user' => $this->session->userdata('display_name'),
                    'remark' => $podata['remarks']
                );
                $rid = $this->ak->insert_new('ak_po_from_customers', $data);

                $itms = array(
                    'R_po_no' => $rid,
                    'cust_epono' => $poeno,
                    'bud_items' => $podata['item_id'],
                    'cust_shade_name' => $podata['cust_color_name'],
                    'bud_shades' => $podata['shade_id'],
                    'qty' => $podata['po_qty'],
                    'bud_uoms' => $podata['po_uom'],
                    'rate' => $podata['po_price'],
                    'tax' => 0
                );
                $this->ak->insert_new('ak_po_from_customers_items', $itms);
            }

            $this->session->set_flashdata('success', 'PO Request Accepted Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/po_from_customers_enquiry_list', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/po_from_customers_enquiry_list', 'refresh');
    }

    function po_sample_no($poeno, $s_id)
    {
        $podata = $this->ak->get_cust_po_enquiry($poeno);
        if ($podata) {
            $podata = $podata[0];

            $items = array(
                's_poeno' => $poeno,
                's_status' => 1,
                's_option' => $this->input->post('po_sample_option'),
                's_remarks' => $this->input->post('po_sample_remarks'),
                's_user' => $this->session->userdata('display_name'),
                's_date' => date("Y-m-d H:i:s")
            );
            $this->ak->update_all('dost_customers_po_sample', 's_id', $s_id, $items);

            $this->session->set_flashdata('success', 'PO Sample Completed Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/po_sampling_queue', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/po_sampling_queue', 'refresh');
    }

    function po_sample_final_option($poeno, $s_id)
    {
        $podata = $this->ak->get_cust_po_enquiry($poeno);
        if ($podata) {
            $podata = $podata[0];

            $items = array(
                's_poeno' => $poeno,
                's_status' => $this->input->post('po_sample_final_option'),
                's_final_remarks' => $this->input->post('po_sample_final_remarks'),
                's_user' => $this->session->userdata('display_name'),
                's_date' => date("Y-m-d H:i:s")
            );
            $this->ak->update_all('dost_customers_po_sample', 's_id', $s_id, $items);

            if ($this->input->post('po_sample_final_option') == 0) {
                $data = array(
                    's_poeno' => $poeno,
                    's_status' => 1,
                    's_option' => 0,
                    's_remarks' => '',
                    's_user' => $this->session->userdata('display_name'),
                    's_date' => date("Y-m-d H:i:s")
                );
                $s_id = $this->ak->insert_new('dost_customers_po_sample', $data);

                $data = array(
                    'po_sample_no' => $s_id,
                    'status' => 2
                );
                $this->ak->update_all('dost_customers_po_enquiry', 'poeno', $poeno, $data);

                $this->session->set_flashdata('success', 'PO Sample Rejected & Sent for Re-Sampling!!!');
                redirect(base_url() . 'customer_purchase_order/po_sample_completed', 'refresh');
            }
            $this->session->set_flashdata('success', 'PO Sample Approved By Customer!!!');
            redirect(base_url() . 'customer_purchase_order/po_sample_completed', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/po_sample_completed', 'refresh');
    }

    function add_dyeing_plan()
    {
        $gpo_machine_name = $this->input->post('gpo_machine_name');
        $gpo_plan_date = $this->input->post('gpo_plan_date');
        $gpo_remarks = $this->input->post('gpo_remarks');
        $fill_qty = $this->input->post('fill_qty');

        $data = array(
            'gpo_machine_name' => $gpo_machine_name,
            'gpo_plan_date' => date("Y-m-d H:i:s", strtotime($gpo_plan_date)),
            'gpo_status' => 1,
            'gpo_remarks' => $gpo_remarks,
            'gpo_user' => $this->session->userdata('display_name'),
            'gpo_date' => date("Y-m-d H:i:s")
        );
        $gpono = $this->ak->insert_new('dost_customers_gpo', $data);

        if ($fill_qty) {
            foreach ($fill_qty as $dy_poeno => $dy_poqty) {
                $data = array(
                    'dy_gpono' => $gpono,
                    'dy_poeno' => $dy_poeno,
                    'dy_poqty' => $dy_poqty,
                    'dy_status' => 1,
                    'dy_remarks' => '',
                    'dy_user' => $this->session->userdata('display_name'),
                    'dy_date' => date("Y-m-d H:i:s")
                );
                $this->ak->insert_new('dost_customers_po_dyeplan', $data);

                $poeno = $this->ak->get_cust_po_enquiry($dy_poeno);

                $data = array(
                    'gpo_item_id' => @$poeno[0]['item_id'],
                    'gpo_shade_id' => @$poeno[0]['shade_id']
                );
                $this->ak->update_all('dost_customers_gpo', 'gpono', $gpono, $data);
            }
        }

        if ($gpono) {
            $this->session->set_flashdata('success', 'GPO Plan created Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/po_dyeing_queue', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/po_dyeing_queue', 'refresh');
    }

    function add_dyeing_lot()
    {
        $gpo_machine_name = $this->input->post('gpo_machine_name');
        $gpo_plan_date = $this->input->post('gpo_plan_date');
        $gpo_remarks = $this->input->post('gpo_remarks');
        $fill_qty = $this->input->post('fill_qty');
        $gpo_mannual_lot = $this->input->post('gpo_mannual_lot');

        $data = array(
            'gpo_status' => 2
        );
        $lot = false;
        if ($fill_qty) {
            foreach ($fill_qty as $gpono => $dyl_poqty) {

                $this->ak->update_all('dost_customers_gpo', 'gpono', $gpono, $data);

                $data = array(
                    'dyl_gpono' => $gpono,
                    'dyl_poqty' => $dyl_poqty,
                    'dyl_status' => 1,
                    'dyl_mannual_lot' => $gpo_mannual_lot,
                    'dyl_machine_name' => $gpo_machine_name,
                    'dyl_remarks' => $gpo_remarks,
                    'dyl_user' => $this->session->userdata('display_name'),
                    'dyl_date' => date("Y-m-d H:i:s")
                );
                $lot = $this->ak->insert_new('dost_customers_po_dyelot', $data);
            }
        }

        if ($lot) {
            $this->session->set_flashdata('success', 'Lot created Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/po_dyeing_plan', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/po_dyeing_plan', 'refresh');
    }

    function po_gpo_shade_edit($gpono)
    {
        if (!$gpono) {
            return false;
        }
        $gpo_shade_id = $this->input->post('filter_shade_id');

        $data = array(
            'gpo_shade_id' => $gpo_shade_id
        );

        $this->ak->update_all('dost_customers_gpo', 'gpono', $gpono, $data);

        $this->session->set_flashdata('success', 'Shade Code updated Successfully!!!');
        redirect(base_url() . 'customer_purchase_order/dyeing_lot_approval_queue', 'refresh');

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/dyeing_lot_approval_queue', 'refresh');
    }

    function po_gpo_shade_edit2($gpono)
    {
        if (!$gpono) {
            return false;
        }
        $gpo_shade_id = $this->input->post('filter_shade_id');

        $data = array(
            'gpo_shade_id' => $gpo_shade_id
        );

        $this->ak->update_all('dost_customers_gpo', 'gpono', $gpono, $data);

        $this->session->set_flashdata('success', 'Shade Code updated Successfully!!!');
        redirect(base_url() . 'customer_purchase_order/cust_lot_approval_queue', 'refresh');

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/cust_lot_approval_queue', 'refresh');
    }

    function po_gpo_lot_approve($lotno)
    {
        if (!$lotno) {
            return false;
        }
        $lot_status_option = $this->input->post('lot_status_option');
        $lot_final_option = $this->input->post('lot_final_option');
        $lot_final_remarks = $this->input->post('lot_final_remarks');

        $data = array(
            'dyla_lotno' => $lotno,
            'dyla_status' => $lot_status_option,
            'dyla_option' => $lot_final_option,
            'dyla_remarks' => $lot_final_remarks,
            'dyla_user' => $this->session->userdata('display_name'),
            'dyla_userid' => $this->session->userdata('user_id'),
            'dyla_date' => date("Y-m-d H:i:s")
        );
        $dyla_id = $this->ak->insert_new('dost_customers_po_dyelotstatus', $data);

        if ($dyla_id) {

            $approvalflag = array();
            $lotsstatus = $this->ak->dost_customers_po_dyelotstatusloop($lotno);
            if ($lotsstatus) {
                foreach ($lotsstatus as $key => $lstatus) {
                    if ($lstatus['dyla_status'] == 1) {
                        $userstatus = $this->m_users->getuserdetails($lstatus['dyla_userid']);
                        if ($userstatus) {
                            foreach ($userstatus as $key => $userarr) {
                                if ($userarr['user_category'] == 9) {
                                    $approvalflag[9] = 1;
                                } else if ($userarr['user_category'] == 10) {
                                    $approvalflag[10] = 1;
                                } else if ($userarr['user_category'] == 11) {
                                    $approvalflag[11] = 1;
                                } else if ($userarr['user_category'] == 12) {
                                    $approvalflag[12] = 1;
                                } else if ($userarr['user_category'] == 13) {
                                    $approvalflag[13] = 1;
                                } else if ($userarr['user_category'] == 20) {
                                    $approvalflag[20] = 1;
                                }
                            }
                        }
                    }
                }
            }

            if (count($approvalflag) >= 2) {
                $data = array(
                    'dyl_status' => 2
                );
                $this->ak->update_all('dost_customers_po_dyelot', 'dyl_id', $lotno, $data);
            }

            $this->session->set_flashdata('success', 'Saved Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/dyeing_lot_approval_queue', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/dyeing_lot_approval_queue', 'refresh');
    }

    function po_gpo_lot_cust_approve($lotno)
    {
        if (!$lotno) {
            return false;
        }
        $dost_lot_final_approval = $this->input->post('dost_lot_final_approval');
        $lot_final_remarks = $this->input->post('lot_final_remarks');

        $data = array(
            'dyla_lotno' => $lotno,
            'dyla_status' => $dost_lot_final_approval,
            'dyla_remarks' => $lot_final_remarks,
            'dyla_user' => $this->session->userdata('display_name'),
            'dyla_userid' => $this->session->userdata('user_id'),
            'dyla_date' => date("Y-m-d H:i:s")
        );
        $dyla_id = $this->ak->insert_new('dost_customers_po_dyelotstatus', $data);

        if ($dyla_id) {

            $approvalflag = array();
            $lotsstatus = $this->ak->dost_customers_po_dyelotstatusloop($lotno);
            if ($lotsstatus) {
                foreach ($lotsstatus as $key => $lstatus) {
                    if ($lstatus['dyla_status'] == 1) {
                        $userstatus = $this->m_users->getuserdetails($lstatus['dyla_userid']);
                        if ($userstatus) {
                            foreach ($userstatus as $key => $userarr) {
                                if ($userarr['user_category'] == 9) {
                                    $approvalflag[9] = 1;
                                } else if ($userarr['user_category'] == 10) {
                                    $approvalflag[10] = 1;
                                } else if ($userarr['user_category'] == 11) {
                                    $approvalflag[11] = 1;
                                } else if ($userarr['user_category'] == 12) {
                                    $approvalflag[12] = 1;
                                } else if ($userarr['user_category'] == 13) {
                                    $approvalflag[13] = 1;
                                } else if ($userarr['user_category'] == 20) {
                                    $approvalflag[20] = 1;
                                }
                            }
                        }
                    }
                }
            }

            if (count($approvalflag) >= 2) {
                $dyl_status = ($dost_lot_final_approval == 4) ? 1 : 3;
                $data = array(
                    'dyl_status' => $dyl_status
                );
                $this->ak->update_all('dost_customers_po_dyelot', 'dyl_id', $lotno, $data);

                if ($dost_lot_final_approval == 4) {
                    $data = array(
                        'dyla_loop' => 1
                    );
                    $this->ak->update_all('dost_customers_po_dyelotstatus', 'dyla_lotno', $lotno, $data);
                }
            }

            $this->session->set_flashdata('success', 'Saved Successfully!!!');
            redirect(base_url() . 'customer_purchase_order/cust_lot_approval_queue', 'refresh');
        }

        $this->session->set_flashdata('error', 'That action is failed, please try again!!!');
        redirect(base_url() . 'customer_purchase_order/cust_lot_approval_queue', 'refresh');
    }

    function po_from_customers_enquiry_list()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';

        $filter_from_date =date("Y-m-d", strtotime("-1 month"));
     
        $filter_to_date = date("Y-m-d", strtotime("1days"));
       
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
           
        }

        if ($this->session->userdata('logged_as') == 'user') {
            $data['activeItem'] = 'new_po';
            $data['page_title'] = 'New PO';
             $data['page_heading'] = 'PO Received From Customer Online';
            $data['table'] = $this->ak->ak_po_list_customers('', $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        } else {
            $data['activeItem'] = 'po_from_customers_enquiry_list';
            $data['page_title'] = 'PO List';
            $data['page_heading'] = 'PO List';
            $data['table'] = $this->ak->ak_po_list_customers($this->session->userdata('user_id'), $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        }
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();
       
        $this->load->view('po_from_customers_enquiry_list', $data);
    }

    function po_accepted_by_stock()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_accepted_by_stock';
        $data['page_title'] = 'PO Fm. Stock';
        $data['page_heading'] = 'PO Accepted (Delivery Fm. Ready Stock)';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_stock($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_stock_list', $data);
    }

    function po_accepted()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_accepted';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        if ($this->session->userdata('logged_as') == 'user') {
            $data['page_title'] = 'PO Accepted';
            $data['page_heading'] = 'PO Accepted';
        } else {
            $data['page_title'] = 'PO Accepted List';
            $data['page_heading'] = 'PO Accepted List';
        }
        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_stock_list', $data);
    }

    function po_sampling_queue()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_sampling_queue';
        $data['page_title'] = 'PO Sampling Queue';
        $data['page_heading'] = 'PO Sampling Queue';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_sampling($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_sampling_list', $data);
    }

    function po_sample_completed()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_sample_completed';
        $data['page_title'] = 'PO Sample Completed';
        $data['page_heading'] = 'PO Sample Completed & Pending for Customer Approval';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_sampling_completed($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_sampling_list', $data);
    }

    function po_sample_approved_by_customer()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_sample_approved_by_customer';
        $data['page_title'] = 'PO Sample Approved By Customer';
        $data['page_heading'] = 'PO Sample Approved By Customer, Final Sample Report';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_sampling_final($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_stock_list', $data);
    }

    function po_dyeing_queue()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_dyeing_queue';
        $data['page_title'] = 'PO Dyeing Queue';
        $data['page_heading'] = 'PO Dyeing Queue';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing_queue($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_dyeing_list', $data);
    }

    function po_dyeing_plan()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_dyeing_plan';
        $data['page_title'] = 'GPO Dyeing Plan';
        $data['page_heading'] = 'GPO Dyeing Plan';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['machines'] = $this->m_masters->getallmcmasteractive('bud_machines');
        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing_plan($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_dyeing_plan', $data);
    }

    function gpo_details($gpono)
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'gpo_details';
        $data['page_title'] = 'GPO Detail';
        $data['page_heading'] = 'GPO Detail';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['machines'] = $this->m_masters->getallmcmasteractive('bud_machines');
        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing_plan_by_gpo($gpono, $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_dyeing_gpo_details', $data);
    }

    function dyeing_lot_approval_queue()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'dyeing_lot_approval_queue';
        $data['page_title'] = 'D Prod. Completed';
        $data['page_heading'] = 'D Production Completed & Lot Approval By Supervisor & Production Head';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['machines'] = $this->m_masters->getallmcmasteractive('bud_machines');
        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing_plan($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_dyeing_process', $data);
    }

    function cust_lot_approval_queue()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'cust_lot_approval_queue';
        $data['page_title'] = 'Lot Final Approval By Customer';
        $data['page_heading'] = 'Lot Final Approval By Customer';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['machines'] = $this->m_masters->getallmcmasteractive('bud_machines');
        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing_plan($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_dyeing_approve', $data);
    }

    function po_lot_report()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_lot_report';
        $data['page_title'] = 'Lot Final Report';
        $data['page_heading'] = 'D Production Lot Final Report';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        $data['machines'] = $this->m_masters->getallmcmasteractive('bud_machines');
        $data['table'] = $this->ak->ak_po_list_accepted_customers_by_dyeing_plan($filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_dyeing_report', $data);
    }

    function po_rejected()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_rejected';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {

            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        if ($this->session->userdata('logged_as') == 'user') {
            $data['page_title'] = 'PO Rejected';
            $data['page_heading'] = 'PO Rejected';
            $data['table'] = $this->ak->ak_po_list_rejected_customers('', $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        } else {
            $data['page_title'] = 'PO Rejected List';
            $data['page_heading'] = 'PO Rejected List';
            $data['table'] = $this->ak->ak_po_list_rejected_customers($this->session->userdata('user_id'), $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        }
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_reject_list', $data);
    }

    function po_pending()
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_pending';

        $filter_from_date = '';
        $filter_to_date = '';
        $cust_id = '';
        $module_id = '';
        $item_id = '';
        $shade_id = '';
        if (isset($_POST['filter'])) {
            $data['filter'] = array(
                'filter_from_date' => $this->input->post('filter_from_date'),
                'filter_to_date' => $this->input->post('filter_to_date'),
                'filter_cust_id' => $this->input->post('filter_cust_id'),
                'filter_module_id' => $this->input->post('filter_module_id'),
                'filter_item_id' => $this->input->post('filter_item_id'),
                'filter_shade_id' => $this->input->post('filter_shade_id')
            );

            $filter_from_date = date("Y-m-d", strtotime($this->input->post('filter_from_date')));
            $filter_to_date = date("Y-m-d", strtotime($this->input->post('filter_to_date') . "1days"));
            $cust_id = $this->input->post('filter_cust_id');
            $module_id = $this->input->post('filter_module_id');
            $item_id = $this->input->post('filter_item_id');
            $shade_id = $this->input->post('filter_shade_id');
        }

        if ($this->session->userdata('logged_as') == 'user') {
            $data['page_title'] = 'PO Pending';
            $data['page_heading'] = 'PO Pending';
            $data['table'] = $this->ak->ak_po_list_rejected_customers('', $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        } else {
            $data['page_title'] = 'PO In Lab Sample';
            $data['page_heading'] = 'PO Pending (In Lab Sampling)';
            $data['table'] = $this->ak->ak_po_list_rejected_customers($this->session->userdata('user_id'), $filter_from_date, $filter_to_date, $cust_id, $module_id, $item_id, $shade_id);
        }
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_stock_list', $data);
    }

    function po_from_customers_enquiry_details($poeno)
    {
        $data = $this->set_assets_paths();
        $data['activeTab'] = 'po';
        $data['activeItem'] = 'po_from_customers_enquiry_details';
        if ($this->session->userdata('logged_as') == 'user') {
            $data['page_title'] = 'View PO Status & Details';
            $data['page_heading'] = 'View PO Status & Details';
        } else {
            $data['page_title'] = 'View PO Status & Details';
            $data['page_heading'] = 'View PO Status & Details';
        }
        $data['table'] = $this->ak->get_cust_po_enquiry($poeno);
        $data['customers'] = $this->m_masters->getallmaster('bud_customers');
        $data['items'] = $this->m_masters->getallitemmasteractive('bud_items');
        $data['uoms'] = $this->m_masters->getallmaster('bud_uoms');
        $data['shades'] = $this->m_masters->getallmasteractive('bud_shades');
        $data['categories'] = $this->m_masters->getallcategories();

        $this->load->view('po_from_customers_enquiry_details', $data);
    }

    public function fileUpload()
    {
        if (!empty($_FILES['file']['name'])) {
            $this->load->library('upload');
            $this->load->library('image_lib');
            $imagePath  = realpath(APPPATH . '../uploads/customeritems');
            $rand       = random_string('alnum', 16);

            $config = array(
                'file_name'     => $rand,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 3000,
                'overwrite'     => FALSE,
                'upload_path'   => $imagePath
            );

            //Load upload library
            //$this->load->library('upload', $config);
            $this->upload->initialize($config);

            // File upload
            if ($this->upload->do_upload('file')) {
                // Get data about the file
                $uploadData = $this->upload->data();
            }

            $config = array(
                'file_name'     => 'sx_' . $rand,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 3000,
                'overwrite'     => FALSE,
                'upload_path'   => $imagePath
            );

            //Load upload library
            $this->upload->initialize($config);

            // File upload
            if ($this->upload->do_upload('file')) {
                // Get data about the file
                $uploadData = $this->upload->data();
                $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $uploadData['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'width'           =>  116,
                    'height'          =>  116,
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
            }
        }
    }
}
