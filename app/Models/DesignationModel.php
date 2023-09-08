<?php
namespace App\Models;
use CodeIgniter\Model;


class DesignationModel extends Model
{
   protected $table = 'once_designation';
   protected $allowedFields = ['designation','updated_by','updated_on','status'];
   //add added on timestamp
}
?>