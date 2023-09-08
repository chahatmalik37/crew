<?php
namespace App\Models;
use CodeIgniter\Model;


class ShareReportModel extends Model
{
   protected $table = 'share_report';
   protected $allowedFields = ['emp_id','shared_id','shared_date','status','updated_by','updated_on'];
   //add added on timestamp

   


}
?>