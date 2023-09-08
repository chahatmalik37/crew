<?php
namespace App\Controllers;
use system\I18n\Time;
use App\Models\EmployeeModel;

use App\Models\EventsModel;
use App\Models\DepartmentModel;
use App\Models\UserModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class OnceDepartment extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $model = new DepartmentModel();
        $query['desi_detail'] = $model->orderBy('id', 'asc')->findAll();
        if (count($query['desi_detail']) > 0) {
            // echo view('include/header');
            echo view('department', $query);
        } else {
            echo view('department');
        }
        // echo view('include/footer');

    }
    public function insert()
    {
        $session = session();
        if ($session->has('username')) {
            $Common = new Common();


            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'dept_name' => $this->request->getVar('department'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'
            ];
            $model = new DepartmentModel();
            $Common->SaveRecord($model, $data);
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function store()
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');

            $data = [];
            $rules = [
                'department' => [
                    'rules' => 'required|is_unique[once_dept.dept_name]',
                    'errors' => [
                        'required' => 'Required',
                        'is_unique' => 'Already Taken'
                    ],
                ],
                
            ];
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "save";

                    $this->insert();

                    return redirect()->to(base_url('OnceDepartment'))->with('status_icon', 'success')
                        ->with('status', 'Department Inserted Successfully');
                } else {
                    // echo "test";
                    $model = new DepartmentModel();
                    $data['desi_detail'] = $model->orderBy('id', 'asc')->findAll();
                    

                    $data['validation'] = $this->validator;
                    // echo view('include/header');
                    echo view('department', $data);
                    // echo view('include/footer');
                }
            }
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function edit($id)
    {
        helper('form');
        
        $model = new DepartmentModel();
        $data['category'] = $model->orderBy('id', 'asc')->findAll();
        $data['row'] =$model->where('id',$id)->first();
       
       // echo view('include/header');
        echo view('department_edit', $data);
    }

    // public function update($id)
    // {
    //     // echo "<pre>";
    //     // print_r($_POST); exit;
    //     helper('form');
    //     $session = session();
    //     if ($session->has('username')) {
    //         $model = new DepartmentModel();
    //         $Common = new Common();
    //         $data2 = [
    //             'dept_name' => $this->request->getVar('department'),
    //         ];
    //         $get_row = $model->where($data2)->first();
    //         if(!empty($get_row)){
    //             return redirect()->to(base_url('OnceDepartment/edit/'.$id))->with('status_icon', 'error')
    //             ->with('status', 'Data already exsist');

    //         }else{

    //         // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
    //         $data = [
    //             'dept_name' => $this->request->getVar('department'),
    //             'updated_by' => $session->get('username'),
    //             // 'updated_on' => $now,
    //             'status' => 'Active'

    //         ];
            
    //         $Common->UpdateRecord($model, $data, $id);

    //         // // $model->employee_added_data($data);
    //         return redirect()->to(base_url('OnceDepartment'))->with('status_icon', 'success')
    //             ->with('status', 'Department Updated Successfully');
    //         }
    //     } else {
    //         $session->setFlashdata('warning', 'Session Expired!Please Login');
    //         $session->destroy();
    //         return redirect('')->to('/');
    //     }
    // }
    
    public function update($id)
    {
        // echo "<pre>";
        // print_r($_POST); exit;
        helper('form');
        $session = session();
        if ($session->has('username')) {

            $data = [];
            $rules = [
                'department' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],
                
            ];
            if ($this->request->getMethod() == 'put') {
                if ($this->validate($rules)) {
            $model = new DepartmentModel();
            $Common = new Common();
            $data2 = [
                'dept_name' => $this->request->getVar('department'),
            ];
            $get_row = $model->where($data2)->first();
            if(!empty($get_row)){
                return redirect()->to(base_url('OnceDepartment/edit/'.$id))->with('status_icon', 'error')
                ->with('status', 'Data already exsist');

            }else{

            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'dept_name' => $this->request->getVar('department'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'

            ];
            
            $Common->UpdateRecord($model, $data, $id);

            // // $model->employee_added_data($data);
            return redirect()->to(base_url('OnceDepartment'))->with('status_icon', 'success')
                ->with('status', 'Department Updated Successfully');
            }

            }else{
               $model = new DepartmentModel();
               $data['category'] = $model->orderBy('id', 'asc')->findAll();
               $data['row'] =$model->where('id',$id)->first();
                $data['validation'] = $this->validator;
                echo view('department_edit', $data);

       
               }
             }
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function delete($id)
    {
        $session = session();
        // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;

        if ($session->has('username')) {
            // $Common = new Common();


            $model = new DepartmentModel();
            $model->where('id', $id)->delete();

            return redirect()->to(base_url('OnceDepartment'))->with('status_icon', 'success')
                ->with('status', 'Department Deleted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
}
