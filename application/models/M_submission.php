<?php
class M_submission extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function insert_submission($data)
    {
        return $this->db->insert('submissions', $data);
    }
    public function get_by_user($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->get('submissions')
            ->row();
    }
    public function update_by_user($user_id, $data)
    {
        return $this->db->where('user_id', $user_id)
            ->update('submissions', $data);
    }
}
