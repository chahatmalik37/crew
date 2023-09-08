<?php
namespace App\Controllers;
use system\I18n\Time;
use App\Models\AntivirusModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class OnceAntivirus extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $model = new AntivirusModel();
        $query['desi_detail'] = $model->orderBy('id', 'asc')->findAll();
        if (count($query['desi_detail']) > 0) {
            // echo view('include/header');
            echo view('antivirus', $query);
        } else {
            echo view('antivirus');
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
                'serv_provider' => $this->request->getVar('provider'),
                'key_alloted' => $this->request->getVar('keys'),
                'expiry_date' => $this->request->getVar('expirydate'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'
            ];
            $model = new AntivirusModel();
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
                'provider' => [
                    'rules' => 'required|alpha_space',
                    'errors' => [
                        'required' => 'Required',
                        'alpha_space' => 'Please enter only alphabets',
                    ],
                ],

                'keys' => [
                    'rules' => 'required|is_unique[once_antivirus.key_alloted]',
                    'errors' => [
                        'required' => 'Required',
                        'is_unique' => 'Already Taken'
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

                    return redirect()->to(base_url('OnceAntivirus'))->with('status_icon', 'success')
                        ->with('status', 'Antivirus Inserted Successfully');
                } else {
                    // echo "test";
                    $model = new AntivirusModel();
                    $data['desi_detail'] = $model->orderBy('id', 'asc')->findAll();
                    

                    $data['validation'] = $this->validator;
                    // echo view('include/header');
                    echo view('antivirus', $data);
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
        
        $model = new AntivirusModel();
        $data['category'] = $model->orderBy('id', 'asc')->findAll();
        $data['row'] =$model->where('id',$id)->first();
       
       // echo view('include/header');
        echo view('antivirus_edit', $data);
    }

    // public function update($id)
    // {
    //     // echo "<pre>";
    //     // print_r($_POST); exit;
    //     helper('form');
    //     $session = session();
    //     if ($session->has('username')) {

    //         $Common = new Common();
    //         $model = new AntivirusModel();
    //         $data2 = [
    //             'key_alloted' => $this->request->getVar('keys'),
    //         ];
    //         $get_row = $model->where($data2)->first();
    //         if(!empty($get_row)){
    //             return redirect()->to(base_url('OnceAntivirus/edit/'.$id))->with('status_icon', 'error')
    //             ->with('status', 'Data already exsist');

    //         }else{

    //         // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
    //         $data = [
    //             'serv_provider' => $this->request->getVar('provider'),
    //             'key_alloted' => $this->request->getVar('keys'),
    //             'expiry_date' => $this->request->getVar('expirydate'),
    //             'updated_by' => $session->get('username'),
    //             // 'updated_on' => $now,
    //             'status' => 'Active'

    //         ];
            
    //         $Common->UpdateRecord($model, $data, $id);

    //         // // $model->employee_added_data($data);
    //         return redirect()->to(base_url('OnceAntivirus'))->with('status_icon', 'success')
    //             ->with('status', 'Antivirus Updated Successfully');
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
                        'alpha_space' => 'Please enter only alphabets',
                    ],
                ],

                'keys' => [
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
            $model = new AntivirusModel();
            $data2 = [
                'key_alloted' => $this->request->getVar('keys'),
            ];
            $get_row = $model->where($data2)->first();
            if(!empty($get_row)){
                if($get_row['id'] != $id){
                    return redirect()->to(base_url('OnceAntivirus/edit/'.$id))->with('status_icon', 'error')
                   ->with('status', 'This Key already exists');
                }else{

                $data = [
                'serv_provider' => $this->request->getVar('provider'),
                'expiry_date' => $this->request->getVar('expirydate'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                // 'status' => 'Active'
                ];
            
                $Common->UpdateRecord($model, $data, $id);
                return redirect()->to(base_url('OnceAntivirus'))->with('status_icon', 'success')
                ->with('status', 'Antivirus Updated Successfully');
            }

            }else{

            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'serv_provider' => $this->request->getVar('provider'),
                'key_alloted' => $this->request->getVar('keys'),
                'expiry_date' => $this->request->getVar('expirydate'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                // 'status' => 'Active'
            ];
            
            $Common->UpdateRecord($model, $data, $id);

            // // $model->employee_added_data($data);
            return redirect()->to(base_url('OnceAntivirus'))->with('status_icon', 'success')
                ->with('status', 'Antivirus Updated Successfully');
                }
            }else{
                $model = new AntivirusModel();
                $data['category'] = $model->orderBy('id', 'asc')->findAll();
                $data['row'] =$model->where('id',$id)->first();
                $data['validation'] = $this->validator;
                echo view('antivirus_edit', $data);

       
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


            $model = new AntivirusModel();
            $model->where('id', $id)->delete();

            return redirect()->to(base_url('OnceAntivirus'))->with('status_icon', 'success')
                ->with('status', 'Antivirus Deleted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
}
