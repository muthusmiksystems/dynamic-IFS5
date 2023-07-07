<?php
class Directpack_model extends CI_Model {
    function getNextBoxNo($box_prefix)
    {
        $this->db->select_max('box_no');
        $this->db->where('box_prefix', $box_prefix);
        $query = $this -> db -> get('bud_yt_packing_boxes');
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->box_no + 1;
        }
    }
	public function get_machine($machine_id)
    {
        $this->db->where('machine_id', $machine_id);
        $result = $this->db->get('bud_machines');
        return $result->row();
    }
    public function get_machines($machine_status = false)
    {
        if(!empty($machine_status))
        {
        	$this->db->where('machine_status', $machine_status);
        }
        $result = $this->db->get('bud_machines');
        return $result->result();
    }
    public function get_items($item_status = false)
    {
    	if(!empty($item_status))
    	{
    		$this->db->where('item_status', $item_status);
    	}
        $this->db->order_by('item_name', 'asc');
    	$result = $this->db->get('bud_items');
        return $result->result();
    }
    public function get_shades($shade_status = false)
    {
        if(!empty($shade_status))
        {
        	$this->db->where('shade_status', $shade_status);
        }
        $result = $this->db->get('bud_shades');
        return $result->result();
    }
    public function save_lot($save)
    {
        if($save['lot_id'])
        {
            $this->db->where('lot_id', $save['lot_id']);
            $this->db->update('bud_lots', $save);
            return $save['lot_id'];
        }
        else
        {
            $this->db->insert('bud_lots', $save);
            return $this->db->insert_id();
        }
    }

    public function save_lot_for_new_feature($save)
    {
        
       
            $this->db->insert('bud_lots', $save);
            return $this->db->insert_id();
        
    }

    public function save_dlc_packing_items($save)
    {
        if($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('bud_dlc_packing_items', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('bud_dlc_packing_items', $save);
            return $this->db->insert_id();
        }
    }
    public function save_dlc_packing_items_for_new_feature($save)
    {
        
           
        
            $this->db->insert('bud_dlc_packing_items', $save);
            return $this->db->insert_id();
        
    }

    function get_lots($filter = array())
    {
        $this->db->select('bud_lots.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_shades','bud_lots.lot_shade_no = bud_shades.shade_id', 'left');
        $this->db->join('bud_items','bud_lots.lot_item_id = bud_items.item_id', 'left');
        $this->db->group_by('bud_lots.lot_id');
        $this->db->where('bud_lots.direct_entry', 1);
        if(count($filter))
        {
            if(isset($filter['shade_id']))
            {
                $this->db->where('bud_lots.lot_shade_no', $filter['shade_id']);
            }
            if(isset($filter['item_id']))
            {
                $this->db->where('bud_lots.lot_item_id', $filter['item_id']);
            }
        }
        $this->db->order_by('lot_id', 'desc');
        return $this->db->get('bud_lots')->result();
    }

    function get_lots_by_qty($filter = array())
    {
        $this->db->select('bud_lots.*,SUM(bud_lots.lot_qty) as total_lot_qty,SUM(bud_lots.no_springs) as total_no_springs,SUM(bud_lots.lot_oil_required) as total_lot_oil_required,MAX(bud_lots.id) as latest_id');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_shades','bud_lots.lot_shade_no = bud_shades.shade_id', 'left');
        $this->db->join('bud_items','bud_lots.lot_item_id = bud_items.item_id', 'left');
        $this->db->group_by('bud_lots.lot_no');
        $this->db->where('bud_lots.direct_entry', 1);
        if(count($filter))
        {
            if(isset($filter['shade_id']))
            {
                $this->db->where('bud_lots.lot_shade_no', $filter['shade_id']);
            }
            if(isset($filter['item_id']))
            {
                $this->db->where('bud_lots.lot_item_id', $filter['item_id']);
            }
        }
        $this->db->order_by('lot_id', 'desc');
        return $this->db->get('bud_lots')->result();
    }


    function get_latest_lots($latest_id)
    {
        $this->db->select('bud_lots.*');
       
        $this->db->where('bud_lots.direct_entry', 1);
        $this->db->where('bud_lots.id',$latest_id);
        return $this->db->get('bud_lots')->result(0);
    }
    public function save_packing($save)
    {
        if($save['box_id'])
        {
            $this->db->where('box_id', $save['box_id']);
            $this->db->update('bud_yt_packing_boxes', $save);
            return $save['box_id'];
        }
        else
        {
            if($this->check_boxno_exist($save['box_prefix'], $save['box_no']))
            {
                $this->db->insert('bud_yt_packing_boxes', $save);
                return $this->db->insert_id();                
            }
        }
    }

    public function check_boxno_exist($box_prefix, $box_no)
    {
        $this->db->select('box_no');
        $this->db->from('bud_yt_packing_boxes');
        $this->db->where('box_prefix', $box_prefix);
        $this->db->where('box_no', $box_no);
        $count = $this->db->count_all_results();
        if ($count > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function get_direct_packings($is_deleted = false, $direct_pack_only = true)
    {
        $this->db->select('bud_yt_packing_boxes.*');
        $this->db->select('bud_lots.lot_no as lot_lot_no');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_lots', 'bud_yt_packing_boxes.lot_no=bud_lots.lot_id', 'left');
        $this->db->join('bud_items', 'bud_yt_packing_boxes.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_yt_packing_boxes.shade_no=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_yt_packing_boxes.packed_by=bud_users.ID', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        $this->db->group_by('bud_yt_packing_boxes.box_id');  //new
        if(!empty($is_deleted))
        {
            $this->db->where('bud_yt_packing_boxes.is_deleted', $is_deleted);
        }
        if(!empty($direct_pack_only))
        {
            $this->db->where('bud_yt_packing_boxes.box_prefix', 'DIR');
        }
        $this->db->where('bud_yt_packing_boxes.is_deleted', 0);        

        $this->db->order_by('bud_yt_packing_boxes.box_id', 'desc');
        return $this->db->get('bud_yt_packing_boxes')->result();
    }

    public function get_direct_pack_box($box_id = false)
    {
        $this->db->select('bud_yt_packing_boxes.*');
        $this->db->select('bud_lots.lot_no as lot_lot_no');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_users.user_nicename');
        $this->db->select('bud_shades.shade_name, bud_shades.shade_code');
        $this->db->select('bud_stock_rooms.stock_room_name');
        $this->db->join('bud_lots', 'bud_yt_packing_boxes.lot_no=bud_lots.lot_id', 'left');
        $this->db->join('bud_items', 'bud_yt_packing_boxes.item_id=bud_items.item_id', 'left');
        $this->db->join('bud_shades', 'bud_yt_packing_boxes.shade_no=bud_shades.shade_id', 'left');
        $this->db->join('bud_users', 'bud_yt_packing_boxes.packed_by=bud_users.ID', 'left');
        $this->db->join('bud_stock_rooms', 'bud_yt_packing_boxes.stock_room_id=bud_stock_rooms.stock_room_id', 'left');
        if(!empty($box_id))
        {
            $this->db->where('bud_yt_packing_boxes.box_id', $box_id);
        }
        return $this->db->get('bud_yt_packing_boxes')->row();
    }

    public function get_stock_rooms($concern_id = false)
    {
        if(!empty($concern_id))
        {
            $this->db->where('concern_id', $concern_id);
        }
        $result = $this->db->get('bud_stock_rooms');
        return $result->result();
    }

    function get_lot_details($lot_no,$id='')
    {
        
        $this->db->select('bud_lots.*');
        $this->db->select('bud_items.item_name');
        $this->db->select('bud_shades.shade_name,bud_shades.shade_code');
        $this->db->join('bud_shades','bud_lots.lot_shade_no = bud_shades.shade_id', 'left');
        $this->db->join('bud_items','bud_lots.lot_item_id = bud_items.item_id', 'left');
        $this->db->where('bud_lots.direct_entry', 1);
        $this->db->where('bud_lots.lot_no',$lot_no);
        if($id!='')
        {
            $this->db->where('bud_lots.id',$id);   
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get('bud_lots')->result();
    }


    public function lot_update($id,$save,$lot_no='')
    {
        if(!empty($id))
        {
            $this->db->where('id', $id);
        }
        if($lot_no!='')
        {
            $this->db->where('lot_no', $lot_no);
        }
        $this->db->update('bud_lots', $save);
    }
}