<?php

namespace App\Controllers;

use system\I18n\Time;
use App\Models\EmployeeModel;
use App\Models\AllotmentModel;
use App\Models\AntivirusModel;
use App\Models\OnceEmailModel;
use App\Models\EmailIdModel;
use App\Models\SimCardModel;
use App\Models\EventsModel;
use App\Models\UserModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class EmailIdController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.name,emp.id,emp.per_mobile_no,emp.emp_short_code,al.*,emp.id as emp_id');
        $builder->join('alloted as al', 'emp.id = al.emp_id', "left");
        $builder->where('al.status', 'Active');
        $builder->groupby('al.emp_id');
        $builder->orderby('emp.emp_short_code');
        
        $show['alot_detail'] = $builder->get()->getResultArray();
        // echo "<pre>";
        // print_r($show);
        // exit;
        // echo view('include/header');
        echo view('email_allot', $show);
        // echo view('include/footer');

    }
    public function fetch_emp_short_code($id)
    {
        helper('form', 'url');

        $builder = $this->db->table("employee as emp");
        $builder->select('emp.emp_short_code');
        $builder->where('emp.id', $id);

        $optionsResult = $builder->get()->getResultArray();
        if (!empty($optionsResult)) {
            return json_encode($optionsResult);
        } else {
            return "<option>No Short Code Available.</option>";
        }
    }
    public function insert()
    {
        $session = session();
        if ($session->has('username')) {
            $Common = new Common();
            $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));
            $model6 = new AllotmentModel();
            $empDet = $model6->where('emp_id', $this->request->getVar('nameallotted'))->first();
            // print_r($empDet);
            // exit;
            if ($this->request->getVar('alloted_tab') == 'EmailTab') {

                $data = [
                    'emp_id' => $this->request->getVar('nameallotted'),
                    'email_id' => $this->request->getVar('emailId'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data5 = [

                    'email_id' => $empDet['email_id'] . ',' . $this->request->getVar('emailId'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data2 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Allotted'
                ];

                $model = new AllotmentModel();
                if ($empDet == 0) {
                    $Common->SaveRecord($model, $data);
                    $model2 = new OnceEmailModel();
                    $Common->UpdateRecord($model2, $data2, $this->request->getVar('emailId'));
                } else {
                    $Common->UpdateRecord($model, $data5, $empDet['id']);
                    $model2 = new OnceEmailModel();
                    $Common->UpdateRecord($model2, $data2, $this->request->getVar('emailId'));
                }
            }
            if ($this->request->getVar('alloted_tab') == 'DeptTab') {

                $data8 = [
                    'emp_id' => $this->request->getVar('nameallotted'),
                    'dept_id' => $this->request->getVar('department'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data7 = [

                    'dept_id' => $this->request->getVar('department'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];


                $model = new AllotmentModel();
                if ($empDet == 0) {
                    $Common->SaveRecord($model, $data8);
                } else {
                    $Common->UpdateRecord($model, $data7, $empDet['id']);
                }
            }
            if ($this->request->getVar('alloted_tab') == 'DesgnTab') {

                $data9 = [
                    'emp_id' => $this->request->getVar('nameallotted'),
                    'desig_id' => $this->request->getVar('DesignId'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data10 = [

                    'desig_id' => $this->request->getVar('DesignId'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];


                $model = new AllotmentModel();
                if ($empDet == 0) {
                    $Common->SaveRecord($model, $data9);
                } else {
                    $Common->UpdateRecord($model, $data10, $empDet['id']);
                }
            }
            if ($this->request->getVar('alloted_tab') == 'SimTab') {

                if ($this->request->getVar('gridCheck') == 'on' || $this->request->getVar('gridCheck') == 1) {
                    $gridCheck = 1;
                } else {
                    $gridCheck = 0;
                }
                $data3 = [
                    'emp_id' => $this->request->getVar('nameallotted'),
                    'sim_id' => $this->request->getVar('simcard'),
                    'person_sim' => $gridCheck,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data6 = [
                    'sim_id' => $empDet['sim_id'] . ',' . $this->request->getVar('simcard'),
                    'person_sim' => $gridCheck,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data4 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Allotted'
                ];

                $model = new AllotmentModel();
                if ($empDet == 0) {
                    $Common->SaveRecord($model, $data3);
                    $model4 = new SimCardModel();
                    $Common->UpdateRecord($model4, $data4, $this->request->getVar('simcard'));
                } else {

                    $Common->UpdateRecord($model, $data6, $empDet['id']);
                    $model4 = new SimCardModel();
                    $Common->UpdateRecord($model4, $data4, $this->request->getVar('simcard'));
                }
            }
            if ($this->request->getVar('alloted_tab') == 'StSqTab') {

                $data12 = [
                    'emp_id' => $this->request->getVar('nameallotted'),
                    'star_id' => $this->request->getVar('StSq'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data13 = [

                    'star_id' => $this->request->getVar('StSq'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];


                $model = new AllotmentModel();
                if ($empDet == 0) {
                    $Common->SaveRecord($model, $data12);
                } else {
                    $Common->UpdateRecord($model, $data13, $empDet['id']);
                }
            }
            if ($this->request->getVar('alloted_tab') == 'AntiTab') {

                if ($this->request->getVar('P_anti') != '') {
                    $gridCheck = $this->request->getVar('P_anti');
                }
                $data14 = [
                    'emp_id' => $this->request->getVar('nameallotted'),
                    'anti_id' => $this->request->getVar('keyallotted'),
                    'person_anti' => $gridCheck,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data15 = [
                    'anti_id' => $this->request->getVar('keyallotted'),
                    'person_anti' => $gridCheck,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data16 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Allotted'
                ];

                $model = new AllotmentModel();
                if ($empDet == 0) {
                    $Common->SaveRecord($model, $data14);
                    $model4 = new AntivirusModel();
                    $Common->UpdateRecord($model4, $data16, $this->request->getVar('keyallotted'));
                } else {

                    $Common->UpdateRecord($model, $data15, $empDet['id']);
                    $model4 = new AntivirusModel();
                    $Common->UpdateRecord($model4, $data16, $this->request->getVar('keyallotted'));
                }
            }
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function store($tabVal)
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');

            $data = [];
             if($tabVal=='Email'){
            $rules = [
                'nameallotted' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                'emailId' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'

                    ],
                ],

            ];
        }
        if($tabVal=='StnSq'){
            $rules = [
                'nameallotted' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                'StSq' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'

                    ],
                ],

            ];
        }
        if($tabVal=='Desgn'){
            $rules = [
                'nameallotted' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                'DesignId' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'

                    ],
                ],

            ];
        }
        if($tabVal=='Dept'){
            $rules = [
                'nameallotted' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                'department' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'

                    ],
                ],

            ];
        }
        if($tabVal=='Sim'|| $tabVal=='Anti'){
            $rules = [
                'nameallotted' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

            ];
        }
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "save";
                    $this->insert();

                    return redirect()->to(base_url('EmailIdController/redirection/'.$tabVal))->with('status_icon', 'success')
                        ->with('status', 'Inserted Successfully');
                } else {
                    // echo "test";
                   $builder = $this->db->table("employee as emp");
                   $builder->select('emp.name,emp.id,emp.per_mobile_no,emp.emp_short_code,al.*,emp.id as emp_id');
                   $builder->join('alloted as al', 'emp.id = al.emp_id', "left");
                   $builder->where('al.status', 'Active');
                   $builder->groupby('al.emp_id');
                   $builder->orderby('emp.emp_short_code');
                   
                   $data['alot_detail'] = $builder->get()->getResultArray();
                    // echo "<pre>";
                    // print_r($show['alot_detail']);
                    // exit;
                    $data['validation'] = $this->validator;
                    // echo view('include/header');
                    echo view('email_allot', $data);
                    // echo view('include/footer');
                }
            }
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function edit($id, $tabId, $tabActive)
    {
        helper('form');
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.name,emp.id,emp.per_mobile_no,emp.emp_short_code,al.*,emp.id as emp_id');
        $builder->join('alloted as al', 'emp.id = al.emp_id', "left");
        $builder->where('al.id', $id);
        $query['edit_alot_detail'] = $builder->get()->getResultArray();

        $query['EditValue'] = $tabId;
        $query['tabActive'] = $tabActive;
        // echo "<pre>";
        // print_r($query);
        // exit;
        echo view('edit_allot', $query);
    }

    public function update($id, $tabId,$tabVal)
    {
        // echo "<pre>";
        // print_r($_POST); exit;
        helper('form');
        $session = session();
        if ($session->has('username')) {

            $Common = new Common();

            $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;

            $model6 = new AllotmentModel();
            $empDet = $model6->where('id', $id)->first();
            // print_r($empDet);
            // exit;
            if ($this->request->getVar('alloted_tab') == 'EmailTab') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['email_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                $data5 = [

                    'email_id' => $output . ',' . $this->request->getVar('emailId'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data2 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'
                ];
                $data12 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Allotted'
                ];
                $model = new AllotmentModel();
                $Common->UpdateRecord($model, $data5, $id);
                $model2 = new OnceEmailModel();
                $Common->UpdateRecord($model2, $data2, $tabId);
                $Common->UpdateRecord($model2, $data12, $this->request->getVar('emailId'));
            }
            if ($this->request->getVar('alloted_tab') == 'DeptTab') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['dept_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                $data8 = [

                    'dept_id' => $this->request->getVar('department'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];

                $model = new AllotmentModel();
                $Common->UpdateRecord($model, $data8, $id);
            }
            if ($this->request->getVar('alloted_tab') == 'DesgnTab') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['desig_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                $data10 = [

                    'desig_id' => $this->request->getVar('DesignId'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];

                $model = new AllotmentModel();
                $Common->UpdateRecord($model, $data10, $id);
            }
            if ($this->request->getVar('alloted_tab') == 'StSqTab') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['star_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                $data10 = [

                    'star_id' => $this->request->getVar('StSq'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];

                $model = new AllotmentModel();
                $Common->UpdateRecord($model, $data10, $id);
            }
            if ($this->request->getVar('alloted_tab') == 'SimTab') {


                $array1 = array($tabId);
                $array2 = explode(',', $empDet['sim_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                $data6 = [
                    'sim_id' => $output . ',' . $this->request->getVar('simcard'),
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data13 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'
                ];
                $data4 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Allotted'
                ];

                $model = new AllotmentModel();

                $Common->UpdateRecord($model, $data6, $empDet['id']);
                $model4 = new SimCardModel();

                $Common->UpdateRecord($model4, $data13, $tabId);
                $Common->UpdateRecord($model4, $data4, $this->request->getVar('simcard'));
            }
            if ($this->request->getVar('alloted_tab') == 'AntiTab') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['anti_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                if ($this->request->getVar('P_anti') != '') {
                    $gridCheck = $this->request->getVar('P_anti');
                }
                $data17 = [

                    'anti_id' => $this->request->getVar('keyallotted'),
                    'person_anti' => $gridCheck,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'

                ];
                $data18 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'
                ];
                $data19 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Allotted'
                ];
                $model = new AllotmentModel();
                $Common->UpdateRecord($model, $data17, $id);
                $model2 = new AntivirusModel();
                $Common->UpdateRecord($model2, $data18, $tabId);
                $Common->UpdateRecord($model2, $data19, $this->request->getVar('keyallotted'));
            }

            return redirect()->to(base_url('EmailIdController/redirection/'.$tabVal))->with('status_icon', 'success')
                ->with('status', 'Updated Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function delete($id, $tabId, $tabVal)
    {
        $session = session();
        $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
        $model6 = new AllotmentModel();
        $empDet = $model6->where('id', $id)->first();
        if ($session->has('username')) {
            $Common = new Common();
            // echo $id.'->'.$tabId.'-'.$tabVal;
            // exit;
            if ($tabVal == 'Email') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['email_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                // echo $output.','.'val';
                // exit;
                $data = [

                    'email_id' => $output,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active',
                ];
                $data2 = [
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active'
                ];
                $model2 = new AllotmentModel();
                $Common->UpdateRecord($model2, $data, $id);
                $model = new OnceEmailModel();
                $Common->UpdateRecord($model, $data2, $tabId);
            }
            if ($tabVal == 'StnSq') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['star_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                // echo $output.','.'val';
                // exit;
                $data3 = [

                    'star_id' => $output,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active',
                ];

                $model2 = new AllotmentModel();
                $Common->UpdateRecord($model2, $data3, $id);
            }
            if ($tabVal == 'Dept') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['dept_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                // echo $output.','.'val';
                // exit;
                $data7 = [

                    'dept_id' => $output,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active',
                ];

                $model2 = new AllotmentModel();
                $Common->UpdateRecord($model2, $data7, $id);
            }
            if ($tabVal == 'Desgn') {
                $array1 = array($tabId);
                $array2 = explode(',', $empDet['desig_id']);
                $array3 = array_diff($array2, $array1);

                $output = implode(',', $array3);
                // echo $output.','.'val';
                // exit;
                $data8 = [

                    'desig_id' => $output,
                    'updated_by' => $session->get('username'),
                    'updated_on' => $now,
                    'status' => 'Active',
                ];

                $model2 = new AllotmentModel();
                $Common->UpdateRecord($model2, $data8, $id);
            }
            if ($tabVal == 'Sim') {
                if ($tabId != '0') {
                    $array1 = array($tabId);
                    $array2 = explode(',', $empDet['sim_id']);
                    $array3 = array_diff($array2, $array1);

                    $output = implode(',', $array3);
                    // echo $output.','.'val';
                    // exit;
                    $data4 = [

                        'sim_id' => $output,
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active',
                    ];
                    $data5 = [
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active'
                    ];

                    $model2 = new AllotmentModel();
                    $Common->UpdateRecord($model2, $data4, $id);
                    $model4 = new SimCardModel();

                    $Common->UpdateRecord($model4, $data5, $tabId);
                } else {
                    $data6 = [

                        'person_sim' => 0,
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active',
                    ];
                    $model2 = new AllotmentModel();
                    $Common->UpdateRecord($model2, $data6, $id);
                }
            }
            if ($tabVal == 'Anti') {
                if ($tabId != '0') {
                    $array1 = array($tabId);
                    $array2 = explode(',', $empDet['anti_id']);
                    $array3 = array_diff($array2, $array1);

                    $output = implode(',', $array3);
                    // echo $output.','.'val';
                    // exit;
                    $data10 = [

                        'anti_id' => $output,
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active',
                    ];
                    $data9 = [
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active'
                    ];

                    $model2 = new AllotmentModel();
                    $Common->UpdateRecord($model2, $data10, $id);
                    $model4 = new AntivirusModel();
                    $Common->UpdateRecord($model4, $data9, $tabId);
                } else {
                    // echo "value";
                    // exit;
                    $data11 = [

                        'person_anti' => '',
                        'updated_by' => $session->get('username'),
                        'updated_on' => $now,
                        'status' => 'Active',
                    ];
                    $model2 = new AllotmentModel();
                    $Common->UpdateRecord($model2, $data11, $id);
                }
            }
            return redirect()->to(base_url('EmailIdController/redirection/'.$tabVal))->with('status_icon', 'success')
                ->with('status', 'Delete Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
   public function sendmail($tabVal)
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');
            $email = \Config\Services::email();

            if ($this->request->getMethod() == 'post') {
                // if ($this->validate($rules)) {
                $builder = $this->db->table("employee as emp");
                $builder->select('emp.name,emp.id,emp.per_mobile_no,emp.emp_short_code,al.*,emp.id as emp_id');
                $builder->join('alloted as al', 'emp.id = al.emp_id', "left");
                $builder->where('al.status', 'Active');
                $builder->groupby('al.emp_id');
                $query['alot_detail'] = $builder->get()->getResultArray();
                $message3 = '';
                $message4 = '';
                $message2 = '';
                $message5='';
                $message6='';
                $message7='';
                foreach ($query['alot_detail'] as $alotDet) {

                    if ($tabVal == 'Email') {
                        $message = '<h2  style="color: #467302;" align="center">Employee Email Details</h2>
                    <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
                    <thead>
                    <tr>
                        <th scope="col">Name Allotted</th>
                        <th scope="col">Short Code</th>
                        <th scope="col">EmailId</th>
                    </tr>
                    </thead>
                        ';
                        $email_id = explode(",", $alotDet['email_id']);

                        foreach ($email_id as $val) {
                            $builder = $this->db->table("once_email as email");
                            $builder->select('email.email_id,email.id');
                            $builder->where('email.id', $val);

                            $emData = $builder->get()->getResultArray();


                            foreach ($emData as $value) {

                                if ($alotDet['email_id'] != '') {
                                    $message2 .= '<tr  align="center">
                                <td>' . $alotDet['name'] . '</td>
                                <td>' . $alotDet['emp_short_code'] . '</td>
                                <td>' .  $value['email_id'] . '</td>
                            </tr>';

                                    $email->setTo('admin@ansh.com');
                                    $email->setFrom('admin@ansh.com');
                                    $email->setSubject('Email Id Allotment Details');
                                    $email->setMessage($message . $message2);
                                }
                            }
                        }
                    }
                    if ($tabVal == 'Dept') {
                        $message = '<h2  style="color: #467302;" align="center">Employee Department Details</h2>
                    <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
                    <thead>
                    <tr>
                        <th scope="col">Name Allotted</th>
                        <th scope="col">Short Code</th>
                        <th scope="col">Department</th>
                    </tr>
                    </thead>
                        ';
                        $dept_id = explode(",", $alotDet['dept_id']);

                        foreach ($dept_id as $val) {
                            $builder = $this->db->table("once_dept as dept");
                            $builder->select('dept.dept_name,dept.id');
                            $builder->where('dept.id', $val);

                            $deptData = $builder->get()->getResultArray();
                            foreach ($deptData as $value) {


                                if ($alotDet['dept_id'] != '') {
                                    $message3 .= '<tr  align="center">
                                <td>' . $alotDet['name'] . '</td>
                                <td>' . $alotDet['emp_short_code'] . '</td>
                                <td>' .  $value['dept_name'] . '</td>
                            </tr>';
                                }
                            }
                            $email->setTo('admin@ansh.com');
                            $email->setFrom('admin@ansh.com');
                            $email->setSubject('Department Allotment Details');
                            $email->setMessage($message . $message3);
                        }
                    }
                    if ($tabVal == 'StnSq') {
                        $message = '<h2  style="color: #467302;" align="center">Employee Star/Square Details</h2>
                <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
                <thead>
                <tr>
                    <th scope="col">Name Allotted</th>
                    <th scope="col">Short Code</th>
                    <th scope="col">Star/Square</th>
                </tr>
                </thead>
                    ';
                        $star_id = explode(",", $alotDet['star_id']);

                        foreach ($star_id as $val) {
                            $builder = $this->db->table("once_star_square as stsq");
                            $builder->select('stsq.st_sq,stsq.id,stsq.color');
                            $builder->where('stsq.id', $val);

                            $stData = $builder->get()->getResultArray();


                            foreach ($stData as $value) {

                                if ($value['st_sq'] == "st") {
                                    $icon = "Star";
                                } else if ($value['st_sq'] == "sq") {
                                    $icon = "Square";
                                }
                                if ($value['color'] == "#FF0000") {
                                    $color = "Red";
                                } elseif ($value['color'] == "#FFC948") {
                                    $color = "Orange";
                                } elseif ($value['color'] == "#FFFF00") {
                                    $color = "Yellow";
                                } elseif ($value['color'] == "#35ff35") {
                                    $color = "Green";
                                } elseif ($value['color'] == "#0000FF") {
                                    $color = "Blue";
                                } elseif ($value['color'] == "#4B0082") {
                                    $color = "Indigo";
                                } elseif ($value['color'] == "#9400D3") {
                                    $color = "Violet";
                                }


                                if ($alotDet['star_id'] != '') {
                                    $message4 .= '<tr  align="center">
                            <td>' . $alotDet['name'] . '</td>
                            <td>' . $alotDet['emp_short_code'] . '</td>
                            <td>' . $icon . '<b>{' . $color . '}</b></td>
                        </tr>';
                                }
                            }
                            $email->setTo('admin@ansh.com');
                            $email->setFrom('admin@ansh.com');
                            $email->setSubject('Star/Square Allotment Details');
                            $email->setMessage($message . $message4);
                        }
                    }
                    if ($tabVal == 'Desgn') {
                        $message = '<h2  style="color: #467302;" align="center">Employee Designation Details</h2>
            <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
            <thead>
            <tr>
                <th scope="col">Name Allotted</th>
                <th scope="col">Short Code</th>
                <th scope="col">Designation</th>
            </tr>
            </thead>
                ';
                        $desig_id = explode(",", $alotDet['desig_id']);

                        foreach ($desig_id as $val) {
                            $builder = $this->db->table("once_designation as desgn");
                            $builder->select('desgn.designation,desgn.id');
                            $builder->where('desgn.id', $val);

                            $desigData = $builder->get()->getResultArray();
                            foreach ($desigData as $value) {


                                if ($alotDet['desig_id'] != '') {
                                    $message5 .= '<tr  align="center">
                                                  <td>' . $alotDet['name'] . '</td>
                                                  <td>' . $alotDet['emp_short_code'] . '</td>
                                                  <td>' .  $value['designation'] . '</td>
                                                  </tr>';
                                }
                            }
                            $email->setTo('admin@ansh.com');
                            $email->setFrom('admin@ansh.com');
                            $email->setSubject('Designation Allotment Details');
                            $email->setMessage($message . $message5);
                        }
                    }
                    if ($tabVal == 'Sim') {
                        $message = '<h2  style="color: #467302;" align="center">Employee Sim Details</h2>
                    <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
                    <thead>
                    <tr>
                        <th scope="col">Name Allotted</th>
                        <th scope="col">Short Code</th>
                        <th scope="col">Sim</th>
                    </tr>
                    </thead>
                        ';
                        $sim_id = explode(",", $alotDet['sim_id']);

                        foreach ($sim_id as $val) {
                            $builder = $this->db->table("once_simcard as sim");
                            $builder->select('sim.number,sim.id');
                            $builder->where('sim.id', $val);
                            $smData = $builder->get()->getResultArray();



                            foreach ($smData as $value) {

                                if ($alotDet['sim_id'] != '') {
                                    $message6 .= '<tr  align="center">
                                <td>' . $alotDet['name'] . '</td>
                                <td>' . $alotDet['emp_short_code'] . '</td>
                                <td>' .  $value['number'] . '</td>
                            </tr>';

                                    $email->setTo('admin@ansh.com');
                                    $email->setFrom('admin@ansh.com');
                                    $email->setSubject('Sim Allotment Details');
                                    
                       
                                }
                               
                            }
                            }
                            if ($alotDet['person_sim'] == '1') {

                                $number = '(' . $alotDet["per_mobile_no"] . ')';
                                $message6 .= '<tr  align="center">
                                <td>' . $alotDet['name'] . '</td>
                                <td>' . $alotDet['emp_short_code'] . '</td>
                                <td>' .  $number. '</td>
                            </tr>';
                            }
                            $email->setMessage($message.$message6);
                           
                    }
                    if ($tabVal == 'Anti') {
                        $message = '<h2  style="color: #467302;" align="center">Employee Antivirus Details</h2>
                    <table border="1"  style="border: 2px solid #73AD21;" width="100%" cellpadding="5">
                    <thead>
                    <tr>
                        <th scope="col">Name Allotted</th>
                        <th scope="col">Short Code</th>
                        <th scope="col">Service Provider</th>
                        <th scope="col">Keys Allotted</th>
                    </tr>
                    </thead>
                        ';
                        $anti_id = explode(",", $alotDet['anti_id']);

                        foreach ($anti_id as $val) {
                            $builder = $this->db->table("once_antivirus as anti");
                            $builder->select('anti.key_alloted,anti.id,anti.serv_provider');
                            $builder->where('anti.id', $val);

                            $antiData = $builder->get()->getResultArray();


                            foreach ($antiData as $value) {

                                if ($alotDet['anti_id'] != '') {
                                    $message7 .= '<tr  align="center">
                                <td>' . $alotDet['name'] . '</td>
                                <td>' . $alotDet['emp_short_code'] . '</td>
                                <td>' .  $value['serv_provider'] . '</td>
                                <td>' .  $value['key_alloted'] . '</td>
                            </tr>';

                                    $email->setTo('admin@ansh.com');
                                    $email->setFrom('admin@ansh.com');
                                    $email->setSubject('Antivirus Allotment Details');
                                    
                       
                                }
                               
                            }
                            }
                            if ($alotDet['person_anti'] != '') {
                                $message7 .= '<tr  align="center">
                                <td>' . $alotDet['name'] . '</td>
                                <td>' . $alotDet['emp_short_code'] . '</td>
                                <td></td>
                                <td>' .  $alotDet['person_anti']. '</td>
                            </tr>';
                            }
                            $email->setMessage($message.$message7);
                           
                    }
                }


                if ($email->send()) {

                    return redirect()->to(base_url('EmailIdController/redirection/'.$tabVal))->with('status_icon', 'success')
                        ->with('status', 'Mail Sent Successfully');
                } else {
                   return redirect()->to(base_url('EmailIdController/redirection/'.$tabVal))->with('status_icon', 'error')
                        ->with('status', 'Mail Not Sent');
                }
                // if ($this->request->getVar('email') != '') {




            }
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
     public function redirection($tabVal)
    {
        if($tabVal=='Email'||$tabVal=='Dept'||$tabVal=='Desgn'||$tabVal=='Anti'||$tabVal=='Sim'||$tabVal=='StnSq'){
        helper('form', 'url');
        $builder = $this->db->table("employee as emp");
        $builder->select('emp.name,emp.id,emp.per_mobile_no,emp.emp_short_code,al.*,emp.id as emp_id');
        $builder->join('alloted as al', 'emp.id = al.emp_id', "left");
        $builder->where('al.status', 'Active');
        $builder->groupby('al.emp_id');
        $builder->orderby('emp.emp_short_code');
        $show['alot_detail'] = $builder->get()->getResultArray();
        }
        // echo "<pre>";
        // print_r($show);
        // exit;
        // echo view('include/header');
        echo view('email_allot', $show);
        // echo view('include/footer');

    }
}
