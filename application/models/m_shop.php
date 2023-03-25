<?php
class M_shop extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_items()
    {
        $this->db->order_by('item_name', 'asc');
        $result = $this->db->get('bud_items');
        return $result->result_array();
    }
    function get_item($item_id)
    {
        $this->db->where('item_id', $item_id);
        return $this->db->get('bud_items')->row();
    }
    function get_shades()
    {
        $result = $this->db->get('bud_shades');
        return $result->result_array();
    }
    function save_inward($inwardData)
    {
        if ($inwardData['id']) {
            $this->db->where('id', $inwardData['id']);
            $this->db->update('bud_s_inward_reg', $inwardData);
            return $inwardData['id'];
        } else {
            $this->db->insert('bud_s_inward_reg', $inwardData);
            return $this->db->insert_id();
        }
    }
    function get_inward_register($from_date = null, $to_date = null)
    {
        $this->db->join('bud_items', 'bud_items.item_id=bud_s_inward_reg.item_id');
        $this->db->join('bud_shades', 'bud_shades.shade_id=bud_s_inward_reg.shade_id');
        if ($from_date != null && $to_date != null) {
            $this->db->where("bud_s_inward_reg.inward_date between '$from_date' and '$to_date'");
        }
        $result = $this->db->get('bud_s_inward_reg');
        return $result->result_array();
    }
    function insertEstimateCart($data)
    {
        $this->db->insert('bud_estimate_items_temp', $data);
        return $this->db->insert_id();
    }
    function deleteEstimateCart($row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->delete('bud_estimate_items_temp');
        return true;
    }
    function destroyEstimateCart($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('bud_estimate_items_temp');
        return true;
    }
    function viewEstimateCart()
    {
        $this->db->select('*,bud_estimate_items_temp.item_uom as uom, bud_shades.shade_name')
            ->from('bud_estimate_items_temp')
            ->join('bud_items', 'bud_items.item_id=bud_estimate_items_temp.item_id')
            ->join('bud_shades', 'bud_shades.shade_id=bud_estimate_items_temp.shade_id')
            ->where('bud_estimate_items_temp.user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }
    function save_estimate($estimateData)
    {
        if ($estimateData['estimate_id']) {
            $this->db->where('estimate_id', $estimateData['estimate_id']);
            $this->db->update('bud_estimates_shop', $estimateData);
            return $estimateData['estimate_id'];
        } else {
            $this->db->insert('bud_estimates_shop', $estimateData);
            return $this->db->insert_id();
        }
    }
    function saveEstimateCart($data)
    {
        $this->db->insert('bud_estimate_items', $data);
        return $this->db->insert_id();
    }
    function get_estimate_register($from_date = null, $to_date = null, $from_est_id = null, $to_est_id = null)
    {
        $this->db->select('*');
        $this->db->join('bud_estimate_items', 'bud_estimate_items.estimate_id=bud_estimates_shop.estimate_id');
        $this->db->join('bud_items', 'bud_items.item_id=bud_estimate_items.item_id');
        $this->db->join('bud_shades', 'bud_shades.shade_id=bud_estimate_items.shade_id');
        if ($from_date != null && $to_date != null) {
            $this->db->where("estimate_date between '$from_date' and '$to_date'");
        }
        if (!empty($from_est_id)) {
            $this->db->where('estimate_id >=', $from_est_id);
        }
        if (!empty($to_est_id)) {
            $this->db->where('estimate_id <=',  $to_est_id);
        }
        $result = $this->db->get('bud_estimates_shop');
        return $result->result_array();
    }
    function get_estimate($estimate_id)
    {
        $this->db->select('*');
        $this->db->where('estimate_id', $estimate_id);
        $result = $this->db->get('bud_estimates_shop');
        return $result->first_row('array');
    }
    function estimateValue($estimate_id)
    {
        $estimate_value = 0;
        $this->db->select('sum(amount) as estimate_value');
        $this->db->where('estimate_id', $estimate_id);
        $this->db->from('bud_estimate_items');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->estimate_value;
        } else {
            return 0;
        }
    }
    function getEstimateItems($estimate_id)
    {
        $this->db->select('*,bud_estimate_items.item_uom as uom, bud_shades.shade_name')
            ->from('bud_estimate_items')
            ->join('bud_items', 'bud_items.item_id=bud_estimate_items.item_id')
            ->join('bud_shades', 'bud_shades.shade_id=bud_estimate_items.shade_id')
            ->where('bud_estimate_items.estimate_id', $estimate_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function no_to_words($no)
    {
        $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fouteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninty', '100' => 'hundred &', '1000' => 'thousand', '100000' => 'lakh', '10000000' => 'crore');
        if ($no == 0)
            return ' ';
        else {
            $novalue = '';
            $highno = $no;
            $remainno = 0;
            $value = 100;
            $value1 = 1000;
            while ($no >= 100) {
                if (($value <= $no) && ($no  < $value1)) {
                    $novalue = $words["$value"];
                    $highno = (int) ($no / $value);
                    $remainno = $no % $value;
                    break;
                }
                $value = $value1;
                $value1 = $value * 100;
            }
            if (array_key_exists("$highno", $words))
                return $words["$highno"] . " " . $novalue . " " . no_to_words($remainno);
            else {
                $unit = $highno % 10;
                $ten = (int) ($highno / 10) * 10;
                return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . no_to_words($remainno);
            }
        }
    }
    function estimate_report($start = null, $end = null)
    {
        if (!empty($start)) {
            $this->db->where('estimate_date >=', $start);
        }
        if (!empty($end)) {
            $this->db->where('estimate_date <',  $end);
        }

        // just fetch a list of estimate id's
        $estimates = $this->db->select('estimate_id,customer_mobile')->get('bud_estimates_shop')->result();

        $items = array();
        foreach ($estimates as $estimate) {
            $estimate_items    = $this->db->select('item_id, qty')->where('estimate_id', $estimate->estimate_id)->get('bud_estimate_items')->result_array();
            /*echo "<pre>";
            print_r($estimate_items);
            echo "</pre>";*/
            foreach ($estimate_items as $i) {

                if (isset($items[$i['item_id']])) {
                    $items[$i['item_id']]    += $i['qty'];
                } else {
                    $items[$i['item_id']]    = $i['qty'];
                }
            }
        }
        arsort($items);

        // don't need this anymore
        unset($estimates);

        $return = array();
        foreach ($items as $key => $quantity) {
            $item = $this->db->where('item_id', $key)->get('bud_items')->row();
            if ($item) {
                $item->quantity_sold = $quantity;
            } else {
                $item = (object) array('item_id' => 'Deleted', 'item_name' => 'Deleted', 'quantity_sold' => $quantity);
            }

            $return[] = $item;
        }
        return $return;
    }

    function getCustomers()
    {
        $this->db->select('customer_mobile, customer_name');
        $this->db->distinct('customer_mobile');
        $this->db->from('bud_estimates_shop');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_cust_item_estimate_reg($from_date = null, $to_date = null, $item_id = null, $customer_mobile = null)
    {
        $this->db->select('*');
        if (!empty($from_date)) {
            $this->db->where('estimate_date >=', $from_date);
        }
        if (!empty($to_date)) {
            $this->db->where('estimate_date <=',  $to_date);
        }
        if (!empty($customer_mobile)) {
            $this->db->where('customer_mobile', $customer_mobile);
        }
        $estimates = $this->db->get('bud_estimates_shop')->result();

        $return = array();
        foreach ($estimates as $estimate) {
            $estimate_id = $estimate->estimate_id;
            $estimate_date = $estimate->estimate_date;
            $customer_mobile = $estimate->customer_mobile;
            $customer_name = $estimate->customer_name;
            $this->db->select('bud_estimate_items.*, bud_items.item_name');
            $this->db->join('bud_items', 'bud_items.item_id = bud_estimate_items.item_id');
            $this->db->where('estimate_id', $estimate_id);
            if (!empty($item_id)) {
                $this->db->where('bud_items.item_id', $item_id);
            }
            $item_details = $this->db->get('bud_estimate_items')->result();

            if ($item_details) {
                foreach ($item_details as $row) {
                    $item = $this->get_item($row->item_id);
                    $row->item_name = $item->item_name;
                    $row->estimate_date = $estimate_date;
                    $row->customer_name = $customer_name;
                    $row->customer_mobile = $customer_mobile;
                    // $return[$customer_mobile][] = $item_details;
                    $return[$estimate_id][] = $row;
                }
            }
        }
        return $return;
    }
}
