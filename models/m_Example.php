<?php
class m_Example extends CI_Model {

    public function __construct()    {
        $this->load->database();
    }
    
    public function timestamp() {
        $phpdate = new DateTime();
        $phpdate->setDate(2018,2,23);
        $phpdate->setTime(12,56);
        $d = (object) [
            "eventstart" => date( 'Y-m-d H:i:s', $phpdate->getTimestamp() )
            ];
        $this->db->insert('reminders',$d);
    }


}