<?php
namespace App\Models;
use CodeIgniter\Model;


class DepartmentModel extends Model
{
   protected $table = 'once_dept';
   protected $allowedFields = ['dept_name','updated_by','updated_on','status'];
   //add added on timestamp
}
?>