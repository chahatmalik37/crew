<?php
namespace App\Models;
use CodeIgniter\Model;


class SimCardModel extends Model
{
   protected $table = 'once_simcard';
   protected $allowedFields = ['number','status','updated_by','provider','package','updated_on'];
}
?>