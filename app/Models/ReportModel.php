<?php
namespace App\Models;
use CodeIgniter\Model;


class ReportModel extends Model
{
   protected $table = 'report';
   protected $allowedFields = ['date','template_id','report','share','status','updated_by','updated_on'];
   //add added on timestamp

   


}
?>