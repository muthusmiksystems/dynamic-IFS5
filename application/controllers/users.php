<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
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
		$this->load->model('m_general');
		$this->load->library('encrypt');

		if (!$this->session->userdata('logged_in')) {
			// Allow some methods?
			$allowed = array(
				'login',
				'submitlogin',
				'forgotpassword',
				'getpassword',
				'resetpassword',
				'updatepassword'
			);
			if (!in_array($this->router->method, $allowed)) {
				redirect(base_url() . 'users/login', 'refresh');
			}
		}
	}

	function index()
	{
		$is_privileged = $this->m_users->is_privileged('index', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			$data['activeTab'] = 'user';
			$data['activeItem'] = 'listusers';
			$data['page_title'] = 'List Users';
			$data['css'] = array(
				'css/bootstrap.min.css',
				'css/bootstrap-reset.css',
				'assets/font-awesome/css/font-awesome.css',
				'css/style.css',
				'css/select2.css',
				'css/style-responsive.css'
			);
			$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
			$data['js'] = array(
				'js/jquery.js',
				'js/select2.js',
				'js/bootstrap.min.js',
				'js/jquery.scrollTo.min.js',
				'js/jquery.nicescroll.js',
				'assets/data-tables/jquery.dataTables.min.js',
				'assets/data-tables/DT_bootstrap.js'
			);

			$data['js_common'] = array('js/common-scripts.js');
			$data['js_thispage'] = array('js/dynamic-table.js');
			$data['users'] = $this->m_users->getallusers();
			$this->load->view('v_listusers.php', $data);
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}
	public function login()
	{
		$data['page_title'] = 'Login';
		$data['css'] = array('css/bootstrap.min.css', 'css/bootstrap-reset.css', 'assets/font-awesome/css/font-awesome.css', 'css/style.css', 'css/style-responsive.css');
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$this->load->view('v_login.php', $data);
	}
	public function submitlogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if ($username != '' && $password != '') {
			$login = $this->m_users->check_secure_login($username, $this->encrypt->encode($password));
			$cdata = @explode('-', $username);
			
			
			$cust_login = $this->m_users->check_cust_login(@$cdata[1], $password, @$cdata[0]);
			if ($login && $this->encrypt->decode($login['user_pass']) == $password) {
				$this->session->set_userdata('user_id', $login['ID']);
				$this->session->set_userdata('user_login', $login['user_login']);
				$this->session->set_userdata('user_category', $login['user_category']);
				$this->session->set_userdata('display_name', $login['display_name']);
				$this->session->set_userdata('logged_as', 'user');
				$this->session->set_userdata('logged_in', TRUE);
				redirect(base_url());
			} elseif ($cust_login && $this->encrypt->decode($cust_login['password']) == $password) {
				$this->session->set_userdata('user_id', $cust_login['cust_id']);
				$disp_name = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_id', $cust_login['cust_id'], 'cust_name');
				$this->session->set_userdata('display_name', $disp_name);
				$this->session->set_userdata('user_category', '0');
				$this->session->set_userdata('logged_as', 'customer');
				$this->session->set_userdata('logged_in', TRUE);
				redirect(base_url());
			} else {
				$this->session->set_flashdata('error', 'Wrong Username or password');
				redirect(base_url() . "users/login", 'refresh');
			}
		} else {
			redirect(base_url() . "users/login", 'refresh');
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		$sess_array = $this->session->all_userdata();
		foreach ($sess_array as $key => $val) {
			// if($key!='session_id'||$key!='last_activity'||$key!='admin_id'){
			$this->session->unset_userdata($key);
			// }
		}
		redirect(base_url() . 'users/login', 'refresh');
	}
	public function forgotpassword()
	{
		$data['page_title'] = 'Forgot your password';
		$data['css'] = array(
			'css/bootstrap.min.css',
			'css/bootstrap-reset.css',
			'assets/font-awesome/css/font-awesome.css',
			'css/style.css',
			'css/select2.css',
			'css/style-responsive.css'
		);
		$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
		$this->load->view('v_forgotpassword.php', $data);
	}
	public function getpassword()
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => '465',
			'smtp_user' => 'budnetdesign@gmail.com',
			'smtp_pass' => 'newlife@5',
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline'   => '\r\n'
		);

		$login_type = $this->input->post('login_type');
		$user_email = $this->input->post('email');
		if ($login_type == 'user') {
			$email_exit = $this->m_users->check_email_exist($user_email);
			$random_key = random_string('alnum', 16);
			if ($email_exit) {
				$formData = array(
					'user_activation_key' => $random_key,
				);
				$this->m_users->updaterandompass($user_email, $formData);
				$messagebody = '<h2>Forgot Password</h3><br/>';
				$messagebody .= '<p>Click blow link</p>';
				$messagebody .= '<a href="' . base_url() . 'users/resetpassword/' . $random_key . '">' . base_url() . 'users/resetpassword/' . $random_key . '</a>';

				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->set_mailtype("html");
				$this->email->from('budnetdesign@gmail.com', 'Budnet');
				$this->email->to($user_email);
				$this->email->subject('Forgot Password');
				$this->email->message($messagebody);
				$this->email->send();
				$this->session->set_flashdata('success', 'Check your email');
				redirect(base_url() . "users/login", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Enter your registered email.');
				redirect(base_url() . "users/forgotpassword", 'refresh');
			}
		} else {
			$customer_id = $this->m_masters->getmasterIDvalue('bud_customers', 'cust_email', $user_email, 'cust_id');
			if ($customer_id) {
				$random_pass = random_string('alnum', 8);
				$formData = array(
					'cust_password' => $random_pass
				);
				$this->m_masters->updatemaster('bud_cust_logins', 'cust_id', $customer_id, $formData);
				$messagebody = '<h2>New Login Details</h3><br/>';
				$messagebody .= '<p>Password: ' . $random_pass . '</p>';

				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->set_mailtype("html");
				$this->email->from('budnetdesign@gmail.com', 'Budnet');
				$this->email->to($user_email);
				$this->email->subject('Forgot Password');
				$this->email->message($messagebody);
				$this->email->send();
				$this->session->set_flashdata('success', 'Check your email');
				redirect(base_url() . "users/login", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Enter your registered email.');
				redirect(base_url() . "users/forgotpassword", 'refresh');
			}
		}
	}
	public function resetpassword()
	{
		if ($this->uri->segment(3) === FALSE) {
			redirect(base_url(), 'refresh');
		} else {
			$user_activation_key = $this->uri->segment(3);
			$checkrandomkey = $this->m_users->checkrandomkey($user_activation_key);
			if ($checkrandomkey) {
				$data['page_title'] = 'Forgot your password';
				$data['user_activation_key'] = $user_activation_key;
				$data['css'] = array(
					'css/bootstrap.min.css',
					'css/bootstrap-reset.css',
					'assets/font-awesome/css/font-awesome.css',
					'css/style.css',
					'css/style-responsive.css'
				);
				$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
				$this->load->view('v_resetpassword.php', $data);
			} else {
				redirect(base_url(), 'refresh');
			}
		}
	}
	public function updatepassword()
	{
		$user_pass = $this->encrypt->encode($this->input->post('user_pass'));
		$user_activation_key = $this->input->post('user_activation_key');
		$formData = array(
			'user_pass' => $user_pass,
			'user_activation_key' => ''
		);
		$this->m_users->updatenewpass($user_activation_key, $formData);
		$this->session->set_flashdata('success', 'Successfully updated!!!');
		redirect(base_url() . "users/login", 'refresh');
	}
	function addnew()
	{
		$is_privileged = $this->m_users->is_privileged('addnew', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			$data['activeTab'] = 'user';
			$data['activeItem'] = 'adduser';
			$data['page_title'] = 'Add New User';
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
				'js/jquery-ui-1.9.2.custom.min.js',
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
				'js/jquery.validate.min.js'
			);
			$data['js_common'] = array('js/common-scripts.js');
			$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js');
			$this->load->view('v_adduser.php', $data);
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}
	function edit()
	{
		$is_privileged = $this->m_users->is_privileged('edit', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			if ($this->uri->segment(3) === FALSE) {
				redirect(base_url() . "my404/404", 'refresh');
			} else {
				$data['activeTab'] = 'user';
				$data['activeItem'] = 'adduser';
				$user_id = $this->uri->segment(3);
				$data['users'] = $this->m_users->getuserdetails($user_id);
				$data['activeTab'] = 'user';
				$data['activeItem'] = 'adduser';
				$data['page_title'] = 'Add New User';
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
					'js/jquery-ui-1.9.2.custom.min.js',
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
					'js/jquery.validate.min.js'
				);
				$data['js_common'] = array('js/common-scripts.js');
				$data['js_thispage'] = array('js/form-validation-script.js', 'js/form-component.js');
				$this->load->view('v_edituser.php', $data);
			}
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}

	function saveuser()
	{
		$is_privileged = $this->m_users->is_privileged('addnew', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			$user_category = $this->input->post('user_category');
			$display_name = $this->input->post('display_name');
			$user_nicename = $this->input->post('user_nicename');
			$user_login = $this->input->post('user_login');
			$user_pass = $this->encrypt->encode($this->input->post('user_pass'));
			$user_email = $this->input->post('user_email');
			$user_address = $this->input->post('user_address');
			$user_city = $this->input->post('user_city');
			$user_pincode = $this->input->post('user_pincode');
			$user_phone = $this->input->post('user_phone');
			$user_mobile = $this->input->post('user_mobile');
			$user_dateofjoin = $this->input->post('user_dateofjoin');
			$user_dateofbirth = $this->input->post('user_dateofbirth');
			$user_status = $this->input->post('user_status');
			$dj = explode("-", $user_dateofjoin);
			$user_dateofjoin = $dj[2] . '-' . $dj[1] . '-' . $dj[0];
			$db = explode("-", $user_dateofbirth);
			$user_dateofbirth = $db[2] . '-' . $db[1] . '-' . $db[0];

			$config['upload_path'] = 'uploads/users/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '16000';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['overwrite'] = FALSE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');
			$user_photo = '';
			if (!$this->upload->do_upload('user_photo')) {
				$error = array('error' => $this->upload->display_errors());
				// print_r($error);
				// exit();
			} else {
				$image = $this->upload->data();
				$user_photo = $image['file_name'];
			}

			$formData = array(
				'user_category' => $user_category,
				'display_name' => $display_name,
				'user_nicename' => $user_nicename,
				'user_login' => $user_login,
				'user_pass' => $user_pass,
				'user_email' => $user_email,
				'user_status' => $user_status,
				'user_registered' => date("Y-m-d H:i:s"),
				'user_address' => $user_address,
				'user_city' => $user_city,
				'user_pincode' => $user_pincode,
				'user_phone' => $user_phone,
				'user_mobile' => $user_mobile,
				'user_dateofjoin' => $user_dateofjoin,
				'user_dateofbirth' => $user_dateofbirth,
				'user_photo' => $user_photo
			);

			$dupUID = @$this->input->post('dupUID');
			if ($dupUID != '') {
				$requsers = $this->m_purchase->getDatas('bud_users', 'ID', $dupUID);
				foreach ($requsers as $user) {
					$formData['user_access_modules'] = $user['user_access_modules'];
				}
			}

			$check_exit = $this->m_users->check_user_exist($user_login);
			$email_exit = $this->m_users->check_email_exist($user_email);
			if ($check_exit) {
				$this->session->set_flashdata('warning', 'Username already exist');
				redirect(base_url() . "users/addnew", 'refresh');
			} elseif ($email_exit) {
				$this->session->set_flashdata('warning', 'Email already exist');
				redirect(base_url() . "users/addnew", 'refresh');
			} else {
				$result = $this->m_users->saveuser($formData);
				if ($result) {

					if ($dupUID != '') {
						$privileges = $this->m_users->get_all_privileges();
						foreach ($privileges as $privilege) {
							$upriv_id = $privilege['upriv_id'];
							$exist = $this->m_users->is_upriv_exit($dupUID, $upriv_id);
							$existadd = $this->m_users->is_upriv_add_action_exit($dupUID, $upriv_id);
							$existdel = $this->m_users->is_upriv_del_action_exit($dupUID, $upriv_id);

							if ($exist) {
								$formData2 = array(
									'user_id' => $result,
									'privilege_id' => $upriv_id
								);
								$this->m_purchase->saveDatas('bud_privilege_users', $formData2);
							}

							if ($existadd) {
								$formData2 = array(
									'user_id' => $result,
									'privilege_id' => $upriv_id
								);
								$this->m_purchase->saveDatas('bud_privilege_add_action_users', $formData2);
							}

							if ($existdel) {
								$formData2 = array(
									'user_id' => $result,
									'privilege_id' => $upriv_id
								);
								$this->m_purchase->saveDatas('bud_privilege_del_action_users', $formData2);
							}
						}
					}

					$this->session->set_flashdata('success', 'Successfully Saved!!!');
					redirect(base_url() . "users/addnew", 'refresh');
				} else {
					$this->session->set_flashdata('error', 'That action is not valid, please try again');
					redirect(base_url() . "users/addnew", 'refresh');
				}
			}
		} else {
			echo "You dont have privilage";
			//redirect(base_url()."my404/404", 'refresh');
		}
	}
	function updateuser()
	{
		$is_privileged = $this->m_users->is_privileged('edit', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			$ID = $this->input->post('ID');
			$user_category = $this->input->post('user_category');
			$display_name = $this->input->post('display_name');
			$user_nicename = $this->input->post('user_nicename');
			$old_user_login = $this->input->post('old_user_login');
			$user_login = $this->input->post('user_login');
			$user_pass = $this->encrypt->encode($this->input->post('user_pass'));
			$old_user_email = $this->input->post('old_user_email');
			$user_email = $this->input->post('user_email');
			$user_address = $this->input->post('user_address');
			$user_city = $this->input->post('user_city');
			$user_pincode = $this->input->post('user_pincode');
			$user_phone = $this->input->post('user_phone');
			$user_mobile = $this->input->post('user_mobile');
			$user_dateofjoin = $this->input->post('user_dateofjoin');
			$user_dateofbirth = $this->input->post('user_dateofbirth');
			$user_status = $this->input->post('user_status');

			$old_user_photo = $this->input->post('old_user_photo');
			$user_photo = $old_user_photo;
			$config['upload_path'] = 'uploads/users/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '16000';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['overwrite'] = FALSE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$img_ext_chk = array('jpg', 'png', 'gif', 'jpeg');

			if (!$this->upload->do_upload('user_photo')) {
				$error = array('error' => $this->upload->display_errors());
				// print_r($error);
				// exit();
			} else {
				if ($old_user_photo != '') {
					if (file_exists('uploads/users/' . $old_user_photo)) {
						unlink('uploads/users/' . $old_user_photo);
					}
				}
				$image = $this->upload->data();
				$user_photo = $image['file_name'];
			}

			$dj = explode("-", $user_dateofjoin);
			$user_dateofjoin = $dj[2] . '-' . $dj[1] . '-' . $dj[0];
			$db = explode("-", $user_dateofbirth);
			$user_dateofbirth = $db[2] . '-' . $db[1] . '-' . $db[0];
			$formData = array(
				'user_category' => $user_category,
				'display_name' => $display_name,
				'user_nicename' => $user_nicename,
				'user_login' => $user_login,
				'user_pass' => $user_pass,
				'user_email' => $user_email,
				'user_status' => $user_status,
				'user_registered' => date("Y-m-d H:i:s"),
				'user_address' => $user_address,
				'user_city' => $user_city,
				'user_pincode' => $user_pincode,
				'user_phone' => $user_phone,
				'user_mobile' => $user_mobile,
				'user_dateofjoin' => $user_dateofjoin,
				'user_dateofbirth' => $user_dateofbirth,
				'user_photo' => $user_photo
			);
			if ($old_user_login != $user_login) {
				$check_exit = $this->m_users->check_user_exist($user_login);
			} else {
				$check_exit = false;
			}
			if ($old_user_email != $user_email) {
				$email_exit = $this->m_users->check_email_exist($user_email);
			} else {
				$email_exit = false;
			}
			if ($check_exit) {
				$this->session->set_flashdata('warning', 'Username already exist');
				redirect(base_url() . "users/edit/" . $ID, 'refresh');
			} elseif ($email_exit) {
				$this->session->set_flashdata('warning', 'Email already exist');
				redirect(base_url() . "users/edit/" . $ID, 'refresh');
			} else {
				$result = $this->m_users->updateuser($ID, $formData);
				if ($result) {
					$this->session->set_flashdata('success', 'Successfully Updated!!!');
					redirect(base_url() . "users", 'refresh');
				} else {
					$this->session->set_flashdata('error', 'That action is not valid, please try again');
					redirect(base_url() . "users/edit/" . $ID, 'refresh');
				}
			}
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}
	function delete()
	{
		$is_privileged = $this->m_users->is_privileged('delete', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			if ($this->uri->segment(3) === FALSE) {
				redirect(base_url() . "my404/404", 'refresh');
			} else {
				$ID = $this->uri->segment(3);
				$result = $this->m_users->deleteuser($ID);
				if ($result) {
					$this->session->set_flashdata('success', 'Successfully Deleted!!!');
					redirect(base_url() . "users", 'refresh');
				} else {
					$this->session->set_flashdata('error', 'That action is not valid, please try again');
					redirect(base_url() . "users", 'refresh');
				}
			}
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}

	// Update User Privileges
	function manage_user_privileges()
	{
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_admin) {
			$data['activeTab'] = 'user';
			$data['activeItem'] = 'listusers';
			$data['page_title'] = 'Magange User Privileges';
			// $data['privileges'] = $this->m_purchase->getActivetableDatas('bud_privileges', 'upriv_status');
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
			if ($this->uri->segment(3) === FALSE) {
				redirect(base_url() . "m404", 'refresh');
			} else {
				$data['user_id'] = $this->uri->segment(3);
				$this->load->view('v_update_user_privileges', $data);
			}
		} else {
			redirect(base_url() . "m404", 'refresh');
		}
	}
	function update_user_privileges($user_id)
	{
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_admin) {
			// Update privileges.
			if (isset($_POST['user_access_modules'])) {
				$user_access_modules = $this->input->post('user_access_modules');
			} else {
				$user_access_modules = array();
			}
			foreach ($this->input->post('update') as $row) {
				if ($row['current_status'] != $row['new_status']) {
					// Insert new user privilege.
					if ($row['new_status'] == 1) {
						$formData = array(
							'user_id' => $user_id,
							'privilege_id' => $row['id']
						);
						$this->m_purchase->saveDatas('bud_privilege_users', $formData);
					}
					// Delete existing user privilege.
					else {
						$this->m_users->delete_privilege_user($user_id, $row['id']);
					}
				}
				if ($row['current_status_add'] != $row['new_status_add']) {
					// Insert new user privilege.
					if ($row['new_status_add'] == 1) {
						$formData = array(
							'user_id' => $user_id,
							'privilege_id' => $row['id']
						);
						$this->m_purchase->saveDatas('bud_privilege_add_action_users', $formData);
					}
					// Delete existing user privilege.
					else {
						$this->m_users->delete_privilege_add_action_user($user_id, $row['id']);
					}
				}
				if ($row['current_status_del'] != $row['new_status_del']) {
					// Insert new user privilege.
					if ($row['new_status_del'] == 1) {
						$formData = array(
							'user_id' => $user_id,
							'privilege_id' => $row['id']
						);
						$this->m_purchase->saveDatas('bud_privilege_del_action_users', $formData);
					}
					// Delete existing user privilege.
					else {
						$this->m_users->delete_privilege_del_action_user($user_id, $row['id']);
					}
				}
			}
			// Update User Modules
			$userData = array(
				'user_access_modules' => implode(",", $user_access_modules)
			);
			$this->m_purchase->updateDatas('bud_users', 'ID', $user_id, $userData);
			$this->session->set_flashdata('success', 'Successfully Updated!!!');
			redirect(base_url() . "users", 'refresh');
		} else {
			redirect(base_url() . "m404", 'refresh');
		}
	}

	function createcustomerlogin()
	{
		$is_privileged = $this->m_users->is_privileged('index', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			$data['activeTab'] = 'user';
			$data['activeItem'] = 'createcustomerlogin';
			$data['page_title'] = 'Create Customer Login';
			$data['css'] = array(
				'css/bootstrap.min.css',
				'css/bootstrap-reset.css',
				'assets/font-awesome/css/font-awesome.css',
				'css/style.css',
				'css/select2.css',
				'css/style-responsive.css'
			);
			$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
			$data['js'] = array(
				'js/jquery.js',
				'js/select2.js',
				'js/bootstrap.min.js',
				'js/jquery.scrollTo.min.js',
				'js/jquery.nicescroll.js',
				'assets/data-tables/jquery.dataTables.min.js',
				'assets/data-tables/DT_bootstrap.js'
			);

			$data['js_common'] = array('js/common-scripts.js');
			$data['js_thispage'] = array('js/dynamic-table.js');
			$data['users'] = $this->m_users->getallusers();
			$data['customers'] = $this->m_masters->getactivemaster('bud_customers', 'cust_status');
			$data['cust_logins'] = $this->m_masters->getallmaster('bud_cust_logins');
			if ($this->uri->segment(3) === FALSE) {
				$this->load->view('v_createcustomerlogin.php', $data);
			} else {
				$data['cust_login_id'] = $this->uri->segment(3);
				$this->load->view('v_createcustomerlogin.php', $data);
			}
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}
	function createcustlogin_save()
	{
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/

		$cust_login_id = $this->input->post('cust_login_id');
		$old_cust_username = $this->input->post('old_cust_username');
		$customer_id = $this->input->post('customer_id');
		$cust_username = $this->input->post('cust_username');
		$cust_password = $this->input->post('cust_password');
		$formData = array(
			'cust_id' => $customer_id,
			'cust_username' => $cust_username,
			'cust_password' => $cust_password
		);

		if ($cust_login_id == '') {
			$check_exist = $this->m_masters->getmasterdetails('bud_cust_logins', 'cust_username', $cust_username);
			if (empty($check_exist)) {
				$result = $this->m_masters->savemaster('bud_cust_logins', $formData);
				if ($result) {
					$this->session->set_flashdata('success', 'Successfully Saved!!!');
					redirect(base_url() . "users/createcustomerlogin", 'refresh');
				} else {
					$this->session->set_flashdata('error', 'That action is not valid, please try again');
					redirect(base_url() . "users/createcustomerlogin", 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Username already exist.');
				redirect(base_url() . "users/createcustomerlogin", 'refresh');
			}
		} else {
			if ($old_cust_username != $cust_username) {
				$check_exist = $this->m_masters->getmasterdetails('bud_cust_logins', 'cust_username', $cust_username);
				if (empty($check_exist)) {
					$result = $this->m_masters->updatemaster('bud_cust_logins', 'cust_login_id', $cust_login_id, $formData);
					if ($result) {
						$this->session->set_flashdata('success', 'Successfully Saved!!!');
						redirect(base_url() . "users/createcustomerlogin", 'refresh');
					} else {
						$this->session->set_flashdata('error', 'That action is not valid, please try again');
						redirect(base_url() . "users/createcustomerlogin", 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Username already exist');
					redirect(base_url() . "users/createcustomerlogin", 'refresh');
				}
			} else {
				$result = $this->m_masters->updatemaster('bud_cust_logins', 'cust_login_id', $cust_login_id, $formData);
				if ($result) {
					$this->session->set_flashdata('success', 'Successfully Saved!!!');
					redirect(base_url() . "users/createcustomerlogin", 'refresh');
				} else {
					$this->session->set_flashdata('error', 'That action is not valid, please try again');
					redirect(base_url() . "users/createcustomerlogin", 'refresh');
				}
			}
		}
	}
	function deletecustlogin($cust_login_id = null)
	{
		$result = $this->m_masters->deletemaster('bud_cust_logins', 'cust_login_id', $cust_login_id);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Deleted!!!');
			redirect(base_url() . "users/createcustomerlogin", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "users/createcustomerlogin", 'refresh');
		}
	}
	function change_cust_password()
	{
		$is_privileged = $this->m_users->is_privileged('index', 'upriv_function', $this->session->userdata('user_id'));
		$is_admin = $this->m_users->is_admin($this->session->userdata('user_id'));
		if ($is_privileged || $is_admin) {
			$data['activeTab'] = 'customer';
			$data['activeItem'] = 'change_cust_password';
			$data['page_title'] = 'Change Customer Password';
			$data['css'] = array(
				'css/bootstrap.min.css',
				'css/bootstrap-reset.css',
				'assets/font-awesome/css/font-awesome.css',
				'css/style.css',
				'css/select2.css',
				'css/style-responsive.css'
			);
			$data['js_IE'] = array('js/html5shiv.js', 'js/respond.min.js');
			$data['js'] = array(
				'js/jquery.js',
				'js/select2.js',
				'js/bootstrap.min.js',
				'js/jquery.scrollTo.min.js',
				'js/jquery.nicescroll.js',
				'assets/data-tables/jquery.dataTables.min.js',
				'assets/data-tables/DT_bootstrap.js'
			);

			$data['js_common'] = array('js/common-scripts.js');
			$data['js_thispage'] = array('js/dynamic-table.js');
			$data['cust_details'] = $this->m_masters->getmasterdetails('bud_cust_logins', 'cust_id', $this->session->userdata('user_id'));
			if ($this->uri->segment(3) === FALSE) {
				$this->load->view('v_change_cust_password.php', $data);
			} else {
				$data['cust_login_id'] = $this->uri->segment(3);
				$this->load->view('v_change_cust_password.php', $data);
			}
		} else {
			redirect(base_url() . "my404/404", 'refresh');
		}
	}
	function update_cust_password()
	{
		$cust_id = $this->input->post('cust_id');
		$cdata = @explode('-', $cust_id);
		$cust_password = $this->input->post('cust_password');
		$formData = array(
			'password' => $this->encrypt->encode($cust_password)
		);
		$result = $this->m_masters->updatemaster('bud_customers', 'cust_id', $cdata[1], $formData);
		if ($result) {
			$this->session->set_flashdata('success', 'Successfully Saved!!!');
			redirect(base_url() . "users/change_cust_password", 'refresh');
		} else {
			$this->session->set_flashdata('error', 'That action is not valid, please try again');
			redirect(base_url() . "users/change_cust_password", 'refresh');
		}
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */
