<?php
namespace App\Controllers;
use system\I18n\Time;
use App\Models\StarSquareModel;
use App\Libraries\Common;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Request;

// use Dompdf\Dompdf;

class OnceStarSquare extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form', 'url');
        $model = new StarSquareModel();
        $query['desi_detail'] = $model->orderBy('id', 'desc')->findAll();
        if (count($query['desi_detail']) > 0) {
            // echo view('include/header');
            echo view('starnsquare', $query);
        } else {
            echo view('starnsquare');
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
                'st_sq' => $this->request->getVar('starnsquare'),
                'color' => $this->request->getVar('color'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'
            ];
            $model = new StarSquareModel();
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
                'starnsquare' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                'color' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],
                
            ];
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "save";
                    $data2 = [
                    'st_sq' => $this->request->getVar('starnsquare'),
                    'color' => $this->request->getVar('color'),
                        ];
                        $model = new StarSquareModel();
                    $get_row = $model->where($data2)->first();
                    if(!empty($get_row)){
                        return redirect()->to(base_url('OnceStarSquare'))->with('status_icon', 'error')
                            ->with('status', 'Data already exsist');

                    }else{

                    $this->insert();

                    return redirect()->to(base_url('OnceStarSquare'))->with('status_icon', 'success')
                        ->with('status', 'Star and Square Inserted Successfully');
                    }
                } else {
                    // echo "test";
                    $model = new StarSquareModel();
                    $data['desi_detail'] = $model->orderBy('id', 'desc')->findAll();
                    

                    $data['validation'] = $this->validator;
                    // echo view('include/header');
                    echo view('starnsquare', $data);
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
        
        $model = new StarSquareModel();
        $data['category'] = $model->orderBy('id', 'desc')->findAll();
        $data['row'] =$model->where('id',$id)->first();
       
       // echo view('include/header');
        echo view('starnsquare_edit', $data);
    }

    // public function update($id)
    // {
    //     // echo "<pre>";
    //     // print_r($_POST); exit;
    //     helper('form');
    //     $session = session();
    //     if ($session->has('username')) {

    //         $Common = new Common();
    //          $model = new StarSquareModel();
    //         $data2 = [
    //             'st_sq' => $this->request->getVar('starnsquare'),
    //             'color' => $this->request->getVar('color'),
    //         ];
    //         $get_row = $model->where($data2)->first();
    //         if(!empty($get_row)){
    //             return redirect()->to(base_url('OnceStarSquare/edit/'.$id))->with('status_icon', 'error')
    //             ->with('status', 'Data already exsist');

    //         }else{

    //         // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
    //         $data = [
    //             'st_sq' => $this->request->getVar('starnsquare'),
    //             'color' => $this->request->getVar('color'),
    //             'updated_by' => $session->get('username'),
    //             // 'updated_on' => $now,
    //             'status' => 'Active'

    //         ];
           
    //         $Common->UpdateRecord($model, $data, $id);

    //         // // $model->employee_added_data($data);
    //         return redirect()->to(base_url('OnceStarSquare'))->with('status_icon', 'success')
    //             ->with('status', 'Star and Square Updated Successfully');
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
                'starnsquare' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],

                'color' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required',
                    ],
                ],
                
            ];

            if ($this->request->getMethod() == 'put') {
                if ($this->validate($rules)) {

            $Common = new Common();
             $model = new StarSquareModel();
            $data2 = [
                'st_sq' => $this->request->getVar('starnsquare'),
                'color' => $this->request->getVar('color'),
            ];
            $get_row = $model->where($data2)->first();
            if(!empty($get_row)){
                return redirect()->to(base_url('OnceStarSquare/edit/'.$id))->with('status_icon', 'error')
                ->with('status', 'Data already exsist');

            }else{

            // $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));;
            $data = [
                'st_sq' => $this->request->getVar('starnsquare'),
                'color' => $this->request->getVar('color'),
                'updated_by' => $session->get('username'),
                // 'updated_on' => $now,
                'status' => 'Active'

            ];
           
            $Common->UpdateRecord($model, $data, $id);

            // // $model->employee_added_data($data);
            return redirect()->to(base_url('OnceStarSquare'))->with('status_icon', 'success')
                ->with('status', 'Star and Square Updated Successfully');
              }
            }else{
                $model = new StarSquareModel();
                $data['category'] = $model->orderBy('id', 'desc')->findAll();
                $data['row'] =$model->where('id',$id)->first();
                $data['validation'] = $this->validator;
                echo view('starnsquare_edit', $data);

       
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


            $model = new StarSquareModel();
            $model->where('id', $id)->delete();

            return redirect()->to(base_url('OnceStarSquare'))->with('status_icon', 'success')
                ->with('status', 'Star and Square Deleted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
}
