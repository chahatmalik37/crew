<?php
namespace App\Controllers;
use App\Models\DashboardModel;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    private $db;
	public function __construct()
    {
        $this->db = db_connect();
    }

	public function index()
    {
         $session = session();
        if ($session->get('username') == 'Admin') {
            // print_r($_SESSION);
    	echo view('dashboard');
        } else {
            $session->setFlashdata('warning', 'Session Expired!Please Login');
            $session->destroy();
            return redirect('')->to('/');
        }
    
	}
	
	public function loadData()
	{
		// echo "hiii";
		// $event = new DashboardModel();
		// on page load this ajax code block will be run
		$event = $this->db->table("events as ev");
		$event->select('ev.id,ev.start,ev.end,ev.employee_id,emp.name,emp.id,CONCAT(emp.name, " ", ev.head) AS title');
		$event->join('employee as emp', 'ev.employee_id = emp.id', "left");
		// // $data = $event->where([
		// 	'start >=' => $this->request->getVar('start'),
		// 	'end <='=> $this->request->getVar('end')
		// ])->findAll();

		$data = $event->get()->getResultArray();
		foreach($data as $res){
			$date1=date('d-F-Y', strtotime($res['start']));
			$date=strtotime($res['start']);
			$time  = $date;
			$day   = date('d',$time);
			$month = date('m',$time);
			$year  = date('Y',$time);
			$curryear = date('Y');

			$data1[] = array(
			    'title'   => $res["title"], 
			    'start'   => $curryear . "-" . $month . "-" . $day,
			    'bday'   => $date1
			);
		}
		// $test ="hii";
		return json_encode($data1);
	}
	
	public function loadNotes()
	{
		$event = $this->db->table("notes as ns");
		$event->select('ns.id,ns.start,ns.employee_id,emp.name,emp.id,CONCAT(emp.name, " ", ns.head) AS title');
		$event->join('employee as emp', 'ns.employee_id = emp.id', "left");
		$event->where('ns.log_type in (1,2,3,4)');
		$event->where('ns.status','Pending');
		$data = $event->get()->getResultArray();
		// $test ="hii";
		return json_encode($data);
	}
	
	public function loadLeave()
	{
		$event = $this->db->table("emp_leave as el");
		$event->select('el.id,el.start,el.end,el.employee_id,emp.name,emp.id,CONCAT(emp.name, " ", "on Leave") AS title');
		$event->join('employee as emp', 'el.employee_id = emp.id', "left");
		$event->where('el.status','Approved');
		$data = $event->get()->getResultArray();
		// $test ="hii";
		return json_encode($data);
	}
	
	public function loadDataA()
	{
	    $event = $this->db->table("once_antivirus as av");
		$event->select('av.expiry_date as start,CONCAT(av.serv_provider," ","(", av.key_alloted,")"," ","Expiry") AS title');
		$data = $event->get()->getResultArray();
		// $test ="hii";
		return json_encode($data);
	}
	
	public function email_expiry()
	{
		$event = $this->db->table("once_email as oe");
		$event->select('oe.expiry_date as start,CONCAT(oe.email_id," ","Expiry") AS title');
		$data = $event->get()->getResultArray();
		// $test ="hii";
		return json_encode($data);
	}
	public function renewal()
	{
		$event = $this->db->table("renewal as re");
		$event->select('re.expiry_date as start,CONCAT(re.product," ","Expiry") AS title');
		$data = $event->get()->getResultArray();
		// $test ="hii";
		return json_encode($data);
	}
}?>