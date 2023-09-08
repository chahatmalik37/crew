<?php
namespace App\Controllers;
use system\I18n\Time;
use App\Models\RenewalModel;
// use App\Models\DashboardXModel;

use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class Renewal extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $model = new RenewalModel();
        $query['desi_detail'] = $model->orderBy('id', 'desc')->findAll();
        if (count($query['desi_detail']) > 0) {
            // echo view('include/header');
            echo view('renewal', $query);
        } else {
            echo view('renewal');
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
                'product' => $this->request->getVar('product'),
                'category' => $this->request->getVar('category'),
                'expiry_date' => $this->request->getVar('expirydate'),
                'amount' => $this->request->getVar('amount'),
                'notes' => $this->request->getVar('notes'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'
            ];
            $model = new RenewalModel();
             $last_id = $Common->SaveRecordGetId($model, $data);
            // if ($this->request->getVar('expirydate')) {
            // $data6 = [
            //     'a_id'=>$last_id,
            //     'head'=>'expiry',
            //     'start' => $this->request->getVar('expirydate'),
            //     'updated_by' => $session->get('username'),
            //     'updated_on' => $now,
            // ];
            // $model6 = new DashboardXModel();
            // $Common->SaveRecord($model6, $data6);
        // }
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
                'product' => [
                    'rules' => 'required|is_unique[renewal.product]',
                    'errors' => [
                        'required' => 'Required',
                        // 'alpha_space' => 'Please enter only alphabets',
                    ],
                ],

                'category' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                        // 'is_unique' => 'Already Taken'
                    ],
                ],

                // 'expirydate' => [
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => 'Required',
                //     ],
                // ],
                
            ];
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "save";

                    $this->insert();

                    return redirect()->to(base_url('Renewal'))->with('status_icon', 'success')
                        ->with('status', 'Product Inserted Successfully');
                } else {
                    // echo "test";
                    $model = new RenewalModel();
                    $data['desi_detail'] = $model->where('status','Active')->orderBy('id', 'desc')->findAll();
                    

                    $data['validation'] = $this->validator;
                    // echo view('include/header');
                    echo view('renewal', $data);
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
        
        $model = new RenewalModel();
        $data['category'] = $model->orderBy('id', 'desc')->findAll();
        $data['row'] =$model->where('id',$id)->first();
       
       // echo view('include/header');
        echo view('renewal_edit', $data);
    }

        public function update($id)
    {
        // echo "<pre>";
        // print_r($_POST); exit;
        helper('form');
        $session = session();
        if ($session->has('username')) {

           $data = [];
            $rules = [
                'product' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                        // 'alpha_space' => 'Please enter only alphabets',
                    ],
                ],

                'category' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                // 'expirydate' => [
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => 'Required',
                //     ],
                // ],
                
            ];

            if ($this->request->getMethod() == 'put') {
                if ($this->validate($rules)) {

            $Common = new Common();
            $model = new RenewalModel();
            $data2 = [
                'product' => $this->request->getVar('product'),
                'category' => $this->request->getVar('category'),
            ];
            $get_row = $model->where($data2)->first();
            if(!empty($get_row)){
                if($get_row['id'] != $id){
                    return redirect()->to(base_url('Renewal/edit/'.$id))->with('status_icon', 'error')
                   ->with('status', 'This Product Already exists');
                }else{

                $data = [
                    'product' => $this->request->getVar('product'),
                    'category' => $this->request->getVar('category'),
                    'expiry_date' => $this->request->getVar('expirydate'),
                    'amount' => $this->request->getVar('amount'),
                    'notes' => $this->request->getVar('notes'),
                    'updated_by' => $session->get('username'),
                    // 'updated_on' => $now,
                    'status' => 'Active'
                ];
            
                $Common->UpdateRecord($model, $data, $id);
                return redirect()->to(base_url('Renewal'))->with('status_icon', 'success')
                ->with('status', 'Product Updated Successfully');
            }

            }else{

            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'product' => $this->request->getVar('product'),
                'category' => $this->request->getVar('category'),
                'expiry_date' => $this->request->getVar('expirydate'),
                'amount' => $this->request->getVar('amount'),
                'notes' => $this->request->getVar('notes'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'
            ];
            
            $Common->UpdateRecord($model, $data, $id);

            // // $model->employee_added_data($data);
            return redirect()->to(base_url('Renewal'))->with('status_icon', 'success')
                ->with('status', 'Product Updated Successfully');
                }
            }else{
                $model = new RenewalModel();
                $data['category'] = $model->orderBy('id', 'desc')->findAll();
                $data['row'] =$model->where('id',$id)->first();
                $data['validation'] = $this->validator;
                echo view('renewal_edit', $data);

       
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


            $model = new RenewalModel();
            $model->where('id', $id)->delete();

            return redirect()->to(base_url('Renewal'))->with('status_icon', 'success')
                ->with('status', 'Product Deleted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
}
