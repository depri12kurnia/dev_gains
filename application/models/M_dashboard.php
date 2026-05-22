<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{

    public function get_user_progress($user_id)
    {
        $this->db->select('
            u.id as user_id,
            p.status as payment_status,
            p.comment as payment_comment,
            p.proof_file,
            s.status as submission_status,
            s.title as submission_title
        ');
        $this->db->from('users u');
        // Join ke tabel payments
        $this->db->join('payments p', 'u.id = p.user_id', 'left');
        // Join ke tabel submissions
        $this->db->join('submissions s', 'u.id = s.user_id', 'left');
        $this->db->where('u.id', $user_id);

        $query = $this->db->get();
        return $query->row(); // Mengembalikan satu baris data sebagai object
    }
}
