<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminder extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_reminder');
        $this->load->helper('html_gen');
    }
    
	public function index()
	{
	    // load all the data needed in the views in variables to be passed as second parameter
	    $data['dummy'] = $this->hdata->iam_id; 
	    
		$this->load->view('intro');
		$this->load->view('v_reminder',$data);
	}
    
    private function make_date($y, $mo, $d, $h, $mi) {
        $phpdate = new DateTime();
        $phpdate->setDate($y,$mo,$d);
        $phpdate->setTime($h,$mi);
        return $phpdate;
    }

    public function ajax() {
	    switch($this->hdata->aktion) {
            case 'TEST_DATE':
                // check if the dates are acceptable
                $ret = new stdClass();
                $phpdate = $this->make_date((int)$this->hdata->fyear,(int)$this->hdata->fmonth,
                                            (int)$this->hdata->fday,
                                            (int)$this->hdata->fhour,(int)$this->hdata->fminute);

                if ($phpdate->getTimestamp() < time()) {
                    $ret->mex_1 = "Wrong date or date is in the past";
                } else {
                    $ret->mex_1 = $phpdate->format('l - d F Y - H:i');
                }
                // try to add the interval
                $phpdate->modify("+" . (int)$this->hdata->rmonth . " months");
                $phpdate->modify("+" . (int)$this->hdata->rday . " days");
                $phpdate->modify("+" . (int)$this->hdata->rminute . " minutes");
                $phpdate->modify("+" . (int)$this->hdata->rhour . " hours");
                $ret->mex_2 = $phpdate->format('l - d F Y - H:i');
                echo json_encode($ret);

                break;
            case 'SAVE_NEW_ITEM':
                $phpdate = $this->make_date((int)$this->hdata->fyear,(int)$this->hdata->fmonth,
                                    (int)$this->hdata->fday,
                                    (int)$this->hdata->fhour,(int)$this->hdata->fminute);

                $reschedule = "no";
                if ($this->hdata->after_exec == 'R') {
                    $reschedule = sprintf("%d %d %d %d",(int)$this->hdata->rmonth,
                                (int)$this->hdata->rday, (int)$this->hdata->rhour,
                                (int)$this->hdata->rminute);
                }
                $ret = $this->m_reminder->new_reminder($this->hdata->iam_id,
                                                $this->hdata->message,
                                                $this->hdata->after_exec,
                                                $reschedule, $phpdate->getTimestamp() );
                echo ($ret . $reschedule);
                break;

                        
        }
    }	

    public function all() {
        // retrieve the list of reminders of the current user
        $reminders = $this->m_reminder->get_all_reminders($this->hdata->iam_id);
        $html = "";
        $html .= span("A",["class"=>"rem_list_header","style"=>"width:30px;"]);
        $html .= span("S",["class"=>"rem_list_header","style"=>"width:30px;"]);
        $html .= span("Message",["class"=>"rem_list_header","style"=>"width:600px;"]);
        $html .= span("Trigger",["class"=>"rem_list_header","style"=>"width:200px;"]);
        $html .= span("Next",["class"=>"rem_list_header","style"=>"width:30px;"]);

        $phpdate = new DateTime();
        foreach($reminders as $rem) {
            $html .= br();
            $html .= span("[x]",["class"=>"rem_list_item","style"=>"width:30px;"]);
            $html .= span($rem->state,["class"=>"rem_list_item","style"=>"width:30px;"]);
            $html .= span($rem->message,["class"=>"rem_list_item","style"=>"width:600px;"]);
            $phpdate->setTimestamp($rem->eventstart);
            $html .= span($phpdate->format('l - d F Y - H:i'),["class"=>"rem_list_item","style"=>"width:200px;"]);
            $html .= span($rem->after_exec,["class"=>"rem_list_item","style"=>"width:30px;"]);
        }

        echo $html;

    }
}
    