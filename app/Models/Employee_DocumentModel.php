<?php
namespace App\Models;
use CodeIgniter\Model;


class Employee_DocumentModel extends Model
{
   protected $table = 'employee_document';
   protected $allowedFields = ['document_name','file_name','updated_by','updated_on','status','filepath','type'];
   //add added on timestamp
}
?>
