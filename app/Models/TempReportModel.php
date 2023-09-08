<?php
namespace App\Models;
use CodeIgniter\Model;


class TempReportModel extends Model
{
   protected $table = 'rep_template';
   protected $allowedFields = ['template','status','updated_by','updated_on'];
   //add added on timestamp
}
?>