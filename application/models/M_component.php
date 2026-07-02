<?php
class M_component extends CI_Model
{
    /**
     * Mengambil semua komponen aktif berdasarkan kategori kompetensi
     */
    public function get_components_by_category($category)
    {
        return $this->db->where('is_active', 1)
            ->where('category_code', $category)
            ->order_by('id', 'ASC')
            ->get('assessment_components')
            ->result_array();
    }

    /**
     * Memproses simpan data massal (Insert, Update, Soft Delete)
     */
    public function save_assessment_components_batch($components_data, $category_code)
    {
        // Jalankan Database Transaction Guard
        $this->db->trans_start();

        $kept_ids = [];
        $new_inserts = [];

        foreach ($components_data as $row) {
            // Lewati jika nama komponen kosong
            if (empty($row['component_name'])) {
                continue;
            }

            $id          = (!empty($row['id']) && is_numeric($row['id'])) ? $row['id'] : null;
            $name        = $row['component_name'];
            $description = !empty($row['description']) ? $row['description'] : null;
            $weight      = (int)$row['weight'];
            $score_1_desc = !empty($row['score_1_desc']) ? $row['score_1_desc'] : null;
            $score_2_desc = !empty($row['score_2_desc']) ? $row['score_2_desc'] : null;
            $score_3_desc = !empty($row['score_3_desc']) ? $row['score_3_desc'] : null;
            $score_4_desc = !empty($row['score_4_desc']) ? $row['score_4_desc'] : null;
            $score_5_desc = !empty($row['score_5_desc']) ? $row['score_5_desc'] : null;

            // KONDISI 1: Jika baris memiliki ID numerik asli -> Lakukan UPDATE
            if ($id !== null) {
                $update_data = [
                    'category_code'  => $category_code,
                    'component_name' => $name,
                    'weight'         => $weight,
                    'description'    => $description,
                    'score_1_desc'    => $score_1_desc,
                    'score_2_desc'    => $score_2_desc,
                    'score_3_desc'    => $score_3_desc,
                    'score_4_desc'    => $score_4_desc,
                    'score_5_desc'    => $score_5_desc,
                    'is_active'      => 1
                ];
                $this->db->where('id', $id)->update('assessment_components', $update_data);
                $kept_ids[] = $id;
            }
            // KONDISI 2: Baris baru tanpa ID -> Siapkan untuk INSERT massal
            else {
                $new_inserts[] = [
                    'category_code'  => $category_code,
                    'component_name' => $name,
                    'weight'         => $weight,
                    'description'    => $description,
                    'score_1_desc'    => $score_1_desc,
                    'score_2_desc'    => $score_2_desc,
                    'score_3_desc'    => $score_3_desc,
                    'score_4_desc'    => $score_4_desc,
                    'score_5_desc'    => $score_5_desc,
                    'is_active'      => 1
                ];
            }
        }

        // 1. Eksekusi Insert Batch data baru jika ada
        if (!empty($new_inserts)) {
            $this->db->insert_batch('assessment_components', $new_inserts);

            $first_id = $this->db->insert_id();
            $affected = $this->db->affected_rows();
            for ($k = 0; $k < $affected; $k++) {
                $kept_ids[] = $first_id + $k;
            }
        }

        // 2. SOFT DELETE MECHANISM: Nonaktifkan kriteria yang dihapus dari layar oleh user
        if (!empty($kept_ids)) {
            $this->db->where('category_code', $category_code)
                ->where_not_in('id', $kept_ids)
                ->update('assessment_components', ['is_active' => 0]);
        } else {
            $this->db->where('category_code', $category_code)
                ->update('assessment_components', ['is_active' => 0]);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
