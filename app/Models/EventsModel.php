<?php
namespace App\Models;
use CodeIgniter\Model;


class EventsModel extends Model
{
   protected $table = 'events';
   protected $allowedFields = ['employee_id','head','start','end','updated_by','updated_on'];
   //add added on timestamp
   

}
?>
