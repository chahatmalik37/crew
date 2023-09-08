<?php

namespace App\Controllers;

use system\I18n\Time;
use App\Models\EmployeeModel;
use App\Models\AllotmentModel;
use App\Models\AntivirusModel;
use App\Models\OnceEmailModel;
use App\Models\SimCardModel;
use App\Models\EventsModel;
use App\Models\Employee_DocumentModel;
use App\Models\UserModel;
use App\Models\AttendanceModel;
use App\Models\Employee_Discont_ReactiveModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
// use Dompdf\Dompdf;

class Employee extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form');

        // echo view('include/header');
        echo view('staff');
        // echo view('include/footer');
          
    }
    public function insert()
    {
        $session = session();
        if($session->has('username')){
        $Common = new Common();

       
        $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
        $data = [
            'name' => $this->request->getVar('name_allotted'),
            'emp_short_code' => $this->request->getVar('ShortCode'),
            'date_of_joining' => $this->request->getVar('datejoining'),
            'legal_name' => $this->request->getVar('legalname'),
            'per_email_id' => $this->request->getVar('personalemailid'),
            'per_mobile_no' => $this->request->getPost('percontactno'),
            'dob' => $this->request->getVar('dob'),
            'gender' => $this->request->getVar('gender'),
            'anniversary_date' => $this->request->getVar('anniversary'),
            'salary_bank_detail' => $this->request->getVar('salary_bank'),
            // 'upload_document_id'=> $res,
            'relationship_kin' => $this->request->getVar('Relkin'),
            'kin_name' => $this->request->getVar('kinsname'),
            'kin_mobile_no' => $this->request->getVar('Kinsmobileno'),
            'kin_address' => $this->request->getVar('Kinsadd'),
            'kin_job' => $this->request->getVar('Kinsjob'),
            'kin_current_address' => $this->request->getVar('Currentaddress'),
            'emp_current_address' => $this->request->getVar('currentlocation'),
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',
            'reference' => $this->request->getVar('reference'),

        ];
        $model = new EmployeeModel();
        $res2 = $Common->SaveRecordGetId($model, $data);
        $filesUploaded = 0;
        $doc_id_str = '';
        if ($this->request->getFileMultiple('fileuploads')) {
            $files = $this->request->getFileMultiple('fileuploads');
            foreach ($files as $file) {

                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/', $newName);
                    $data2 = [
                        'file_name' => $file->getClientName(),
                        'filepath' => 'uploads/' . $newName,
                        'type' => $file->getClientExtension(),
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active',
                    ];
                    $fileUploadModel = new Employee_DocumentModel();
                    $doc_id2 = $Common->SaveRecordGetId($fileUploadModel, $data2);
                    $doc_array2[] = explode(",", $doc_id2);

                    $filesUploaded++;
                }
            }
        }

        $modelName = new EmployeeModel();

        $doc_data = $modelName->where('id', $res2)->first();

        if (isset($doc_array2)) {
            foreach ($doc_array2 as $val) {
                $doc_id_str .=  "," . implode(",", $val);
            }
            // print_r($doc_id_str);

            $data10 = [
                'updated_by' => $session->get('username'),
                'updated_on' => $now,
                'upload_document_id' => $doc_data['upload_document_id'] . $doc_id_str,
            ];
            $Common->UpdateRecord($model, $data10, $res2);
        }
        if ($this->request->getVar('dob')) {
            $data5 = [
                'head' => 'Birthday',
                'employee_id' => $res2,
                'start' => $this->request->getVar('dob'),
                'updated_by' => $session->get('username'),
                'updated_on' => $now,
            ];
            $model5 = new EventsModel();
            $Common->SaveRecord($model5, $data5);
        }
        if ($this->request->getVar('datejoining') != '') {

            $data12 = [
                'head' => 'Joining',
                'employee_id' => $res2,
                'start' => $this->request->getVar('datejoining'),
                'updated_by' => $session->get('username'),
                'updated_on' => $now,
            ];

            $model12 = new EventsModel();
            $Common->SaveRecord($model12, $data12);
        }
        if ($this->request->getVar('anniversary')) {
            $data6 = [
                'head' => 'Anniversary',
                'employee_id' => $res2,
                'start' => $this->request->getVar('anniversary'),
                'updated_by' => $session->get('username'),
                'updated_on' => $now,
            ];
            $model6 = new EventsModel();
            $Common->SaveRecord($model6, $data6);
        }
        // $model->employee_added_data($data);
        $data3 = [
            'employee_name' => $this->request->getVar('name_allotted'),
            'login_id' => $this->request->getVar('login'),
            'login_password' => MD5($this->request->getVar('password')),
            'employee_id' => $res2,
            'user_type' => 'User',
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',

        ];
        $model3 = new UserModel();
        $user_id = $Common->SaveRecordGetId($model3, $data3);

        $data4 = [

            'employee_id' => $res2,
            'login_time' => $this->request->getVar('logintime'),
            'logout_time' => $this->request->getVar('logout'),
            'break_permitted' => $this->request->getVar('break'),
            'weekly_off' => $this->request->getVar('weekoff'),
            'leave_per_month' => $this->request->getPost('leave'),
            'attendance_exempt' => $this->request->getVar('attendanceexempt'),
            'break_exempt' => $this->request->getVar('breakexempt'),
            'report_exempt' => $this->request->getVar('reportexempt'),
            'ip_exempt' => $this->request->getVar('ipexempt'),
            'wifi_ip' => $this->request->getVar('wifiip'),
            'updated_by' =>$session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',

        ];
        $model4 = new AttendanceModel();
        $attend_id = $Common->SaveRecordGetId($model4, $data4);
            $data7 = [
                'date_of_leaving' => $this->request->getVar('dateofleaving'),
                'comments' => $this->request->getVar('Comment'),
                'leaving_reason' => $this->request->getVar('reasonforleaving'),
                'date_of_rejoin' => $this->request->getVar('dateofrejoin'),
                'reactive_authorized_by' => $this->request->getVar('auth'),
                'reactive_reason' => $this->request->getVar('reason'),
                'employee_id' => $res2,
                // 'discontinuation_doc_id' => $res,
                'updated_by' =>$session->get('username'),
                'updated_on' => $now,
                'status' => 'Deactive',

            ];
           
        $data8 = [
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Deactive',

        ];
        if ($this->request->getVar('dateofleaving') != '') {

            $model7 = new Employee_Discont_ReactiveModel();
            $Common->SaveRecord($model7, $data7);
            $Common->UpdateRecord($model4, $data8, $attend_id);
            $Common->DeleteRecord($model3, $user_id);
            $Common->UpdateRecord($model, $data8, $res2);
            // $Common->UpdateRecord($model2, $data8, $doc_id);

        }
        }
        else{
        $session->setFlashdata('warning','Session Expired!Please Login');
        $session->destroy();
         return redirect('')->to('/');
    }
    }

    public function store()
    {
         $session = session();
        if($session->has('username')){
        helper('form');

        $data = [];
        $rules = [
            'legalname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Required'
                ],
            ],
             'name_allotted' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Required'
                ],
            ],
            'ShortCode' =>  [
                'rules' => 'required|is_unique[employee.emp_short_code]|alpha_numeric',
                'errors' => [
                    'required' => 'Required',
                    'alpha_numeric'=>'Alpha-numeric Allowed',
                    'is_unique' => 'Already taken.'


                ],
            ],
            'personalemailid' =>   [
                'rules' => 'required|is_unique[employee.per_email_id]',
                'errors' => [
                    'required' => 'Required',
                    'is_unique' => 'Already taken.'

                ],
            ],
           
            'currentlocation' =>   [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Required'
                ],
            ],
          
            'datejoining' =>   [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Required'
                ],
            ],
            'password' =>   [
                'rules' => 'required',
                'errors' => [
                    'required' => 'You must provide a Password.'
                ],
            ],
            'login' =>   [
                'rules' => 'required|is_unique[user.login_id]',
                'errors' => [
                    'required' => 'You must provide a LoginId.',
                    'is_unique' => 'Already taken.'

                ],
            ],
            'logintime' =>   [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Required.'
                ],
            ],
            'logout' =>   [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Required.'
                ],
            ],

        ];


        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                // echo "save";
               
                $this->insert();

                return redirect()->to(base_url('Employee'))->with('status_icon', 'success')
                    ->with('status', 'Employee Inserted Successfully');
                
            } else {
                // echo "test";

                $data['validation'] = $this->validator;
                // echo view('include/header');
                echo view('staff', $data);
                // echo view('include/footer');
            }
        }
    }
    else{
        $session->setFlashdata('warning','Session Expired!Please Login');
        $session->destroy();
         return redirect('')->to('/');
    }
        
    }


    public function get_detail($id)
    {
                helper('form');

        // echo $id;
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.*,dr.*,ed.*,at.*,user.*,emp.id as emp_id,at.id as atten_id,dr.id as discont_id,ed.id as emp_doc_id,user.id as ur_id');
        // $builder->select('emp.*,at.*');
        $builder->join('employee_discont_reactive as dr', 'emp.id = dr.employee_id', "left");
        $builder->join('employee_document as ed', 'emp.upload_document_id = ed.id', "left");
        $builder->join('attendance as at', 'emp.id = at.employee_id', "left");
        $builder->join('user', 'emp.id = user.employee_id', "left");
        $builder->where('emp.id', $id);
        $query['view'] = $builder->get()->getResultArray();
        // echo "<pre>";
        // print_r($query); exit;


        // echo view('include/header');
        echo view('employee_info', $query);
        // echo view('include/footer');

        // echo $this->db->getLastQuery();
        // echo "<pre>";
        // print_r($data);

        // return $data;
        // return redirect()->to(base_url('Question'));   

    }

    public function edit($id)
    {
                helper('form');


        $builder = $this->db->table("employee as emp");
        $builder->select('emp.*,dr.*,at.*,user.*,emp.id as emp_id,at.id as atten_id,dr.id as discont_id,user.id as ur_id');
        // $builder->select('emp.*,at.*');
        $builder->join('employee_discont_reactive as dr', 'emp.id = dr.employee_id', "left");
        $builder->join('attendance as at', 'emp.id = at.employee_id', "left");
        $builder->join('user', 'emp.id = user.employee_id', "left");
        $builder->where('emp.id', $id);
        $data['employee_detail'] = $builder->get()->getResultArray();
        // echo "<pre>";
        // print_r($data);
        $query = $this->db->table("employee as emp");
        $query->select('emp.upload_document_id,ed.*');
        $query->join("employee_document AS ed", "find_in_set(ed.id,emp.upload_document_id)<> 0", "left", false);
        $query->where('emp.id', $id);
        $data['employee_doc'] = $query->get()->getResultArray();
        return view('edit_staff', $data);
    }

    public function update($id)
    {
                // echo "<pre>";
                // print_r($_POST); exit;
                helper('form');
 $session = session();
        if($session->has('username')){
        // echo 'update';
        // echo $this->request->getVar('personalemailid');
        // $doc_id = $this->request->getVar('doc_id');
        $user_id = $this->request->getVar('user_id');
        $discont_id = $this->request->getVar('discont_id');
        $attend_id = $this->request->getVar('attend_id');
        $Common = new Common();

        $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
        $data = [
            'name' => $this->request->getVar('name_allotted'),
            'emp_short_code' => $this->request->getVar('ShortCode'),
            'date_of_joining' => $this->request->getVar('datejoining'),
            'legal_name' => $this->request->getVar('legalname'),
            'per_email_id' => $this->request->getVar('personalemailid'),
            'per_mobile_no' => $this->request->getVar('percontactno'),
            'dob' => $this->request->getVar('dob'),
            'gender' => $this->request->getVar('gender'),
            'anniversary_date' => $this->request->getVar('anniversary'),
            'salary_bank_detail' => $this->request->getVar('salary_bank'),
            // 'upload_document_id'=> $res,
            'relationship_kin' => $this->request->getVar('Relkin'),
            'kin_name' => $this->request->getVar('kinsname'),
            'kin_mobile_no' => $this->request->getVar('Kinsmobileno'),
            'kin_address' => $this->request->getVar('Kinsadd'),
            'kin_job' => $this->request->getVar('Kinsjob'),
            'kin_current_address' => $this->request->getVar('Currentaddress'),
            'emp_current_address' => $this->request->getVar('currentlocation'),
            'updated_by' =>$session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',
            'reference' => $this->request->getVar('reference'),

        ];
        $model = new EmployeeModel();
        $Common->UpdateRecord($model, $data, $id);
$filesUploaded = 0;
        $doc_id_str = '';
        if ($this->request->getFileMultiple('fileuploads')) {
            $files = $this->request->getFileMultiple('fileuploads');
            foreach ($files as $file) {

                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/', $newName);
                    $data2 = [
                        'file_name' => $file->getClientName(),
                        'filepath' => 'uploads/' . $newName,
                        'type' => $file->getClientExtension(),
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active',
                    ];
                    $fileUploadModel = new Employee_DocumentModel();
                    $doc_id2 = $Common->SaveRecordGetId($fileUploadModel, $data2);
                    $doc_array2[] = explode(",", $doc_id2);

                    $filesUploaded++;
                }
            }
        }

        $modelName = new EmployeeModel();

        $doc_data = $modelName->where('id', $id)->first();

        if (isset($doc_array2)) {
            foreach ($doc_array2 as $val) {
                $doc_id_str .=  "," . implode(",", $val);
            }
            // print_r($doc_id_str);

            $data11 = [
                'updated_by' => $session->get('username'),
            'updated_on' => $now,
                'upload_document_id' => $doc_data['upload_document_id'] . $doc_id_str,
            ];
            $Common->UpdateRecord($model, $data11, $id);
        }
        // // $model->employee_added_data($data);
         $UsrModel = new UserModel();
        $passwordMatch=$UsrModel->select('login_password')->where('employee_id',$id)->where('status','Active')->first();
        if($passwordMatch['login_password']!='' && $passwordMatch['login_password']==$this->request->getVar('password')){
           $passMatch=$this->request->getVar('password');
        }else{
           $passMatch=    MD5($this->request->getVar('password'));
        }
        $data3 = [
            'employee_name' => $this->request->getVar('name_allotted'),
            'login_id' => $this->request->getVar('login'),
            'login_password' => $passMatch,
            'employee_id' => $id,
            'user_type' => 'User',
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',

        ];
        $model3 = new UserModel();
        if ($user_id != '') {
            $Common->UpdateRecord($model3, $data3, $user_id);
        }
       $data5 = [
            'head' => 'Birthday',
            'employee_id' => $id,
            'start' => $this->request->getVar('dob'),
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
        ];

        $model5 = new EventsModel();
        $birthDet = $model5->where('employee_id', $id)->where('head', 'Birthday')->first();

        if ($this->request->getVar('dob') != '0000-00-00' && $this->request->getVar('dob') != '') {
            if($birthDet==0){
                $Common->SaveRecord($model5, $data5);
            }else if (date('Y-m-d', strtotime($this->request->getVar('dob'))) != $birthDet['start']) {
                $model5->where('employee_id', $id)->where('head', 'Birthday')->delete();
                $Common->SaveRecord($model5, $data5);
            }
        } 
        $data6 = [
            'head' => 'Anniversary',
            'employee_id' => $id,
            'start' => $this->request->getVar('anniversary'),
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
        ];
        $model6 = new EventsModel();
        $anniDet = $model6->where('employee_id', $id)->where('head', 'Anniversary')->first();

        if ($this->request->getVar('anniversary') != '0000-00-00' && $this->request->getVar('anniversary') != '') {
            if($anniDet==0){
                $Common->SaveRecord($model6, $data6);
            }else if (date('Y-m-d', strtotime($this->request->getVar('anniversary'))) != $anniDet['start']) {
                $model6->where('employee_id', $id)->where('head', 'Anniversary')->delete();
                $Common->SaveRecord($model6, $data6);
            } 
        }
        $data12 = [
            'head' => 'Joining',
            'employee_id' => $id,
            'start' => $this->request->getVar('datejoining'),
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
        ];

        $model12 = new EventsModel();
        $joinDet = $model12->where('employee_id', $id)->where('head', 'Joining')->first();

        if ($this->request->getVar('datejoining') != '0000-00-00' && $this->request->getVar('datejoining') != '') {
            if($joinDet==0){
                $Common->SaveRecord($model12, $data12);
            }else
            if (date('Y-m-d', strtotime($this->request->getVar('datejoining'))) != $joinDet['start']) {
                $model12->where('employee_id', $id)->where('head', 'Joining')->delete();
                $Common->SaveRecord($model12, $data12);
            }
        }
        $data4 = [

            'employee_id' =>  $id,
            'login_time' => $this->request->getVar('logintime'),
            'logout_time' => $this->request->getVar('logout'),
            'break_permitted' => $this->request->getVar('break'),
            'weekly_off' => $this->request->getVar('weekoff'),
            'leave_per_month' => $this->request->getVar('leave'),
            'attendance_exempt' => $this->request->getVar('attendanceexempt'),
            'break_exempt' => $this->request->getVar('breakexempt'),
            'report_exempt' => $this->request->getVar('reportexempt'),
            'ip_exempt' => $this->request->getVar('ipexempt'),
            'wifi_ip' => $this->request->getVar('wifiip'),
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status'=>'Active'

        ];
        $model4 = new AttendanceModel();
        if ($attend_id != '') {
            $Common->UpdateRecord($model4, $data4, $attend_id);
        }
        $data7 = [
            'date_of_leaving' => $this->request->getVar('dateofleaving'),
            'comments' => $this->request->getVar('Comment'),
            'leaving_reason' => $this->request->getVar('reasonforleaving'),
            'date_of_rejoin' => $this->request->getVar('dateofrejoin'),
            'reactive_authorized_by' => $this->request->getVar('auth'),
            'reactive_reason' => $this->request->getVar('reason'),
            'employee_id' => $id,
            // 'discontinuation_doc_id' => $res,
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',

        ];
         $data10 = [
            'date_of_leaving' => $this->request->getVar('dateofleaving'),
            'comments' => $this->request->getVar('Comment'),
            'leaving_reason' => $this->request->getVar('reasonforleaving'),
            'date_of_rejoin' => $this->request->getVar('dateofrejoin'),
            'reactive_authorized_by' => $this->request->getVar('auth'),
            'reactive_reason' => $this->request->getVar('reason'),
            'employee_id' => $id,
            // 'discontinuation_doc_id' => $res,
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Deactive',

        ];
       $data8 = [
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Deactive',

        ];
        $data9 = [
            'updated_by' => $session->get('username'),
            'updated_on' => $now,
            'status' => 'Active',

        ];
        $builder = $this->db->table("employee_discont_reactive as empDisRec");
        $builder->select('empDisRec.status,empDisRec.date_of_leaving');
        $builder->where('empDisRec.employee_id', $id);
        $query = $builder->get()->getResultArray();
        $model7 = new Employee_Discont_ReactiveModel();
        $discontinue = '';
        if (count($query) > 0) {
            foreach ($query as $value) {
                $discontinue = $value['status'];
                $disdate = $value['date_of_leaving'];
            }
        }
        // echo "<pre>";
        // print_r($discontinue);
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.date_of_joining');
        $builder->where('emp.id', $id);
        $query2 = $builder->get()->getResultArray();
        if (count($query2) > 0) {
            foreach ($query2 as $val) {
                $joindate = $val['date_of_joining'];
            }
        }
        if ($discont_id != '' && $this->request->getVar('dateofrejoin') != '0000-00-00' && $discontinue == 'Deactive') {
            // echo 'reactive ';
            $rules = [
                'login' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
            ];
            if ($disdate > date('Y-m-d', strtotime($this->request->getVar('dateofrejoin')))) {
                return redirect()->to(base_url('Employee/edit/' . $id))->with('status_icon', 'error')
                    ->with('status', 'Please Provide Valid Date Of Rejoining  ');
            } 
            elseif ($this->validate($rules)) {
                $Common->UpdateRecord($model7, $data7, $discont_id);
                $Common->UpdateRecord($model4, $data9, $attend_id);
                $Common->SaveRecord($model3, $data3);
                $Common->UpdateRecord($model, $data9, $id);
            } else {
                $data['validation'] = $this->validator;
                return redirect()->to(base_url('Employee/edit/' . $id))->with('status_icon', 'error')
                    ->with('status', 'Please Provide the Login Details');
            }
        } else if ($discont_id != ''  && $discontinue == 'Active' && date('Y-m-d',strtotime($this->request->getVar('dateofleaving'))) == $disdate ) {
            // echo 'reactive update';
            $Common->UpdateRecord($model7, $data7, $discont_id);
        } else if ($this->request->getVar('dateofleaving') != '' && $discontinue == '') {
            // echo 'Decont ';
            if ($joindate > date('Y-m-d', strtotime($this->request->getVar('dateofleaving')))) {
                return redirect()->to(base_url('Employee/edit/' . $id))->with('status_icon', 'error')
                    ->with('status', 'Please Provide a Valid Date Of Leaving');
            } else {
                 $model6 = new AllotmentModel();
                    $empDet = $model6->where('emp_id', $id)->first();
                    if ($empDet != 0) {
                        if ($empDet['email_id'] != '') {
                            $email_id = explode(",", $empDet['email_id']);

                            foreach ($email_id as $val) {
                                $builder = $this->db->table("once_email as email");
                                $builder->select('email.email_id,email.id');
                                $builder->where('email.id', $val);

                                $emData = $builder->get()->getResultArray();
                                foreach ($emData as $value) {
                                    $model15 = new OnceEmailModel();
                                    $Common->UpdateRecord($model15, $data9, $value['id']);
                                }
                            }
                        }
                        if ($empDet['sim_id'] != '') {
                            $sim_id = explode(",", $empDet['sim_id']);

                            foreach ($sim_id as $val) {
                                $builder = $this->db->table("once_simcard as sim");
                                $builder->select('sim.id');
                                $builder->where('sim.id', $val);

                                $simData = $builder->get()->getResultArray();
                                foreach ($simData as $value) {
                                    $model16 = new SimCardModel();
                                    $Common->UpdateRecord($model16, $data9, $value['id']);
                                }
                            }
                        }
                        if ($empDet['anti_id'] != '') {
                            $anti_id = explode(",", $empDet['anti_id']);

                            foreach ($anti_id as $val) {
                                $builder = $this->db->table("once_antivirus as anti");
                                $builder->select('anti.id');
                                $builder->where('anti.id', $val);

                                $antiData = $builder->get()->getResultArray();
                                foreach ($antiData as $value) {
                                    $model14 = new AntivirusModel();
                                    $Common->UpdateRecord($model14, $data9, $value['id']);
                                }
                            }
                        }
                        if($empDet['id']){
                            $model18 = new AllotmentModel();
                            $Common->DeleteRecord($model18, $empDet['id']);
                            }
                    }

            $Common->SaveRecord($model7, $data10);
            $Common->UpdateRecord($model4, $data8, $attend_id);
            $Common->DeleteRecord($model3, $user_id);
            $Common->UpdateRecord($model, $data8, $id);
            // $Common->UpdateRecord($model2, $data8, $doc_id);
            }


        } else if ($discont_id != '' &&  date('Y-m-d',strtotime($this->request->getVar('dateofleaving'))) > $disdate && $discontinue == 'Active') {
           
            $model6 = new AllotmentModel();
                    $empDet = $model6->where('emp_id', $id)->first();
                    if ($empDet != 0) {
                        if ($empDet['email_id'] != '') {
                            $email_id = explode(",", $empDet['email_id']);

                            foreach ($email_id as $val) {
                                $builder = $this->db->table("once_email as email");
                                $builder->select('email.email_id,email.id');
                                $builder->where('email.id', $val);

                                $emData = $builder->get()->getResultArray();
                                foreach ($emData as $value) {
                                    $model15 = new OnceEmailModel();
                                    $Common->UpdateRecord($model15, $data9, $value['id']);
                                }
                            }
                        }
                        if ($empDet['sim_id'] != '') {
                            $sim_id = explode(",", $empDet['sim_id']);

                            foreach ($sim_id as $val) {
                                $builder = $this->db->table("once_simcard as sim");
                                $builder->select('sim.id');
                                $builder->where('sim.id', $val);

                                $simData = $builder->get()->getResultArray();
                                foreach ($simData as $value) {
                                    $model16 = new SimCardModel();
                                    $Common->UpdateRecord($model16, $data9, $value['id']);
                                }
                            }
                        }
                        if ($empDet['anti_id'] != '') {
                            $anti_id = explode(",", $empDet['anti_id']);

                            foreach ($anti_id as $val) {
                                $builder = $this->db->table("once_antivirus as anti");
                                $builder->select('anti.id');
                                $builder->where('anti.id', $val);

                                $antiData = $builder->get()->getResultArray();
                                foreach ($antiData as $value) {
                                    $model14 = new AntivirusModel();
                                    $Common->UpdateRecord($model14, $data9, $value['id']);
                                }
                            }
                        }
                        if($empDet['id']){
                            $model17 = new AllotmentModel();
                            $Common->DeleteRecord($model17, $empDet['id']);
                            }
                    }

            $Common->UpdateRecord($model7, $data10,$discont_id);
            $Common->UpdateRecord($model4, $data8, $attend_id);
            $Common->DeleteRecord($model3, $user_id);
            $Common->UpdateRecord($model, $data8, $id);
            // $Common->UpdateRecord($model2, $data8, $doc_id);
        }
        return redirect()->to(base_url('Employee'))->with('status_icon', 'success')
            ->with('status', 'Employee Updated Successfully');
        }
        else{
        $session->setFlashdata('warning','Session Expired!Please Login');
        $session->destroy();
         return redirect('')->to('/');
    }
    }
    public function delete($id,$emp_id)
    {  $session = session();
        $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
        
        if($session->has('username')){
        $Common = new Common();
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.upload_document_id');
        $builder->where('emp.id', $emp_id);
        $query2 = $builder->get()->getResultArray();
        if (count($query2) > 0) {
            foreach ($query2 as $val) {
                $joinDocId = $val['upload_document_id'];
            }
        }

        $array1 = array($id);
        $array2 = explode(',', $joinDocId);
        $array3 = array_diff($array2, $array1);

        $output = implode(',', $array3);

        $data = [
            'updated_by' =>$session->get('username'),
            'updated_on' => $now,
            'upload_document_id' => $output,
        ];
        $model2 = new EmployeeModel();
        $Common->UpdateRecord($model2, $data, $emp_id);
         $builder = $this->db->table("employee_document as emp_doc");
        $builder->select('emp_doc.filepath');
        $builder->where('emp_doc.id', $id);
        $query1 = $builder->get()->getResultArray();
        if (count($query1) > 0) {
            foreach ($query1 as $val) {
                $filepath = $val['filepath'];
            }
        }
        // echo $filepath;
        // exit();
        unlink($filepath);
        $model = new Employee_DocumentModel();
        $model->where('id', $id)->delete();

        return redirect()->to(base_url('Employee/edit/' . $emp_id))->with('status_icon', 'success')
                    ->with('status', 'Delete Successfully');

    
        }
        else{
        $session->setFlashdata('warning','Session Expired!Please Login');
        $session->destroy();
         return redirect('')->to('/');
    }
        }
    public function sendmail()
    {
         $session = session();
        if($session->has('username')){
        helper('form');
        
        $rules = [
            'email' => [
                'rules' => 'valid_emails',
                'errors' => [
                    'valid_emails' => 'please provide valid email'
                ],
            ],
        ];
       
        if ($this->request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $emp_id = $this->request->getVar('username');
                $builder = $this->db->table("employee as emp");
                $builder->select('emp.*,dr.*,ed.*,at.*,user.*,emp.id as emp_id,at.id as atten_id,dr.id as discont_id,ed.id as emp_doc_id,user.id as ur_id');
                // $builder->select('emp.*,at.*');
                $builder->join('employee_discont_reactive as dr', 'emp.id = dr.employee_id', "left");
                $builder->join('employee_document as ed', 'emp.upload_document_id = ed.id', "left");
                $builder->join('attendance as at', 'emp.id = at.employee_id', "left");
                $builder->join('user', 'emp.id = user.employee_id', "left");
                $builder->where('emp.id', $emp_id);
                $data['employee'] = $builder->get()->getResultArray();

                // $data['employee'] = $common->getRecord($model, $emp_id);
                foreach ($data['employee']  as $empDetail) {
                    if($empDetail["attendance_exempt"]=="0" || $empDetail["attendance_exempt"]==""){
                    $attendance='No';
                }else{
                    $attendance='Yes';
                }
                if($empDetail["report_exempt"]=="0" || $empDetail["attendance_exempt"]==""){
                    $report='No';
                }else{
                    $report='Yes';
                }
                if($empDetail["break_exempt"]=="0" || $empDetail["break_exempt"]==""){
                    $break='No';
                }else{
                    $break='Yes';
                }
                 if($empDetail["ip_exempt"]=="0" || $empDetail["break_exempt"]==""){
                    $ip='No';
                }else{
                    $ip='Yes';
                }
                 if($empDetail['anniversary_date']!='0000-00-00'){
                     $anniDate= date('d-m-Y',strtotime($empDetail['anniversary_date']));
                     
                 }
                 if($empDetail['dob']!='0000-00-00'){
                     $dob= date('d-m-Y',strtotime($empDetail['dob']));
                     
                 }
                    $message = '
                <h2  style="color: #467302;" align="center">Employee Details</h2>
                    <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
                        <tr>
                           <td  style="background-color: #467302;color:white" colspan="2" >Staff Info</td>
                        </tr>
                        <tr>
                           <td width="30%">Name</td>
                           <td width="70%">' . $empDetail['legal_name'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Email Id</td>
                            <td width="70%">' . $empDetail['per_email_id'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Contact Number</td>
                            <td width="70%">' . $empDetail['per_mobile_no'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Current Location</td>
                            <td width="70%">' . $empDetail['emp_current_address'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Date of Birth</td>
                            <td width="70%">' .$dob . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Anniversary Date</td>
                            <td width="70%">' .$anniDate. '</td>
                        </tr>
                        <tr>
                            <td width="30%">Gender</td>
                            <td width="70%">' . $empDetail['gender'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Salary Bank Detail</td>
                            <td width="70%">' . $empDetail['salary_bank_detail'] . '</td>
                        </tr>
                        <tr>
                           <td style="background-color: #467302;color:white" colspan="2">Office Info</td>
                        </tr>
                        <tr>
                            <td width="30%">Name Alloted</td>
                            <td width="70%">' . $empDetail['name'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Date of Joining</td>
                            <td width="70%">' . date('d-m-Y',strtotime($empDetail['date_of_joining'])). '</td>
                        </tr>
                        <tr>
                            <td width="30%">Short Code</td>
                            <td width="70%">' . $empDetail['emp_short_code'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Reference</td>
                            <td width="70%">' . $empDetail['reference'] . '</td>
                        </tr>
                        <tr>
                           <td style="background-color: #467302;color:white" colspan="2">SOS Info</td>
                        </tr>
                        <tr>
                            <td width="30%">Relationship-Kin</td>
                            <td width="70%">' . $empDetail['relationship_kin'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Kin Name</td>
                            <td width="70%">' . $empDetail['kin_name'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Kin Mobile number</td>
                            <td width="70%">' . $empDetail['kin_mobile_no'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Kin Address</td>
                            <td width="70%">' . $empDetail['kin_address'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Kin Job Details</td>
                            <td width="70%">' . $empDetail['kin_job'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Kin Current Address</td>
                            <td width="70%">' . $empDetail['kin_current_address'] . '</td>
                        </tr>
                        <tr>
                           <td style="background-color: #467302;color:white" colspan="2">Attendance Info</td>
                        </tr>
                        <tr>
                            <td width="30%">Login Time</td>
                            <td width="70%">' . $empDetail['login_time'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Logout Time</td>
                            <td width="70%">' . $empDetail['logout_time'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Break Permitted</td>
                            <td width="70%">' . $empDetail['break_permitted'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Weekly Off</td>
                            <td width="70%">' . $empDetail['weekly_off'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Leaves Per Month</td>
                            <td width="70%">' . $empDetail['leave_per_month'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Wifi Ip</td>
                            <td width="70%">' . $empDetail['wifi_ip'] . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Attendance Exempt</td>
                            <td width="70%">' . $attendance . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Report Exempt</td>
                            <td width="70%">' . $report . '</td>
                        </tr>
                        <tr>
                            <td width="30%">Break Exempt</td>
                            <td width="70%">' . $break. '</td>
                        </tr>
                        <tr>
                            <td width="30%">IP Exempt</td>
                            <td width="70%">' . $ip . '</td>
                        </tr>
                        <tr >
                            <td style="background-color: #467302;color:white" colspan="2" >Login Info</td>
                        </tr>
                        <tr>
                            <td width="30%">Login Id</td>
                            <td width="70%">' . $empDetail['login_id'] . '</td>
                        </tr>
                        
                    </table>';
                }
                if ($this->request->getVar('email') != '' && $this->request->getVar('username') != '') {
                    

                    $email = \Config\Services::email();
                    $email->setTo($this->request->getVar('email'));
                    $email->setFrom('admin@ansh.com', 'Employee Details');
                    $email->setSubject($this->request->getVar('subject'));
                    $email->setMessage($message . '<br>' . $this->request->getVar('message'));

                    if ($email->send()) {
                         if ($this->request->getVar('requestmail')=='view') {

                        return redirect()->to(base_url('Employee/get_detail/'.$this->request->getVar('employee_id')))->with('status_icon', 'success')
                            ->with('status', 'Mail Sent Successfully');
                    }elseif ($this->request->getVar('requestmail')=='insert') {

                        return redirect()->to(base_url('Employee'))->with('status_icon', 'success')
                            ->with('status', 'Mail Sent Successfully');
                    }elseif ($this->request->getVar('requestmail')=='edit') {

                        return redirect()->to(base_url('Employee/edit/'.$this->request->getVar('employee_id')))->with('status_icon', 'success')
                            ->with('status', 'Mail Sent Successfully');
                    }
                    } else {
                        $data = $email->printDebugger(['headers']);
                        print_r($data);
                    }
                }
            }else {
                if ($this->request->getVar('requestmail') == 'view') {

                    return redirect()->to(base_url('Employee/get_detail/' . $this->request->getVar('employee_id')))->with('status_icon', 'error')
                        ->with('status', 'Please Provide Proper Email');
                } elseif ($this->request->getVar('requestmail') == 'insert') {

                    return redirect()->to(base_url('Employee'))->with('status_icon', 'error')
                        ->with('status', 'Please Provide Proper Email');
                } elseif ($this->request->getVar('requestmail') == 'edit') {

                    return redirect()->to(base_url('Employee/edit/' . $this->request->getVar('employee_id')))->with('status_icon', 'error')
                        ->with('status', 'Please Provide Proper Email');
                }
            }
        }
                }else{
        $session->setFlashdata('warning','Session Expired!Please Login');
        $session->destroy();
         return redirect('')->to('/');

}

    }
    
   
}