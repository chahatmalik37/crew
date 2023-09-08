<?php

namespace App\Models;

use CodeIgniter\Model;


class NotesModel extends Model
{
  
   protected $table = 'notes';
   protected $allowedFields = ['head','notes','leave_id','start','daily_id', 'employee_id','end', 'log_type', 'status','updated_on'];

   
}
