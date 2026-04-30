<?php
class M_payment extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function insert_payment($data)
    {
        return $this->db->insert('payments', $data);
    }

    public function get_by_user($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('id', 'DESC')
            ->get('payments')
            ->row(); // ambil terbaru
    }

    public function update_by_user($user_id, $data)
    {
        return $this->db->where('user_id', $user_id)
            ->update('payments', $data);
    }
}
