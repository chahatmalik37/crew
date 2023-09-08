<?php

namespace App\Controllers;

use system\I18n\Time;
use App\Models\EmployeeModel;
use App\Models\EventsModel;
use App\Models\Employee_DocumentModel;
use App\Models\UserModel;
use App\Models\AttendanceModel;
use App\Libraries\Common;
use App\Controllers\BaseController;

class SearchStaff extends BaseController
{   private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        helper('form');

        // echo view('include/header');
        echo view('staff_search');
        // echo view('include/footer');
    }
    public function search_data(){
    //   echo "<pre>";
    //     print_r($_POST); 
    	$search_text =  $this->request->getVar('search_text');
    	$text = gettype($search_text);
    // 	echo $text;
// exit;
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.*,dr.*,ed.*,at.*,user.*,emp.id as emp_id,at.id as atten_id,dr.id as discont_id,ed.id as emp_doc_id,user.id as ur_id,emp.status as act_deact_re');
        // $builder->select('emp.*,at.*');
        $builder->join('employee_discont_reactive as dr', 'emp.id = dr.employee_id', "left");
        $builder->join('employee_document as ed', 'emp.upload_document_id = ed.id', "left");
        $builder->join('attendance as at', 'emp.id = at.employee_id', "left"); 
        $builder->join('user', 'emp.id = user.employee_id', "left"); 
        // $query['search'] = $builder->get()->getResultArray();

        if($text === 'integer'){
            // echo "int";
        
            $builder->like('emp.per_mobile_no', $search_text);
            $builder->orlike('at.leave_per_month', $search_text);
            $builder->orlike('at.attendance_exempt', $search_text);
            $builder->orlike('at.report_exempt', $search_text);
            $builder->orlike('at.break_exempt', $search_text);
            $builder->orlike('at.ip_exempt', $search_text);
            // $builder->orlike('at.discontinuation_doc_id', $search_text);
            // $builder->orlike('dr.discontinuation_doc_id', $search_text);
            $builder->orlike('at.break_permitted', $search_text);
            $builder->orlike('at.weekly_off', $search_text);
            // $query['search'] = $builder->get()->getResultArray();
        }elseif($text === 'string'){

            $chkDate = strtotime($search_text);
            // $chkDate = preg_filter('/[0-9]+[0-9]+[0-9]/','($0)', $search_text);
            // echo $chkDate."char";

            if(!empty($chkDate)){
            // echo "Date";

        
                $builder->like('emp.date_of_joining', $search_text);
                $builder->orlike('emp.dob', $search_text);
                $builder->orlike('emp.anniversary_date', $search_text);
                $builder->orlike('at.login_time', $search_text);
                $builder->orlike('at.logout_time', $search_text);
                $builder->orlike('emp.per_mobile_no', $search_text);
                // $query['search'] = $builder->get()->getResultArray();
            }else{
            // echo "String";

                
                $builder->like('emp.name', $search_text, 'both');
                $builder->orlike('emp.per_mobile_no', $search_text,'both');
                $builder->orlike('emp.emp_short_code', $search_text, 'both');
                $builder->orlike('emp.legal_name', $search_text, 'both');
                $builder->orlike('emp.per_email_id', $search_text, 'both');
                $builder->orlike('emp.salary_bank_detail', $search_text, 'both');
                $builder->orlike('emp.gender', $search_text, 'both');
                $builder->orlike('emp.relationship_kin', $search_text, 'both');
                $builder->orlike('emp.kin_name', $search_text, 'both');
                $builder->orlike('emp.kin_address', $search_text, 'both');
                $builder->orlike('emp.kin_job', $search_text, 'both');
                $builder->orlike('emp.kin_current_address', $search_text, 'both');
                $builder->orlike('emp.emp_current_address', $search_text, 'both');
                $builder->orlike('dr.comments', $search_text, 'both');
                $builder->orlike('dr.reactive_authorized_by', $search_text, 'both');
                $builder->orlike('dr.reactive_reason', $search_text, 'both');
                $builder->orlike('ed.file_name', $search_text,'both');
                $builder->orlike('ed.document_name', $search_text,'both');
                $builder->orlike('user.login_id', $search_text, 'both');
                // $query['search'] = $builder->get()->getResultArray();
                
            }
        }
        $builder->groupBy('emp.id');
        $builder->orderBy('emp.status','ASC');
        $query['search'] = $builder->get()->getResultArray();
        // To get last query executed
        // echo $this->db->getLastQuery();

        // $query['search'] = $builder->get()->getResultArray();
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";
         // $model = new EmployeeModel();
         // $Common = new Common();
         // echo $Common->SaveRecord($model,$data);
        // echo view('include/header');
        echo view('staff_search',$query);
        // echo view('include/footer');
    }

}