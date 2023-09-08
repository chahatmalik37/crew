<?php
namespace App\Models;
use CodeIgniter\Model;


class AttendanceModel extends Model
{
   protected $table = 'attendance';
   protected $allowedFields = ['employee_id','login_time','logout_time','break_permitted','weekly_off','leave_per_month','attendance_exempt','break_exempt','report_exempt','ip_exempt','wifi_ip','updated_by','updated_on','status'];
   //add added on timestamp

   


}
?>
