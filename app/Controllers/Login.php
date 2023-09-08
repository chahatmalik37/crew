<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Login extends BaseController
{

    private $db;
  
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        echo view('login');

    }
    public function AuthLogin()
{
    $data = [
        'login_id' => $this->request->getVar('email'),
        'login_password' => MD5($this->request->getVar('password')),
    ];

    $login_get = $this->db->table("user");
    $login_get->where($data);
    $query = $login_get->get()->getResultArray();

    if (count($query) > 0) {
        $session = session();
        $ses_data = [
            'employe_id' => $query[0]['employee_id'],
            'login_id' => $query[0]['login_id'],
            'login_type' => $query[0]['user_type'],
            'username' => $query[0]['employee_name'],
            'isLoggedIn' => TRUE
        ];
        $session->set($ses_data);

        if ($session->get('login_type') == 'Admin') {
            return redirect()->to(base_url('/Dashboard'));
        } else {
            return redirect()->to(base_url('/Attendance'));
        }
    } else {
        $session = session();
        // $session->setFlashdata('login_failed', 'Incorrect email or password. Please try again.');
        
        

return redirect()->to('/')->with('info', 'hiiii test');
    }
}

    
    public function logout()
    {  $session = session();
        $session->destroy();
        return redirect()->to('/');

    }
}    