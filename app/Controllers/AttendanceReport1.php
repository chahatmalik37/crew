<?php

namespace App\Controllers;

use system\I18n\Time;
use App\Models\EmployeeModel;
use App\Models\EventsModel;
use App\Models\Att_Model;
use App\Models\UserModel;
use App\Models\AttendanceModel;
use App\Models\NotesModel;
use App\Libraries\Common;
use App\Libraries\LogTypeEnum;
use App\Controllers\BaseController;
// use Dompdf\Dompdf;

class AttendanceReport extends BaseController
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
        if ($session->get('login_type')=='Admin') {
            
            $data = ['session' => $session, 'request' => $this->request];
            echo view('attendance_report', $data);
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }

    public function search_report()
    {
        
        $from = $this->request->getVar('from_date');
        $to = $this->request->getVar('to_date');
        $month_new = array();
        // $data_show = array();

        $start    = new \DateTime($from);
        $end      = new \DateTime($to);
        $interval = new \DateInterval('P1D');
        $end->add($interval);
        $period = new \DatePeriod($start, $interval, $end);
  
        foreach ($period as $dt) {
            array_push($month_new, $dt->format("Y-m-d"));
        }
       
        // Array for month name
        $monthNames = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        $query['month'] = $month_new;
        if (empty($from) && empty($to)) {
            $my_monthname=array();
            $now = (new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE"));
            $prevDate=date('Y-m-d', strtotime('-1 day', strtotime($now)));
            $nowDate=date('Y-m-d',strtotime($now));
            
            array_push($my_monthname,$prevDate,$nowDate);
            $query['month'] = $my_monthname;
            $builder = $this->db->table("emp_daily_attendance as av");
          $builder->select('av.created_at,av.attendance_date,av.log_type,av.employee_id,emp.name,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted');
          $builder->join('employee as emp', 'emp.id = av.employee_id', "left");
          $builder->join('attendance as at', 'av.employee_id = at.employee_id', "left");
          $builder->where('date(av.attendance_date) BETWEEN "' . date('Y-m-d', strtotime($prevDate)) . '"   and "' . date('Y-m-d', strtotime($nowDate)) . '" ');
          $builder->where('av.log_type in(1,2,4,3)');
          $builder->orderby('av.id', 'asc');
          $query['employee'] = $builder->get()->getResultArray();

          $builder = $this->db->table("emp_leave as el");
          $builder->select('el.start,el.end,el.leave_reason,el.status,emp.name,el.employee_id,TIMEDIFF(el.end,el.start) as dateDiff,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted');
          $builder->join('employee as emp', 'emp.id = el.employee_id', "left");
          $builder->join('attendance as at', 'emp.id = at.employee_id', "left"); 
          $builder->where('date(el.start) BETWEEN "' . date('Y-m-d', strtotime($prevDate)) . '"   and "' . date('Y-m-d', strtotime($nowDate)) . '" ');
          $builder->where('el.status="Approved"');
          $builder->where('emp.status="Active"');
          $builder->orderby('el.id','asc');
          $query['employee2'] = $builder->get()->getResultArray();
          $datewise_employee_leave = array();
          $month_new=array();
          if($query['employee2']){
          foreach ($query['employee2'] as $emp_leave) {
            $start1   = new \DateTime($emp_leave['start']);
            $end1      = new \DateTime($emp_leave['end']);
           
        $interval1 = new \DateInterval('P1D');
        $period2 = new \DatePeriod($start1, $interval1, $end1);
  
        foreach ($period2 as $dt) {
            array_push($month_new, $dt->format("Y-m-d"));
        }
              $employee_id = $emp_leave['name'];
              foreach($month_new  as $date){
                  if($date>=date('Y-m-d',strtotime($emp_leave['start']))&&$date<=date('Y-m-d',strtotime($emp_leave['end']))){
              if (!isset($datewise_employee_leave[$date])) {
                  $datewise_employee_leave[$date] = array();
              }
              if (!isset($datewise_employee_leave[$date][$employee_id])) {
                  $datewise_employee_leave[$date][$employee_id] = array();
              }
              $datewise_employee_leave[$date][$employee_id][] = $emp_leave;
          }
             }
        }
          
        }
        $query['datewise_employee_leave']=$datewise_employee_leave;
        //  $query['datawise_employee']=array_merge($query['employee'],$datewise_employee_leave);
         $query['from'] = date('d-m-Y',strtotime($prevDate));
        $query['to'] = date('d-m-Y',strtotime($nowDate));
        //  echo "<pre>";
        //  print_r($query['datawise_employee']);
        //  exit;
         
            echo view('attendance_report', $query);
            

        } else {
            $builder = $this->db->table("emp_daily_attendance as av");
          $builder->select('av.created_at,av.attendance_date,av.log_type,av.employee_id,emp.name,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted');
          $builder->join('employee as emp', 'emp.id = av.employee_id', "left");
          $builder->join('attendance as at', 'av.employee_id = at.employee_id', "left");
           
          $builder->where('date(av.attendance_date) BETWEEN "' . date('Y-m-d', strtotime($from)) . '"   and "' . date('Y-m-d', strtotime($to)) . '" ');
          $builder->where('av.log_type in(1,2,4,3)');
          $builder->orderby('av.id', 'asc');
          $query['employee'] = $builder->get()->getResultArray();

           $builder = $this->db->table("emp_leave as el");
          $builder->select('el.start,el.end,el.leave_reason,el.status,emp.name,el.employee_id,TIMEDIFF(el.end,el.start) as dateDiff,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted');
          $builder->join('employee as emp', 'emp.id = el.employee_id', "right");
          $builder->join('attendance as at', 'emp.id = at.employee_id', "left"); 
          $builder->where('date(el.start) BETWEEN "' . date('Y-m-d', strtotime($from)) . '"   and "' . date('Y-m-d', strtotime($to)) . '" ');
          $builder->where('el.status="Approved"');
          $builder->where('emp.status="Active"');
          $builder->orderby('el.id','asc');
          $query['employee2'] = $builder->get()->getResultArray();
          $datewise_employee_leave = array();
          $month_new=array();
          if($query['employee2']){
          foreach ($query['employee2'] as $emp_leave) {
            $start1   = new \DateTime($emp_leave['start']);
            $end1      = new \DateTime($emp_leave['end']);
           
        $interval1 = new \DateInterval('P1D');
        $period2 = new \DatePeriod($start1, $interval1, $end1);
  
        foreach ($period2 as $dt) {
            array_push($month_new, $dt->format("Y-m-d"));
        }
              $employee_id = $emp_leave['name'];
              foreach($month_new  as $date){
                  if($date>=date('Y-m-d',strtotime($emp_leave['start'])) && $date<=date('Y-m-d',strtotime($emp_leave['end']))){
           
              if (!isset($datewise_employee_leave[$date])) {
                  $datewise_employee_leave[$date] = array();
              }
              if (!isset($datewise_employee_leave[$date][$employee_id])) {
                  $datewise_employee_leave[$date][$employee_id] = array();
              }
              $datewise_employee_leave[$date][$employee_id][] = $emp_leave;
          }
              }
        }
          
        }
        $query['datewise_employee_leave']=$datewise_employee_leave;
          $query['from'] = date('d-m-Y',strtotime($from));
        $query['to'] = date('d-m-Y',strtotime($to));
        // echo "<pre>";
        // print_r($query);
        // exit;
         
            echo view('attendance_report', $query);
            

        }

    }
    public function fetch_emp_detail_with_datewise(){
        $session = session();
        if ($session->has('username')) {
            helper('form');
            $from = $this->request->getVar('from');
            $to = $this->request->getVar('to');
            $builder = $this->db->table("emp_daily_attendance as emp");
            $builder->select('emp.*,stf.name');
            $builder->join('employee as stf', 'stf.id = emp.employee_id', "left");
            $builder->where('emp.employee_id',$this->request->getVar('emp_id'));
            $builder->where('emp.attendance_date BETWEEN "' .$from . '"   and "' . $to . '" ');
            $builder->orderby('emp.id', "asc");
            $EmpAttDet1 = $builder->get()->getResultArray(); 
          $builder = $this->db->table("emp_leave as el");
          $builder->select('el.start,el.end,el.leave_reason,el.status,emp.name,el.employee_id');
          $builder->join('employee as emp', 'emp.id = el.employee_id', "right");
          $builder->where('el.employee_id',$this->request->getVar('emp_id'));
          $builder->where('date(el.start) BETWEEN "' . $from . '"   and "' .$to . '" ');
          $builder->where('el.status="Approved"');
          $builder->where('emp.status="Active"');
          $builder->orderby('el.id','desc');
          $EmpAttDet2 = $builder->get()->getResultArray();
          
           if(!empty($EmpAttDet1) &&!empty($EmpAttDet2) ){
                    $EmpAttDet=array_merge_recursive($EmpAttDet1,$EmpAttDet2);
                }elseif(!empty($EmpAttDet1) ){
                    $EmpAttDet=$EmpAttDet1;
                   }
                   elseif(!empty($EmpAttDet2) ){
                    $EmpAttDet=$EmpAttDet2;
                   }
                  
       
        if (!empty($EmpAttDet)) {
            // print_r(json_encode($result));
            return json_encode($EmpAttDet);
        } 
        }else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    }
    public function edit()
    {
    }

    public function update()
    {
    }
    public function delete()
    {
    }
    public function sendmail()
    {
    }
}
