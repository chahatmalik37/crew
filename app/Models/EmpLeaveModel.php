<?php
namespace App\Models;
use CodeIgniter\Model;


class EmpLeaveModel extends Model
{
   protected $table = 'emp_leave';
   protected $allowedFields = ['employee_id','start','end','leave_reason','email_to','updated_by','updated_on','status'];
   //add added on timestamp

   


}
?>
