<?php
class M_payment extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }


    var $table = 'payments';
    var $column_order = array('payments.id', 'payments.user_id', 'payments.bank_name', 'payments.sender_name', 'payments.status');
    var $column_search = array('payments.user_id', 'payments.bank_name', 'payments.sender_name', 'payments.status');
    var $order = array('payments.id' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('payments.id, users.email, users.first_name, users.last_name, payments.user_id, payments.bank_name, payments.sender_name, payments.status');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = payments.user_id');
        $this->db->order_by('payments.id', 'desc');

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
                $i++;
            }
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
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

    public function get_by_id($id)
    {
        $this->db->select('payments.*, users.email');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = payments.user_id');
        $this->db->where('payments.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_payment($id, $data)
    {
        return $this->db->where('id', $id)
            ->update('payments', $data);
    }

    public function update_by_user($user_id, $data)
    {
        return $this->db->where('user_id', $user_id)
            ->update('payments', $data);
    }

    public function get_all($id = null)
    {
        if ($id !== null) {
            $this->db->where('user_id', $id);
        }

        return $this->db->order_by('created_at', 'DESC')
            ->get('payments')
            ->result();
    }
}
