<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_Reminder extends CI_Model {

    public function __construct()    {
        $this->load->database();
    }

    public function new_reminder($user_id, $message, $after_exec, $repeat_after, $eventstart) {
        $o = (object) [
            "user_id" => $user_id,
            "message" => $message,
            "after_exec" => $after_exec,
            "repeat_after" => $repeat_after,
            "eventstart" => $eventstart
        ];
        if ($this->db->insert('reminders',$o)) {
            //echo $this->db->last_query();
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function get_all_reminders($user_id) {
        return $this->db->select("*")->from('reminders')
                    ->where('user_id',$user_id)
                    ->get()->result();
    }
}
    