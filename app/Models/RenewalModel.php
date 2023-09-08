<?php
namespace App\Models;
use CodeIgniter\Model;


class RenewalModel extends Model
{
   protected $table = 'renewal';
   protected $allowedFields = ['product','category','expiry_date','amount','notes','updated_by','updated_on','status'];
   //add added on timestamp
}

?>