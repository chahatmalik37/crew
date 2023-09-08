<?php
namespace App\Controllers;
use App\Models\ReportModel;
use App\Models\TempReportModel;
use App\Models\ShareReportModel;
use App\Models\AllotmentModel;
use App\Models\OnceEmailModel;
use App\Libraries\Common;
class Report extends BaseController
{ 
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

	public function index()
	{
        $session = session();
        if ($session->has('username')) {
              $username =$session->get('employe_id');
           $model = new ReportModel();
           $data['report'] = $model->where('updated_by',$username)->findAll();
           $model1 = new TempReportModel();
           $data['template'] = $model1->where('updated_by',$username)->findAll();
           // echo $this->db->getLastQuery();
           // print_r($data);
          echo view('report',$data);
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
	}

	 public function template_create()
    {
    	
         $session = session();
        if ($session->has('username')) {
            $Common = new Common();
            $data=[
                'template'=> $this->request->getVar('template'),
                'updated_by'=> $session->get('employe_id'),
                'status' => 'Active',

            ];
            $model = new TempReportModel();
            $Common->SaveRecord($model, $data);
            if(!empty($this->request->getVar('template_1'))){
            $count = count($this->request->getVar('template_1'));
             for ($i=0; $i < $count ; $i++) { 
                $data=[
                'template'=> $this->request->getVar('template_1')[$i],
                'updated_by'=> $session->get('employe_id'),
                'status' => 'Active',

             ];
            
            $Common->SaveRecord($model, $data);

             }
         }
             return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Template Created Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

	 public function add_report()
    {
        $session = session();
        if ($session->has('username')) {
            $Common = new Common();
                // echo "<pre>";
                // print_r($_POST);
            $model = new ReportModel();
            $count = count($this->request->getVar('temp_id'));
             for ($i=0; $i < $count ; $i++) { 
                $data=[
                'date'=> $this->request->getVar('date'),
                'template_id'=> $this->request->getVar('temp_id')[$i],
                'report'=> $this->request->getVar('details')[$i],
                'updated_by'=> $session->get('employe_id'),
                'status' => 'Active',

             ];
            
            $Common->SaveRecord($model, $data);

             }
             
             if(!empty($this->request->getVar('temp_id_share'))){

                       $count1 = count($this->request->getVar('temp_id_share'));
                       for ($i=0; $i < $count1 ; $i++) { 
                        $data1=[
                        'date'=> $this->request->getVar('date'),
                        'template_id'=> $this->request->getVar('temp_id_share')[$i],
                        'updated_by'=> $session->get('employe_id'),
                        'report'=> $this->request->getVar('details_share')[$i],
                        'share'=>1,
                        'status' => 'Active',

                     ];
                    
                    $Common->SaveRecord($model, $data1);

                    }
                }
             return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Report Submitted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function add_report_modal()
    {
        $session = session();
        if ($session->has('username')) {
            $Common = new Common();
                // echo "<pre>";
                // print_r($_POST); exit;
            $model = new ReportModel();
            $data=[
                'date'=> $this->request->getVar('date'),
                // 'template_id'=> $this->request->getVar('temp_id'),
                'report'=> $this->request->getVar('report'),
                'updated_by'=> $session->get('employe_id'),
                'status' => 'Active',
            ];
            
            if(!empty($this->request->getVar('temp_id_share'))){

                       $count1 = count($this->request->getVar('temp_id_share'));
                       for ($i=0; $i < $count1 ; $i++) { 
                           echo "Active";
                        $data1=[
                        'date'=> $this->request->getVar('date'),
                        'template_id'=> $this->request->getVar('temp_id_share')[$i],
                        'updated_by'=> $session->get('employe_id'),
                        'report'=> $this->request->getVar('details_share')[$i],
                        'share'=>1,
                        'status' => 'Active',

                     ];
                    
                    $Common->SaveRecord($model, $data1);

                    }
                }
            $Common->SaveRecord($model, $data);
    
             
             return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Report Submitted Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function del_template(){
      
        
        $model = new TempReportModel();
        $id = $this->request->getVar('id_temp');
        $data =[
            'status'=> 'Inactive',
               
                ];
        $res = $model->update($id,$data);         
        echo json_encode($res);
    }

    public function get_detail(){
           $data = [
                'rep.date'=> $this->request->getVar('date_add'),
                'rep.updated_by'=> $this->request->getVar('user_name'),
                
                ];
                
            $sales_get = $this->db->table("report as rep");
            $sales_get->select('rep.id as rep_id,rep.date,rep.template_id,rep.report,rep.updated_by,rep.share,r_t.template,r_t.updated_by,r_t.id,emp.id,emp.name');
            $sales_get->join('rep_template as r_t', 'rep.template_id = r_t.id', "left");
            $sales_get->join('employee as emp', 'r_t.updated_by = emp.id', "left");
            $sales_get->where($data);
            
            $query = $sales_get->get()->getResultArray();  
           echo json_encode($query);
        }
        
        public function get_share_date(){
           $data = [
                // 'sr.shared_date'=> $this->request->getVar('date_add'),
                'sr.shared_id'=> $this->request->getVar('user_name'),
                'sr.status'=> 'Active',
            ];
            $sales_get = $this->db->table("share_report as sr");
            $sales_get->select('sr.*,emp.id,emp.name');
            $sales_get->join('employee as emp', 'sr.emp_id = emp.id', "left");
            $sales_get->where($data);
            $query = $sales_get->get()->getResultArray();  
           echo json_encode($query);
        }
    

	public function edit_report()
	{
        
        $session = session();
        if ($session->has('username')) {
            $Common = new Common();
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";

                //  exit;
            $model = new ReportModel();
             $count = count($this->request->getVar('details'));
             for ($i=0; $i < $count ; $i++) { 
               
                $data=[
                'date'=> $this->request->getVar('date_add'),
                'report'=> $this->request->getVar('details')[$i],
                'updated_by'=> $session->get('employe_id'),
                'status' => 'Active',

                ];
                 $id=$this->request->getVar('id_edit')[$i];
            
               $res = $model->update($id,$data);         


             }
             
             return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Report Edited Successfully');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
		
	}

    public function share_report(){
        $session = session();
        if ($session->has('username')) {
        helper('form');
        $Common = new Common();
        
        $rules = [
            'share_email' => [
                'rules' => 'required|valid_emails',
                'errors' => [
                    'required'=>'Required Field',
                    'valid_emails' => 'please provide valid email'
                ],
            ],

             'share_date' => [
                'rules' => 'required',
                'errors' => [
                    'required'=>'Required Field',
                ],
            ],
        ];
       
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                    // echo "<pre>";
                    // print_r($_POST);
                    // echo "</pre>";
                    $share_email =$this->request->getVar('share_email');
                    $share_date  =$this->request->getVar('share_date');
                    $share_e = explode(",",$share_email);
                    $count = count($share_e);
                    //  echo "<pre>";
                    // print_r($share_e);
                    // echo "</pre>";

                   $model11 = new ShareReportModel();
           
             for ($i=0; $i < $count ; $i++) { 
                $model = new OnceEmailModel();
                $model2 = new AllotmentModel();

                 $once_email_dbid = $model->where('email_id',$share_e[$i])->findAll();
                 $once_email_dbid = $once_email_dbid[0]['id'];
                 $alot_emp_id = $model2->like('email_id',$once_email_dbid)->findAll();
                 $share_id = $alot_emp_id[0]['emp_id'];
                    // echo "<pre>";
                    // print_r($alot_emp_id);
                    // echo "</pre>";
                    if($share_id != $session->get('employe_id') ){
        
               $data2=[
                    'emp_id'=> $session->get('employe_id'),
                    'shared_id'=> $share_id,
                    'shared_date'=> $this->request->getVar('share_date'),
                    'updated_by'=>$session->get('username'),
                    'status' => 'Active',
                ];
                
                $event = $this->db->table("alloted as al");
                $event->select('eml.email_id');
                $event->join('once_email as eml', "find_in_set(eml.id,al.email_id)<>0", "left");
                $event->where('al.emp_id', $session->get('employe_id') );
                $fromMailId= $event->get()->getRow('email_id');
                
                $message = '<b>Hello,</b><p>You have recieved a Daily Report Share request from '.trim($session->get('username')," ").' and shared date is '.date('d-m-Y',strtotime($this->request->getVar('share_date'))).'. Please Login and Check.</p>';
                $email = \Config\Services::email();
                $email->setTo($share_e[$i]);
                $email->setCC('hr@ansh.com');
                $email->setFrom($fromMailId, 'Share Report of '.$session->get('username'));
                $email->setSubject('Share Report');
                $email->setMessage($message);
                $email->send();

                $Common->SaveRecord($model11, $data2);
                    }else{
                       return redirect()->to(base_url('Attendance'))->with('status_icon', 'error')
                        ->with('status', 'Please do not enter your ID for Share'); 
                    }

             }
             
             return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Report Shared Successfully');

                }else{
                   //  $username =$session->get('employe_id');
                   // $model = new ReportModel();
                   // $data['report'] = $model->where('updated_by',$username)->where('status','Active')->findAll();
                   // $model1 = new TempReportModel();
                   // $data['template'] = $model1->where('updated_by',$username)->where('status','Active')->findAll();
                   //  $data['validation'] = $this->validator;
                   //  echo view('report',$data);
                    return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Please check the form');
                }
            }
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }

    }
    
    public function stop_share_report(){
         $session = session();
        if ($session->has('username')) {
            $data = [
                'shared_date'=> $this->request->getVar('stop_share_date'),
                'emp_id'=> $session->get('employe_id'),
                
                ];
            $sales_get = $this->db->table("share_report as rep");
            $sales_get->select('rep.*');
            // $sales_get->join('rep_template as r_t', 'rep.template_id = r_t.id', "left");
            $sales_get->where($data);
            $query = $sales_get->get()->getResultArray();
            // echo "<pre>";
            // print_r($query); 
            $count = count($query);
            for ($i=0; $i < $count ; $i++) { 
                $model = new ShareReportModel();
            $data=[
                'status' => 'InActive',
                'shared_end'=> date('Y-m-d'),

                ];
                 $id=$query[$i]['id'];
            
               $res = $model->update($id,$data); 
              
            }
             return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Sharing stopped Successfully');

        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }

     }

}
?>