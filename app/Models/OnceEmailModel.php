<?php

namespace App\Models;

use CodeIgniter\Model;


class OnceEmailModel extends Model
{
  
   protected $table = 'once_email';
   protected $allowedFields = ['email_id', 'nature_of_email','expiry_date', 'forwarding_to', 'updated_by', 'updated_on', 'status'];

   
}
