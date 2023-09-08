<?php
namespace App\Models;
use CodeIgniter\Model;


class StarSquareModel extends Model
{
   protected $table = 'once_star_square';
   protected $allowedFields = ['st_sq','color','updated_by','updated_on','status'];
   //add added on timestamp
}?>