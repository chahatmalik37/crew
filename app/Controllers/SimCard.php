<?php
namespace App\Controllers;
use system\I18n\Time;
use App\Models\SimCardModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class SimCard extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $model = new SimCardModel();
        $query['simcard'] = $model->orderBy('id', 'asc')->findAll();
        if (count($query['simcard']) > 0) {
            // echo view('include/header');
            echo view('simcard', $query);
        } else {
            echo view('simcard');
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
               'number'=> $this->request->getVar('simno'),
             'provider'=> $this->request->getVar('provider'),
             'package'=> $this->request->getVar('package'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'
            ];
            $model = new SimCardModel();
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
                'simno' => [
                    'rules' => 'required|is_unique[once_simcard.number]',
                    'errors' => [
                        'required' => 'Required',
                        'is_unique' => 'Already Taken'
                    ],
                ],
                
                
                'provider' => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Required',
                        
                    ],
                ],



                'package' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],
                
            ];
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "save";

                    $this->insert();

                    return redirect()->to(base_url('SimCard'))->with('status_icon', 'success')
                        ->with('status', 'Simcard Inserted Successfully');
                } else {
                    // echo "test";
                    $model = new SimCardModel();
                    $data['simcard'] = $model->orderBy('id', 'asc')->findAll();
                    

                    $data['validation'] = $this->validator;
                    
                    echo view('simcard', $data);
                   
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
        
        $model = new SimCardModel();
        $data['simcard'] = $model->orderBy('id', 'asc')->findAll();
        $data['row'] =$model->where('id',$id)->first();
       
       
        echo view('simcard_edit', $data);
    }

    // public function update($id)
    // {
    //     // echo "<pre>";
    //     // print_r($_POST); exit;
    //     helper('form');
    //     $session = session();
    //     if ($session->has('username')) {

    //         $Common = new Common();
    //         $model = new SimCardModel();
    //         $data2 = [
    //             'number' => $this->request->getVar('simno'),
    //         ];
    //         $get_row = $model->where($data2)->first();
    //         if(!empty($get_row)){
    //             return redirect()->to(base_url('SimCard/edit/'.$id))->with('status_icon', 'error')
    //             ->with('status', 'Data already exsist');

    //         }else{

    //         // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
    //         $data = [
    //             'number'=> $this->request->getVar('simno'),
    //          'provider'=> $this->request->getVar('provider'),
    //          'package'=> $this->request->getVar('package'),
    //             'updated_by' => $session->get('username'),
    //             // 'updated_on' => $now,
    //             'status' => 'Active'

    //         ];
            
    //         $Common->UpdateRecord($model, $data, $id);

    //         // // $model->employee_added_data($data);
    //         return redirect()->to(base_url('SimCard'))->with('status_icon', 'success')
    //             ->with('status', 'Simcard Updated Successfully');
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
                'provider' => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Required',
                        
                    ],
                ],

                'simno' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                        
                    ],
                ],

                'package' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],
                
            ];

            if ($this->request->getMethod() == 'put') {
                if ($this->validate($rules)) {

            $Common = new Common();
            $model = new SimCardModel();
            $data2 = [
                'number' => $this->request->getVar('simno'),
            ];
            $get_row = $model->where($data2)->first();
            if(!empty($get_row)){
                if($get_row['id'] != $id){
                    return redirect()->to(base_url('SimCard/edit/'.$id))->with('status_icon', 'error')
                   ->with('status', 'This number already exists');
                }else{

                $data = [
                'provider'=> $this->request->getVar('provider'),
                'package'=> $this->request->getVar('package'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                // 'status' => 'Active'
                ];
            
                $Common->UpdateRecord($model, $data, $id);
                return redirect()->to(base_url('SimCard'))->with('status_icon', 'success')
                ->with('status', 'Simcard Updated Successfully');
            }

            }else{

            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'number'=> $this->request->getVar('simno'),
             'provider'=> $this->request->getVar('provider'),
             'package'=> $this->request->getVar('package'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                // 'status' => 'Active'

            ];
            
            $Common->UpdateRecord($model, $data, $id);

            // // $model->employee_added_data($data);
            return redirect()->to(base_url('SimCard'))->with('status_icon', 'success')
                ->with('status', 'Simcard Updated Successfully');
                }
            }else{
                $model = new SimCardModel();
                $data['simcard'] = $model->orderBy('id', 'asc')->findAll();
                $data['row'] =$model->where('id',$id)->first();
                $data['validation'] = $this->validator;
                echo view('simcard_edit', $data);

       
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


            $model = new SimCardModel();
            $model->where('id', $id)->delete();

            return redirect()->to(base_url('SimCard'))->with('status_icon', 'success')
                ->with('status', 'Simcard Deleted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
}
