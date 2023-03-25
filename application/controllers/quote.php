<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quote extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('ML_dyeing', 'user');
        error_reporting(0);
        $this->load->model('ML_knitting', 'user');

        $this->load->model('ML_quote', 'quote');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->load->view('quote/sperate_quote');
    }
    public function load()
    {
        $this->load->view('quote/sperate_quote', $data);
    }
    function load_item_json()
    {

        $data = $this->user->get_table_data('bud_lbl_items', null, null, null, null);
        $item = array();
        foreach ($data as $row) {
            $item[] = $row['item_name'];
            //$item[] = $row['item_code'].' / '.$row['item_name'];
        }
        echo implode(',', $item);
    }
    function load_cust()
    {
        $data = $this->user->get_table_data('bud_customers', null, null, null, null);
        echo "<option value=''>Choose Customer</option>";
        foreach ($data as $row) {
            echo "<option value='" . $row['cust_id'] . "'>" . $row['cust_name'] . "</option>";
        }
    }
    function load_cust2()
    {
        $data = $this->user->get_table_data('tbl_vendor', null, null, null, null);
        echo "<option value=''>Choose Customer</option>";
        foreach ($data as $row) {
            echo "<option value='" . $row['id'] . "'>" . $row['cname'] . "</option>";
        }
    }
    function load_item_detail()
    {
        $val = $this->input->post('id');
        $user_viewed = $this->session->userdata('user_viewed');
        if ($user_viewed == 1) {
            $data = $this->user->get_table_data('bud_items', null, 'item_id', $val, null);
        }
        if ($user_viewed == 2) {
            $data = $this->user->get_table_data('bud_te_items', null, 'item_id', $val, null);
        }
        if ($user_viewed == 3) {
            $data = $this->user->get_table_data('bud_lbl_items', null, 'item_id', $val, null);
        }
        if (count($data) > 0) {
            $path = '';
            $user_viewed = $this->session->userdata('user_viewed');
            if ($user_viewed != 3) {
                $path = base_url('uploads/itemsamples');
            } else {
                $path = base_url('uploads/itemsamples/labels');
            }
            $umo = $this->user->get_table_data('bud_uoms', null, 'uom_id', $data[0]['item_uom'], 'uom_name');
            echo $data[0]['item_id'] . '&&' . $data[0]['direct_sales_rate'] . '&&' . $data[0]['hsn_code'] . '&&' . $path . '/' . $data[0]['item_sample'] . '&&' . $data[0]['item_tax'] . '&&' . $data[0]['item_uom'] . '&&' . $umo;
        } else {
            echo 0;
        }
    }
    function find_dc()
    {
        $where['job_type'] = 'Quote';
        $where['branch'] = $this->input->post('id');
        $ai = $this->quote->get_no($where);
        foreach ($ai as $a) {
            $count = $a['auto'];
        }
        echo ++$count;
    }
    function sale_outward()
    {
        $where['job_type'] = 'Quote';
        $where['branch'] = $this->input->post('branch');
        $ai = $this->quote->get_no($where);
        foreach ($ai as $a) {
            $count = $a['auto'];
        }

        $add = array(
            'count_value' => ++$count,
            'job_type' => 'Quote',
            'branch'  => $this->input->post('branch'),
            'added_user' => $this->session->userdata('user_id'),
            'added_date' => date('d/m/y h:i:s')
        );
        $this->db->insert('tbl_bill', $add);

        //echo '<pre>'.json_encode($this->input->post(),JSON_PRETTY_PRINT).'</pre>';
        if ($this->input->post('custom_type') == 1) {
            $cust =  $this->user->get_table_data('bud_customers', null, 'cust_id', $this->input->post('cname'), null);
            //bud_customers is from customer master in quotation
            $name = $cust[0]['cust_name'];
            $add = $cust[0]['cust_address'];
            $phn = $cust[0]['cust_phone'];
            $email = $cust[0]['cust_email'];
            $gst = $cust[0]['cust_gst'];
        } else {
            $cust =  $this->user->get_table_data('tbl_vendor', null, 'id', $this->input->post('cname'), null);
            //tbl_vendor new customer in quotation
            $name = $cust[0]['cname'];
            $add = $cust[0]['caddress'];
            $phn = $cust[0]['phn_no'];
            $email = $cust[0]['email'];
            $gst = $cust[0]['gst_no'];

            //var_dump($cust);
        }

        $pid = '';
        if (!empty(@$this->uri->segment(3))) {
            $pid = $this->uri->segment(3);
            if (@$this->uri->segment(4) == 'duplicate') {
                $pid = '';
            } else {
                $pid = $this->uri->segment(3);
            }
        }

        $array = array(
            'id' => $pid,
            'bill_no' => $count,
            'quote_type' => $this->session->userdata('user_viewed'),
            'bill_date' => date("Y-m-d"),
            'branch'  => $this->input->post('branch'),
            'cname'  => $name,
            'caddress'  => $add,
            'phone'  => $phn,
            'gstno'  => $gst,
            'email'  => $email,
            'cust_type' => $this->input->post('custom_type'),
            'sale_type'  => '1',
            'cust_id'  => $this->input->post('cname'),
            'total_qty' => $this->input->post('total_qty'),
            'general' => htmlentities($this->input->post('general')),
            'remarks' => htmlentities($this->input->post('remarks')),
            'payment' => htmlentities($this->input->post('payment')),
            'delivery' => htmlentities($this->input->post('delivery')),
            'cash_mode' => $this->input->post('cash_mode'),
            'deliver_date' => $this->input->post('deliver_date'),
            'request_by' => $this->input->post('request_by'),
            'added_user_id'  => $this->session->userdata('user_id'),
            'added_user'  => $this->session->userdata('user_name'),
            'added_date' => date('Y-m-d')
        );

        if ($pid != '') {
            $this->db->where('id', $pid);
            $this->db->update('tbl_quote', $array);
        } else {
            $this->db->insert('tbl_quote', $array);
            $pid = $this->db->insert_id();
        }

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $p_id = $this->input->post('p_id');
        $hsn = $this->input->post('hsn');
        $rate = $this->input->post('rate');
        $qty = $this->input->post('qty');
        $tax = $this->input->post('tax');
        $image = $this->input->post('image');
        $umo_id = $this->input->post('umo_id');
        $umo_name = $this->input->post('umo_name');
        $i = 0;
        foreach ($name as $row) {
            if ($qty[$i] != '' && $qty[$i] > 0) {
                $array = array(
                    'id' => $id[$i],
                    'name' => $name[$i],
                    'p_id' => $p_id[$i],
                    'purchase_id' => $pid,
                    'hsn' => $hsn[$i],
                    'tax' => $tax[$i],
                    'umo_i' => $umo_id[$i],
                    'umo_n' => $umo_name[$i],
                    'invoice_id' => $count,
                    'rate'  => $rate[$i],
                    'image'  => $image[$i],
                    'qty'  => $qty[$i],
                    'branch'  => $this->input->post('branch'),
                );

                if ($id[$i] != '') {
                    $this->db->where('id', $id[$i]);
                    $this->db->update('tbl_quote_list', $array);
                } else {
                    $this->db->insert('tbl_quote_list', $array);
                }
            }
            $i++;
        }
        //redirect('quote/print_quote/'.$pid);
        //  echo $pid;
        redirect('general_dc_report/quoteReport');
    }
    function print_quote()
    {
        $this->load->view('quote/VW_quote_print');
    }
    function add_cust()
    {
        $data = $this->input->post();

        $this->db->insert('tbl_vendor', $data);
    }
    function report()
    {
        $data['status'] = 0;
        $data['msg'] = 'New Quoatation report';
        $this->load->view('quote/VW_report', $data);
    }
    function success_report()
    {
        $data['status'] = 1;
        $data['msg'] = 'Success Quoatation report';
        $this->load->view('quote/VW_report', $data);
    }
    function cancel_report()
    {
        $data['status'] = 2;
        $data['msg'] = 'Cancel Quoatation report';
        $this->load->view('quote/VW_report', $data);
    }
    function quote_update()
    {
        $data = array(
            'remark' => htmlentities($this->input->post('remark')),
            'status' => $this->input->post('status'),
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('tbl_quote', $data);
        redirect('general_dc_report/quoteReport');
    }
    function sample_report()
    {

        $data['activeTab'] = 'general_dc_report';
        $data['activeItem'] = 'itemstockRegister';
        $data['page_title'] = 'General Item Stock Register';
        $data['stock_register'] = array();
        $data['css'] = array(
            'css/bootstrap.min.css',
            'css/bootstrap-reset.css',
            'assets/font-awesome/css/font-awesome.css',
            'assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css',
            'css/owl.carousel.css',
            'css/style.css',
            'css/select2.css',
            'css/style-responsive.css',
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
            'assets/data-tables/DT_bootstrap.js'
        );
        $data['js_common'] = array('js/common-scripts.js');
        $data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js', 'js/dynamic-table.js');
        $this->load->view('quote/VW_report', $data);
    }
    function senddEmail()
    {
        $from_email = "mariseetha19@gmail.com";
        $to_email = "mariappan@budnet.in";
        $img = base_url('uploads') . '/1.jpg';
        echo $img;

        //Load email library 
        $this->load->library('email');

        $email_setting  = array('mailtype' => 'html');
        $this->email->initialize($email_setting);

        $this->email->from($from_email, 'Mariappan');
        $this->email->to($to_email);
        $this->email->subject('Email Test');
        $this->email->message('<b>Testing the email class</b><img src="' . $img . '">');
        //$this->email->attach($img);
        $this->email->set_mailtype('html');

        //Send mail 
        if ($this->email->send())
            echo true;
        else
            $this->session->set_flashdata("email_sent", "Error in sending Email.");
        echo false;
    }
    function sendEmail()
    {
        //    	echo $this->input->post('id');
        $data = $this->user->get_table_data('tbl_quote', null, 'id', $this->input->post('id'), null);
        $purchase_list = $this->user->get_table_data('tbl_quote_list', null, 'purchase_id', $data[0]['id'], null);
        $branchdata = $this->user->get_table_data('bud_concern_master', null, null, null, null);

        $v = $data[0]['branch'];
        $current = current(array_filter($branchdata, function ($e) use ($v) {
            return $e['concern_id'] == $v;
        }));
        $branch_name =  @$current['concern_name'];

        //$from_email = "purohit.dynamic@gmail.com"; 
        $from_email = "mariappan@budnet.in";

        $to_email = $data[0]['email'];
        $img = base_url('uploads') . '/1.jpg';

        $message = "<div id='emailContent'><center><h4 style='color:red;'> Quotation Number : " . $data[0]['bill_no'] . " </h4></center><p style='font-family: Verdana;font-size: small;' contentEditable > Dear Sir.,<br><br>";

        $message .= "Greetings From <b><a style='font-size:16px;color:black'> Dynamic Dost </a>,</b> <br><br> Pls find Our Offer For the follwing Items :<br><p style='padding-left:10px !important'>";
        $ln = 1;
        foreach ($purchase_list as $row) {
            $img = $row['image'];
            //$message .= ' <br><b> '.$ln.' ) Item Name / Code :  ' .$row['name'] .'</b>';

            $message .= '<table  cellspacing="5px">';
            $message .= '<tr><th>' . $ln . ') ' . '</th><th>Item Code</th><th> : ' . $row['p_id'] . '</th></tr>';
            $message .= '<tr><th></th><th>Item Name</th><th> : ' . @explode('-', $row['name'])[0] . '</th></tr>';
            $message .= '<tr><th></th><th>Item Rate</th><th> : ' . number_format($row['rate'], 2) . ' / ' . $row['umo_n'] . '</th></tr>';
            //$message .= '<tr><th></th><th>Item UOM : '.$row['umo_n'].'</th></tr>';
            $message .= ' </table><br><b>';

            //$message .= 'Item Rate :  ' .number_format($row['rate'],2) .'</b>';
            if (strpos($img, ".jpg") !== false || strpos($img, ".png") || strpos($img, ".jpeg") !== false) {

                $message .= '<br><img src="' . $img . '" height="100" width="100"><br><br>';
            } else {
                $message .= '';
            }
            $ln++;
        }
        $message .= '</p>' . $data[0]['remarks'] . '<br>Waiting for your E-mail confirmation.<br><br>Regards,<br><b>Y.C.Purohit (Sales Head)<br>+91 93455 40123<br>reply at<br>purohit.dynamic@gmail.com<br>mahesh.dynamic@gmail.com</b><br> Issue PO. to : <br><span style="font-size: 15px;">' . $branch_name . '</span><br>Prepared By: <br>' . $this->session->userdata('display_name') . ' - ' . date("Y-m-d H:i:s");
        $message .= ' </p></div>';

        echo '<input type="text" id="subject" value="Dynamic Dost Quotation" class="form-control" required style="border:none;">';
        echo '<hr>';
        echo '<input type="text" id="email" value="' . $data[0]['email'] . '" class="form-control" required style="border:none;">';
        echo '<hr>';

        echo $message;
    }
    function confirmEmail()
    {
        $this->load->library('email');

        $email_setting  = array('mailtype' => 'html');
        $this->email->initialize($email_setting);

        $from_email = "purohit.dynamic@gmail.com";

        $this->email->from($from_email, 'Dynamic');
        $this->email->to($this->input->post('email'));
        $this->email->subject($this->input->post('subject'));
        $this->email->message($this->input->post('message'));
        //$this->email->attach($img);
        $this->email->set_mailtype('html');

        //Send mail 
        if ($this->email->send()) {
            echo '<br><br><br><center><h1 style="color:green"> Mail Send Sucessfully...!!!</h1></center>';
        } else {
            $this->session->set_flashdata("email_sent", "Error in sending Email.");
            echo '<br><br><br><center><h1 style="color:red"> Mail Not Send ..!!!</h1></center>';
        }
    }

    function load_result()
    {
        $this->db->select($this->input->post('column'));
        $this->db->from($this->input->post('table'));

        $this->db->like($this->input->post('search'), $this->input->post('keyword'));
        $this->db->limit(50, 0);
        $data = $this->db->get()->result_array();

        $path = '';
        $user_viewed = $this->session->userdata('user_viewed');

        if ($user_viewed != 3) {
            $path = base_url('uploads/itemsamples');
        } else {
            $path = base_url('uploads/itemsamples/labels');
        }

        echo '<ul id="country-list">';
        $i = rand(1, 99) + time();
        foreach ($data as $row) {
            echo '<li onClick="selectValue(this)" tabindex="1"  id="li' . ++$i . '" data-row="' . $this->input->post('row') . '"  data-id="' . $row['id'] . '" data-value="' . $row['name'] . ' - ' . $row['id'] . '" ><img src="' . $path . '/' . $row['item_sample'] . '" height="30" width="30"> &nbsp; &nbsp; ' . $row['name'] . '</li>';
        }

        echo '</ul>';
    }
}
