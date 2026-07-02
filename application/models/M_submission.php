<?php
class M_submission extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }


    var $table = 'submissions';
    var $column_order = array('submissions.id', 'submissions.user_id', 'submissions.team_leader',  'submissions.leader_titles', 'submissions.institution', 'submissions.country', 'submissions.partType', 'submissions.crossCollab', 'submissions.team_members', 'submissions.category', 'submissions.title', 'submissions.focus_area', 'submissions.alignment_theme', 'submissions.link', 'submissions.supporting_links', 'submissions.status');
    var $column_search = array('submissions.user_id', 'submissions.team_leader', 'submissions.leader_titles', 'submissions.institution', 'submissions.country', 'submissions.partType', 'submissions.crossCollab', 'submissions.team_members', 'submissions.category', 'submissions.title', 'submissions.focus_area', 'submissions.alignment_theme', 'submissions.link', 'submissions.supporting_links', 'submissions.status');
    var $order = array('submissions.id' => 'desc');

    private function _get_datatables_query()
    {
        $this->db->select('submissions.id, users.email, submissions.user_id, submissions.team_leader, submissions.leader_titles, submissions.institution, submissions.country, submissions.partType, submissions.crossCollab, submissions.team_members, submissions.category, submissions.title, submissions.focus_area, submissions.alignment_theme, submissions.link, submissions.supporting_links, submissions.status');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = submissions.user_id');
        $this->db->order_by('submissions.id', 'desc');

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

        // Filter by category
        if (!empty($_POST['category'])) {
            $this->db->where('submissions.category', $_POST['category']);
        }

        // Filter by status
        if (!empty($_POST['status'])) {
            $this->db->where('submissions.status', $_POST['status']);
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

    public function get_by_id($id)
    {
        $this->db->select('submissions.*, users.email');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = submissions.user_id');
        $this->db->where('submissions.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function update_by_user($user_id, $data)
    {
        return $this->db->where('user_id', $user_id)
            ->update('submissions', $data);
    }

    public function update_submission($id, $data)
    {
        return $this->db->where('id', $id)
            ->update('submissions', $data);
    }

    public function get_all($id = null)
    {
        if ($id !== null) {
            $this->db->where('user_id', $id);
        }

        return $this->db->order_by('created_at', 'DESC')
            ->get('submissions')
            ->result();
    }
}
