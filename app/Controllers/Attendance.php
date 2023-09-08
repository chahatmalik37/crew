<?php

namespace App\Controllers;

use system\I18n\Time;
use App\Models\ShareReportModel;
use App\Models\EmployeeModel;
use App\Models\EventsModel;
use App\Models\Att_Model;
use App\Models\UserModel;
use App\Models\AttendanceModel;
use App\Models\EmpLeaveModel;
use App\Models\NotesModel;
use App\Models\ReportModel;
use App\Models\TempReportModel;
use App\Libraries\Common;
use App\Libraries\LogTypeEnum;
use App\Controllers\BaseController;
// use Dompdf\Dompdf;

class Attendance extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        helper('form');
        $session = session();
        $att_model = new Att_Model;
        if ($session->has('username')) {
            $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));
            $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select('emp.log_type');
                $builder->where('emp.employee_id', $session->get('employe_id'));
                $builder->orderby('emp.id',"desc");
                $builder->limit(1);
                $query = $builder->get()->getResultArray();
                $builder = $this->db->table("emp_daily_attendance as emp");
            $builder->select('emp.*');
            $builder->where('emp.employee_id', $session->get('employe_id'));
            
            $builder->where('date(`created_at`)', date('Y-m-d', strtotime($now)));
            $builder->orderby('emp.id',"asc");
            $EmpAttDet = $builder->get()->getResultArray();
                        $data = ['session' => $session, 'request' => $this->request];
          
    $builder = $this->db->table("emp_leave as lv");
    $builder->select('lv.*');
    $builder->where('lv.employee_id', $session->get('employe_id'));
    $builder->orderby('lv.id desc');
     $empLeave = $builder->get()->getResultArray();
           
           $check = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
               $check2 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGOUT)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check3 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::BREAK)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check4 = $att_model->where('employee_id',$session->get('employe_id'))->where('log_type', LogTypeEnum::RESTART)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
              $check6 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGOUT)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->countAllResults();
                $check5 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->countAllResults();
              
                $data['breakCount'] = $check3;
            $data['RestartCount'] = $check4;
            $data['loginCount'] = $check;
            $data['logoutCount'] = $check2;
        $data['prevLoginCount'] = $check5;
        $data['prevLogoutCount'] = $check6;
        $data['EmpAttDet']=$EmpAttDet;
        $data['empLeave']=$empLeave;
             $data['status']=$query[0]['log_type'];
             $username =$session->get('employe_id');
            //Report section starts(shruti) 
           
           $model1 = new TempReportModel();
           $data['template'] = $model1->where('updated_by',$username)->where('status','Active')->findAll();
           $model = new ShareReportModel();
           $share_query = $this->db->table("share_report as sr");
            $share_query->select('sr.*,emp.name,emp.id');
            $share_query->join('employee as emp', 'sr.emp_id = emp.id', "left");
            $share_query->where('sr.shared_id',$username);
            $share_query->where('sr.status','Active');
            $data['share_template'] = $share_query->get()->getResultArray();
            
            $my_share = $this->db->table("share_report as sr");
            $my_share->select('sr.*,emp.name,emp.id');
            $my_share->join('employee as emp', 'sr.shared_id = emp.id', "left");
            $my_share->where('sr.emp_id',$username);
            $my_share->where('sr.status','Active');
            $data['my_share'] = $my_share->get()->getResultArray();
            //Report section ends(shruti) 
        //   echo "<pre>";
        //   print_r($data['share_template']);
        //   echo "</pre>";
        //   exit;
            echo view('attendance', $data);
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }


    public function add()
    {
      
        $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));
        $session = session();
         
         if ($session->has('username')) {
          $username =$session->get('username');
          //Report section starts (shruti)
           
           $model1 = new TempReportModel();
           $data['template'] = $model1->where('updated_by',$username)->where('status','Active')->findAll();
           
            $share_query = $this->db->table("share_report as sr");
            $share_query->select('sr.*,emp.name,emp.id');
            $share_query->join('employee as emp', 'sr.emp_id = emp.id', "left");
            $share_query->where('sr.shared_id',$username);
            $share_query->where('sr.status','Active');
            $data['share_template'] = $share_query->get()->getResultArray();
            
            $my_share = $this->db->table("share_report as sr");
            $my_share->select('sr.*,emp.name,emp.id');
            $my_share->join('employee as emp', 'sr.shared_id = emp.id', "left");
            $my_share->where('sr.emp_id',$username);
            $my_share->where('sr.status','Active');
            $data['my_share'] = $my_share->get()->getResultArray();
            //Report section ends (shruti) 
            
        $att_model = new Att_Model;
         $Common = new Common;
        $data = ['session' => $session, 'request' => $this->request];
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            if ($session->has('employe_id')) {
 helper('form');
                // $ipaddress =   file_get_contents('https://api.ipify.org');
                // echo   $ipaddress.'ghgh';
                // exit;
                // if ($ipaddress) {
                //     $ip = $ipaddress;
                // } else {
                $ip = '';
                // }
                $idata['ip_address'] = $ip;
                $idata['employee_id'] = $session->get('employe_id');
                if (isset($log_in)) {
                    $idata['log_type'] = LogTypeEnum::LOGIN;
                    $lt = "Time In";
                } else if (isset($break)) {
                    $idata['log_type'] = LogTypeEnum::BREAK;
                    //  if($l_break==1){
                    //                     $lt = "Lunch Break";
                    //                 }else{
                    $lt = "Break";
                    // }
                } else if (isset($restart)) {
                    $idata['log_type'] = LogTypeEnum::RESTART;
                    //  if($l_restart==1){
                    //     $lt = "Lunch Restart";
                    // }else{
                    $lt = "Restart";
                    // }
                } else {
                    $idata['log_type'] = LogTypeEnum::LOGOUT;
                    $lt = "Time Out";
                }
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select('emp.log_type');
                $builder->where('emp.employee_id', $session->get('employe_id'));
                $builder->orderby('emp.id', "desc");
                $builder->limit(1);
                $query = $builder->get()->getResultArray();
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select('emp.*');
                $builder->where('emp.employee_id', $session->get('employe_id'));

                $builder->where('date(`created_at`)', date('Y-m-d', strtotime($now)));
                $builder->orderby('emp.id', "asc");
                $EmpAttDet = $builder->get()->getResultArray();
                // $check = $att_model->where('employee_id',$idata['employee_id'])->where('log_type',$idata['log_type'])->where('date(`created_at`)',date('Y-m-d'))->countAllResults();
                $check = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check1 = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', $idata['log_type'])->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check2 = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::LOGOUT)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check3 = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::BREAK)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check4 = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::RESTART)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check6 = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::LOGOUT)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->countAllResults();
                $check5 = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->countAllResults();
                $yesterdayLoginDate = $att_model->where('employee_id', $idata['employee_id'])->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->orderBy('id', 'desc')->limit(1)->find();
               

                if ($check5 == $check6) {
                    if ($check1 > 0) {
                        if (isset($log_in)) {

                            if ($check == $check2) {
                                $idata['attendance_date']=date('Y-m-d', strtotime($now));
                                $idata['log_type'] = LogTypeEnum::LOGIN;
                                $lt = "Time In";
                                $save = $att_model->save($idata);
                                if ($save) {
                                    $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                    return redirect()->to('Attendance');
                                }
                            } else {
                                $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                            }
                        } else if (isset($break) && ($check > $check2)) {


                                if ($check3 == $check4 ||  $check3 > $check4) {
                                $idata['attendance_date']=date('Y-m-d', strtotime($now));
                                    $idata['log_type'] = LogTypeEnum::BREAK;
                                    
                                    $lt = "Break";
                                    
                                    $save = $att_model->save($idata);
                                    if ($save) {
                                        $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                        return redirect()->to('Attendance');
                                        
                                    }
                                } else {
                                    $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                                }
                            } else {
                                if (isset($log_out)) {
                                    if ($check > $check2) {
                                        $idata['attendance_date']=date('Y-m-d', strtotime($now));

                                        $idata['log_type'] = LogTypeEnum::LOGOUT;
                                        $lt = "Time Out";
                                        $save = $att_model->save($idata);
                                        if ($save) {
                                            $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                            return redirect()->to('Attendance');
                                        }
                                    } else {
                                        $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                                    }
                                }
                                if (isset($restart)) {

                                    if ($check3 > $check4) {

                                        $idata['attendance_date']=date('Y-m-d', strtotime($now));

                                        $idata['log_type'] = LogTypeEnum::RESTART;

                                        $lt = "Restart";

                                        $save = $att_model->save($idata);
                                        if ($save) {
                                            $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                            return redirect()->to('Attendance');
                                        }
                                    } else {
                                        $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                                    }
                                } else {
                                    $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                                }
                            }
                    } else {
                        if (isset($log_in)) {
                            $idata['attendance_date']=date('Y-m-d', strtotime($now));

                            $idata['log_type'] = LogTypeEnum::LOGIN;
                            $lt = "Time In";
                            $save = $att_model->save($idata);
                            if ($save) {
                                $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                return redirect()->to('Attendance');
                            }
                        } else if ($check > 0 && $check > $check2) {
                            $idata['attendance_date']=date('Y-m-d', strtotime($now));

                            $save = $att_model->save($idata);
                            if ($save) {
                                $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                return redirect()->to('Attendance');
                               
                            }
                        } else {
                            $session->setFlashdata('error', "You have to Login For Today.");
                        }
                    }
                } elseif ($check5 > $check6) {
                    if (isset($log_out)) {

                        $idata['log_type'] = LogTypeEnum::LOGOUT;
                        $lt = "Time Out";
                         $logout_id = $Common->SaveRecordGetId($att_model, $idata);
                                  
                        if ($logout_id) {
                            if($check2 >=1){
                                $idata2['attendance_date']=date('Y-m-d', strtotime($now));
                                $Common->UpdateRecord($att_model, $idata2,$logout_id);
                           
                            $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                            return redirect()->to('Attendance');
                            }else{ 
                                $idata2['attendance_date']=!empty($yesterdayLoginDate)?$yesterdayLoginDate[0]['attendance_date']:'';
                                $Common->UpdateRecord($att_model, $idata2,$logout_id);
                              
                                $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Yesterday.");
                                return redirect()->to('Attendance');
                            }
                        }
                    }else
                    if (isset($log_in) && $check2 > $check) {
                        $idata['attendance_date']=date('Y-m-d', strtotime($now));
                        $idata['log_type'] = LogTypeEnum::LOGIN;
                        $lt = "Time In";
                        $save = $att_model->save($idata);
                        if ($save) {
                            $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                            return redirect()->to('Attendance');
                        }
                    }else if ($check > 0 && ($check2 == $check)) {
                       
                            if(isset($log_in)){
                        $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                          
                            }else{
                                $idata['attendance_date']=date('Y-m-d', strtotime($now));
                                $save = $att_model->save($idata);
                                if ($save) {
                                $session->setFlashdata('success', "You have sucessfully added your {$lt} Record Today.");
                                return redirect()->to('Attendance');
                            }
                        }
                    }else {
                        $session->setFlashdata('error', "You have to Logout For Yesterday.");
                    }
                }
            }
        }
        $data['breakCount'] = $check3;
        $data['RestartCount'] = $check4;
        $data['loginCount'] = $check;
        $data['logoutCount'] = $check2;

        $data['prevLoginCount'] = $check5;
        $data['prevLogoutCount'] = $check6;
        $data['EmpAttDet'] = $EmpAttDet;
        $data['status'] = $query[0]['log_type'];
        $data['page_title'] = "Attendace";
        return view('attendance', $data);
         }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function noteAttendanceAdd()
    {
        $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));
        $session = session();
         if ($session->has('username')) {
        $att_model = new Att_Model;
        $note_model = new NotesModel;
        $Common = new Common;
        $data = ['session' => $session, 'request' => $this->request];
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            if ($session->has('employe_id')) {
 helper('form');
                // $ipaddress =   file_get_contents('https://api.ipify.org');
                // echo   $ipaddress.'ghgh';
                // exit;
                // if ($ipaddress) {
                //     $ip = $ipaddress;
                // } else {
                $ip = '';
                // }
                // $idata['ip_address'] = $ip;
                // $idata['employee_id'] = $session->get('employe_id');
                if (isset($loginNote)) {
                    $lt = "Time In";
                } else if (isset($breakNote)) {
                    $lt = "Break";
                } else if (isset($restartNote)) {
                    $lt = "Restart";
                } else {
                    $idata['log_type'] = 3;
                    $lt = "Time Out";
                }
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select('emp.log_type');
                $builder->where('emp.employee_id', $session->get('employe_id'));
                $builder->orderby('emp.id', "desc");
                $builder->limit(1);
                $query = $builder->get()->getResultArray();
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select('emp.*');
                $builder->where('emp.employee_id', $session->get('employe_id'));

                $builder->where('date(`created_at`)', date('Y-m-d', strtotime($now)));
                $builder->orderby('emp.id', "asc");
                $EmpAttDet = $builder->get()->getResultArray();
                // $check = $att_model->where('employee_id',$idata['employee_id'])->where('log_type',$idata['log_type'])->where('date(`created_at`)',date('Y-m-d'))->countAllResults();
                $check = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check1 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', $this->request->getVar('log_type'))->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check2 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGOUT)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check3 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::BREAK)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check4 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::RESTART)->where('date(`created_at`)', date('Y-m-d', strtotime($now)))->countAllResults();
                $check6 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGOUT)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->countAllResults();
                $check5 = $att_model->where('employee_id', $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->countAllResults();
                $yesterdayLoginDate = $att_model->where('employee_id',  $session->get('employe_id'))->where('log_type', LogTypeEnum::LOGIN)->where('date(`created_at`)!="'.date('Y-m-d', strtotime($now)).'"')->orderBy('id', 'desc')->limit(1)->find();
                $event = $this->db->table("alloted as al");
                $event->select('eml.email_id');
                $event->join('once_email as eml', "find_in_set(eml.id,al.email_id)<>0", "left");
                $event->where('al.emp_id', $session->get('employe_id') );
                $fromMailId= $event->get()->getRow('email_id');
                 
               //  echo  $check1.''. $this->request->getVar('log_type').'-'.date('Y-m-d', strtotime($now));
                //  exit;
                $message = '<h3>Hello Admin, </h3><p>You have recieved a note from '.trim($session->get('username')," ").'.</p>';
                if ($check5 == $check6) {
                    if ($check1 > 0) {
                        if (isset($loginNote)) {

                            if ($check == $check2) {
                                $lt = "Time In";
                                $idata = [
                                    'log_type' => LogTypeEnum::LOGIN,
                                    'ip_address' => $ip,
                                    'attendance_date'=>date('Y-m-d', strtotime($now)),
                                    'employee_id' => $session->get('employe_id'),
                                ];
                                $att_model = new Att_Model;

                                $login_note_id = $Common->SaveRecordGetId($att_model, $idata);

                                if ($login_note_id) {
                                    $data2 = [
                                        'head' => 'Login Note',
                                        'notes' => $this->request->getVar('Addnotes'),
                                        'start' => $this->request->getVar('datetime'),
                                        'daily_id' => $login_note_id,
                                        'employee_id' => $session->get('employe_id'),
                                        'log_type' => LogTypeEnum::LOGIN,
                                        'status' => 'Pending',
                                    ];
                                }
                                $note_id = $Common->SaveRecordGetId($note_model, $data2);
                                if ($note_id) {
                                    $message2 = '<p><b>Login Time: </b>' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                    $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $login_note_id . '/' . $note_id . '">Approve</a>';
                                    $email = \Config\Services::email();
                                    $email->setTo(['hr@ansh.com']);
                                    if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Login Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Login Note'); 
                                        }
                                    $email->setSubject('Login Note');
                                    $email->setMessage($message . $message2 . $message3);

                                    if ($email->send()) {
                                        $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                        return redirect()->to('Attendance');
                                    }
                                }
                            } else {
                                $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                            }
                        } else if (isset($breakNote) && $check > $check2) {
                            if ($check3 == $check4 ||  $check3 > $check4) {

                                $lt = "Break";
                                $idata = [
                                    'log_type' => LogTypeEnum::BREAK,
                                    'ip_address' => $ip,                                   
                                    'attendance_date'=>date('Y-m-d', strtotime($now)),

                                    'employee_id' => $session->get('employe_id'),
                                ];
                                $att_model = new Att_Model;

                                $break_note_id = $Common->SaveRecordGetId($att_model, $idata);

                                if ($break_note_id) {
                                    $data2 = [
                                        'head' => 'Break Note',
                                        'notes' => $this->request->getVar('Addnotes'),
                                        'start' => $this->request->getVar('datetime'),
                                        'daily_id' => $break_note_id,
                                        'employee_id' => $session->get('employe_id'),
                                        'log_type' => LogTypeEnum::BREAK,
                                        'status' => 'Pending',
                                    ];
                                }
                                $note_id = $Common->SaveRecordGetId($note_model, $data2);
                                if ($note_id) {
                                    $message2 = '<p><b>Break Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                    $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $break_note_id . '/' . $note_id . '">Approve</a>';
                                    $email = \Config\Services::email();
                                    $email->setTo(['hr@ansh.com']);
                                    if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Break Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Break Note'); 
                                        }
                                    $email->setSubject('Break Note');
                                    $email->setMessage($message . $message2 . $message3);

                                    if ($email->send()) {
                                        $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                        return redirect()->to('Attendance');
                                    }
                                }
                            } else {
                                $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                            }
                        } else {
                            if (isset($logoutNote)) {
                                if ($check > $check2) {

                                    $lt = "Time Out";
                                    $idata = [
                                        'log_type' => LogTypeEnum::LOGOUT,
                                        'ip_address' => $ip,
                                        'attendance_date'=>date('Y-m-d', strtotime($now)),

                                        'employee_id' => $session->get('employe_id'),
                                    ];
                                    $att_model = new Att_Model;

                                    $logout_note_id = $Common->SaveRecordGetId($att_model, $idata);

                                    if ($logout_note_id) {
                                        $data2 = [
                                            'head' => 'Logout Note',
                                            'notes' => $this->request->getVar('Addnotes'),
                                            'start' => $this->request->getVar('datetime'),
                                            'daily_id' => $logout_note_id,
                                            'employee_id' => $session->get('employe_id'),
                                            'log_type' => LogTypeEnum::LOGOUT,
                                            'status' => 'Pending',
                                        ];
                                    }
                                    $note_id = $Common->SaveRecordGetId($note_model, $data2);
                                    if ($note_id) {
                                        $message2 = '<p><b>Logout Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                        $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $logout_note_id . '/' . $note_id . '">Approve</a>';
                                        $email = \Config\Services::email();
                                        $email->setTo(['hr@ansh.com']);
                                        if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Logout Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Logout Note'); 
                                        }
                                        $email->setSubject('Logout Note');
                                        $email->setMessage($message . $message2 . $message3);

                                        if ($email->send()) {
                                            $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                            return redirect()->to('Attendance');
                                        }
                                    }
                                } else {
                                    $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                                }
                            }
                            if (isset($restartNote)) {

                                if ($check3 > $check4) {
                                    $lt = "Restart";
                                    $idata = [
                                        'log_type' => LogTypeEnum::RESTART,
                                        'ip_address' => $ip,               
                                        'attendance_date'=>date('Y-m-d', strtotime($now)),

                                        'employee_id' => $session->get('employe_id'),
                                    ];
                                    $att_model = new Att_Model;

                                    $restart_note_id = $Common->SaveRecordGetId($att_model, $idata);
                                    //    print_r($login_note_id);
                                    //    exit;
                                    // $save = $att_model->save($idata);
                                    if ($restart_note_id) {
                                        $data2 = [
                                            'head' => 'Restart Note',
                                            'notes' => $this->request->getVar('Addnotes'),
                                            'start' => $this->request->getVar('datetime'),
                                            'daily_id' => $restart_note_id,
                                            'employee_id' => $session->get('employe_id'),
                                            'log_type' => LogTypeEnum::RESTART,
                                            'status' => 'Pending',
                                        ];
                                    }
                                    $note_id = $Common->SaveRecordGetId($note_model, $data2);
                                    if ($note_id) {
                                        $message2 = '<p><b>Restart Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                        $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $restart_note_id . '/' . $note_id . '">Approve</a>';
                                        $email = \Config\Services::email();
                                        $email->setTo(['hr@ansh.com']);
                                        if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Restart Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Restart Note'); 
                                        }
                                        $email->setSubject('Restart Note');
                                        $email->setMessage($message . $message2 . $message3);

                                        if ($email->send()) {
                                            $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                            return redirect()->to('Attendance');
                                        }
                                    }
                                } else {
                                    $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                                }
                            }
                        }
                    } else {
                        if (isset($loginNote)) {

                            $lt = "Time In";
                            $idata = [
                                'log_type' => LogTypeEnum::LOGIN,
                                'ip_address' => $ip,                              
                                'attendance_date'=>date('Y-m-d', strtotime($now)),
                                'employee_id' => $session->get('employe_id'),
                            ];
                            $att_model = new Att_Model;

                            $login_note_id = $Common->SaveRecordGetId($att_model, $idata);
                            // $save = $att_model->save($idata);
                            if ($login_note_id) {
                                $data2 = [
                                    'head' => 'Login Note',
                                    'notes' => $this->request->getVar('Addnotes'),
                                    'start' => $this->request->getVar('datetime'),
                                    'daily_id' => $login_note_id,
                                    'employee_id' => $session->get('employe_id'),
                                    'log_type' => LogTypeEnum::LOGIN,
                                    'status' => 'Pending',
                                ];
                            }
                            $note_id = $Common->SaveRecordGetId($note_model, $data2);
                            if ($note_id) {
                                $message2 = '<p><b>Login Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $login_note_id . '/' . $note_id . '">Approve</a>';
                                $email = \Config\Services::email();
                                $email->setTo(['hr@ansh.com']);
                                if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Login Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Login Note'); 
                                        }
                                $email->setSubject('Login Note');
                                $email->setMessage($message . $message2 . $message3);

                                if ($email->send()) {
                                    $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                    return redirect()->to('Attendance');
                                }
                            }
                        } else if ($check > 0  && $check > $check2) {
                            $idata = [
                                'log_type' => $this->request->getVar('log_type'),
                                'ip_address' => $ip,       
                                'attendance_date'=>date('Y-m-d', strtotime($now)),

                                'employee_id' => $session->get('employe_id'),
                            ];
                            $att_model = new Att_Model;

                            $login_note_id = $Common->SaveRecordGetId($att_model, $idata);
                            // $save = $att_model->save($idata);
                            if ($login_note_id) {

                                if ($this->request->getVar('log_type') == '2') {
                                    $log_type = 'Break';
                                } elseif ($this->request->getVar('log_type') == '3') {
                                    $log_type = 'Logout';
                                } else {
                                    $log_type = 'Restart';
                                }
                                $data2 = [
                                    'head' => $log_type . ' Note',
                                    'notes' => $this->request->getVar('Addnotes'),
                                    'start' => $this->request->getVar('datetime'),
                                    'daily_id' => $login_note_id,
                                    'employee_id' => $session->get('employe_id'),
                                    'log_type' => $this->request->getVar('log_type'),
                                    'status' => 'Pending',
                                ];
                            }
                            $note_id = $Common->SaveRecordGetId($note_model, $data2);
                            if ($note_id) {
                                $message2 = '<p><b>'.$log_type . ' Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                $message3 = '<a class="btn btn-primary mb-2" role="button" href="' . base_url('Attendance/approval') . '/' . $login_note_id . '/' . $note_id . '">Approve</a>';
                                $email = \Config\Services::email();
                                $email->setTo(['hr@ansh.com']);
                                if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' '. $lt . ' Note');
                                        }else{
                                            
                                        $email->setFrom('admin@ansh.com', $lt . ' Note');
                                        }
                                $email->setSubject($lt . ' Note');
                                $email->setMessage($message . $message2 . $message3);

                                if ($email->send()) {
                                    $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                    return redirect()->to('Attendance');
                                }
                            }
                        } else {
                            $session->setFlashdata('error', "You have to Login For Today.");
                        }
                    }
                } elseif ($check5 > $check6) {
                    if (isset($logoutNote)) {

                        $lt = "Time Out";
                        $idata = [
                            'log_type' => LogTypeEnum::LOGOUT,
                            'ip_address' => $ip,
                            'employee_id' => $session->get('employe_id'),
                        ];
                        $att_model = new Att_Model;

                        $logout_note_id = $Common->SaveRecordGetId($att_model, $idata);

                        if ($logout_note_id) {
                            $data2 = [
                                'head' => 'Logout Note',
                                'notes' => $this->request->getVar('Addnotes'),
                                'start' => $this->request->getVar('datetime'),
                                'daily_id' => $logout_note_id,
                                'employee_id' => $session->get('employe_id'),
                                'log_type' => LogTypeEnum::LOGOUT,
                                'status' => 'Pending',
                            ];

                            $note_id = $Common->SaveRecordGetId($note_model, $data2);
                        }
                        if ($note_id) {
                            $message2 = '<p><b>Logout Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                            $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $logout_note_id . '/' . $note_id . '">Approve</a>';
                            $email = \Config\Services::email();
                            $email->setTo(['hr@ansh.com']);
                              if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Logout Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Logout Note'); 
                                        }
                            $email->setSubject('Logout Note');
                            $email->setMessage($message . $message2 . $message3);

                            if ($email->send()) {
                                if($check2>=1){
                                      $idata2=[
                                        'attendance_date'=>date('Y-m-d', strtotime($now)),
                                    ];
                                $Common->UpdateRecord($att_model, $idata2,$logout_note_id);
                               
                                $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                return redirect()->to('Attendance');
                                }else{
                                     $idata2=[
                                        'attendance_date'=>!empty($yesterdayLoginDate)?$yesterdayLoginDate[0]['attendance_date']:'',
                                    ];      
                                $Common->UpdateRecord($att_model, $idata2,$logout_note_id);
                               
                                    $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Yesterday.");
                                return redirect()->to('Attendance');
                                }
                            }
                        }
                    }else
                    if (isset($loginNote) && $check2 > $check) {

                        $lt = "Time In";
                        $idata = [
                            'log_type' => LogTypeEnum::LOGIN,
                            'ip_address' => $ip,
                            'attendance_date'=>date('Y-m-d', strtotime($now)),
                            'employee_id' => $session->get('employe_id'),
                        ];
                        $att_model = new Att_Model;

                        $login_note_id = $Common->SaveRecordGetId($att_model, $idata);
                        // $save = $att_model->save($idata);
                        if ($login_note_id) {
                            $data2 = [
                                'head' => 'Login Note',
                                'notes' => $this->request->getVar('Addnotes'),
                                'start' => $this->request->getVar('datetime'),
                                'daily_id' => $login_note_id,
                                'employee_id' => $session->get('employe_id'),
                                'log_type' => LogTypeEnum::LOGIN,
                                'status' => 'Pending',
                            ];
                        }
                        $note_id = $Common->SaveRecordGetId($note_model, $data2);
                        if ($note_id) {
                            $message2 = '<p><b>Login Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                            $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') . '/' . $login_note_id . '/' . $note_id . '">Approve</a>';
                            $email = \Config\Services::email();
                            $email->setTo(['hr@ansh.com']);
                              if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' Login Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', 'Login Note'); 
                                        }
                            $email->setSubject('Login Note');
                            $email->setMessage($message . $message2 . $message3);

                            if ($email->send()) {
                                $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                return redirect()->to('Attendance');
                            }
                        }
                    }else if ($check > 0 && ($check2 == $check)) {
                       
                            if(isset($loginNote)){
                        $session->setFlashdata('error', "You have already a {$lt} Record Today.");
                          
                            }else{
                                $idata = [
                                    'log_type' => $this->request->getVar('log_type'),
                                    'ip_address' => $ip,
                                    'attendance_date'=>date('Y-m-d', strtotime($now)),
                                    'employee_id' => $session->get('employe_id'),
                                ];
                                $att_model = new Att_Model;
    
                                $login_note_id = $Common->SaveRecordGetId($att_model, $idata);
                                // $save = $att_model->save($idata);
                                if ($login_note_id) {
    
                                    if ($this->request->getVar('log_type') == '2') {
                                        $log_type = 'Break';
                                    } elseif ($this->request->getVar('log_type') == '3') {
                                        $log_type = 'Logout';
                                    } else {
                                        $log_type = 'Restart';
                                    }
                                    $data2 = [
                                        'head' => $log_type . ' Note',
                                        'notes' => $this->request->getVar('Addnotes'),
                                        'start' => $this->request->getVar('datetime'),
                                        'daily_id' => $login_note_id,
                                        'employee_id' => $session->get('employe_id'),
                                        'log_type' => $this->request->getVar('log_type'),
                                        'status' => 'Pending',
                                    ];
                                }
                                $note_id = $Common->SaveRecordGetId($note_model, $data2);
                                if ($note_id) {
                                    $message2 = '<p><b>'.$log_type . ' Time:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('datetime'))) . '</p><p><b>Note:</b> ' . $this->request->getVar('Addnotes') . '</p>';
                                    $message3 = '<a class="btn btn-primary mb-2" role="button" href="' . base_url('Attendance/approval') . '/' . $login_note_id . '/' . $note_id . '">Approve</a>';
                                    $email = \Config\Services::email();
                                    $email->setTo(['hr@ansh.com']);
                                      if($fromMailId!=''){
                                        $email->setFrom($fromMailId,$session->get('username').' '.$lt.' Note');
                                        }else{
                                            $email->setFrom('admin@ansh.com', $lt . ' Note'); 
                                        }
                                    $email->setSubject($lt . ' Note');
                                    $email->setMessage($message . $message2 . $message3);
    
                                    if ($email->send()) {
                                        $session->setFlashdata('success', "You have sucessfully added your {$lt} Note Today.");
                                        return redirect()->to('Attendance');
                                    }
                                }
                            }
                        }
                    } else {
                        $session->setFlashdata('error', "You have to Logout For Yesterday.");
                    }
                
            }
        }


        $data['breakCount'] = $check3;
        $data['RestartCount'] = $check4;
        $data['loginCount'] = $check;
        $data['logoutCount'] = $check2;

        $data['prevLoginCount'] = $check5;
        $data['prevLogoutCount'] = $check6;
        $data['EmpAttDet'] = $EmpAttDet;
        $data['status'] = $query[0]['log_type'];
        $data['page_title'] = "Attendace";
        
        //Report section starts (shruti)
            $username =$session->get('username');
           $model1 = new TempReportModel();
           $data['template'] = $model1->where('updated_by',$username)->where('status','Active')->findAll();
           
            $share_query = $this->db->table("share_report as sr");
            $share_query->select('sr.*,emp.name,emp.id');
            $share_query->join('employee as emp', 'sr.emp_id = emp.id', "left");
            $share_query->where('sr.shared_id',$username);
            $share_query->where('sr.status','Active');
            $data['share_template'] = $share_query->get()->getResultArray();
            
            $my_share = $this->db->table("share_report as sr");
            $my_share->select('sr.*,emp.name,emp.id');
            $my_share->join('employee as emp', 'sr.shared_id = emp.id', "left");
            $my_share->where('sr.emp_id',$username);
            $my_share->where('sr.status','Active');
            $data['my_share'] = $my_share->get()->getResultArray();
            //Report section ends (shruti) 
        return view('attendance', $data);
         }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function approval($daily_id,$notes_id){
        // echo $notes_id;
        // echo $daily_id;
       
         helper('form');
        $data=[
            'status'=>'Approved',
        ];
        $model1 = new NotesModel();
        $res=$model1->update($notes_id,$data);
        // echo $res; 
        $query = $model1->where('id',$notes_id)->first();
        // print_r($query); 
        $now = $query['start'];
        // echo $now;
        $data2 =[
            'created_at'=>$now,
        ];
        $model = new Att_Model();
        $res1=$model->update($daily_id,$data2);
        // echo $res1; 
        if($res){
         return redirect()->to(base_url('Attendance/view_approval'))->with('status_icon', 'success')
                    ->with('status', 'Approved Successfully');   
        }
        


    }

 public function leave_approval($notes_id){
        // echo $notes_id;
        // echo $daily_id;
        helper('form');
        
        $data=[
            'status'=>'Approved',
        ];
        $model1 = new EmpLeaveModel();
        $res=$model1->update($notes_id,$data);
        // echo $res1; 
        if($res){
         return redirect()->to(base_url('Attendance/view_approval'))->with('status_icon', 'success')
                    ->with('status', 'Approved Successfully');   
        }
        


    }

    public function view_approval(){
        $session = session();
        if($session->get('login_type')=='Admin'){
       $model = new Att_Model();
       $model1 = new NotesModel();
       $model2 = new EmployeeModel();
        helper('form');
        $event = $this->db->table("notes as ns");
        $event->select('ns.*,ns.start,ns.employee_id,emp.name,emp.id,emp.emp_short_code,CONCAT(emp.name, " ", ns.head) AS title,ns.id AS notes_id');
        $event->join('employee as emp', 'ns.employee_id = emp.id', "left");
        $event->where('ns.log_type in (1,2,3,4)' );
        $event->where('ns.status','Pending');
        $data['approval'] = $event->get()->getResultArray();
        $event = $this->db->table("emp_leave as ns");
        $event->select('ns.*,ns.start,ns.end,ns.employee_id,emp.name,emp.id,emp.emp_short_code,ns.id AS notes_id');
        $event->join('employee as emp', 'ns.employee_id = emp.id', "left");
        $event->where('ns.status','Pending');
        $data['leave_approval'] = $event->get()->getResultArray();
        // echo "<pre>";
        // print_r($data);

        echo view('approval',$data);
        }else{
            $session->destroy();
            return redirect()->to(base_url('/'))->with('status_icon', 'error')
                    ->with('status', 'Not Permitted');
        }

    }

    public function addLeave()
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');
            $data = ['session' => $session, 'request' => $this->request];
            //Report section starts (shruti) 
            $username =$session->get('username');
           
           $model1 = new TempReportModel();
           $data['template'] = $model1->where('updated_by',$username)->where('status','Active')->findAll();
           $share_query = $this->db->table("share_report as sr");
            $share_query->select('sr.*,emp.name,emp.id');
            $share_query->join('employee as emp', 'sr.emp_id = emp.id', "left");
            $share_query->where('sr.shared_id',$username);
            $share_query->where('sr.status','Active');
            $data['share_template'] = $share_query->get()->getResultArray();
            
            $my_share = $this->db->table("share_report as sr");
            $my_share->select('sr.*,emp.name,emp.id');
            $my_share->join('employee as emp', 'sr.shared_id = emp.id', "left");
            $my_share->where('sr.emp_id',$username);
            $my_share->where('sr.status','Active');
            $data['my_share'] = $my_share->get()->getResultArray();
            //Report section ends (shruti) 
            $emp_leave_model = new EmpLeaveModel;
            $note_model = new NotesModel;
            $Common = new Common;
            $rules = [
                'email' => [
                    'rules' => 'valid_emails',
                    'errors' => [
                        'valid_emails' => 'please provide valid emails'
                    ],
                ],
                 'from_datetime' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
                 'to_datetime' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
                 'Addleavenotes' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Required'
                    ],
                ],
            ];
            $event = $this->db->table("alloted as al");
        $event->select('eml.email_id');
        $event->join('once_email as eml', "find_in_set(eml.id,al.email_id)<>0", "left");
        $event->where('al.emp_id', $session->get('employe_id') );
        $fromMailId= $event->get()->getRow('email_id');
             
            if ($this->request->getMethod() == 'post') {
                if ($this->validate($rules)) {
                     $startDate = strtotime($this->request->getVar('from_datetime'));
                    $endDate = strtotime($this->request->getVar('to_datetime'));
                  
                    if ($endDate >= $startDate){
                   
                    $data = [
                        'leave_reason' => $this->request->getVar('Addleavenotes'),
                        'start' => $this->request->getVar('from_datetime'),
                        'end' => $this->request->getVar('to_datetime'),
                        'employee_id' => $session->get('employe_id'),
                        'status' => 'Pending',
                        'updated_by'=> $session->get('username'),
                        'email_to'=>$this->request->getVar('email'),
                    ];
           if ($this->request->getVar('save_id')==''){
                $leave_id = $Common->SaveRecordGetId($emp_leave_model, $data);
            }else{
                $leave_id=$this->request->getVar('save_id');
                $Common->UpdateRecord($emp_leave_model, $data, $this->request->getVar('save_id'));
            }
                
                //     $data2 = [
                //         'head' => 'Leave',
                //         'notes' => $this->request->getVar('Addleavenotes'),
                //         'start' => $this->request->getVar('from_datetime'),
                //         'end' => $this->request->getVar('to_datetime'),
                //         'employee_id' => $session->get('employe_id'),
                //         'leave_id'=>$leave_id ,
                //         'log_type' =>  LogTypeEnum::LEAVE,
                //         'status' => 'Pending',
                //     ];
                
                // $note_id = $Common->SaveRecordGetId($note_model, $data2);
               
                $levDet = $emp_leave_model->where('id', $leave_id)->first();
                    if ($this->request->getVar('email') != '') {

                       $message = '<h3 style="color:black;">Hello Admin, </h3><p style="color:black;">Requesting you to approve my leave for the below dates:</p>';
                        $message2 = '<p ><b>Start Date:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('from_datetime'))) . '<br><b>End Date:</b> ' . date('d-m-Y, h:iA', strtotime($this->request->getVar('to_datetime'))) . '</p><p><b>Leave Note From '.$session->get('username').':</b> ' . $this->request->getVar('Addleavenotes') . '</p>';
                        // $message3 = '<a class="btn btn-primary mb-2" role="button"  href="' . base_url('Attendance/approval') .'/' . $note_id . '">Approve</a>';
                       
                        $email = \Config\Services::email();
                        $email->setTo($this->request->getVar('email'));
                        if($fromMailId!=''){
                        $email->setFrom($fromMailId,$session->get('username'));
                        }else{
                            $email->setFrom('admin@ansh.com',$session->get('username')); 
                        }
                        if($levDet==0){
                        $email->setSubject('Apply Leave');
                        }else{
                            $email->setSubject('Leave'); 
                        }
                        $email->setMessage($message.$message2);
    
                        if ($email->send()) {
                            return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                            ->with('status', 'Mail Sent Successfully');
                   
                        }else{
                            // $email->printDebugger();
                              print_r( $email->printDebugger());
                            exit;
                        }
                    }
                }else {
                   return redirect()->to(base_url('Attendance'))->with('status_icon', 'error')
                    ->with('status', 'End Date should be greater than Start Date.');
        
                }
                    
                } else {
                    $data['validation'] = $this->validator;
                    echo view('attendance', $data);
                    return redirect()->to(base_url('Attendance'))->with('status_icon', 'error')
                            ->with('status', 'All fields are mandatory.');
                    
                    //   return redirect()->to(base_url('Attendance'))->with('status_icon', 'error')
                    //         ->with('status', 'Please Provide Proper Email');
                  
                }
               
            }
        }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function fetch_emp_leave($id)
    {
      $session = session();
        if ($session->has('username')) {
             helper('form');
            $data = ['session' => $session, 'request' => $this->request];
    $builder = $this->db->table("emp_leave as lv");
    $builder->select('lv.*');
    $builder->where('lv.id', $id);
    $result = $builder->get()->getResultArray();

        if (!empty($result)) {
            return json_encode($result);
        } else {
            return "No data Available";
        }
        }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function saveLeave()
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');
            $emp_leave_model = new EmpLeaveModel;
            $note_model = new NotesModel;
            $Common = new Common;
            $data = ['session' => $session, 'request' => $this->request];
            if ($this->request->getMethod() == 'post') {
                   $startDate = strtotime($this->request->getVar('from_datetime'));
                    $endDate = strtotime($this->request->getVar('to_datetime'));
                  
                    if ($endDate >= $startDate){
                    $data = [
                        'leave_reason' => $this->request->getVar('Addleavenotes'),
                        'start' => $this->request->getVar('from_datetime'),
                        'end' => $this->request->getVar('to_datetime'),
                        'employee_id' => $session->get('employe_id'),
                        'status' => 'Plan',
                        'updated_by'=> $session->get('username'),
                        'email_to'=>$this->request->getVar('email'),
                    ];
                    
                    if ($this->request->getVar('save_id')==''){
                        $leave_id = $Common->SaveRecordGetId($emp_leave_model, $data);
                    }else{
                        $this->addLeave();
                    }
                    }else{
                         return redirect()->to(base_url('Attendance'))->with('status_icon', 'error')
                    ->with('status', 'End Date should be greater than Start Date.');
                    }
            
                
            }
            return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
            ->with('status', 'Leave Save Successfully');
   
        }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function deleteLeave()
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');
            $id = $this->request->getVar('del_db_id');
             $emp_leave_model = new EmpLeaveModel;
            $note_model = new NotesModel;
            $Common = new Common;
            $data = ['session' => $session, 'request' => $this->request];
            if ($this->request->getMethod() == 'post') {
               
                $levDet = $emp_leave_model->where('id', $id)->first();
                    if ($levDet['status']=='Plan'){
                       
                        $emp_leave_model->where('id', $id)->delete();
                       
                    }else{
                       
                        $this->cancelLeave($id);
                    }
            }
            return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                        ->with('status', 'Deleted Successfully');
   
        }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function cancelLeave($id)
    {
        $session = session();
        if ($session->has('username')) {
            helper('form');
            $emp_leave_model = new EmpLeaveModel;
            $note_model = new NotesModel;
            $Common = new Common;
           
            $event = $this->db->table("alloted as al");
            $event->select('eml.email_id');
            $event->join('once_email as eml', "find_in_set(eml.id,al.email_id)<>0", "left");
            $event->where('al.emp_id', $session->get('employe_id') );
            $fromMailId= $event->get()->getRow('email_id');
               
                $levDet = $emp_leave_model->where('id', $id)->first();
                 $message = '<h3 style="color:black;">Hello Admin, </h3><p style="color:black;">Requesting you to approve my leave for the below dates:</p>';
                        $message2 = '<p ><b>Start Date:</b> ' . date('d-m-Y, h:iA', strtotime($levDet['start'])) . '<br><b>End Date:</b> ' . date('d-m-Y, h:iA', strtotime($levDet['end'])) . '</p><p><b>Leave Note From '.$session->get('username').':</b> ' . $levDet['leave_reason'] . '</p>';
                       
                        $email = \Config\Services::email();
                        $email->setTo($levDet['email_to']);
                        if($fromMailId!=''){
                            $email->setFrom($fromMailId,$session->get('username'));
                            }else{
                                $email->setFrom('admin@ansh.com',$session->get('username')); 
                            }
                        $email->setSubject('Cancel Leave');
                        $email->setMessage($message.$message2);
    
                        if ($email->send()) {
                          
                            $Common->DeleteRecord($emp_leave_model, $id);
                           // $notDet = $note_model->where('leave_id', $id)->first();
                            
                           // $Common->DeleteRecord($note_model,$notDet['id']);
                            return redirect()->to(base_url('Attendance'))->with('status_icon', 'success')
                            ->with('status', 'Mail Sent Successfully');
                   
                        }
                    
                
               
            
        }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
   
    }
    public function fetch_emp_detail_for_approval(){
        $session = session();
        if ($session->has("username")) {
            helper("form");
            $model= new NotesModel;
            $note_id = $this->request->getVar("note_id");
            $result=$model->where('id',$note_id)->find();
            if (!empty($result)) {
                // print_r(json_encode($result));
                return json_encode($result);
            }  
        }else{
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }
    public function updateNote($type){
        $session = session();
        if ($session->has("username")) {
            helper("form");
            $note_id = $this->request->getVar("save_id");
            $daily_id = $this->request->getVar("daily_id");
            if($type=='Note'){

                $data=[
                    'start'=>$this->request->getVar("from_datetime"),
                    'status'=>'Pending',
                ];
                $model1 = new NotesModel();
                $res=$model1->update($note_id,$data);
                // echo $res; 
              //  $query = $model1->where('id',$note_id)->first();
                // print_r($query); 
              //  $now = $query['start'];
                // echo $now;
              //  $data2 =[
               //     'created_at'=>$now,
           //     ];
            //    $model = new Att_Model();
             //   $res1=$model->update($daily_id,$data2);
                // echo $res1; 
                if($res){
                 return redirect()->to(base_url('Attendance/view_approval'))->with('status_icon', 'success')
                            ->with('status', 'Notes Edited Successfully');   
                }

            }
           
        }else{
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }
    public function DeleteNote($type){
        $session = session();
        if ($session->has("username")) {
            helper("form");
            $note_id = $this->request->getVar("save_id");
            $daily_id = $this->request->getVar("daily_id");
            if($type=='Note'){
                $model1 = new NotesModel();
                $model1->delete($note_id);
                
                $model = new Att_Model();
                $model->delete($daily_id);
                
                 return redirect()->to(base_url('Attendance/view_approval'))->with('status_icon', 'success')
                            ->with('status', 'Delete Successfully');   
                

            }
           
        }else{
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }

    public function get_detail(){
        $session = session();
        if ($session->has("username")) {
            helper("form");
            $data = [
                'emp.log_type' => $this->request->getVar("type"),
                'emp.employee_id' => $this->request->getVar("username"),
                'emp.attendance_date' => $this->request->getVar("date"),
                
                ];
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select("emp.*,stf.name");
                $builder->join(
                    "employee as stf",
                    "stf.id = emp.employee_id",
                    "left"
                );
                $builder->where($data);
                $EmpAttDet = $builder->get()->getResultArray();
                if(!empty($EmpAttDet)){
                    return json_encode($EmpAttDet);
                }
           
        }else{
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }
    public function UpdateAttendance()
    {
     
     $session = session();
     if ($session->has('username')) {
   
         $model = new Att_Model();
         $count = count($this->request->getVar('detail'));
         for ($i=0; $i < $count ; $i++) { 
    
              $data=[
                    'attendance_date'=> $this->request->getVar('attend_detail')[$i],
                    'created_at'=> $this->request->getVar('detail')[$i],
                    ];
        $id=$this->request->getVar('id_edit')[$i];
   
         $res = $model->update($id,$data); 
           }

             return redirect()->to(base_url('Attendance/view_approval'))->with('status_icon', 'success')
                        ->with('status', 'Attendance Updated Successfully');
            } else {
                $session->setFlashdata('warning', 'Session Expired!Please Login');
                $session->destroy();
                return redirect('')->to('/');
            }
     
    }
    public function DeleteAttendance(){
        $session = session();
        if ($session->has("username")) {
            helper("form");
            $attendance_id = $this->request->getVar("attend_id");
                
                $model = new Att_Model();
                $model->delete($attendance_id);
                
                 return redirect()->to(base_url('Attendance/view_approval'))->with('status_icon', 'success')
                            ->with('status', 'Delete Successfully');   
                

            
           
        }else{
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }
    
}
