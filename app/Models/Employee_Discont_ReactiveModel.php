<?php
namespace App\Models;
use CodeIgniter\Model;


class Employee_Discont_ReactiveModel extends Model
{
   protected $table = 'employee_discont_reactive';
   protected $allowedFields = ['employee_id','date_of_leaving','leaving_reason','date_of_rejoin','comments','discontinuation_doc_id','reactive_authorized_by','reactive_reason','status','updated_by','updated_on'];
   //add added on timestamp

   


}
?>
