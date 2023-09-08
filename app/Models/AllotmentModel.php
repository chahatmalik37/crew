<?php
namespace App\Models;
use CodeIgniter\Model;


class AllotmentModel extends Model
{
   protected $table = 'alloted';
   protected $allowedFields = ['person_anti','anti_id','dept_id','desig_id','star_id','email_id','emp_id','sim_id','person_sim','updated_by','updated_on','status'];
}
?>