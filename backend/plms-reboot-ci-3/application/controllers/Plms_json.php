
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plms_json extends MY_Controller {	

    public function __construct()	{
        parent::__construct();
        $_SESSION['walk'] .= __METHOD__;		
    }

    public function index()
    {
        $_SESSION['walk'] .= __METHOD__;
        echo json_encode(__METHOD__);

    }
    // 2565-01-13
    public function get_online_student($ci_session) {
        // convert string to number as neccessary
        if(!is_numeric($ci_session)) {
            $ci_session = intval($ci_session);
        }
        $this->load->model('lab_model');
        $user = $this->lab_model->get_user($ci_session);
        // echo json_encode($user); return ;
        if (!$user) {
            echo json_encode("Not_Found"); return ;
        }
        header('Content-Type: application/json; charset=utf-8');
        // header('Content-Type: application/json');
        // echo json_encode($user);
        if ($user['status'] != 'online') {
            echo json_encode("NOT_ALLOW"); return ;
        }
        //update last_seen
        // $this->lab_model->update_user_last_seen($user['id']);
        $online_student = $this->lab_model->get_online_student();
        echo json_encode($online_student); return ;
        //echo __METHOD__;
        $this->load->model('lab_model');
        $online_student = $this->lab_model->get_online_student();
        //echo "<pre/>"; print_r($online_student); echo "</pre>";
        $data = array();
        $data['online_student'] =$online_student;
        if ($user_role == 'supervisor') {
            $data['group_status'] = $this->lab_model-> get_class_schedule_all();
        }
        echo json_encode($data);
        //echo json_encode($online_student);
    }



    //2021-03-07
    public function landing_page() {
       
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        $decoded="na";
        if ($contentType === "application/json") {
            //Receive the RAW post data.
            $content = trim(file_get_contents("php://input"));

            $decoded = json_decode($content, true);

            //If json_decode failed, the JSON is invalid.
            if(! is_array($decoded)) {
                echo json_encode("not array");

            } else {
                // Send error back to user.
            }
        }
        
        $data ='elapsed_time = ';
        $data .= floatval($decoded['infoForTracking']['elapsed_time'])*1000;
        $data .= " milliseconds.";
       
        
        $elapsed_time_sec = floatval($decoded['infoForTracking']['elapsed_time']);
        $elapsed_time_micro = 1000000*$elapsed_time_sec;        
        $elapsed_time_micro = intval($elapsed_time_micro);

        $activity_log = $decoded['infoForTracking'];
        $activity_log['elapsed_time'] = $elapsed_time_micro;
        $activity_log['server_port'] =  intval($activity_log['server_port']);
        $activity_log['client_port'] =  intval($activity_log['client_port']);
        $activity_log['ci_id'] =  intval($activity_log['ci_id']);
        $activity_log['requestTime'] =  intval($activity_log['requestTime']);

        $this->load->model('activityLog_model');
        $result = $this->activityLog_model->addActivity( $activity_log);

        echo json_encode( $result );
    }

    // 2021-03-09
    public function student_activity_log() {
        // //echo __METHOD__; return;
        // //echo json_encode( __METHOD__ );        return;
        // $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        // $decoded="na";
        // echo json_encode( __METHOD__ );        return;
        // if ($contentType === "application/json") {
        //     //Receive the RAW post data.
        //     $content = trim(file_get_contents("php://input"));

        //     $decoded = json_decode($content, true);
        //     echo json_encode("123");
        //     //echo json_encode( __METHOD__ );        return;
        //     //echo json_encode( $decoded );            return ;


        //     //If json_decode failed, the JSON is invalid.
        //     if(! is_array($decoded)) {
        //         echo json_encode("not array");

        //     } else {
        //         // Send error back to user.
        //         echo json_encode("123");
        //     }
        // }
        // //echo json_encode( $decoded );            return ;
        // //$this->load->model('activityLog_model');
        
        // $this->load->model('activityLog_model');
        // //echo json_encode( $decoded );            return ;
        // $result = $this->activityLog_model->addActivityStudent( $decoded);
        // echo json_encode( $result );            return ;
        // //$result .= " ==> ok";
        // echo json_encode( "ok ".$result );

    }

    public function test_json_post() {
        return "555";
    }

    // 13 March 2021
    public function update_submission_time ($submission_id,$elapsed_time_micro) {
        // $data = $submission_id." --- ".$elapsed_time_micro;
        // echo json_encode($data);

        $this->load->model('student_model');
        $result = $this->student_model->update_submission_time ($submission_id,$elapsed_time_micro);
        echo json_encode($result);
       

    }

    // 29 March 2021
    public function exercise_access_toggle () {
        // $content = trim(file_get_contents("php://input"));
        // $decoded = json_decode($content, true);
        // echo json_encode($decoded);
        // return;


        $x = $_GET['x'];
        $y = $_GET['y'];
        // echo json_encode(__METHOD__);
        // $name = $_POST['name'];
        // $x=file_get_contents('php://input');
        if ($x) {
            echo json_encode($_GET);
        }else {
            echo json_encode("NO POST DATA");
        }
        
       

    }
    // 5 October 2022
    public function get_midterm_score ($user="none",$ci_session=0) {
        $this->load->model('student_model');
        $stu_record = $this->student_model->get_student_record();
        $stu_midscore = array(
            'mid_score'     =>  $stu_record['mid_score']
        );
        echo json_encode($stu_midscore); return ;
        // // convert string to number as neccessary
        // if(!is_numeric($ci_session)) {
        //     $ci_session = intval($ci_session);
        // }
        // $this->load->model('lab_model');
        // $user_cf = $this->lab_model->get_user($ci_session);

        // $this->load->model('student_model');
        // $stu_id = $user;
        // $result = $this->student_model->retrieve_student_record($stu_id);
        
        // echo json_encode($result); return ;

        
    }

     // 5 October 2022
     public function test () {
        $_SESSION['walk'] .= " ==> ".__METHOD__;
        // echo json_encode($_SERVER); return ;
        echo json_encode($_SESSION); return ;
        // echo json_encode(apache_request_headers()); return ;
        echo json_encode(getallheaders()); return ;
        
    }
    
}

