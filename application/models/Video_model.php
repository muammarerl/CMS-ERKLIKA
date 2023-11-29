<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

    public function get_data() {
        $this->db->select('id, video_id, name_id, description_id, caption_id, labels');
        $this->db->from('sv_videos');
        $query = $this->db->get();

        return $query->result();
    }
}