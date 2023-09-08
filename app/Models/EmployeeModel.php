<?php
namespace App\Models;
use CodeIgniter\Model;


class EmployeeModel extends Model
{
   protected $table = 'employee';
   protected $allowedFields = ['name','emp_short_code','date_of_joining','legal_name','per_email_id','per_mobile_no','dob','gender','anniversary_date','salary_bank_detail','upload_document_id','relationship_kin','kin_name','kin_mobile_no','kin_address','kin_job','kin_current_address','emp_current_address','updated_by','updated_on','status','reference',''];
   //add added on timestamp

   
   public function employee_added_data($data)
   {
        $db      = \Config\Database::connect();
        $this->db->table("employee")->insert($data);
        $insertId = $db->insertID();
        return $insertId;
   }
   

}
?>
