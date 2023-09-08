<?php

namespace App\Controllers;

use system\I18n\Time;
use App\Models\EmployeeModel;
use App\Models\OnceEmailModel;
use App\Models\EventsModel;
use App\Models\UserModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class OnceEmail extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $model = new OnceEmailModel();
        $query['email_detail'] = $model->orderBy('id', 'asc')->findAll();
       
        if (count($query['email_detail']) > 0) {
            // echo view('include/header');
            echo view('once_email', $query);
        } else {
            echo view('once_email');
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
                'email_id' => $this->request->getVar('email'),
                'nature_of_email' => $this->request->getVar('natureofmail'),
                'forwarding_to' =>  $this->request->getVar('forwarding'),
                'expiry_date' =>  $this->request->getVar('expiry'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'

            ];
            $model = new OnceEmailModel();
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
                'email' => [
                    'rules' => 'required|is_unique[once_email.email_id]',
                    'errors' => [
                        'required' => 'Required',
                        'is_unique' => 'Already Taken'
                    ],
                ],
                'natureofmail' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
            ];
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "save";

                    $this->insert();

                    return redirect()->to(base_url('OnceEmail'))->with('status_icon', 'success')
                        ->with('status', 'Email Inserted Successfully');
                } else {
                    // echo "test";
                    $model = new OnceEmailModel();
                    $data['email_detail'] = $model->orderBy('id', 'asc')->findAll();
                    

                    $data['validation'] = $this->validator;
                    // echo view('include/header');
                    echo view('once_email', $data);
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
        
        $model = new OnceEmailModel();
        $data['category'] = $model->orderBy('id', 'asc')->findAll();
        $data['row'] =$model->where('id',$id)->first();
       
        echo view('edit_once_email', $data);
    }

    // public function update($id)
    // {
    //     // echo "<pre>";
    //     // print_r($_POST); exit;
    //     helper('form');
    //     $session = session();
    //     if ($session->has('username')) {

    //         $Common = new Common();
    //         $model = new OnceEmailModel();
            
    //         $data2 = [
    //             'email_id' => $this->request->getVar('email'),
                
    //         ];
    //         $get_row = $model->where($data2)->first();
    //         if(!empty($get_row)){
    //             return redirect()->to(base_url('OnceEmail/edit/'.$id))->with('status_icon', 'error')
    //             ->with('status', 'Data already exsist');

    //         }else{

    //         $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
    //         $data = [
    //             'email_id' => $this->request->getVar('email'),
    //             'nature_of_email' => $this->request->getVar('natureofmail'),
    //             'forwarding_to' => $this->request->getVar('forwarding'),
    //             'updated_by' => $session->get('username'),
    //             'updated_on' => $now,
    //             'status' => 'Active'

    //         ];
            
    //         $Common->UpdateRecord($model, $data, $id);

    //         // // $model->employee_added_data($data);
    //         return redirect()->to(base_url('OnceEmail'))->with('status_icon', 'success')
    //             ->with('status', 'Email Updated Successfully');
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
                'email' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                        
                    ],
                ],
                'natureofmail' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
            ];

            if ($this->request->getMethod() == 'put') {
                if ($this->validate($rules)) {

            $Common = new Common();
            $model = new OnceEmailModel();
            $data2 = [
                'email_id' => $this->request->getVar('email'),
            ];
            $get_row = $model->where($data2)->first();
            if(!empty($get_row)){
                if($get_row['id'] != $id){
                    return redirect()->to(base_url('OnceEmail/edit/'.$id))->with('status_icon', 'error')
                   ->with('status', 'This Email already exists');
                }else{

                $data = [
                
                'nature_of_email' => $this->request->getVar('natureofmail'),
                'forwarding_to' =>  $this->request->getVar('forwarding'),
                'expiry_date' =>  $this->request->getVar('expiry'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                // 'status' => 'Active'

            ];
            
                $Common->UpdateRecord($model, $data, $id);
                return redirect()->to(base_url('OnceEmail'))->with('status_icon', 'success')
                ->with('status', 'Email Updated Successfully');
            }

            }else{

            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'email_id' => $this->request->getVar('email'),
                'nature_of_email' => $this->request->getVar('natureofmail'),
                'forwarding_to' =>  $this->request->getVar('forwarding'),
                'expiry_date' =>  $this->request->getVar('expiry'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                // 'status' => 'Active'

            ];
            
            $Common->UpdateRecord($model, $data, $id);

            // // $model->employee_added_data($data);
            return redirect()->to(base_url('OnceEmail'))->with('status_icon', 'success')
                ->with('status', 'Email Updated Successfully');
                }
            }else{
                $model = new OnceEmailModel();
                $data['category'] = $model->orderBy('id', 'asc')->findAll();
                $data['row'] =$model->where('id',$id)->first();
                $data['validation'] = $this->validator;
                echo view('edit_once_email', $data);

       
               }
             }// echo view('include/header');
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


            $model = new OnceEmailModel();
            $model->where('id', $id)->delete();

            return redirect()->to(base_url('OnceEmail'))->with('status_icon', 'success')
                ->with('status', 'Delete Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
}
