<?php
namespace App\Models;
use CodeIgniter\Model;


class UserModel extends Model
{
   protected $table = 'user';
   protected $allowedFields = ['employee_name','login_id','login_password','employee_id','updated_by','updated_on','status','user_type'];
   //add added on timestamp

   


}
?>