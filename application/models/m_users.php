<?php
class M_users extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function check_login($username, $password)
    {

        $this->db->select('*');
        $this->db->from('bud_users');
        $this->db->where('user_login', $username);
        $this->db->where('user_pass', $password);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row('array');
        } else {
            return false;
        }
    }
    function check_secure_login($username, $password)
    {
        $this->db->select('*');
        $this->db->from('bud_users');
        $this->db->where('user_login', $username);
        //$this->db->where('user_pass', $password);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row('array');
        } else {
            return false;
        }
    }
    function check_cust_login($username, $password, $type)
    {

        $this->db->select('*');
        $this->db->from('bud_customers');
        $this->db->where('cust_id', $username);
        //$this->db->where('password', $password);
        $this->db->where('cust_type', $type);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row('array');
        } else {
            return false;
        }
    }
    function check_user_exist($user_login)
    {
        $this->db->where("user_login", $user_login);
        $query = $this->db->get("bud_users");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function check_email_exist($user_email)
    {
        $this->db->where("user_email", $user_email);
        $query = $this->db->get("bud_users");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function saveuser($data)
    {
        $this->db->insert('bud_users', $data);
        return $this->db->insert_id();
    }
    function getallusers()
    {
        $this->db->select('bud_users.*,bud_user_category.category_name');
        $this->db->from('bud_users');
        $this->db->join('bud_user_category', 'bud_user_category.category_id=bud_users.user_category', 'left');
        if ($this->session->userdata('user_id') != 1) {
            $this->db->where('bud_users.user_category', $this->session->userdata('user_category'));
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function getuserdetails($user_id)
    {
        $this->db->select('*')
            ->from('bud_users')
            ->where('ID', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function checkrandomkey($user_activation_key)
    {
        $this->db->select('*')
            ->from('bud_users')
            ->where('user_activation_key', $user_activation_key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function updateuser($user_id, $data)
    {
        $this->db->where('ID', $user_id);
        $this->db->update('bud_users', $data);
        return true;
    }
    function updaterandompass($user_email, $data)
    {
        $this->db->where('user_email', $user_email);
        $this->db->update('bud_users', $data);
        return true;
    }
    function updatenewpass($user_activation_key, $data)
    {
        $this->db->where('user_activation_key', $user_activation_key);
        $this->db->update('bud_users', $data);
        return true;
    }
    function deleteuser($ID)
    {
        $this->db->where('ID', $ID);
        $this->db->delete('bud_users');
        return true;
    }
    function delete_privilege_user($user_id, $privilege_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('privilege_id', $privilege_id);
        $this->db->delete('bud_privilege_users');
        return true;
    }
    function delete_privilege_add_action_user($user_id, $privilege_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('privilege_id', $privilege_id);
        $this->db->delete('bud_privilege_add_action_users');
        return true;
    }
    function delete_privilege_del_action_user($user_id, $privilege_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('privilege_id', $privilege_id);
        $this->db->delete('bud_privilege_del_action_users');
        return true;
    }
    function is_upriv_exit($user_id, $privilege_id)
    {
        $this->db->select('*')
            ->from('bud_privilege_users')
            ->where('user_id', $user_id)
            ->where('privilege_id', $privilege_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function is_upriv_add_action_exit($user_id, $privilege_id)
    {
        $this->db->select('*')
            ->from('bud_privilege_add_action_users')
            ->where('user_id', $user_id)
            ->where('privilege_id', $privilege_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function is_upriv_del_action_exit($user_id, $privilege_id)
    {
        $this->db->select('*')
            ->from('bud_privilege_del_action_users')
            ->where('user_id', $user_id)
            ->where('privilege_id', $privilege_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function is_admin($user_id)
    {
        $this->db->select('*');
        $this->db->from('bud_users');
        $this->db->where('ID', $user_id);
        //$this->db->where('user_login', 'admin');
        $this->db->where('user_type', '1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function is_privileged($upriv_name, $upriv_controller, $logged_user_id)
    {
        // $privileges = $this->m_users->get_privilege_id($upriv_name, $upriv_controller);
        $privileges = $this->m_users->get_privilege_id($upriv_name, $upriv_controller, $this->session->userdata('user_viewed'));
        foreach ($privileges as $privilege) {
            $upriv_id = $privilege['upriv_id'];
            $has_privilege = $this->m_users->has_privilege($upriv_id, $logged_user_id);
            if ($has_privilege) {
                return true;
            }
        }
    }
    function get_privilege_id($upriv_name, $upriv_controller, $user_viewed)
    {
        $this->db->select('*')
            ->from('bud_privileges')
            ->where($upriv_controller, $upriv_name)
            ->where("FIND_IN_SET('" . $user_viewed . "',upriv_modules)!=", 0);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_privileges($upriv_name, $upriv_controller)
    {
        $this->db->select('*')
            ->from('bud_privileges')
            ->where($upriv_controller, $upriv_name);
        $query = $this->db->get();
        return $query->result_array();
    }
    function has_privilege($upriv_id, $logged_user_id)
    {
        $this->db->select('*')
            ->from('bud_privilege_users')
            ->where('user_id', $logged_user_id)
            ->where('privilege_id', $upriv_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function has_privilege_add_action($upriv_id, $logged_user_id)
    {
        $this->db->select('*')
            ->from('bud_privilege_add_action_users')
            ->where('user_id', $logged_user_id)
            ->where('privilege_id', $upriv_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function has_privilege_del_action($upriv_id, $logged_user_id)
    {
        $this->db->select('*')
            ->from('bud_privilege_del_action_users')
            ->where('user_id', $logged_user_id)
            ->where('privilege_id', $upriv_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function is_manu_active($upriv_name, $upriv_controller, $user_viewed)
    {
        $this->db->select('*')
            ->from('bud_privileges')
            ->where($upriv_controller, $upriv_name)
            ->where("FIND_IN_SET('" . $user_viewed . "',upriv_modules)!=", 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_all_privileges_by_module($user_viewed, $logged_user_id, $is_admin)
    {
        if ($is_admin) {
            $this->db->select('*')
                ->from('bud_privileges')
                ->where("FIND_IN_SET('" . $user_viewed . "',upriv_modules)!=", 0)
                ->order_by('upriv_group_order', 'upriv_menu_order');
        } else {
            $this->db->from('bud_privilege_users as bpu')
                ->join('bud_privileges as bp', 'bp.upriv_id = bpu.privilege_id', 'left')
                ->where('bpu.user_id', $logged_user_id)
                ->where("FIND_IN_SET('" . $user_viewed . "',bp.upriv_modules)!=", 0)
                ->order_by('bp.upriv_group_order', 'bp.upriv_menu_order');
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_privileges()
    {
        $this->db->select('*')
            ->from('bud_privileges')
            ->order_by('upriv_group_order', 'upriv_menu_order');
        $query = $this->db->get();
        return $query->result_array();
    }
}
