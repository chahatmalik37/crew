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
        helper("form");
        $session = session();
        if ($session->get("login_type") == "Admin") {
            $data = ["session" => $session, "request" => $this->request];
            echo view("attendance_report", $data);
        } else {
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }

    public function search_report()
    {
        $from = $this->request->getVar("from_date");
        $to = $this->request->getVar("to_date");
        $report_type = $this->request->getVar("reportType");
        $month_new = [];
        // $data_show = array();

        $start = new \DateTime($from);
        $end = new \DateTime($to);
        $interval = new \DateInterval("P1D");
        $end->add($interval);
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            array_push($month_new, $dt->format("Y-m-d"));
        }

        // Array for month name
        $monthNames = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ];
        $query["month"] = $month_new;
        if (empty($from) && empty($to)) {
            $my_monthname = [];
            $now = new \CodeIgniter\I18n\Time("now", "GMT+5:30", "de_DE");
            $prevDate = date("Y-m-d", strtotime("-1 day", strtotime($now)));
            $nowDate = date("Y-m-d", strtotime($now));

            array_push($my_monthname, $prevDate, $nowDate);
            $query["month"] = $my_monthname;
            if ($report_type == "Login-Logout") {
                $builder = $this->db->table("emp_daily_attendance as av");
                $builder->select(
                    "av.created_at,emp.emp_short_code,av.attendance_date,av.log_type,av.employee_id,emp.name,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = av.employee_id",
                    "left"
                );
                $builder->join(
                    "attendance as at",
                    "av.employee_id = at.employee_id",
                    "left"
                );
                $builder->where(
                    'date(av.attendance_date) BETWEEN "' .
                        date("Y-m-d", strtotime($prevDate)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($nowDate)) .
                        '" '
                );
                $builder->where("av.log_type in(1,2,4,3)");
                $builder->orderby("av.id", "asc");
                $query["employee"] = $builder->get()->getResultArray();
            } elseif ($report_type == "Breaks") {
                $builder = $this->db->table("emp_daily_attendance as av");
                $builder->select(
                    "av.created_at,emp.emp_short_code,av.attendance_date,av.log_type,av.employee_id,emp.name,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = av.employee_id",
                    "left"
                );
                $builder->join(
                    "attendance as at",
                    "av.employee_id = at.employee_id",
                    "left"
                );

                $builder->where(
                    'date(av.attendance_date) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '" '
                );
                $builder->where("av.log_type in(2,4)");
                $builder->orderby("av.id", "asc");
                $query["employee"] = $builder->get()->getResultArray();
            } elseif ($report_type == "Leave") {
                $builder = $this->db->table("emp_leave as el");
                $builder->select(
                    "el.start,emp.emp_short_code,el.end,el.leave_reason,el.status,emp.name,el.employee_id,TIMEDIFF(el.end,el.start) as dateDiff,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = el.employee_id",
                    "left"
                );
                $builder->join(
                    "attendance as at",
                    "emp.id = at.employee_id",
                    "left"
                );
                $builder->where(
                    'date(el.start) BETWEEN "' .
                        date("Y-m-d", strtotime($prevDate)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($nowDate)) .
                        '" OR date(el.end) BETWEEN "' .
                        date("Y-m-d", strtotime($prevDate)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($nowDate)) .
                        '" '
                );
                $builder->where('el.status="Approved"');
                $builder->where('emp.status="Active"');
                $builder->orderby("el.start", "asc");
                $query["employee2"] = $builder->get()->getResultArray();
                $datewise_employee_leave = [];
                $month_new = [];
                if ($query["employee2"]) {
                    foreach ($query["employee2"] as $emp_leave) {
                        $start1 = new \DateTime($emp_leave["start"]);
                        $end1 = new \DateTime($emp_leave["end"]);

                        $interval1 = new \DateInterval("P1D");
                        $end1->add($interval1);
                        $period2 = new \DatePeriod($start1, $interval1, $end1);

                        foreach ($period2 as $dt) {
                            array_push($month_new, $dt->format("Y-m-d"));
                        }
                        $employee_id =  $emp_leave["emp_short_code"] . "," .$emp_leave["name"];
                        foreach ($month_new as $date) {
                            if (
                                $date >=
                                    date(
                                        "Y-m-d",
                                        strtotime($emp_leave["start"])
                                    ) &&
                                $date <=
                                    date("Y-m-d", strtotime($emp_leave["end"]))
                            ) {
                                if (!isset($datewise_employee_leave[$date])) {
                                    $datewise_employee_leave[$date] = [];
                                }
                                if (
                                    !isset(
                                        $datewise_employee_leave[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_leave[$date][
                                        $employee_id
                                    ] = [];
                                }
                                $datewise_employee_leave[$date][
                                    $employee_id
                                ][] = $emp_leave;
                            }
                        }
                    }
                }
                $query["datewise_employee_leave"] = $datewise_employee_leave;
            }elseif ($report_type == "Report") {
                $builder = $this->db->table("report as rp");
                $builder->select(
                    "rp.date,rp.report,emp.emp_short_code,emp.name,emp.id as employee_id"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = rp.updated_by",
                    "left"
                );
                $builder->where(
                    'date(rp.date) BETWEEN "' .
                        date("Y-m-d", strtotime($prevDate)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($nowDate)) .
                        '" '
                );
                $builder->where('emp.status="Active"');
                $builder->orderby("rp.date", "asc");
                $query["employee2"] = $builder->get()->getResultArray();
                $datewise_employee_leave = [];
                $month_new = [];
                if ($query["employee2"]) {
                    foreach ($query["employee2"] as $emp_rep) {
                        $date = $emp_rep["date"];
                        $employee_id = $emp_rep["emp_short_code"] . "," . $emp_rep["name"];
                        
                                if (!isset($datewise_employee_report[$date])) {
                                    $datewise_employee_report[$date] = [];
                                }
                                if (
                                    !isset(
                                        $datewise_employee_report[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_report[$date][
                                        $employee_id
                                    ] = [];
                                }
                                $datewise_employee_report[$date][
                                    $employee_id
                                ][] = $emp_rep;
                            }
                    
                }
                $query["datewise_employee_report"] = $datewise_employee_report;
            }elseif ($report_type == "Notes") {
                $builder = $this->db->table("notes as el");
                $builder->select(
                    "date(el.start) as start,el.head,emp.emp_short_code,emp.name,el.employee_id"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = el.employee_id",
                    "left"
                );
                $builder->where(
                    'date(el.start) BETWEEN "' .
                        date("Y-m-d", strtotime($prevDate)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($nowDate)) .
                        '"'
                );
                $builder->where('el.log_type in(1,2,3,4)');
                $builder->where('emp.status="Active"');
                $builder->orderby("el.start", "asc");
                $query["employee2"] = $builder->get()->getResultArray();
                $datewise_employee_notes = [];
                $month_new = [];
                if ($query["employee2"]) {
                    foreach ($query["employee2"] as $emp_not) {
                        $date = date($emp_not["start"]);
                        $employee_id = $emp_not["emp_short_code"] . "," . $emp_not["name"];
                        
                                if (!isset($datewise_employee_notes[$date])) {
                                    $datewise_employee_notes[$date] = [];
                                }
                                if (
                                    !isset(
                                        $datewise_employee_notes[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_notes[$date][
                                        $employee_id
                                    ] = [];
                                }
                                $datewise_employee_notes[$date][
                                    $employee_id
                                ][] = $emp_not;
                            }
                    
                }
                $query["datewise_employee_notes"] = $datewise_employee_notes;
            
            }
            $query["from"] = date("d-m-Y", strtotime($prevDate));
            $query["to"] = date("d-m-Y", strtotime($nowDate));
            $query["repType"] = $report_type;
            //  echo "<pre>";
            //  print_r($query);
            //  exit;

            echo view("attendance_report", $query);
        } else {
            if ($report_type == "Login-Logout") {
                $builder = $this->db->table("emp_daily_attendance as av");
                $builder->select(
                    "av.created_at,emp.emp_short_code,av.attendance_date,av.log_type,av.employee_id,emp.name,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = av.employee_id",
                    "left"
                );
                $builder->join(
                    "attendance as at",
                    "av.employee_id = at.employee_id",
                    "left"
                );

                $builder->where(
                    'date(av.attendance_date) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '" '
                );
                $builder->where("av.log_type in(1,2,4,3)");
                $builder->orderby("av.id", "asc");
                $query["employee"] = $builder->get()->getResultArray();
            } elseif ($report_type == "Breaks") {
                $builder = $this->db->table("emp_daily_attendance as av");
                $builder->select(
                    "av.created_at,emp.emp_short_code,av.attendance_date,av.log_type,av.employee_id,emp.name,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = av.employee_id",
                    "left"
                );
                $builder->join(
                    "attendance as at",
                    "av.employee_id = at.employee_id",
                    "left"
                );

                $builder->where(
                    'date(av.attendance_date) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '" '
                );
                $builder->where("av.log_type in(2,4)");
                $builder->orderby("av.id", "asc");
                $query["employee"] = $builder->get()->getResultArray();
            } elseif ($report_type == "Leave") {
                $builder = $this->db->table("emp_leave as el");
                $builder->select(
                    "el.start,emp.emp_short_code,el.id,el.end,el.leave_reason,el.status,emp.name,el.employee_id,TIMEDIFF(el.end,el.start) as dateDiff,TIMEDIFF(at.logout_time, at.login_time) as maxworktime,at.break_permitted"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = el.employee_id",
                    "right"
                );
                $builder->join(
                    "attendance as at",
                    "emp.id = at.employee_id",
                    "left"
                );
                $builder->where(
                    'date(el.start) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '" OR date(el.end) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '" '
                );
                $builder->where('el.status="Approved"');
                $builder->where('emp.status="Active"');
                $builder->orderby("el.start", "asc");
                $query["employee2"] = $builder->get()->getResultArray();
                $datewise_employee_leave = [];
                $month_new = [];
                if ($query["employee2"]) {
                    foreach ($query["employee2"] as $key => $emp_leave) {
                        $start1 = new \DateTime($emp_leave["start"]);
                        $end1 = new \DateTime($emp_leave["end"]);

                        $interval1 = new \DateInterval("P1D");
                        $end1->add($interval1);
                        $period2 = new \DatePeriod($start1, $interval1, $end1);
                        $keys = 0;
                        foreach ($period2 as $dt) {
                            array_push($month_new, $dt->format("Y-m-d"));
                        }
                        $employee_id =
                            $emp_leave["emp_short_code"] .
                            "," .
                            $emp_leave["name"];

                        foreach ($month_new as $date) {
                            if (
                                $date >=
                                    date(
                                        "Y-m-d",
                                        strtotime($emp_leave["start"])
                                    ) &&
                                $date <=
                                    date("Y-m-d", strtotime($emp_leave["end"]))
                            ) {
                                if (!isset($datewise_employee_leave[$date])) {
                                    $datewise_employee_leave[$date] = [];
                                }
                                if (
                                    !isset(
                                        $datewise_employee_leave[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_leave[$date][
                                        $employee_id
                                    ] = [];
                                }
                                if (
                                    isset(
                                        $datewise_employee_leave[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_leave[$date][
                                        $employee_id
                                    ][] = $emp_leave;
                                } else {
                                    $datewise_employee_leave[$date][
                                        $employee_id
                                    ] = $emp_leave;
                                }
                            }
                        }
                    }
                }
                $query["datewise_employee_leave"] = $datewise_employee_leave;
            }elseif ($report_type == "Report") {
                $builder = $this->db->table("report as rp");
                $builder->select(
                    "rp.date,rp.report,emp.emp_short_code,emp.name,emp.id as employee_id"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = rp.updated_by",
                    "left"
                );
                $builder->where(
                    'date(rp.date) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '" '
                );
                $builder->where('emp.status="Active"');
                $builder->orderby("rp.date", "asc");
                $query["employee2"] = $builder->get()->getResultArray();
                $datewise_employee_leave = [];
                $month_new = [];
                if ($query["employee2"]) {
                    foreach ($query["employee2"] as $emp_rep) {
                        $date = $emp_rep["date"];
                        $employee_id = $emp_rep["emp_short_code"] . "," . $emp_rep["name"];
                        
                                if (!isset($datewise_employee_report[$date])) {
                                    $datewise_employee_report[$date] = [];
                                }
                                if (
                                    !isset(
                                        $datewise_employee_report[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_report[$date][
                                        $employee_id
                                    ] = [];
                                }
                                $datewise_employee_report[$date][
                                    $employee_id
                                ][] = $emp_rep;
                            }
                    
                }
                $query["datewise_employee_report"] = $datewise_employee_report;
            }elseif ($report_type == "Notes") {
                $builder = $this->db->table("notes as el");
                $builder->select(
                    "date(el.start) as start,el.head,emp.emp_short_code,emp.name,el.employee_id"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = el.employee_id",
                    "left"
                );
                $builder->where(
                    'date(el.start) BETWEEN "' .
                        date("Y-m-d", strtotime($from)) .
                        '"   and "' .
                        date("Y-m-d", strtotime($to)) .
                        '"'
                );
                $builder->where('el.log_type in(1,2,3,4)');
                $builder->where('emp.status="Active"');
                $builder->orderby("el.start", "asc");
                $query["employee2"] = $builder->get()->getResultArray();
                $datewise_employee_notes = [];
                $month_new = [];
                if ($query["employee2"]) {
                    foreach ($query["employee2"] as $emp_not) {
                        $date = date($emp_not["start"]);
                        $employee_id = $emp_not["emp_short_code"] . "," . $emp_not["name"];
                        
                                if (!isset($datewise_employee_notes[$date])) {
                                    $datewise_employee_notes[$date] = [];
                                }
                                if (
                                    !isset(
                                        $datewise_employee_notes[$date][
                                            $employee_id
                                        ]
                                    )
                                ) {
                                    $datewise_employee_notes[$date][
                                        $employee_id
                                    ] = [];
                                }
                                $datewise_employee_notes[$date][
                                    $employee_id
                                ][] = $emp_not;
                            }
                    
                }
                $query["datewise_employee_notes"] = $datewise_employee_notes;
            
            }
            $query["from"] = date("d-m-Y", strtotime($from));
            $query["to"] = date("d-m-Y", strtotime($to));
            $query["repType"] = $report_type;
            // echo "<pre>";
            // print_r($query);
            // exit;

            echo view("attendance_report", $query);
        }
    }
    public function fetch_emp_detail_with_datewise()
    {
        $session = session();
        if ($session->has("username")) {
            helper("form");
            $from = $this->request->getVar("from");
            $to = $this->request->getVar("to");
            $repType = $this->request->getVar("report");
            if ($repType == "Login-Logout") {
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select("emp.*,stf.name");
                $builder->join(
                    "employee as stf",
                    "stf.id = emp.employee_id",
                    "left"
                );
                $builder->where(
                    "emp.employee_id",
                    $this->request->getVar("emp_id")
                );
                $builder->where(
                    'emp.attendance_date BETWEEN "' .
                        $from .
                        '"   and "' .
                        $to .
                        '" '
                );
                $builder->where("emp.log_type in(1,2,4,3)");
                $builder->orderby("emp.id", "asc");
                $EmpAttDet1 = $builder->get()->getResultArray();
            } elseif ($repType == "Breaks") {
                $builder = $this->db->table("emp_daily_attendance as emp");
                $builder->select("emp.*,stf.name");
                $builder->join(
                    "employee as stf",
                    "stf.id = emp.employee_id",
                    "left"
                );
                $builder->where(
                    "emp.employee_id",
                    $this->request->getVar("emp_id")
                );
                $builder->where(
                    'emp.attendance_date BETWEEN "' .
                        $from .
                        '"   and "' .
                        $to .
                        '" '
                );
                $builder->where("emp.log_type in(2,4)");
                $builder->orderby("emp.id", "asc");
                $EmpAttDet1 = $builder->get()->getResultArray();
            } elseif ($repType == "Leave") {
                $builder = $this->db->table("emp_leave as el");
                $builder->select(
                    "el.start,el.end,el.leave_reason,el.status,emp.name,el.employee_id"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = el.employee_id",
                    "right"
                );
                $builder->where(
                    "el.employee_id",
                    $this->request->getVar("emp_id")
                );
                $builder->where(
                    'date(el.start) BETWEEN "' .
                        $from .
                        '"   and "' .
                        $to .
                        '" OR date(el.end) BETWEEN "' .
                        $from .
                        '"   and "' .
                        $to .
                        '"  '
                );
                $builder->where('el.status="Approved"');
                $builder->where('emp.status="Active"');
                $builder->orderby("el.id", "desc");
                $EmpAttDet1 = $builder->get()->getResultArray();
            }elseif ($repType == "Report") {
                
                $builder = $this->db->table("report as rp");

                $builder->select(
                    "rp.date,rp.report,emp.emp_short_code,emp.name"
                );
                $builder->join(
                    "employee as emp",
                    "emp.id = rp.updated_by",
                    "left"
                );
                $builder->where(
                    "rp.updated_by='".$this->request->getVar("emp_id")."'"
                );
                $builder->where(
                    'date(rp.date) BETWEEN "' .
                            $from .
                        '"   and "' .
                        $to.
                        '" '
                );
                $builder->where('emp.status="Active"');
                $builder->orderby("rp.date", "asc");
                $EmpAttDet1 = $builder->get()->getResultArray();
           }elseif ($repType == "Notes") {
            $builder = $this->db->table("notes as el");
            $builder->select(
                "(el.start) as note_date,el.head,el.status,emp.name,el.employee_id"
            );
            $builder->join(
                "employee as emp",
                "emp.id = el.employee_id",
                "right"
            );
            $builder->where(
                "el.employee_id",
                $this->request->getVar("emp_id")
            );
            $builder->where(
                'date(el.start) BETWEEN "' .
                    $from .
                    '"   and "' .
                    $to .
                    '" '
            );
            $builder->where('el.log_type in(1,2,3,4)');
            $builder->where('emp.status="Active"');
            $builder->orderby("el.id", "asc");
            $EmpAttDet1 = $builder->get()->getResultArray();
        }
            if (!empty($EmpAttDet1)) {
                $EmpAttDet = $EmpAttDet1;
            }

            if (!empty($EmpAttDet)) {
                // print_r(json_encode($result));
                return json_encode($EmpAttDet);
            }
        } else {
            $session->setFlashdata("warning", "Session Expired!Please Login");
            $session->destroy();
            return redirect("")->to("/");
        }
    }
    public function ShowReport($employee_id, $from, $to)
    {
        
        $builder = $this->db->table("report as rp");

        $builder->select(
            "rp.date,rp.report,rp.template_id,rp.share,emp.emp_short_code,emp.name,temp.template"
        );
        $builder->join(
            "employee as emp",
            "emp.id=rp.updated_by",
            "left"
        );
        $builder->join(
            "rep_template as temp",
            "temp.id = rp.template_id",
            "left"
        );
         $builder->where(
            'date(rp.date) BETWEEN "' .
                    $from .
                '"   and "' .
                $to.
                '" '
        );
        $builder->where(
            "rp.updated_by='".$employee_id."'"
        );
       
        $builder->where('emp.status="Active"');
        $builder->orderby("rp.date", "asc");
        $data['empReport'] = $builder->get()->getResultArray();
        // echo "<pre>";
        // print_r($data);
        // exit;
        echo view('show_report', $data);
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
