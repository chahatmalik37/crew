<?php
namespace App\Models;
use CodeIgniter\Model;


class AntivirusModel extends Model
{
   protected $table = 'once_antivirus';
   protected $allowedFields = ['serv_provider','key_alloted','expiry_date','updated_by','updated_on','status'];
   //add added on timestamp
}?>